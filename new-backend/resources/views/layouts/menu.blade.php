<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('application.dashboard') }}" class="nav-link {{ ( !empty($active_page) && $active_page == 'dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>

@if( auth()->user()->hasAnyRole(['Admin','Super Admin']))
    <li class="nav-item {{ ( !empty($active_page) && $active_page == 'users') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ ( !empty($active_page) && $active_page == 'users') ? 'active' : '' }}"">
            <i class="nav-icon fa fa-list"></i><span>Daftar Pengguna</span>
            <p>
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link {{ ( !empty($active_subpage) && $active_subpage == 'customers') ? 'active' : '' }}" href="{{ route('application.users.customers.index') }}"> <i class="nav-icon fa fa-user"></i>
                    Pelanggan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ( !empty($active_subpage) && $active_subpage == 'workers') ? 'active' : '' }}" href="{{ route('application.users.workers.index') }}"> <i class="nav-icon fa fa-user"></i>
                    Pekerja
                </a>
            </li>
            @if( auth()->user()->hasAnyRole(['Super Admin']))
                <li class="nav-item">
                    <a class="nav-link {{ ( !empty($active_subpage) && $active_subpage == 'admins') ? 'active' : '' }}" href="{{ route('application.users.admins.index') }}"> <i class="nav-icon fa fa-user"></i>
                        Admin
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ( !empty($active_subpage) && $active_subpage == 'super-admins') ? 'active' : '' }}" href="{{ route('application.users.super-admins.index') }}"> <i class="nav-icon fa fa-user"></i>
                        Super Admin
                    </a>
                </li>
            @endif
        </ul>
    <li>
@endif


