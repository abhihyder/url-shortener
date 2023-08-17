<?php

namespace App\Repositories\Services;

use App\Models\PaymentMethod;
use App\Repositories\Interfaces\PaymentMethodInterface;
use Hyder\JsonResponse\Facades\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PaymentMethodFacadeService implements PaymentMethodInterface
{
    public function datatables()
    {
        return DataTables::of(PaymentMethod::query())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div class="btn-group" role="group" aria-label="Basic example">
            <a href="' . route('admin.payment-method.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
            </div>';
            })
            ->editColumn('min_withdrawal_amount', function ($row) {
                return "$" . number_format($row->min_withdrawal_amount, 4);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(array $request)
    {
        try {
            $validator = $this->validation($request);

            if ($validator->fails()) {
                return JsonResponse::invalidRequest($validator->errors());
            }

            PaymentMethod::create($request);
            return JsonResponse::created('Payment Method added successfully!');
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    public function find(int $id)
    {
        try {
            return PaymentMethod::findOrFail($id);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function update(array $request, int $id)
    {
        try {
            $validator = $this->updateValidation($request,  $id);

            if ($validator->fails()) {
                return JsonResponse::invalidRequest($validator->errors());
            }

            $paymentMethod = PaymentMethod::findOrFail($id);
            if ($paymentMethod->id > 1) {
                $paymentMethod->name = $request['name'];
            }
            $paymentMethod->min_withdrawal_amount = $request['min_withdrawal_amount'];
            $paymentMethod->save();
            return JsonResponse::success('Payment Method updated successfully!');
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    private function validation(array $request)
    {
        return Validator::make($request, [
            'name' => 'required|string|unique:payment_methods,name',
            'min_withdrawal_amount' => 'required|numeric',
        ]);
    }

    private function updateValidation(array $request, int $id)
    {
        return Validator::make($request, [
            'name' => ['required', 'string', Rule::unique('payment_methods', 'name')->ignore($id)],
            'min_withdrawal_amount' => ['required', 'numeric'],
        ]);
    }
}
