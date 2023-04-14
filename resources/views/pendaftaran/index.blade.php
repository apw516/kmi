 <!-- Content Wrapper. Contains page content -->
 @extends('templates.main')
 @section('container')
     <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <div class="content-header">
             <div class="container-fluid">
                 <div class="row mb-2">
                     <div class="col-sm-6">
                         <h1 class="m-0">Cari Pasien</h1>
                     </div><!-- /.col -->
                     <div class="col-sm-6">
                         <ol class="breadcrumb float-sm-right">
                             <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                             <li class="breadcrumb-item active">Cari Pasien</li>
                         </ol>
                     </div><!-- /.col -->
                 </div><!-- /.row -->
             </div><!-- /.container-fluid -->
         </div>
         <!-- /.content-header -->

         <!-- Main content -->
         <section class="content">
             <div class="view_form">
                 <div class="container-fluid">
                     <button class="btn btn-success text-bold" data-toggle="modal" data-target="#modalpasienbaru"><i
                             class="mr-1 bi bi-plus text-bold"></i> Pasien Baru</button>
                 </div>
                 <!--/. container-fluid -->
                     <div class="form-row align-items-center mt-3">
                         <div class="col-sm-2 my-1">
                             <label class="sr-only" for="inlineFormInputName">Name</label>
                             <input type="text" class="form-control" id="inlineFormInputName" placeholder="Cari NIK ...">
                         </div>
                         <div class="col-sm-2 my-1">
                             <label class="sr-only" for="inlineFormInputName">Name</label>
                             <input type="text" class="form-control" id="inlineFormInputName"
                                 placeholder="Cari RM Lama ...">
                         </div>
                         <div class="col-sm-2 my-1">
                             <label class="sr-only" for="inlineFormInputName">Name</label>
                             <input type="text" class="form-control" id="inlineFormInputName"
                                 placeholder="Cari RM baru ...">
                         </div>
                         <div class="col-sm-2 my-1">
                             <label class="sr-only" for="inlineFormInputName">Name</label>
                             <input type="text" class="form-control" id="inlineFormInputName"
                                 placeholder="Cari Nama Pasien ...">
                         </div>
                         <div class="col-sm-2 my-1">
                             <label class="sr-only" for="inlineFormInputName">Name</label>
                             <input type="text" class="form-control" id="inlineFormInputName"
                                 placeholder="Cari Alamat ...">
                         </div>

                         <div class="col-auto my-1">
                             <button type="button" class="btn btn-primary">Submit</button>
                         </div>
                     </div>
                 <div class="view_utama mt-3">

                 </div>
             </div>
         </section>
         <!-- /.content -->
     </div>
     <!-- /.content-wrapper -->

     <!-- Modal -->
     <div class="modal fade" id="modalpasienbaru" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header bg-success">
                     <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-plus"></i> Data Pasien Baru</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <form method="post" class="form-pasien-baru">
                         <div class="form-group">
                             <label for="exampleInputEmail1">Nomor RM lama</label>
                             <input type="text" class="form-control" id="rm_lama" name="rm_lama"
                                 placeholder="Masukan nomor rm lama ...">
                             <small id="emailHelp" class="form-text text-muted">Silahkan isi nomor rm lama jika ada
                                 ...</small>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">NIK</label>
                             <input type="text" class="form-control" id="nik" name="nik"
                                 placeholder="Masukan nomor identitas ...">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Nama Pasien</label>
                             <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                 placeholder="Masukan nama pasien ...">
                         </div>
                         <div class="form-row">
                             <div class="form-group col-md-6">
                                 <label for="inputEmail4">Tempat</label>
                                 <input type="text" class="form-control" id="tempatlahir" name="tempatlahir"
                                     placeholder="Masukan tempat lahir ...">
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="inputPassword4">Tanggal Lahir</label>

                                 <div class="input-group mb-3">
                                     <input type="date" class="form-control" name="tgllahir" id="tgllahir"
                                         placeholder="Recipient's username" aria-label="Recipient's username"
                                         aria-describedby="basic-addon2">
                                     <div class="input-group-append">
                                     </div>
                                 </div>

                             </div>
                         </div>
                         <div class="form-row">
                             <div class="form-group col-md-6">
                                 <label for="inputEmail4">Jenis Kelamin</label>
                                 <div class="form-group">
                                     <select class="form-control" id="jeniskelamin" name="jeniskelamin">
                                         <option value="">Silahkan Pilih</option>
                                         <option value="Laki - laki">Laki - Laki</option>
                                         <option value="Perempuan">Perempuan</option>
                                     </select>
                                 </div>

                             </div>
                             <div class="form-group col-md-6">
                                 <label for="inputPassword4">Nomor Telepon / Handphone</label>

                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control"
                                         placeholder="Masukan nomor telepon / handphone ..."
                                         aria-label="Recipient's username" aria-describedby="basic-addon2" name="notelp"
                                         id="notelp">
                                     <div class="input-group-append"> <span class="input-group-text" id="basic-addon2"><i
                                                 class="bi bi-telephone-plus"></i></span>
                                     </div>
                                 </div>

                             </div>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Alamat</label>
                             <textarea type="text" class="form-control" id="alamat" name="alamat"
                                 placeholder="Masukan alamat lengkap ..."></textarea>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Riwayat Alergi</label>
                             <textarea type="text" class="form-control" id="riwayat_alergi" name="riwayat_alergi"
                                 placeholder="Masukan riwayat alergi jika ada ..."></textarea>
                         </div>
                         <button type="button" class="btn btn-primary" onclick="simpanpasien_baru()"><i
                                 class="bi bi-sd-card"></i> SIMPAN</button>
                     </form>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                             class="bi bi-arrow-clockwise"></i> Batal</button>
                 </div>
             </div>
         </div>
     </div>
     <script>
         $(document).ready(function() {
             ambildatapasien()
         });

         function simpanpasien_baru() {
             spinner = $('#loader')
             spinner.show();
             var data = $('.form-pasien-baru').serializeArray();
             $.ajax({
                 async: true,
                 type: 'post',
                 dataType: 'json',
                 data: {
                     _token: "{{ csrf_token() }}",
                     data: JSON.stringify(data),
                 },
                 url: '<?= route('simpanpasien_baru') ?>',
                 error: function(data) {
                     spinner.hide()
                     Swal.fire({
                         icon: 'error',
                         title: 'Oops...',
                         text: 'Something went wrong!',
                     })
                 },
                 success: function(data) {
                     spinner.hide()
                     if (data.kode == '200') {
                         Swal.fire(
                             'Data Pasien Disimpan !',
                             '',
                             'success'
                         )
                         ambildatapasien()
                         $('#modalpasienbaru').modal('hide');
                     } else {
                         Swal.fire({
                             icon: 'error',
                             title: 'Oops...',
                             text: data.message,
                         })
                     }

                 }
             });
         }
         function ambildatapasien() {
             spinner = $('#loader')
             spinner.show();
             $.ajax({
                 type: 'post',
                 data: {
                     _token: "{{ csrf_token() }}",
                 },
                 url: '<?= route('ambildatapasien') ?>',
                 success: function(response) {
                     spinner.hide()
                     $('.view_utama').html(response);
                 }
             });
         }
     </script>
 @endsection
