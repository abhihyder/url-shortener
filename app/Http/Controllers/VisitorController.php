<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\VisitorFacade;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function visit($urlCode)
    {
        return VisitorFacade::visit($urlCode);
    }

    public function accessCode(Request $request)
    {
        return VisitorFacade::accessCode($request->only(['url_code', 'access_code']));
    }

    public function index()
    {
        if (request()->ajax()) {
            return VisitorFacade::datatables();
        }
        return view('content.visitor.index', ['shorten_url_id' => request()->input('shorten_url_id')]);
    }
}
