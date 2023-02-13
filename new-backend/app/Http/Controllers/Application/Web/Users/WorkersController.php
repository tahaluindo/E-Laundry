<?php

namespace App\Http\Controllers\Application\Web\Users;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class WorkersController extends Controller
{

    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if( !auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Tenant User'])) {
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
        $workers = User::role('Worker User')->orderBy('name', 'asc');

        if(!auth()->user()->hasAnyRole(['Super Admin'])){
            $workers = $workers->where('tenant_id', auth()->user()->tenant_id);
        }

        if(!empty($request->username)){
            $workers = $workers->where('username', 'LIKE', '%'.$request->username.'%');
        }

        if(!empty($request->phone_number)){
            $workers = $workers->where('phone_number', 'LIKE', '%'.$request->phone_number.'%');
        }

        if(!empty($request->name)){
            $workers = $workers->where('name', 'LIKE', '%'.$request->name.'%');
        }

        $workers = $workers->paginate(20);

        return view('application.users.workers.index',[
            'workers' => $workers,
            'active_page' => 'users',
            'active_subpage' => 'workers',
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
        return view('application.users.workers.create',[
            'tenants' => $tenants,
            'active_page' => 'users',
            'active_subpage' => 'workers',
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

        $worker = User::where('username', $request->username)->first();
        if(empty($worker)){
            $worker = new User();
        } else {
            return redirect()->back()->with('error_message', 'Username ini sudah terpakai, silahkan gunakan username lain untuk mendaftar');
        }

        $worker->username = $request->username;
        $worker->name = $request->name;
        $worker->address = $request->address;
        $worker->email = $request->email;
        $worker->phone_number = $request->phone_number;
        $worker->password = Hash::make($request->password);

        if(!auth()->user()->hasAnyRole(['Super Admin'])){
            $worker->tenant_id = auth()->user()->tenant_id;
        } else {
            $worker->tenant_id = $request->tenant_id;
        }

        $worker->save();

        $worker->assignRole('Worker User');

        return redirect()
        ->route('application.users.workers.index')
        ->with('success_message', 'Berhasil menambahkan pekerja!');
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
        $worker = User::find($id);

        if(empty($worker)){
            return redirect()->back()->with('error_message', 'Mohon maaf data pekerja tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        return view('application.users.workers.edit',[
            'worker' => $worker,
            'active_page' => 'users',
            'active_subpage' => 'workers',
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

        $worker= User::find($id);
        if(empty($worker)){
            return redirect()->back()->with('error_message', 'Mohon maaf data pekerja tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        $worker->username = !empty($request->username) ? $request->username : $worker->username;
        $worker->name = !empty($request->name) ? $request->name : $worker->name;
        $worker->address = !empty($request->address) ? $request->address : $worker->address;
        $worker->email = !empty($request->email) ? $request->email : $worker->email;
        $worker->phone_number = !empty($request->phone_number) ? $request->phone_number : $worker->phone_number;
        $worker->password = !empty($request->password) ? Hash::make($request->password) : $worker->password;

        if(!auth()->user()->hasAnyRole(['Super Admin'])){
            $worker->tenant_id = auth()->user()->tenant_id;
        } else {
            $worker->tenant_id = $request->tenant_id;
        }

        $worker->save();

        return redirect()
        ->route('application.users.workers.index')
        ->with('success_message', 'Berhasil mengupdate data pekerja!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $worker = User::find($id);

        if(empty($worker)){
            return redirect()->back()->with('error_message', 'Mohon maaf data pekerja tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        $worker->delete();

        return redirect()
        ->route('application.users.workers.index')
        ->with('success_message', 'Berhasil menghapus data pekerja!');
    }
}
