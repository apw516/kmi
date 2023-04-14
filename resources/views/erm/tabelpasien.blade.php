<table id="tablepasienerm" class="table table-sm table-hover">
    <thead>
        <th>Antrian</th>
        <th>Status Antrian</th>
        <th>Nomor RM</th>
        <th>Nama Pasien</th>
        <th>Keluhan Utama</th>
    </thead>
    <tbody>
        @foreach ($data_erm as $d)
            @if ($d->status_antrian != null)
                <tr class="isi_erm" nomorrm="{{ $d->no_rm }}" kodekunjungan={{ $d->kode_kunjungan }}>
                    <td>{{ $d->nomor_antrian }}</td>
                    <td>
                        @if ($d->status_antrian == 1 || $d->status_antrian == 2)
                            Dalam antrian
                        @elseif ($d->status_antrian == 3 || $d->status_antrian == 4)
                            Proses Pembayaran
                        @elseif ($d->status_antrian == 5)
                            <button class="badge badge-success"> Selesai </button>
                        @else
                            Batal
                        @endif
                    </td>
                    <td>{{ $d->no_rm }}</td>
                    <td>{{ $d->nama_pasien }}</td>
                    <td>{{ $d->keluhan_utama }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tablepasienerm").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "order": [
                [0, 'asc']
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    });
    $('#tablepasienerm').on('click', '.isi_erm', function() {
        nomorrm = $(this).attr('nomorrm')
        kodekunjungan = $(this).attr('kodekunjungan')
        ambilform_erm(nomorrm, kodekunjungan)
    });

    function ambilform_erm(nomorrm, kodekunjungan) {
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                nomorrm,
                kodekunjungan
            },
            url: '<?= route('ambilform_erm') ?>',
            success: function(response) {
                spinner.hide()
                $('.view_pasien').html(response);
            }
        });
    }
</script>
