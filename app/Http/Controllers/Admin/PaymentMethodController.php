<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Facades\PaymentMethodFacade;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return PaymentMethodFacade::datatables();
        }

        return view('content.admin.payment_method.index');
    }

    public function store(Request $request)
    {
        return PaymentMethodFacade::store($request->all());
    }

    public function edit($id)
    {
        try {
            $paymentMethod = PaymentMethodFacade::find($id);
            return view('content.admin.payment_method.edit', ['paymentMethod' => $paymentMethod]);
        } catch (\Exception $ex) {
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        return PaymentMethodFacade::update($request->all(), $id);
    }
}
