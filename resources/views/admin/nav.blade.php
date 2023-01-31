<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 fixed">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="\assets\perpus\assets\img\logoperpus.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">{{-- Auth::user()->username --}}Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="\assets\perpus\assets\img\profile-img.png" class="img-circle" alt="">
                <!-- <img src="/assets/adminlte/dist/img/" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            {{-- <div class="info">
                <a href="{{url('/admin')}}" class="d-block">{{Auth::user()->name}}</a>
            </div> --}}
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/" class="nav-link @if (request()->segment(count(request()->segments())) == '') {{'active'}} @endif">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">Keys Menu</li>
                @if (Auth::user()->role < 1)
                <li class="nav-item">
                    <a href="/users" class="nav-link @if (request()->segment(count(request()->segments())) == 'users') {{'active'}} @endif">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/keys" class="nav-link @if (request()->segment(count(request()->segments())) == 'keys') {{'active'}} @endif">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Key Stock
                        </p>
                    </a>
                </li>
                @endif
                @if (Auth::user()->role < 2)
                <li class="nav-item">
                    <a href="/plans" class="nav-link @if (request()->segment(count(request()->segments())) == 'plans') {{'active'}} @endif">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>
                            Consumed Keys
                        </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
