@extends('layouts.app')
    @section('content')
        <div class="wrapper wrapper-content">
            <a class="btn btn-primary btn-rounded btn-block authorizationAccount" href="#"><i class="fa fa-info-circle"></i> Authorization your account</a>
        </div>
    <script>
        var url = '<?php echo $authUrl; ?>';
    </script>
    @endsection
