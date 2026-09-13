<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('assets/admin/node_modules/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/admin/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script>
    $.fn.tooltip = $.fn.tooltip || function() {
        return this;
    };
    $.fn.popover = $.fn.popover || function() {
        return this;
    };
</script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('assets/admin/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('assets/admin/dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('assets/admin/dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('assets/admin/dist/js/custom.min.js') }}"></script>

<!-- jQuery file upload -->
<script src="{{ asset('assets/admin/node_modules/dropify/dist/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>

<!-- Data Table -->
<script src="{{ asset('assets/admin/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
<script>
    $(function() {
        $('.admin-data-table').DataTable({
            ordering: false,
            lengthChange: false,
            searching: false,
        });
    });
</script>

<!-- Custom admin scripts -->
<script src="{{ asset('assets/admin/dist/js/custom.js') }}"></script>
