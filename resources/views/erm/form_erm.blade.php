<button class="btn btn-danger" onclick="ambildatapasien()"><i class="bi bi-backspace mr-2"></i> Kembali</button>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('adminlte/dist/img/user4-128x128.jpg') }}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center mb-3">{{ strtoupper($datakunjungan[0]->nama_pasien) }}
                        </h3>

                        <p class="text-muted text-center">{{ $datakunjungan[0]->no_rm }}</p>

                        <ul class="list-group list-group-unbordered mb-3 mt-4">
                            <li class="list-group-item">
                                <b>NIK</b> <a class="float-right">{{ $mtpasien[0]->nik }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Tanggal Lahir</b> <a class="float-right">{{ $mtpasien[0]->tgl_lahir }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Alamat</b><br> <a class="float-right">{{ $mtpasien[0]->alamat }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Riwayat Alergi</b><br> <a class="float-right">{{ $mtpasien[0]->riwayat_alergi }}</a>
                            </li>
                        </ul>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Riwayat
                                    Medis</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Assesmen
                                    medis</a>
                            </li>
                            <li class="nav-item" onclick="tindakanhariini()"><a class="nav-link" href="#settings" data-toggle="tab">Tindakan dan
                                    Farmasi</a>
                            </li>
                            <li class="nav-item" onclick="resumemedis()"><a class="nav-link" href="#resume" data-toggle="tab">Resume Medis</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                riwayat
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                <form class="form-resume">
                                    <input type="text" hidden name="kode_kunjungan" id="kode_kunjungan"
                                        value="{{ $datakunjungan[0]->kode_kunjungan }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Tekanan Darah</label>
                                                <div class="input-group mb-3">
                                                    <input readonly type="text" class="form-control bg-light"
                                                        value="{{ $datakunjungan[0]->tekanan_darah }}"
                                                        name="tekanandarah" id="tekanandarah">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">mmHg</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Suhu Tubuh</label>
                                                <div class="input-group mb-3">
                                                    <input readonly type="text" class="form-control bg-light"
                                                        value="{{ $datakunjungan[0]->suhu_tubuh }}" name="suhutubuh"
                                                        id="tekanandarah">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">°C</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Keluhan Utama</label>
                                        <textarea type="text" class="form-control" name="keluhanutama" id="keluhanutama">{{ $datakunjungan[0]->keluhan_utama }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Diagnosa</label>
                                        <input type="text" class="form-control" id="diagnosa" name="diagnosa"
                                            value="{{ $datakunjungan[0]->diagx }}">
                                    </div>
                                    <button type="button" onclick="simpanresume()"
                                        class="btn btn-primary btnsimpan">Simpan</button>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <div class="row">
                                    <div class="col-md-5">
                                        <table id="tabeltarif" class="table table-sm table-hover text-xs">
                                            <thead>
                                                <th>Nama Tarif</th>
                                                <th>Tarif</th>
                                                <th>Jenis Tarif</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($tarif as $t)
                                                    <tr class="pilihlayanan" namatarif="{{ $t->NAMA_TARIF }}"
                                                        harga="{{ $t->TOTAL_TARIF_CURRENT }}"
                                                        kodetarif="{{ $t->KODE_TARIF_DETAIL }}">
                                                        <td>{{ $t->NAMA_TARIF }}</td>
                                                        <td>{{ $t->TOTAL_TARIF_CURRENT }}</td>
                                                        <td>
                                                            @if ($t->KELOMPOK_TARIF_ID == 4)
                                                                PAKET
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card">
                                            <div class="card-header bg-success">Riwayat Hari Ini</div>
                                            <div class="card-body">
                                                <div class="tindakanhariini">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header bg-success">Tindakan / Layanan Pasien</div>
                                            <div class="card-body">
                                                <form action="" method="post" class="formtindakan">
                                                    <div class="input_fields_wrap">
                                                        <div>
                                                        </div>
                                                        <button type="button"
                                                            class="btn btn-warning mb-2 simpanlayanan"
                                                            id="simpanlayanan">Simpan Tindakan</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="card-footer">
                                                <p>pilih layanan untuk pasien</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="resume">
                               <div class="resumenya">

                               </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <script>
        function simpanresume() {
            var data1 = $('.form-resume').serializeArray();
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data1),
                },
                url: '<?= route('simpanresume') ?>',
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                },
                success: function(data) {
                    if (data.kode == '200') {
                        Swal.fire(
                            'Data Pasien Disimpan !',
                            '',
                            'success'
                        )
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
        $(function() {
            $("#tabeltarif").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
        $('#tabeltarif').on('click', '.pilihlayanan', function() {
            var max_fields = 10; //maximum input boxes allowed
            var wrapper = $(".input_fields_wrap"); //Fields wrapper
            var x = 1; //initlal text box count
            kode = $(this).attr('kodetarif')
            namatindakan = $(this).attr('namatarif')
            tarif = $(this).attr('harga')
            // e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append(
                    '<div class="form-row text-xs"><div class="form-group col-md-5"><label for="">Tindakan</label><input readonly type="" class="form-control form-control-sm text-xs" id="" name="namatindakan" value="' +
                    namatindakan +
                    '"><input hidden readonly type="" class="form-control form-control-sm" id="" name="kodelayanan" value="' +
                    kode +
                    '"></div><div class="form-group col-md-2"><label for="inputPassword4">Tarif</label><input readonly type="" class="form-control form-control-sm" id="" name="tarif" value="' +
                    tarif +
                    '"></div><div class="form-group col-md-1"><label for="inputPassword4">Jumlah</label><input type="" class="form-control form-control-sm" id="" name="qty" value="1"></div><div class="form-group col-md-2"><label for="inputPassword4">Disc</label><input type="" class="form-control form-control-sm" id="" name="disc" value="0"></div><div class="form-group col-md-4"><label for="inputPassword4">Keterangan</label><textarea type="" class="form-control form-control-sm" id="" name="keterangan"></textarea></div><i class="bi bi-x-square remove_field form-group col-md-2 text-danger"></i></div>'
                );
                $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;
                })
            }
        });
        $(".simpanlayanan").click(function() {
            var data = $('.formtindakan').serializeArray();
            var kodekunjungan = $('#kode_kunjungan').val()
            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    data: JSON.stringify(data),
                    kodekunjungan: kodekunjungan,
                },
                url: '<?= route('simpanlayanan') ?>',
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Sepertinya ada masalah ...',
                        footer: ''
                    })
                },
                success: function(data) {
                    if (data.kode == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message,
                            footer: ''
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: 'Data berhasil disimpan!',
                            footer: ''
                        })
                        tindakanhariini()
                    }
                }
            });
        });
        $(document).ready(function() {
            tindakanhariini()
        });

        function tindakanhariini() {
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    kodekunjungan: $('#kode_kunjungan').val()
                },
                url: '<?= route('tindakanhariini') ?>',
                error: function(data) {
                    alert('ok')
                },
                success: function(response) {
                    $('.tindakanhariini').html(response)
                }
            });
        }
        function resumemedis() {
            $.ajax({
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    kodekunjungan: $('#kode_kunjungan').val()
                },
                url: '<?= route('resume_hari_ini') ?>',
                error: function(data) {
                    alert('ok')
                },
                success: function(response) {
                    $('.resumenya').html(response)
                }
            });
        }
    </script>
</section>
