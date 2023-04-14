<table id="tabelriwayat_order" class="table table-sm">
    <thead>
        <th>--</th>
        <th>Kode layanan Header</th>
        <th>Total Layanan</th>
        <th>Status</th>
    </thead>
    <tbody>
        @foreach ($riwayat as $r)
            <tr>
                <td>
                    <button class="badge badge-detail badge-info detailorder" data-toggle="modal"
                        data-target="#modaldetail_order"><i class="bi bi-eye-fill"></i></button>
                    <button id="{{ $r->id }}" kodelayananheader="{{ $r->kode_layanan_header }}"
                        class="badge badge-detail badge-danger batalorder"><i class="bi bi-trash"></i></button>
                </td>
                <td>{{ $r->kode_layanan_header }}</td>
                <td>{{ $r->tagihan_pribadi }}</td>
                <td>
                    @if( $r->status_layanan == 1) <label class="bg-warning">Belum konfirmasi </label>
                    @elseif( $r->status_layanan == 2)<label class="bg-success">Aktif </label>
                    @elseif( $r->status_layanan == 9)<label class="bg-danger">Batal</label>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldetail_order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="vd_order">

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
        $("#tabelriwayat_order").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "order": [
                [0, 'asc']
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    });
    $('#tabelriwayat_order').on('click', '.batalorder', function() {
        id = $(this).attr('id')
        kodelayanan = $(this).attr('kodelayananheader')
        Swal.fire({
            icon: 'warning',
            text: 'Layanan ' + kodelayanan + ' akan dibatalkan ?',
            showDenyButton: true,
            confirmButtonText: 'Batal',
            denyButtonText: `Cancel`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                batalorder(id)
            } else if (result.isDenied) {

            }
        })
    });

    function batalorder(id) {
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                id
            },
            url: '<?= route('batalorder') ?>',
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
                        'Layanan dibatalkan ..',
                        '',
                        'success'
                    )
                    tindakanhariini()
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
</script>
