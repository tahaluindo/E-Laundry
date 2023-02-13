<?php

namespace App\Http\Controllers\Application\Web\Users;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{

    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if( !auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Tenant User',  'Worker User'])) {
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
        // DB::enableQueryLog();
        $customers = User::role('Customer User')->orderBy('name', 'asc');

        // if(!auth()->user()->hasAnyRole(['Super Admin'])){
        //     $customers = $customers->where('tenant_id', auth()->user()->tenant_id);
        // }

        if(!empty($request->username)){
            $customers = $customers->where('username', 'LIKE', '%'.$request->username.'%');
        }

        if(!empty($request->phone_number)){
            $customers = $customers->where('phone_number', 'LIKE', '%'.$request->phone_number.'%');
        }

        if(!empty($request->name)){
            $customers = $customers->where('name', 'LIKE', '%'.$request->name.'%');
        }

        $customers = $customers->paginate(20);

        // dd(DB::getQueryLog());

        return view('application.users.customers.index',[
            'customers' => $customers,
            'active_page' => 'users',
            'active_subpage' => 'customers',
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
        $tenants = Tenant::orderBy('name', 'asc')->get();
        return view('application.users.customers.create',[
            'tenants' => $tenants,
            'active_page' => 'users',
            'active_subpage' => 'customers',
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

        $customer = User::where('username', $request->username)->first();
        if(empty($customer)){
            $customer = new User();
        } else {
            return redirect()->back()->with('error_message', 'Username ini sudah terpakai, silahkan gunakan username lain untuk mendaftar');
        }

        $customer->username = $request->username;
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->password = Hash::make($request->password);

        // if(!auth()->user()->hasAnyRole(['Super Admin'])){
            $customer->tenant_id = auth()->user()->tenant_id;
        // } else {
        //     $customer->tenant_id = $request->tenant_id;
        // }

        $customer->save();

        $customer->assignRole('Customer User');

        return redirect()
        ->route('application.users.customers.index')
        ->with('success_message', 'Berhasil menambahkan pelanggan!');
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
        $customer = User::find($id);

        if(empty($customer)){
            return redirect()->back()->with('error_message', 'Mohon maaf data pelanggan tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        return view('application.users.customers.edit',[
            'customer' => $customer,
            'active_page' => 'users',
            'active_subpage' => 'customers',
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

        $customer = User::find($id);
        if(empty($customer)){
            return redirect()->back()->with('error_message', 'Mohon maaf data pelanggan tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        $customer->username = !empty($request->username) ? $request->username : $customer->username;
        $customer->name = !empty($request->name) ? $request->name : $customer->name;
        $customer->address = !empty($request->address) ? $request->address : $customer->address;
        $customer->email = !empty($request->email) ? $request->email : $customer->email;
        $customer->phone_number = !empty($request->phone_number) ? $request->phone_number : $customer->phone_number;
        $customer->password = !empty($request->password) ? Hash::make($request->password) : $customer->password;
        $customer->save();

        return redirect()
        ->route('application.users.customers.index')
        ->with('success_message', 'Berhasil mengupdate data pelanggan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = User::find($id);
        if(empty($customer)){
            return redirect()->back()->with('error_message', 'Mohon maaf data pelanggan tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        $customer->delete();

        return redirect()
        ->route('application.users.customers.index')
        ->with('success_message', 'Berhasil menghapus data pelanggan!');
    }
}
