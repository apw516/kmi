<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ts_kunjungan;
use App\Models\ts_layanan_header;
use App\Models\mt_hasil_transaksi;
use App\Models\data_antrian;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function indexkasir()
    {
        $menu = 'Pembayaran';
        return view('kasir.index_pembayaran', compact([
            'menu'
        ]));
    }
    public function ambildatapasien_bayar()
    {
        $now = $this->get_date();
        $antrian = DB::select('SELECT * FROM mt_antrian a
        INNER JOIN ts_layanan_header b
        ON a.`kode_kunjungan` = b.`kode_kunjungan`
        WHERE tgl_antrian = ? and b.status_layanan != ?', [$now, 9]);
        return view('kasir.tabel_pasien_bayar', compact([
            'antrian'
        ]));
    }
    public function ambildetail_kasir(Request $request)
    {
        $kodekunjungan = $request->kodekunjungan;
        $tindakan = DB::select('SELECT a.status_layanan,a.id as id_header,a.kode_kunjungan,c.`NAMA_TARIF`,b.jumlah_layanan,b.keterangan,b.total_tarif,a.kode_layanan_header,a.`tgl_entry`,a.`total_layanan`,a.`tagihan_pribadi`,
        b.`id_layanan_detail`,b.`kode_tarif_detail`,b.`total_layanan` AS total_detail,b.`diskon_layanan` FROM ts_layanan_header a
        JOIN ts_layanan_detail b ON a.id = b.row_id_header
        JOIN mt_tarif_header c ON LEFT(b.`kode_tarif_detail`,6) = c.`KODE_TARIF_HEADER`
        WHERE a.kode_kunjungan = ? AND a.status_layanan != ?', [$kodekunjungan, 9]);

        return view('kasir.detail_pembayaran', compact([
            'tindakan'
        ]));
    }
    public function prosesterima(Request $request)
    {
        //update layanan header
        ts_layanan_header::where('id', $request->idheader)
            ->update(['status_layanan' => 3]);

        data_antrian::where('kode_kunjungan', $request->kodekunjungan)
            ->update(['status' => 4]);

        $back = [
            'kode' => 200,
            'message' => ''
        ];
        echo json_encode($back);
        die;
    }
    public function prosesbatal(Request $request)
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
    public function simpanpembayaran(Request $request)
    {
        $kunjungan = DB::select('select * from ts_kunjungan where kode_kunjungan = ?',[$request->kode_kunjungan]);
        $datanya = [
            'tgl_entry' => $this->get_now(),
            'tgl_kunjungan' => $kunjungan[0]->tgl_masuk,
            'id_header' => $request->idheader,
            'total_tagihan' => $request->totaltagihan,
            'total_bayar' => $request->uangbayar,
            'total_kembalian' => $request->kembalian,
            'pic' => auth()->user()->id,
        ];
        mt_hasil_transaksi::create($datanya);
        //update layanan header
        ts_layanan_header::where('id', $request->idheader)
            ->update(['status_layanan' => 4]);
        data_antrian::where('kode_kunjungan', $request->kode_kunjungan)
            ->update(['status' => 5]);

        $back = [
            'kode' => 200,
            'message' => ''
        ];
        echo json_encode($back);
        die;
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
}
