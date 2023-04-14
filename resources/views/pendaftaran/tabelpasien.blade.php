  <table class="table table-sm table-bordered table-hover" id="tabelpasien">
      <thead>
          <th>--</th>
          <th>RM lama</th>
          <th>No RM</th>
          <th>NIK</th>
          <th>Nama Pasien</th>
          <th>Jenis Kelamin</th>
          <th>Alamat</th>
          <th>Riwayat Alergi</th>
      </thead>
      <tbody>
          @foreach ($datapasien as $d)
              <tr>
                  <td>
                      <button nomorrm="{{ $d->no_rm }}" nama="{{ $d->nama_px }}" alergi="{{ $d->riwayat_alergi }}"
                          class="btn btn-success btn-sm daftar"><i class="bi bi-box-arrow-in-down-right"></i></button>
                  </td>
                  <td>{{ $d->no_rm_lama }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->nik }}</td>
                  <td>{{ $d->nama_px }}</td>
                  <td>{{ $d->jenis_kelamin }}</td>
                  <td>{{ $d->alamat }}</td>
                  <td>{{ $d->riwayat_alergi }}</td>
              </tr>
          @endforeach
      </tbody>
  </table>
  <!-- Modal -->
  <div class="modal fade" id="modalpendaftaran" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header bg-success">
                  <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-plus"></i> Form Pendaftaran</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form method="post" class="form-pendaftaran">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Nomor RM</label>
                          <input readonly type="text" class="form-control" id="rmpasien" name="rmpasien"
                              placeholder="Masukan nomor rm lama ...">
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Nama Pasien</label>
                          <input readonly type="text" class="form-control" id="nama_pasien_daftar"
                              name="nama_pasien_daftar" placeholder="Masukan nama pasien ...">
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="inputEmail4">Tekanan Darah</label>
                              <input type="text" class="form-control" id="tekanandarah" name="tekanandarah"
                                  placeholder="Masukan tekanan darah pasien ...">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="inputPassword4">Suhu Tubuh</label>
                              <div class="input-group mb-3">
                                  <input type="text" class="form-control" name="suhutubuh" id="suhutubuh"
                                      placeholder="Masukan suhu tubuh pasien ..." aria-label="Recipient's username"
                                      aria-describedby="basic-addon2">
                                  <div class="input-group-append">
                                  </div>
                              </div>

                          </div>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Keluhan Pasien</label>
                          <textarea type="text" class="form-control" id="keluhan" name="keluhan" placeholder="Masukan keluhan pasien ..."></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Riwayat Alergi</label>
                          <textarea type="text" class="form-control" id="riwayat_alergi_daftar" name="riwayat_alergi_daftar"
                              placeholder="Masukan riwayat alergi jika ada ..."></textarea>
                      </div>
                      <button type="button" class="btn btn-primary" onclick="simpanpendaftaran()"><i
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
      $(function() {
          $("#tabelpasien").DataTable({
              "responsive": true,
              "lengthChange": false,
              "autoWidth": true,
              "order": [
                  [2, 'desc']
              ],
              "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          });
      });
      $('#tabelpasien').on('click', '.daftar', function() {
          rm = $(this).attr('nomorrm')
          nama = $(this).attr('nama')
          alergi = $(this).attr('alergi')
          $('#rmpasien').val(rm)
          $('#nama_pasien_daftar').val(nama)
          $('#riwayat_alergi_daftar').val(alergi)
          $('#modalpendaftaran').modal('show');

      });

      function simpanpendaftaran() {
          spinner = $('#loader')
          spinner.show();
          var data = $('.form-pendaftaran').serializeArray();
          $.ajax({
              async: true,
              type: 'post',
              dataType: 'json',
              data: {
                  _token: "{{ csrf_token() }}",
                  data: JSON.stringify(data),
              },
              url: '<?= route('simpanpendaftaran') ?>',
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
                      $('#modalpendaftaran').modal('hide');
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
