<!DOCTYPE html>
<html>
    @include('layouts.include.header')
    <body >
     <div id="wrapper">
        @php
            if (!empty(Auth()->guard()->user())) {
                $data = Auth()->guard()->user();
            }
            if (!empty(Auth()->guard('employee')->user())) {
                $data = Auth()->guard('employee')->user();
            }
        @endphp
            
            
        @if($data['type'] == 'ADMIN')
            @include('layouts.include.leftpanel.admin-left-sidebar')
        @elseif($data['type'] == 'EMPLOYEE')
            @include('layouts.include.leftpanel.employee-left-sidebar')
        @endif   
        
        <div id="page-wrapper" class="gray-bg dashbard-1">
            @include('layouts.include.body_header')
            @include('layouts.include.breadcrumb')
            @include('layouts.include.message')
            @yield('content')
            @include('layouts.include.body_footer')
        </div>
    </div>
    @include('layouts.include.footer')
</body>
</html>