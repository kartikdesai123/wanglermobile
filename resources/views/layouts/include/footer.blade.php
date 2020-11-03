
<!-- Mainly scripts -->

<script src="{{ asset('public/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('public/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('public/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('public/js/plugins/dataTables/datatables.checkbox.js') }}"></script>
<script src="{{ asset('public/js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('public/js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('public/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('public/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

<script src="{{ asset('public/js/plugins/codemirror/codemirror.js') }}"></script>
<script src="{{ asset('public/js/plugins/codemirror/mode/xml/xml.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('public/js/inspinia.js') }}"></script>
<script src="{{ asset('public/js/plugins/pace/pace.min.js') }}"></script>

<!-- Page-Level Scripts -->

<script src="{!! asset('public/js/plugins/validate/jquery.validate.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('public/js/plugins/toastr/toastr.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('public/js/comman_function.js') !!}" type="text/javascript"></script>

<div id="deleteModel" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12"><h3 class="m-t-none m-b">Delete Record</h3>
                        <b>Are You sure want to delete record.</b><br/>
                        <form role="form">
                            <div>
                                <button class="btn btn-sm btn-primary pull-right m-l" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-sm btn-danger pull-right yes-sure m-l" type="button"><strong><i class="fa fa-trash"></i> Delete </strong></button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@if (!empty($js)) 
@foreach ($js as $value) 
<script src="{{ asset('public/js/'.$value) }}" type="text/javascript"></script>
@endforeach
@endif
<script>
        jQuery(document).ready(function() {
        @if (!empty($funinit))
                @foreach ($funinit as $value)
        {{  $value }}
        @endforeach
                @endif
        });
</script>
@section('scripts')
@show


