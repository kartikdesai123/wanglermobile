<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Wagler App | Login</title>

    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/plugins/dataTables/datatables.checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/plugins/fullcalendar/fullcalendar.print.css') }}" rel="stylesheet" media='print'>
    
    <link href="{{ asset('public/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/plugins/codemirror/codemirror.css') }}" rel="stylesheet">
    
    @if (!empty($css)) 
    @foreach ($css as $value) 
    @if(!empty($value))
    <link rel="stylesheet" href="{{ asset('public/css/'.$value) }}">
    @endif
    @endforeach
    @endif
    <script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
    <script>
            var baseurl = "{{ asset('') }}";
    </script>

</head>

