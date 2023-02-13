@extends('layouts.app')

@section('content')
<!-- Main content -->

<section class="content">
    <section class="section">
        <div class="card">
            <div class="card-body" style="padding: 5px 10px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="margin-bottom: 0px !important;">
                    <li class="breadcrumb-item"><a href="{{ route('application.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('application.users.workers.index') }}">Daftar pekerja</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit pekerja</li>
                </ol>
            </nav>
            </div>
        </div>
    </section>
    <br>
    <div class="main-container">
        <section>
            <div>
                <div class="title-block">
                    <h1 class="title">Edit pekerja</h1>
                    <p class='title-description'>Gunakan form dibawah untuk Merubah data pekerja.</p>
                </div>
            </div>
        </section>
        <br>
        <section class="section">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title-body">
                                <h3 class="title">Edit pekerja</h3>
                            </div>
                            <form action="{{ route('application.users.workers.update', $worker) }}" method="POST" style="margin-bottom: 0">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <section>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mb-1">
                                            <div class="form-group">
                                                <label class="control-label">Username</label>
                                                <input type="text" class="form-control boxed" name="username" value="{{ old('username', $worker->username) }}" placeholder="Masukkan Username pekerja">
                                                @error('username')
                                                    <span class="has-error">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-1">
                                            <div class="form-group">
                                                <label class="control-label">Nomor telefon</label>
                                                <input type="text" class="form-control underlined" name="phone_number" value="{{ old('phone_number', $worker->phone_number) }}" placeholder="Masukkan Nomor Telefon pekerja">
                                                @error('phone_number')
                                                    <span class="has-error">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 mb-1">
                                            <div class="form-group">
                                                <label class="control-label">Nama</label>
                                                <input type="text" class="form-control underlined" name="name" value="{{ old('name', $worker->name) }}" placeholder="Masukkan Nama pekerja">
                                                @error('name')
                                                    <span class="has-error">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 mb-1">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="mail" class="form-control underlined" name="email" value="{{ old('email', $worker->email) }}" placeholder="Masukkan Email pekerja">
                                                @error('email')
                                                    <span class="has-error">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 mb-1">
                                            <div class="form-group">
                                                <label class="control-label">Alamat</label>
                                                <textarea type="text" class="form-control underlined" name="address" placeholder="Masukkan Alamat pekerja">{{ old('address', $worker->address) }}</textarea>
                                                @error('address')
                                                    <span class="has-error">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @if(auth()->user()->hasAnyRole(['Super Admin']))
                                            <div class="col-sm-12 col-md-12 mb-1">
                                                <div class="form-group">
                                                    <label class="control-label">Cabang</label>
                                                    <select name="tenant_id" class="form-select form-select-lg">
                                                        <option value="">Pilih Salah Satu Cabang</option>
                                                        @foreach ($tenants as $tenant)
                                                            <option value="{{ $tenant->id }}" @if($tenant->id == $worker->tenant_id) selected @endif>{{ $tenant->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('address')
                                                        <span class="has-error">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-sm-12">
                                            <label>Password</label>
                                            <input type="password" name="password" id="password" class="form-control underlined" placeholder="Masukkan Password (Kosongkan bila password tidak dirubah)">
                                            @error('password')
                                                <span class="has-error">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Konfirmasi ulang password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control underlined" placeholder="Masukkan ulang password (Kosongkan bila password tidak dirubah)">
                                            @error('password_confirmation')
                                                <span class="has-error">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-12 mt-3">
                                            <div class="form-group">
                                                <button class="btn btn-primary" style="width: 30%;">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.card -->

  </section>

@endsection
