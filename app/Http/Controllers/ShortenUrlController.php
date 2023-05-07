<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\ShortenUrlFacade;
use Illuminate\Http\Request;

class ShortenUrlController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return ShortenUrlFacade::datatables();
        }
        return view('content.url.index');
    }

    public function store(Request $request)
    {
        return ShortenUrlFacade::store($request->except(['_token', '_method', 'id']));
    }

    public function update(Request $request)
    {
        return ShortenUrlFacade::update($request->except(['_token', '_method']));
    }

    public function show($id)
    {
        return ShortenUrlFacade::find($id);
    }
}
