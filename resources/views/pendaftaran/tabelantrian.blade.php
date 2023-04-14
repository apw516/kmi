<table class="table table-sm table-bordered table-hover" id="tabelpasien-antrian">
    <thead>
        <th width="100px" class="text-center">--</th>
        <th>Nomor Antrian</th>
        <th>Status</th>
        <th>No RM</th>
        <th>Nama Pasien</th>
        <th>Tanggal Antrian</th>
    </thead>
    <tbody>
        @foreach ($antrian as $d)
            <tr>
                <td class="text-center">
                    <button class="btn btn-success btn-sm panggil" idantrian="{{ $d->id }}"
                        noantrian="{{ $d->nomor_antrian }}"><i class="bi bi-telephone-outbound"></i></button>
                    <button class="btn btn-danger btn-sm batal" idantrian="{{ $d->id }}"
                        noantrian="{{ $d->nomor_antrian }}""><i class="bi bi-x-square"></i></button>
                </td>
                <td>{{ $d->nomor_antrian }}</td>
                <td>
                    @if ($d->status == '1')
                        <button class="badge badge-warning"> Dalam antrian !</button>
                    @elseif ($d->status == '2')
                        <button class="badge badge-info"> Dalam pelayanan !</button>
                    @elseif ($d->status == '3' || $d->status == '4')
                        <button class="badge badge-danger"> Proses Pembayaran !</button>
                    @else
                    <button class="badge badge-success"> Selesai </button>
                    @endif
                </td>
                <td>{{ $d->nomor_rm }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->tgl_antrian }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tabelpasien-antrian").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "order": [
                [2, 'desc']
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    });
    $('#tabelpasien-antrian').on('click', '.panggil', function() {
        id = $(this).attr('idantrian')
        nomorantri = $(this).attr('noantrian')
        Swal.fire({
            icon: 'question',
            title: 'Antrian ' + nomorantri + ' berhasil dipanggil ?',
            showDenyButton: true,
            confirmButtonText: 'Selesai',
            denyButtonText: `Batal`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                updateantrian(id)
            } else if (result.isDenied) {

            }
        })
    });
    $('#tabelpasien-antrian').on('click', '.batal', function() {
        id = $(this).attr('idantrian')
        nomorantri = $(this).attr('noantrian')
        Swal.fire({
            icon: 'warning',
            title: 'Antrian ' + nomorantri + ' akan dibatalkan ?',
            showDenyButton: true,
            confirmButtonText: 'Batal',
            denyButtonText: `Cancel`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                batalantrian(id)
            } else if (result.isDenied) {

            }
        })
    });

    function updateantrian(id) {
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                id
            },
            url: '<?= route('updateantrian') ?>',
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
                        'Pasien berhasil dipanggil !',
                        '',
                        'success'
                    )
                    ambildataantrian()
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
    function batalantrian(id) {
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                id
            },
            url: '<?= route('batalantrian') ?>',
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
                        'Antrian Dibatalkan !',
                        '',
                        'success'
                    )
                    ambildataantrian()
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
