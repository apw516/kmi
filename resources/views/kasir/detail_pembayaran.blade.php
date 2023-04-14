<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> AdminLTE, Inc.
                {{-- <small class="float-right">Tanggal : {{ $resume[0]->tgl_masuk }}</small> --}}
            </h4>
        </div>
        <!-- /.col -->
    </div>

    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped text-xs">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Nama Tarif</th>
                        <th>Kode Tarif</th>
                        <th>Keterangan</th>
                        <th>Total tarif</th>
                        <th>Discount</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tindakan as $t)
                        <tr>
                            <td>{{ $t->jumlah_layanan }}</td>
                            <td>{{ $t->NAMA_TARIF }}</td>
                            <td>{{ $t->kode_tarif_detail }}</td>
                            <td>{{ $t->keterangan }}</td>
                            <td>{{ $t->total_tarif }}</td>
                            <td>{{ $t->diskon_layanan }} %</td>
                            <td>{{ $t->total_detail }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- /.col -->
        <div class="col-6">
            <p class="lead">Tanggal Entry 2/22/2014</p>
            <input hidden type="text" value="{{ $tindakan[0]->kode_kunjungan }}" id="kode_kunjungan">
            <input hidden type="text" value="{{ $tindakan[0]->id_header }}" id="idheader">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Total Semua:</th>
                        <td>{{ $tindakan[0]->tagihan_pribadi }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-6">
            <form class="formkasir" hidden>
                <div class="form-group">
                    <label for="exampleInputEmail1">TOTAL SEMUA</label>
                    <input type="email" class="form-control" id="totaltagihan" aria-describedby="emailHelp"
                        value="{{ $tindakan[0]->tagihan_pribadi }}">
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control col-sm-12" id="uangbayar" placeholder="Bayar ..."
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-dark btn-warning" onclick="hitungkembalian()" type="button"
                                id="button-addon2"><i class="bi bi-coin mr-2"></i>Kembalian</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">TOTAL KEMBALIAN</label>
                    <input type="text" class="form-control" id="kembalian" aria-describedby="emailHelp">
                </div>
                <button type="button" class="btn btn-primary" onclick="simpanpembayaran()"><i
                        class="bi bi-cash-coin mr-2"></i>Simpan</button>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div style="margin-top:100px"class="row no-print">
        <div class="col-12">
            {{-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> --}}
            @if ($tindakan[0]->status_layanan == 2)
                <button onclick="prosesterima()"type="button" class="btn btn-success float-right"><i
                        class="far fa-credit-card mr-2"></i>Terima
                </button>
                @elseif ($tindakan[0]->status_layanan == 4)
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Well done!</h4>
                    <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
                    <hr>
                    <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                  </div>
            @else
                <button onclick="bayar()"type="button" class="btn btn-success float-right bayar"><i
                        class="far fa-credit-card mr-2"></i>Form Kasir
                </button>
                <button onclick="batal()"type="button" class="btn btn-danger mr-2 float-right batal"><i
                        class="bi bi-x-circle mr-2"></i>Batal
                </button>

            @endif
            {{-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
          <i class="fas fa-download"></i> Generate PDF
        </button> --}}
        </div>
    </div>
</div>
<script>
    function bayar() {
        $('.formkasir').removeAttr('Hidden', true)
        $('.bayar').attr('Hidden', true)
        $('.batal').attr('Hidden', true)
    }

    function hitungkembalian() {
        a = $('#totaltagihan').val()
        b = $('#uangbayar').val()
        if (b == '') {
            alert('Isi uang bayar pasien !')
        } else {
            ab = b - a
            $('#kembalian').val(ab)
        }

    }

    function batal() {
        kodekunjungan = $('#kode_kunjungan').val()
        idheader = $('#idheader').val()
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                kodekunjungan: kodekunjungan,
                idheader: idheader,
            },
            url: '<?= route('prosesbatal') ?>',
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
                        text: 'Detail pembayaran dibatalkan ...',
                        footer: ''
                    })
                    $('#modaldetail_kasir').modal('hide');
                    ambildatapasien_bayar()
                }
            }
        });
    }

    function prosesterima() {
        kodekunjungan = $('#kode_kunjungan').val()
        idheader = $('#idheader').val()
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                kodekunjungan: kodekunjungan,
                idheader: idheader,
            },
            url: '<?= route('prosesterima') ?>',
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
                        text: 'Detail pembayaran disimpan...',
                        footer: ''
                    })
                    $('#modaldetail_kasir').modal('hide');
                    ambildatapasien_bayar()
                }
            }
        });
    }

    function simpanpembayaran() {
        totaltagihan = $('#totaltagihan').val()
        uangbayar = $('#uangbayar').val()
        kembalian = $('#kembalian').val()
        kode_kunjungan = $('#kode_kunjungan').val()
        idheader = $('#idheader').val()
        if (uangbayar == '') {
            alert('Isi uang bayar pasien !')
        } else {
            if (kembalian < 0) {
                alert('Nominal pembayaran tidak sesuai !')
            } else {
                simpandata(totaltagihan, uangbayar, kembalian, kode_kunjungan, idheader)
            }
        }
    }

    function simpandata(totaltagihan, uangbayar, kembalian, kode_kunjungan, idheader) {
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                totaltagihan,
                uangbayar,
                kembalian,
                kode_kunjungan,
                idheader
            },
            url: '<?= route('simpanpembayaran') ?>',
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
                        text: 'Pembayaran Berhasil',
                        footer: ''
                    })
                    $('#modaldetail_kasir').modal('hide');
                    ambildatapasien_bayar()
                }
            }
        });
    }
</script>
