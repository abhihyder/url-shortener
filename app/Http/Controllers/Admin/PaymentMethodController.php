<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PaymentMethod::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '<div class="btn-group" role="group" aria-label="Basic example">
                    <a href="'.route('admin.payment-method.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    </div>';
                    return $action;
                })
                ->editColumn('min_withdrawal_amount', function ($row) {
                    return "$" . number_format($row->min_withdrawal_amount, 4);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('content.admin.payment_method.index');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:payment_methods,name',
                'min_withdrawal_amount' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            DB::beginTransaction();
            $paymentMethod = new PaymentMethod();
            $paymentMethod->name = $request->name;
            $paymentMethod->min_withdrawal_amount = $request->min_withdrawal_amount;
            $paymentMethod->save();
            DB::commit();
            return $this->respondCreated('Payment Method added successfully!', $paymentMethod);
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $paymentMethod = PaymentMethod::findOrFail($id);
            return view('content.admin.payment_method.edit', ['paymentMethod' => $paymentMethod]);
        } catch (\Exception $ex) {
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', Rule::unique('payment_methods', 'name')->ignore($id)],
                'min_withdrawal_amount' => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            DB::beginTransaction();
            $paymentMethod = PaymentMethod::findOrFail($id);
            if ($paymentMethod->id > 1) {
                $paymentMethod->name = $request->name;
            }
            $paymentMethod->min_withdrawal_amount = $request->min_withdrawal_amount;
            $paymentMethod->save();
            DB::commit();
            return $this->respondCreated('Payment Method updated successfully!', $paymentMethod);
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }
}
