<?php

namespace App\Http\Controllers;

use App\Models\PaketWisata;
use App\Models\Pelanggan;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservasi::all();
        return view('reservasi.index', [
        'reservasi' => $reservasi
        ]);
    }

   
    public function create()
    {
        return view(
            'reservasi.create', [
                'pelanggan' => Pelanggan::all(),
                'paketwisata' => PaketWisata::all()
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' =>'required',
            'id_paket'=>'required',
            'tgl_reservasi_wisata'=>'required',
            'harga'=>'required',
            'jumlah_peserta'=>'required',
            'diskon'=>'required',
            'nilai_diskon'=>'required',
            'total_bayar'=>'required',
            'file_bukti_tf'=>'required|image|file|max:2048',
            'status_reservasi_wisata'=>'required'
        ]);
        $array = $request->only([
            'id_pelanggan',
            'id_paket',
            'tgl_reservasi_wisata',
            'harga',
            'jumlah_peserta',
            'diskon',
            'nilai_diskon',
            'total_bayar',
            'file_bukti_tf',
            'status_reservasi_wisata'
        ]);
            $array['file_bukti_tf'] = $request->file('file_bukti_tf')->store('Bukti Transfer');
            $tambah=Reservasi::create($array);
            if($tambah) $request->file('file_bukti_tf')->store('Bukti Transfer');
            return redirect()->route('reservasi.index')->with('success_message', 'Berhasil menambah data Reservasi');
    }

    public function edit(string $id)
    {
        
        $reservasi = reservasi::find($id);
        if (!$reservasi) return redirect()->route('reservasi.index')->with
        ('error_message', 'reservasi dengan id = '.$id.' tidak ditemukan');
        return view('reservasi.edit', [
            'reservasi' => $reservasi,
            'pelanggan' => Pelanggan::all(),
            'paketwisata' => PaketWisata::all()
        ]);
    }

  
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_pelanggan' =>'required',
            'id_paket'=>'required',
            'tgl_reservasi_wisata'=>'required',
            'harga'=>'required',
            'jumlah_peserta'=>'required',
            'diskon'=>'required',
            'nilai_diskon'=>'required',
            'total_bayar'=>'required',
            'file_bukti_tf'=>'required|image|file|max:2048',
            'status_reservasi_wisata'=>'required'
            ]);
            $reservasi= Reservasi::find($id);
            $reservasi-> id_pelanggan = $request->id_pelanggan;
            $reservasi-> id_paket = $request->id_paket;
            $reservasi-> tgl_reservasi_wisata = $request->tgl_reservasi_wisata;
            $reservasi-> harga = $request->harga;
            $reservasi-> jumlah_peserta = $request->jumlah_peserta;
            $reservasi-> diskon= $request->diskon;
            $reservasi-> nilai_diskon = $request->nilai_diskon;
            $reservasi-> total_bayar = $request->total_bayar;
            $reservasi-> file_bukti_tf = $request->file('file_bukti_tf')->store('Bukti Transfer');
            $reservasi-> status_reservasi_wisata = $request->status_reservasi_wisata;
            $reservasi->save();
            return redirect()->route('reservasi.index')->with('success_message', 'Berhasil mengubah reservasi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservasi = reservasi::find($id);
        if ($reservasi) {
            $hapus = $reservasi->delete();
            if ($hapus)
                unlink("storage/" . $reservasi->file_bukti_tf);     
        }
        return redirect()->route('reservasi.index')->with('success_message', 'Berhasil menghapus reservasi ');
        }
    }