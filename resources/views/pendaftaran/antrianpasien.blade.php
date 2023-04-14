 <!-- Content Wrapper. Contains page content -->
 @extends('templates.main')
 @section('container')
     <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <div class="content-header">
             <div class="container-fluid">
                 <div class="row mb-2">
                     <div class="col-sm-6">
                         <h1 class="m-0">Data Antrian</h1>
                     </div><!-- /.col -->
                     <div class="col-sm-6">
                         <ol class="breadcrumb float-sm-right">
                             <li class="breadcrumb-item"><a href="#">Cari Pasien</a></li>
                             <li class="breadcrumb-item active">Data Antrian</li>
                         </ol>
                     </div><!-- /.col -->
                 </div><!-- /.row -->
             </div><!-- /.container-fluid -->
         </div>
         <!-- /.content-header -->

         <!-- Main content -->
         <section class="content">
             <div class="view_form">
                 <div class="view_antrian mt-3">

                 </div>
             </div>
         </section>
         <!-- /.content -->
     </div>
     <script>
         $(document).ready(function() {
             ambildataantrian()
         });
         function ambildataantrian() {
             spinner = $('#loader')
             spinner.show();
             $.ajax({
                 type: 'post',
                 data: {
                     _token: "{{ csrf_token() }}",
                 },
                 url: '<?= route('ambilantrian') ?>',
                 success: function(response) {
                     spinner.hide()
                     $('.view_antrian').html(response);
                 }
             });
         }
     </script>
 @endsection
