<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ts_kunjungan;
use App\Models\ts_layanan_header;
use App\Models\ts_layanan_detail;
use App\Models\data_antrian;

use Carbon\Carbon;

class ErmController extends Controller
{
    public function indexerm()
    {
        $menu = 'index_erm';
        return view('erm.index', compact([
            'menu'
        ]));
    }
    public function ambildatapasien_erm()
    {
        $now = $this->get_date();
        $data_erm = DB::select('select *,nomor_antrian,b.status as status_antrian from ts_kunjungan a left outer join mt_antrian b on a.no_rm = b.nomor_rm where a.status_kunjungan = ? and date(a.tgl_masuk) = ?', ['1', $now]);
        return view('erm.tabelpasien', compact([
            'data_erm'
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
    public function ambilform_erm(Request $request)
    {
        $nomorrm = $request->nomorrm;
        $kodekunjungan = $request->kodekunjungan;
        $datakunjungan = DB::select('select * from ts_kunjungan where kode_kunjungan = ?', [$kodekunjungan]);
        $mtpasien = DB::select('select * from mt_pasien where no_rm = ?', [$nomorrm]);
        $tarif = DB::select('SELECT *,b.`KODE_TARIF_DETAIL`,b.`TOTAL_TARIF_CURRENT` FROM mt_tarif_header a INNER JOIN mt_tarif_detail b ON a.`KODE_TARIF_HEADER` = b.`KODE_TARIF_HEADER`');
        return view('erm.form_erm', compact([
            'datakunjungan',
            'mtpasien',
            'tarif'
        ]));
    }
    public function simpanresume(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $datanya = [
            'keluhan_utama' => $dataSet['keluhanutama'],
            'diagx' => $dataSet['diagnosa'],
        ];
        try {
            ts_kunjungan::whereRaw('kode_kunjungan = ?', array($dataSet['kode_kunjungan']))->update($datanya);
            $back = [
                'kode' => 200,
                'message' => 'Resume berhasil disimpan !'
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
    public function simpanlayanan(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index = $nama['name'];
            $value = $nama['value'];
            $dataSet[$index] = $value;
            if ($index == 'keterangan') {
                $arrayindex[] = $dataSet;
            }
        }
        if (count($data) == 0) {
            $back = [
                'kode' => 500,
                'message' => 'Tidak ada layanan yang dipilih ...'
            ];
            echo json_encode($back);
            die;
        };
        // dd($arrayindex);
        $cek_header = DB::select('select * from ts_layanan_header where kode_kunjungan = ? and status_layanan != ?', [$request->kodekunjungan, 9]);
        if (count($cek_header) > 0) {
            $back = [
                'kode' => 500,
                'message' => 'Batalkan layanan sebelumnya untuk simpan data layanan baru ...'
            ];
            echo json_encode($back);
            die;
        }
        try {
            $kode_layanan_header = $this->createLayananheader();
            $data_layanan_header = [
                'kode_layanan_header' => $kode_layanan_header,
                'tgl_entry' =>   $this->get_now(),
                'kode_kunjungan' => $request->kodekunjungan,
                // 'kode_unit' => 'KLINIK',
                'kode_tipe_transaksi' => 2,
                'pic' => auth()->user()->id,
                'status_layanan' => '3',
                'status_retur' => 'OPN',
                'status_pembayaran' => 'OPN'
            ];
            $ts_layanan_header = ts_layanan_header::create($data_layanan_header);
            $now = $this->get_now();
            $grand_total_tarif = 0;
            foreach ($arrayindex as $d) {
                $id_detail = $this->createLayanandetail();
                $disc = $d['disc'] / 100;
                if ($d['disc'] == 0) {
                    $sum_tarif = $d['tarif'] * $d['qty'];
                } else {
                    $discount = $d['tarif'] * $d['qty'] * $disc;
                    $sum_tarif = $d['tarif'] * $d['qty'] - $discount;
                }
                $save_detail = [
                    'id_layanan_detail' => $id_detail,
                    'kode_layanan_header' => $kode_layanan_header,
                    'kode_tarif_detail' => $d['kodelayanan'],
                    'total_tarif' => $d['tarif'],
                    'jumlah_layanan' => $d['qty'],
                    'diskon_layanan' => $d['disc'],
                    'total_layanan' => $sum_tarif,
                    'grantotal_layanan' => $sum_tarif,
                    'kode_dokter1' => auth()->user()->id,
                    'status_layanan_detail' => 'OPN',
                    'tgl_layanan_detail' => $now,
                    'tagihan_pribadi' => $sum_tarif,
                    'tgl_layanan_detail_2' => $now,
                    'row_id_header' => $ts_layanan_header->id,
                    'keterangan' => $d['keterangan']
                ];
                $ts_layanan_detail = ts_layanan_detail::create($save_detail);
                $grand_total_tarif = $grand_total_tarif + $sum_tarif;
            }
            ts_layanan_header::where('id', $ts_layanan_header->id)
                ->update(['status_layanan' => 1, 'total_layanan' => $grand_total_tarif, 'tagihan_pribadi' => $grand_total_tarif]);
            $back = [
                'kode' => 200,
                'message' => ''
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
    public function tindakanhariini(Request $request)
    {
        $kodekunjungan = $request->kodekunjungan;
        $riwayat = DB::SELECT('select * from ts_layanan_header where kode_kunjungan = ?', [$kodekunjungan]);
        return view('erm.tabelriwayat_tindakan', compact([
            'riwayat'
        ]));
    }
    public function resume_hari_ini(Request $request)
    {
        $kodekunjungan = $request->kodekunjungan;
        $resume = DB::select('select * from ts_kunjungan where kode_kunjungan = ?', [$kodekunjungan]);
        // $resume = DB::select('select * from ts_kunjungan where kode_kunjungan = ?',[$kodekunjungan]);
        $tindakan = DB::select('SELECT a.status_layanan,a.id as id_header,c.`NAMA_TARIF`,b.jumlah_layanan,b.keterangan,b.total_tarif,a.kode_layanan_header,a.`tgl_entry`,a.`total_layanan`,a.`tagihan_pribadi`,
        b.`id_layanan_detail`,b.`kode_tarif_detail`,b.`total_layanan` AS total_detail,b.`diskon_layanan` FROM ts_layanan_header a
        INNER JOIN ts_layanan_detail b ON a.id = b.row_id_header
        INNER JOIN mt_tarif_header c ON LEFT(b.`kode_tarif_detail`,6) = c.`KODE_TARIF_HEADER`
        WHERE a.kode_kunjungan = ? AND a.status_layanan != ?', [$kodekunjungan, 9]);
        return view('erm.resume', compact([
            'resume',
            'tindakan'
        ]));
    }
    public function createLayananheader()
    {
        //dummy
        $q = DB::select('SELECT id,kode_layanan_header,RIGHT(kode_layanan_header,6) AS kd_max  FROM ts_layanan_header
        WHERE DATE(tgl_entry) = CURDATE()
        ORDER BY id DESC
        LIMIT 1');
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'HEAD' . date('ymd') . $kd;
    }
    public function createLayanandetail()
    {
        //dummy
        $q = DB::select('SELECT id,id_layanan_detail,RIGHT(id_layanan_detail,6) AS kd_max  FROM ts_layanan_detail
        WHERE DATE(tgl_layanan_detail) = CURDATE()
        ORDER BY id DESC
        LIMIT 1');
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'DET' . date('ymd') . $kd;
    }
    public function prosesbayar(Request $request)
    {
        //update layanan header
        ts_layanan_header::where('id', $request->idheader)
            ->update(['status_layanan' => 2]);

        data_antrian::where('kode_kunjungan', $request->kodekunjungan)
            ->update(['status' => 3]);

        $back = [
            'kode' => 200,
            'message' => ''
        ];
        echo json_encode($back);
        die;
    }
    public function batalorder(Request $request)
    {
        $id = $request->id;
        $data =
            [
                'status_layanan' => 9
            ];
        $cek = DB::SELECT('select * from ts_layanan_header where id = ? and status_layanan = ? or status_layanan = ?', [$id, 3,4]);
        if (count($cek) == 0) {
            DB::table('ts_layanan_header')->where('id', $id)->update($data);
            $back = [
                'kode' => 200,
                'message' => 'Layanan dibatalkan ...'
            ];
        } else {
            $back = [
                'kode' => 500,
                'message' => 'Layanan sedang diproses ...'
            ];
        }
        echo json_encode($back);
        die;
    }
}
