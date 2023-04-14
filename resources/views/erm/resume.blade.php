<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> AdminLTE, Inc.
                <small class="float-right">Tanggal : {{ $resume[0]->tgl_masuk }}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Data Pasien
            <address>
                <strong>{{ $resume[0]->nama_pasien }}</strong><br>
                NO RM : {{ $resume[0]->no_rm }}<br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <strong>Resume</strong>
            <address>
                Diagnosa : <strong>{{ $resume[0]->diagx }}</strong><br>
                Keluhan Utama : <strong>{{ $resume[0]->keluhan_utama }}</strong><br>
                Tekanan Darah : <strong>{{ $resume[0]->tekanan_darah }} mmHg</strong><br>
                Riwayat Alergi : <strong>{{ $resume[0]->riwayat_alergi }} </strong><br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Kunjungan Ke #{{ $resume[0]->counter }}</b><br>
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
        <!-- accepted payments column -->
        <div class="col-6">
            {{-- <p class="lead">Payment Methods:</p>
        <img src="../../dist/img/credit/visa.png" alt="Visa">
        <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
        <img src="../../dist/img/credit/american-express.png" alt="American Express">
        <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
          plugg
          dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p> --}}
        </div>
        <!-- /.col -->
        <div class="col-6">
            <p class="lead">Tanggal Entry 2/22/2014</p>
            <input hidden type="text" value="{{ $tindakan[0]->id_header }}" id="idheader">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Total:</th>
                        <td>{{ $tindakan[0]->tagihan_pribadi }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            {{-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> --}}
            @if($tindakan[0]->status_layanan == 1)
            <button onclick="prosesbayar()"type="button" class="btn btn-success float-right"><i
                    class="far fa-credit-card mr-2"></i>Selesai
            </button>
            @endif
            {{-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
          <i class="fas fa-download"></i> Generate PDF
        </button> --}}
        </div>
    </div>
</div>
<script>
    function prosesbayar() {
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
            url: '<?= route('prosesbayar') ?>',
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
                        text: 'Pelayanan medis selesai !',
                        footer: ''
                    })
                    ambildatapasien()
                }
            }
        });
    }
</script>
