<!-- jQuery (only one version - load first) -->
<script src="{{ asset('js/bootstrap/jquery-3.7.1.min.js') }}?v=1.0" type="text/javascript"></script>

<!-- jQuery UI for Datepicker -->
<link rel="stylesheet" href="{{ asset('css/ui/1.13.1/themes/base/jquery-ui.css') }}?v=1.0">
<script src="{{ asset('js/ui/1.13.2/jquery-ui.js') }}?v=1.0"></script>

<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}?v=1.0" type="text/javascript"></script>

<!-- Select2 -->
<script src="{{ asset('js/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}?v=1.0"></script>

<!-- Chart.js & Patternomaly -->
<script src="{{ asset('js/npm/chart.js') }}?v=1.0"></script>
<script src="{{ asset('js/npm/patternomaly.js') }}?v=1.0"></script>
<script src="{{ asset('js/npm/sweetalert2@11.js') }}?v=1.0"></script>
<!-- DataTables core + extensions -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}?v=1.0"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}?v=1.0"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}?v=1.0"></script>
<script src="{{ asset('js/jszip.min.js') }}?v=1.0"></script>
<script src="{{ asset('js/pdfmake.min.js') }}?v=1.0"></script>
<script src="{{ asset('js/vfs_fonts.js') }}?v=1.0"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}?v=1.0"></script>
<script src="{{ asset('js/buttons.print.min.js') }}?v=1.0"></script>

<!-- Custom script -->
<script src="{{ asset('js/bootstrap/script.js') }}?v=1.0"></script>

<!-- Toastr -->
<script src="{{ asset('js/toastr.min.js') }}?v=1.0" type="text/javascript"></script>

<!-- Initialize components -->
<script>
    $(document).ready(function () {
        // DataTable initialization
        $('#myTable').DataTable({
            searching: true,
            paging: false,
            info: false,
            pageLength: 100
        });

        // Datepicker
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>

<!-- Laravel flash messages -->
@if(session()->has('error'))
    <script>console.error("Error: {{ session('error') }}");</script>
@endif

@if(session()->has('message'))
    <script>console.log("Message: {{ session('message') }}");</script>
@endif

@if(session()->has('info'))
    <script>console.info("Info: {{ session('info') }}");</script>
@endif

</body>
</html>
