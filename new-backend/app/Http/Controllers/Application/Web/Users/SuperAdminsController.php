<?php

namespace App\Http\Controllers\Application\Web\Users;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminsController extends Controller
{

    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if( !auth()->user()->hasAnyRole(['Super Admin'])) {
                abort(404);
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $superAdmins = User::role('Super Admin')->orderBy('name', 'asc');

        if(!empty($request->username)){
            $superAdmins = $superAdmins->where('username', 'LIKE', '%'.$request->username.'%');
        }

        if(!empty($request->phone_number)){
            $superAdmins = $superAdmins->where('phone_number', 'LIKE', '%'.$request->phone_number.'%');
        }

        if(!empty($request->name)){
            $superAdmins = $superAdmins->where('name', 'LIKE', '%'.$request->name.'%');
        }

        $superAdmins = $superAdmins->paginate(20);

        return view('application.users.super-admins.index',[
            'superAdmins' => $superAdmins,
            'active_page' => 'users',
            'active_subpage' => 'super-admins',
            'search_terms'=>[
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'name' => $request->name,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('application.users.super-admins.create',[
            'active_page' => 'users',
            'active_subpage' => 'super-admins',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate
        $validation_rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,NULL,id,deleted_at,NULL',
            'phone_number' => 'required|numeric|min:10',
            'password' => 'required|min:8|max:32|confirmed',
        ];

        if (! empty($request->email)) {
            $validation_rules['email'] = 'email';
        }

        $this->validate($request,$validation_rules);

        $superAdmin = User::where('username', $request->username)->first();
        if(empty($superAdmin)){
            $superAdmin = new User();
        } else {
            return redirect()->back()->with('error_message', 'Username ini sudah terpakai, silahkan gunakan username lain untuk mendaftar');
        }

        $superAdmin->username = $request->username;
        $superAdmin->name = $request->name;
        $superAdmin->address = $request->address;
        $superAdmin->email = $request->email;
        $superAdmin->phone_number = $request->phone_number;
        $superAdmin->password = Hash::make($request->password);
        // $superAdmin->tenant_id = $request->tenant_id;
        $superAdmin->save();
        $superAdmin->assignRole('Super Admin');

        return redirect()
        ->route('application.users.super-admins.index')
        ->with('success_message', 'Berhasil menambahkan super admin!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $superAdmin = User::find($id);

        if(empty($superAdmin)){
            return redirect()->back()->with('error_message', 'Mohon maaf data super admin tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        return view('application.users.super-admins.edit',[
            'admin' => $superAdmin,
            'active_page' => 'users',
            'active_subpage' => 'super-admins',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(!empty($request->password)){
            $validation_rules['password'] = 'required|min:8|max:32|confirmed';
            $this->validate($request,$validation_rules);
        }

        $superAdmin= User::find($id);
        if(empty($superAdmin)){
            return redirect()->back()->with('error_message', 'Mohon maaf data super admin tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        $superAdmin->username = !empty($request->username) ? $request->username : $superAdmin->username;
        $superAdmin->name = !empty($request->name) ? $request->name : $superAdmin->name;
        $superAdmin->address = !empty($request->address) ? $request->address : $superAdmin->address;
        $superAdmin->email = !empty($request->email) ? $request->email : $superAdmin->email;
        $superAdmin->phone_number = !empty($request->phone_number) ? $request->phone_number : $superAdmin->phone_number;
        $superAdmin->password = !empty($request->password) ? Hash::make($request->password) : $superAdmin->password;
        $superAdmin->save();

        return redirect()
        ->route('application.users.super-admins.index')
        ->with('success_message', 'Berhasil mengupdate data super admin!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $superAdmin = User::find($id);

        if(empty($superAdmin)){
            return redirect()->back()->with('error_message', 'Mohon maaf data super admin tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        $superAdmin->delete();

        return redirect()
        ->route('application.users.super-admins.index')
        ->with('success_message', 'Berhasil menghapus data super admin!');
    }
}
