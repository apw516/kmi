<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\mt_pasien;
use App\Models\ts_kunjungan;
use App\Models\data_antrian;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Cari Pasien';
        return view('pendaftaran.index', compact([
            'menu'
        ]));
    }
    public function ambilpasien()
    {
        $datapasien = DB::SELECT('select * from mt_pasien');
        return view('pendaftaran.tabelpasien', compact([
            'datapasien'
        ]));
    }
    public function simpanpasien_baru(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        if ($dataSet['nama_pasien'] == '') {
            $back = [
                'kode' => 500,
                'message' => 'Nama tidak boleh kosong !'
            ];
            echo json_encode($back);
            die;
        } else if ($dataSet['tempatlahir'] == '') {
            $back = [
                'kode' => 500,
                'message' => 'Tempat lahir tidak boleh kosong !'
            ];
            echo json_encode($back);
            die;
        } else if ($dataSet['tgllahir'] == '') {
            $back = [
                'kode' => 500,
                'message' => 'Tanggal lahir tidak boleh kosong !'
            ];
            echo json_encode($back);
            die;
        } else if ($dataSet['alamat'] == '') {
            $back = [
                'kode' => 500,
                'message' => 'Alamat tidak boleh kosong !'
            ];
            echo json_encode($back);
            die;
        } else if ($dataSet['jeniskelamin'] == '') {
            $back = [
                'kode' => 500,
                'message' => 'Jenis kelamin tidak boleh kosong !'
            ];
            echo json_encode($back);
            die;
        }
        $datapasien = [
            'nik' => $dataSet['nik'],
            'no_rm' => $this->get_rm(),
            'no_rm_lama' => $dataSet['rm_lama'],
            'tgl_entry' => $this->get_now(),
            'nama_px' => $dataSet['nama_pasien'],
            'tempat_lahir' => $dataSet['tempatlahir'],
            'jenis_kelamin' => $dataSet['jeniskelamin'],
            'tgl_lahir' => $dataSet['tgllahir'],
            'alamat' => $dataSet['alamat'],
            'riwayat_alergi' => $dataSet['riwayat_alergi'],
            'no_telp' => $dataSet['notelp'],
            'pic' => auth()->user()->id
        ];
        try {
            mt_pasien::create($datapasien);
            $back = [
                'kode' => 200,
                'message' => 'Data Pasien Disimpan !'
            ];
            echo json_encode($back);
            die;
        } catch (\Exception $e) {
            $back = [
                'kode' => 500,
                'message' => $e->getMessage()
            ];
            echo json_encode($back);
            die;
        }
    }
    public function simpanpendaftaran(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $cek_rm = DB::select('select * from ts_kunjungan where no_rm = ?', [$dataSet['rmpasien']]);
        if (count($cek_rm) == 0) {
            $counter = 1;
        } else {
            foreach ($cek_rm as $c)
                $arr_counter[] = array(
                    'counter' => $c->counter
                );
            $last_count = max($arr_counter);
            $counter = $last_count['counter'] + 1;
        }
        $cek_kunjungan = DB::select('select * from ts_kunjungan where no_rm = ? and status_kunjungan = ?', [$dataSet['rmpasien'], 1]);
        if (count($cek_kunjungan) > 0) {
            $back = [
                'kode' => 500,
                'message' => 'Pasien sedang dalam antrian !'
            ];
            echo json_encode($back);
            die;
        }
        $ts_kunjungan = [
            'nama_pasien' => $dataSet['nama_pasien_daftar'],
            'counter' => $counter,
            'no_rm' => $dataSet['rmpasien'],
            'tgl_masuk' => $this->get_now(),
            'status_kunjungan' => 1,
            'pic' => auth()->user()->id,
            'keluhan_utama' => $dataSet['keluhan'],
            'tekanan_darah' => $dataSet['tekanandarah'],
            'suhu_tubuh' => $dataSet['suhutubuh'],
            'riwayat_alergi' => $dataSet['riwayat_alergi_daftar'],
        ];
        try {
            $kunjungan = ts_kunjungan::create($ts_kunjungan);
            //ambil antrian
            $data_antrian = [
                'nomor_antrian' => $this->get_antrian(),
                'tgl_antrian' => $this->get_now(),
                'nomor_rm' => $dataSet['rmpasien'],
                'nama' => $dataSet['nama_pasien_daftar'],
                'kode_kunjungan' => "$kunjungan->id",
            ];
            // dd($data_antrian);
            data_antrian::create($data_antrian);
            $back = [
                'kode' => 200,
                'message' => 'Pendaftaran berhasil !'
            ];
            echo json_encode($back);
            die;
        } catch (\Exception $e) {
            $back = [
                'kode' => 500,
                'message' => $e->getMessage()
            ];
            echo json_encode($back);
            die;
        }
    }
    public function antrianpasien(Request $request)
    {
        $menu = 'Data Antrian';
        return view('pendaftaran.antrianpasien', compact([
            'menu'
        ]));
    }
    public function get_date()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $now = $date;
        return $now;
    }
    public function get_now()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $now = $date . ' ' . $time;
        return $now;
    }
    public function get_antrian()
    {
        $now = $this->get_date();
        $y = DB::select('SELECT MAX(RIGHT(nomor_antrian,2)) AS kd_max FROM mt_antrian WHERE tgl_antrian = ?', [$now]);
        if (count($y) > 0) {
            foreach ($y as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%02s", $tmp);
            }
        } else {
            $kd = "01";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'A' . $kd;
    }
    public function get_rm()
    {
        $y = DB::select('SELECT MAX(RIGHT(no_rm,6)) AS kd_max FROM mt_pasien');
        if (count($y) > 0) {
            foreach ($y as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('y') . $kd;
    }
    public function ambilantrian()
    {
        $now = $this->get_date();
        $antrian = DB::select('select * from mt_antrian where tgl_antrian = ?', [$now]);
        return view('pendaftaran.tabelantrian', compact([
            'antrian'
        ]));
    }
    public function updateantrian(Request $request)
    {
        $id = $request->id;
        $cek = db::select('select * from mt_antrian where id = ? and status = ?', [$id, 1]);
        if (count($cek) == 1) {
            $datanya = [
                'status' => 2
            ];
            data_antrian::whereRaw('id = ?', array($id))->update($datanya);
            $back = [
                'kode' => 200,
                'message' => 'Pasien berhasil dipanggil ...'
            ];
            echo json_encode($back);
            die;
        } else {
            $back = [
                'kode' => 500,
                'message' => 'Pasien sudah dipanggil !'
            ];
            echo json_encode($back);
            die;
        }
    }
    public function batalantrian(Request $request)
    {
        $id = $request->id;
        $cek = db::select('select * from mt_antrian where id = ?', [$id]);
        if ($cek[0]->status == 1) {
            $data =
            [
                'status_kunjungan' => 9
            ];
            DB::table('ts_kunjungan')->where('kode_kunjungan', $cek[0]->kode_kunjungan)->update($data);
            DB::table('mt_antrian')->where('id', $id)->delete();
            $back = [
                'kode' => 200,
                'message' => 'Antrian pasien dibatalkan ...'
            ];
            echo json_encode($back);
            die;
        } else {
            $back = [
                'kode' => 500,
                'message' => 'Pasien dalam pelayanan !'
            ];
            echo json_encode($back);
            die;
        }
    }
}
