<table id="antriankasir" class="table table-sm table-hover">
    <thead>
        <th>Nomor Antrian</th>
        <th>Nomor RM</th>
        <th>Nama</th>
        <th>Status</th>
        <th>Detail Pembayaran</th>
    </thead>
    <tbody>
        @foreach ($antrian as $a)
        @if($a->status_layanan = 3)
            <tr>
                <td>{{ $a->nomor_antrian }}</td>
                <td>{{ $a->nomor_rm }}</td>
                <td>{{ $a->nama }}</td>
                <td>
                    @if($a->status == 3)
                    Dalam Antrian
                    @elseif ($a->status == 4)
                    Sedang Diproses
                    @elseif ($a->status == 5)
                    <button class="badge badge-success"> Selesai </button>
                    @endif
                </td>
                <td><button class="badge badge-info detailkasir" data-toggle="modal" data-target="#modaldetail_kasir" kodekunjungan="{{ $a->kode_kunjungan }}"><i class="bi bi-eye-fill"></i></button></td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldetail_kasir" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Detail Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="modaldetailkasir">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script>
    $(function() {
        $("#antriankasir").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "order": [
                [0, 'asc']
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    });
    $('#antriankasir').on('click', '.detailkasir', function() {
        kodekunjungan = $(this).attr('kodekunjungan')
        form_detail_kasir(kodekunjungan)
    });
    function form_detail_kasir(kodekunjungan) {
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kodekunjungan
            },
            url: '<?= route('ambildetail_kasir') ?>',
            success: function(response) {
                $('.modaldetailkasir').html(response);
            }
        });
    }
</script>
