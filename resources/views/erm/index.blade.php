@extends('templates.main')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Pasien</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Pasien</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="view_pasien">

            </div>
        </section>
        <!-- /.content -->
    </div>
    <script>
        $(document).ready(function() {
            ambildatapasien()
        });

        function ambildatapasien() {
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                url: '<?= route('ambildatapasien_erm') ?>',
                success: function(response) {
                    spinner.hide()
                    $('.view_pasien').html(response);
                }
            });
        }
    </script>
@endsection
