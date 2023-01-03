<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dash');
    }

    public function data()
    {
        $plan = Plan::with('keys');
        return DataTables::of($plan)
        ->addIndexColumn()
        ->setRowId('id')
        ->toJson();
    }
}
