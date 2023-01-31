<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role < 1) {
            return view('user.index');
        }else{
            $uid = Auth::user()->id;
            $user = User::findOrFail($uid);
            return view('user.profile',compact('user'));
        }
    }

    public function data()
    {
        if (Auth::user()->role < 1) {
            $model = User::all();
        } else {
            $model = User::where('role', '>=', 1);
        }

        return DataTables::of($model)
            ->addIndexColumn()
            ->setRowId('id')
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => "required|unique:users,username",
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:16|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = new User;
        $user->name = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        $res = new stdClass;
        $res->status = 'success';
        $res->message = "User berhasil ditambahkan";

        return redirect('/')->with($res->status,json_encode($res));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required',
            'username' => "required|unique:users,username",
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:16|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user->name = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $res = new stdClass;
        $res->message = "User berhasil diubah";

        return redirect('/users')->with('success',json_encode($res));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
    }

    public function change()
    {
        return view('user.reset');
    }

    public function reset(User $user,Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|exists:users,password',
            'new_password' => 'required|string|max:16|confirmed',
            'new_password_confirmation' => 'required'
        ]);

        $res = new stdClass;
        $npw = Hash::make($request->new_password);
        $user->password = $npw;
        $user->save();
        $res->message = "Password berhasil diganti!";
        return redirect('/')->with("success",json_encode($res));
    }
}
