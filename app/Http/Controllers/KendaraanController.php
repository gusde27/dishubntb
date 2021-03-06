<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Kendaraan;
use Illuminate\Support\Facades\Validator;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KendaraanController extends Controller
{

    public function index()
    {
        $kendaraans = DB::table('kendaraans')->paginate(10);

        return view('kendaraans/index', ['kendaraans' => $kendaraans]);
    }

    public function cari(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;

    		// mengambil data dari table pegawai sesuai pencarian data
        $kendaraans = DB::table('kendaraans')
            ->where('nomesin','like',"%".$cari."%")
            ->paginate();

    		// mengirim data pegawai ke view index
		return view('kendaraans/index',['kendaraans' => $kendaraans]);

    }

    public function cetak_pdf(Request $request)
    {
        $id = $request->id;
        $kendaraans = Kendaraan::where('id', $id)->get();

         // return view('cetak_pdf',['kendaraans'=>$kendaraans]);
        $pdf = PDF::loadview('cetak_pdf',['kendaraans'=>$kendaraans]);
        return $pdf->stream('Kartu-Kendaraan-pdf');
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Kendaraan $kendaraan)
    {

    }


    public function edit(Kendaraan $kendaraan)
    {

    }


    public function update(Request $request, Kendaraan $kendaraan)
    {

        Validator::make($request->all(),
            [
            'nopol' => 'required',
            'nomor_uji' => 'required',
            'merk' => 'required',
            'tahun_pembuatan' => 'required',
            'nomor_rangka' => 'required',
            'nomor_mesin' => 'required',
            'daya_orang' => 'required',
            'daya_barang' => 'required',
            'trayek' => 'required',
            'nama_perusahaan' => 'required',
            'alamat_perusahaan' => 'required',
            'nama_pemilik' => 'required',
            'nomor_sk' => 'required',
            'kode_perusahaan' => 'required',
            'masa_sk' => 'required',
            'awal' => 'required',
            'akhir' => 'required',
            ]
        )->validate();

        Kendaraan::where('id', $kendaraan->id)
            ->update([
            'nopol' => $request->nopol,
            'nouji' => $request->nomor_uji,
            'merk' => $request->merk,
            'thpembuatan' => $request->tahun_pembuatan,
            'norangka' => $request->nomor_rangka,
            'nomesin' => $request->nomor_mesin,
            'dayaangkutorang' => $request->daya_orang,
            'dayaangkutbarang' => $request->daya_barang,
            'trayek' => $request->trayek,
            'namaperusahaan' => $request->nama_perusahaan,
            'alamatperusahaan' => $request->alamat_perusahaan,
            'namapemilik' => $request->nama_pemilik,
            'nosk' => $request->nomor_sk,
            'kodeperusahaan' => $request->kode_perusahaan,
            'masaberlaku' => $request->masa_sk,
            'tglawalsk' => $request->awal,
            'tglakhirsk' => $request->akhir
            ]);

            return redirect('/kendaraans')->with('status', 'Data Kendaraan Berhasil Diubah!');
    }


    public function destroy(Kendaraan $kendaraan)
    {
        return $kendaraan;
    }
}
