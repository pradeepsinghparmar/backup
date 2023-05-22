<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>ClinDCast Time Logs</title>
    <!-- Custom fonts for this template-->
    

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <!--<link href="{{ asset('admin/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">-->

    <!--MULTISELECT-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @yield('content')
            </div>
            <!-- End of Main Content -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!--<script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>-->

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/assets/js/sb-admin-2.min.js') }}"></script>
    <!-- Page level plugins -->
    <!-- Page level custom scripts -->
    <!--<script src="{{ asset('admin/assets/js/demo/chart-area-demo.js') }}"></script>-->
    <!--<script src="{{ asset('admin/assets/js/demo/chart-pie-demo.js') }}"></script>-->
    <!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->
    <script src="{{ asset('admin/assets/multiselect/multiselect.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <!--dropdown multiselect-->
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin/assets/js/custom.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
     <!--<script src="{{ asset('admin/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>-->
    <!--<script src="{{ asset('admin/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>-->

    <!-- Page level custom scripts -->
    <!--<script src="{{ asset('admin/assets/js/demo/datatables-demo.js') }}"></script>-->
    <script>
      $(document).ready(function() {
        $('.export_example').DataTable( {
            order: [[ 0, "asc" ]],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                // 'csvHtml5',
                // 'pdfHtml5',
                 'print'
            ],
            alengthChange: true,
            alengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            pageLength: 500,
        });
    });
</script>
</body>
</html>
           