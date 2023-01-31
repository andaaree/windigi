<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\Plan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Dashboard extends Controller
{
    public function index()
    {
        $tk = Key::count();
        $tp = Plan::count();
        $ts = Key::whereDoesntHave('plans')->count();
        // dd($tk,$ts,$tp);
        return view('dash',compact('tk','tp','ts'));
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
