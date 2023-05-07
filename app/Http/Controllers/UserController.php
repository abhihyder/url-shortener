<?php

namespace App\Http\Controllers;

use App\Jobs\BulkStatusChangeMail;
use App\Jobs\StatusChangeMail;
use App\Mail\NotificationMail;
use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use App\Utilities\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query()->with('role');
            if ($request->date_range) {
                $date = explode(' ', $request->date_range);
                if (count($date) == 1) {
                    $users->whereBetween('created_at', [$date[0] . date(' 00:00:00'), $date[0] . date(' 23:59:59')]);
                } else {
                    $users->whereBetween('created_at', [$date[0] . date(' 00:00:00'), $date[2] . date(' 23:59:59')]);
                }
            }
            $users->orderBy('id', 'desc');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '<div class="btn-group customBtnGroup">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-angle-double-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item edit_this_user" href="javascript:;" data-id="' . $row->id . '">Edit/Password Reset</a>';
                        if($row->status== 0){
                            $action .='<a class="dropdown-item" href="javascript:;" onclick="changeStatus(' . $row->id . ',1)">Status Active</a>';
                        }else{
                            $action .='<a class="dropdown-item" href="javascript:;" onclick="changeStatus(' . $row->id . ',0)">Status Inactive</a>';  
                        }
                        if($row->earning_disable== 0){
                            $action .='<a class="dropdown-item" href="javascript:;" onclick="changeEarningStatus(' . $row->id . ',1)">Earning Disable</a>';
                        }else{
                            $action .='<a class="dropdown-item" href="javascript:;" onclick="changeEarningStatus(' . $row->id . ',0)">Earning Enable</a>';  
                        }
                        $action .='<div class="dropdown-divider"></div>
                        <a class="dropdown-item delete_this_user" href="javascript:;" data-id="' . encrypted_value($row->id) . '">Delete</a>
                    </div>
                </div>';
                    return $action;
                })
                ->addColumn('checkbox', function ($row) {
                    $id = $row->id;
                    return '<div class="custom-control custom-checkbox"> <input class="custom-control-input dt-checkboxes" type="checkbox" name="id[]" value="' . $id . '" id="checkbox' . $id . '" /><label class="custom-control-label" for="checkbox' . $id . '"></label></div>';
                })
                ->editColumn('role_name', function ($row) {
                    return $row->role->name;
                })
                ->editColumn('updated_at', function ($row) {
                    return date('d M Y h:ia', strtotime($row->updated_at));
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M Y h:ia', strtotime($row->created_at));
                })
                ->editColumn('status', function ($row) {
                    $status = '<span class="status-badge badge badge-success" onclick="changeStatus(' . $row->id . ',0)">Active</span>';
                    if ($row->status == 0) {
                        $status = '<span class="status-badge badge badge-danger" onclick="changeStatus(' . $row->id . ',1)">Inactive</span>';
                    }
                    return $status;
                })
                ->editColumn('earning_disable', function ($row) {
                    $earning_disable = '<span class="status-badge badge badge-success" onclick="changeEarningStatus(' . $row->id . ',1)">No</span>';
                    if ($row->earning_disable == 1) {
                        $earning_disable = '<span class="status-badge badge badge-danger" onclick="changeEarningStatus(' . $row->id . ',0)">Yes</span>';
                    }
                    return $earning_disable;
                })
                ->rawColumns(['link', 'action', 'checkbox', 'status', 'earning_disable'])
                ->make(true);
        }
        $roles = Role::all();
        return view('content.user.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('content.user.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validation_rule = [
                'username' => ['required', 'string', 'alpha_num', 'min:4', 'max:160', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:160', 'unique:users'],
                'role' => ['required'],
                'password' => ['required', 'min:6', 'confirmed'],
            ];

            if ($request->referral) {
                $validation_rule['referral'] = ['required', 'string', 'alpha_num', 'min:4', 'max:160', 'exists:users,username'];
            }

            $validator = Validator::make($request->all(), $validation_rule);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            $referrer_id = null;

            if ($request->referrer) {
                $referrer = User::where('username', $request->referrer)->first();
                if ($referrer) {
                    $referrer_id = $referrer->id;
                }
            }

            DB::beginTransaction();

            $ip = getIP();
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'referrer_id' => $referrer_id,
                'register_ip' => $ip,
                'role_id' => $request->role,
                'status' => $request->status,
                'earning_disable' => $request->earning_disable,
            ]);

            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->save();

            DB::commit();

            // Send mail-----------------
            SendMail::welcomeMail($user);

            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            return $this->respondWithData($user);
        } catch (\Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            if ($request->new_password) {
                $validator = Validator::make($request->all(), [
                    'new_password' => 'required|min:6',
                ]);
                if ($validator->fails()) {
                    return $this->respondInvalidRequest($validator->errors());
                }
            }

            DB::beginTransaction();
            $user = User::FindOrFail($request->id);
            $current_status = $user->status;
            $current_earning_status = $user->earning_disable;
            $user->name = $request->name;
            $user->role_id = $request->role;
            $user->status = $request->status;
            $user->earning_disable = $request->earning_disable;
            if ($request->new_password) {
                $user->password = Hash::make($request->new_password);
            }
            $user->save();
            DB::commit();

            // Send mail-----------------
            if ($user->email && Config::get('custom_config.mail_notification') && ($current_status != $request->status || $current_earning_status != $request->earning_disable)) {
                $array['view'] = 'content.emails.change_status';
                $array['subject'] = "Status Changed";
                $array['name'] = $user->name ?? $user->username;
                $array['to'] = $user->email;

                $content = "";
                if ($current_status != $request->status) {
                    $content .= "Your account has been ";
                    $content .= $request->status == 1 ? "activeted" : "deactiveted";
                }

                if ($current_status != $request->status && $current_earning_status != $request->earning_disable) {
                    $content .= " and ";
                }

                if ($current_earning_status != $request->earning_disable) {
                    $content .= "Your account earning has been ";
                    $content .= $request->earning_disable == 1 ? "disabled" : "enabled";
                }

                $content .= " at " . date('h:ia d M Y') . " (" . config('app.timezone') . "). Please contact with admin for further discussion.";

                $array['content'] = $content;

                if (Config::get('custom_config.queue_work')) {
                    StatusChangeMail::dispatch($array)
                        ->delay(now()->addSeconds(5));
                } else {
                    Config::set('queue.default', 'sync');
                    Mail::to($array['to'])->queue(new NotificationMail($array));
                }
            }

            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function multipleDelete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            User::whereIn('id', $request->user_id)->delete();

            return true;
        } catch (\Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required'],
                'status' => ['required'],
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            $user = User::FindOrFail($request->user_id);
            $user->status = $request->status;
            $user->save();

            // Send mail-----------------
            if ($user->email && Config::get('custom_config.mail_notification')) {
                $array['view'] = 'content.emails.change_status';
                $array['subject'] = "Status Changed";
                $array['name'] = $user->name ?? $user->username;
                $array['to'] = $user->email;

                $content = "Your account has been ";
                $content .= $request->status == 1 ? "activeted" : "deactiveted";

                $content .= " at " . date('h:ia d M Y') . " (" . config('app.timezone') . "). Please contact with admin for further discussion.";

                $array['content'] = $content;

                if (Config::get('custom_config.queue_work')) {
                    StatusChangeMail::dispatch($array)
                        ->delay(now()->addSeconds(5));
                } else {
                    Config::set('queue.default', 'sync');
                    Mail::to($array['to'])->queue(new NotificationMail($array));
                }
            }
            return true;
        } catch (\Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }

    public function multipleChangeStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required'],
                'status' => ['required']
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            User::whereIn('id', $request->user_id)->update(['status' => $request->status]);

            // Send mail-----------------
            if (Config::get('custom_config.mail_notification')) {
                $users = User::whereIn('id', $request->user_id)->get();
                $array['view'] = 'content.emails.change_status';
                $array['name'] = null;
                $array['subject'] = "Status Changed";
                $array['users'] = $users;

                $content = "Your account has been ";
                $content .= $request->status == 1 ? "activeted" : "deactiveted";

                $content .= " at " . date('h:ia d M Y') . " (" . config('app.timezone') . "). Please contact with admin for further discussion.";

                $array['content'] = $content;

                if (Config::get('custom_config.queue_work')) {
                    BulkStatusChangeMail::dispatch($array)
                        ->delay(now()->addSeconds(5));
                } else {
                    Config::set('queue.default', 'sync');
                    foreach ($users as $user) {
                        if ($user->email) {
                            $array['name'] = $user->name ?? $user->username;
                            $array['to'] = $user->email;
                            Mail::to($array['to'])->queue(new NotificationMail($array));
                        }
                    }
                }
            }
            return true;
        } catch (\Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }

    public function enableOrDisable(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required'],
                'status' => ['required'],
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            $user = User::FindOrFail($request->user_id);
            $user->earning_disable = $request->status;
            $user->save();

            // Send mail-----------------
            if ($user->email && Config::get('custom_config.mail_notification')) {
                $array['view'] = 'content.emails.change_status';
                $array['subject'] = "Status Changed";
                $array['name'] = $user->name ?? $user->username;
                $array['to'] = $user->email;

                $content = "Your account earning has been ";
                $content .= $request->status == 1 ? "disabled" : "enabled";

                $content .= " at " . date('h:ia d M Y') . " (" . config('app.timezone') . "). Please contact with admin for further discussion.";

                $array['content'] = $content;

                if (Config::get('custom_config.queue_work')) {
                    StatusChangeMail::dispatch($array)
                        ->delay(now()->addSeconds(5));
                } else {
                    Config::set('queue.default', 'sync');
                    Mail::to($array['to'])->queue(new NotificationMail($array));
                }
            }

            return true;
        } catch (\Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }
    public function multipleEarningEnableOrDisable(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required'],
                'status' => ['required']
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            User::whereIn('id', $request->user_id)->update(['earning_disable' => $request->status]);

            // Send mail-----------------
            if (Config::get('custom_config.mail_notification')) {
                $users = User::whereIn('id', $request->user_id)->get();
                $array['view'] = 'content.emails.change_status';
                $array['name'] = null;
                $array['subject'] = "Status Changed";
                $array['users'] = $users;

                $content = "Your account earning has been ";
                $content .= $request->status == 1 ? "disabled" : "enabled";

                $content .= " at " . date('h:ia d M Y') . " (" . config('app.timezone') . "). Please contact with admin for further discussion.";

                $array['content'] = $content;

                if (Config::get('custom_config.queue_work')) {
                    BulkStatusChangeMail::dispatch($array)
                        ->delay(now()->addSeconds(5));
                } else {
                    Config::set('queue.default', 'sync');
                    foreach ($users as $user) {
                        if ($user->email) {
                            $array['name'] = $user->name ?? $user->username;
                            $array['to'] = $user->email;
                            Mail::to($array['to'])->queue(new NotificationMail($array));
                        }
                    }
                }
            }

            return true;
        } catch (\Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }
}
