<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function tableData(Request $request)
    {
        $result = generateSimpleDropdown($request->table, $request->column, $request->where, $request->selected);
        return $result;
    }
}
