@php

$currentRoute = Route::current()->getName();

$session = Session::all();
$data = $session['logindata'][0];
if (!empty(Auth()->guard()->user())) {
$data = Auth()->guard()->user();
}
if (!empty(Auth()->guard('employee')->user())) {
$data = Auth()->guard('employee')->user();
}

@endphp
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        @if($data['user_image'] != '' || $data['user_image'] != NULL)
                        <img class="img-circle" width="50" src="{{ asset('public/uploads/users/'.$data['user_image']) }}" alt="User's Profile Picture">
                        @else
                        <img class="img-circle" width="50" src="{{ asset('/public/img/profile_small.jpg') }}" alt="User's Profile Picture">
                        @endif
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ $data['firstname'] }} {{ $data['lastname'] }} </strong>
                            </span> <span class="text-muted text-xs block">{{ $data['type'] }}<b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('admin-update-profile') }}">Update Profile</a></li>
                        <li><a href="{{ route('admin-change-password') }}">Change Password</a></li>

                        <li class="divider"></li>
                        <li><a href="{{ route("logout")}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    WA
                </div>
            </li>
            <li class="{{ ($currentRoute == 'admin-dashboard' ? 'active' : '') }}">
                <a href="{{ route('admin-dashboard') }}"><i class="fa fa-laptop"></i> <span class="nav-label">Dashborad</span></a>
            </li>

            <li class="{{ ($currentRoute == 'admin-users' || $currentRoute == 'edit-users' || $currentRoute == 'add-users' ? 'active' : '') }} ">
                <a href="{{ route('admin-users') }}"><i class="fa fa-users"></i> <span class="nav-label">Users</span></a>
            </li>

            <li class="{{ ($currentRoute == 'admin-customer'  ? 'active' : '') }} ">
                <a href="{{ route('admin-customer') }}"><i class="fa fa-user-o"></i> <span class="nav-label">Customer</span></a>
            </li>

            <li class="{{ ($currentRoute == 'admin-product'  ? 'active' : '') }} ">
                <a href="{{ route('admin-product') }}"><i class="fa fa-product-hunt"></i> <span class="nav-label">Product</span></a>
            </li>
            <li class="{{ ($currentRoute == 'admin-invoice'  ? 'active' : '') }} ">
                <a href="{{ route('admin-invoice') }}"><i class="fa fa-list"></i><span class="nav-label">Invoice</span></a>
            </li>
        </ul>

    </div>
</nav>