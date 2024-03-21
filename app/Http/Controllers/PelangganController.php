<?php

namespace App\Http\Controllers;
use App\Models\Pelanggan;
use App\Models\User;

use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(){
        $pelanggan = pelanggan::all();
        return view('pelanggan.index', [
            'pelanggan' => $pelanggan
        ]);
    }

    public function create()
    {
    //Menampilkan Form Tambah 
    return view(
    'pelanggan.create', [
    'users' => User::all() 
    ]);
    }
    public function store(Request $request)
    {
    //Menyimpan Data 
    $request->validate([
    'nama_lengkap' =>'required',
    'no_hp'=> 'required',
    'alamat'=> 'required',
    'id_user'=> 'required',
    'foto'=> 'required|image|file|max:2048'
    ]);
    $array = $request->only([
    'nama_lengkap', 'no_hp', 'alamat', 'id_user'
    ]);
    $array['foto'] = $request->file('foto')->store('Foto Pelanggans');
    $tambah = Pelanggan::create($array);
    if($tambah) $request->file('foto')->store('Foto pelanggan');
    return redirect()->route('pelanggan.index')->with('success_message', 'Terimakasih telah mengisi data pelanggan ');
    }

    public function destroy(Request $request, $id)
    {
               //Delete
               $pelanggan = Pelanggan::find($id);
               if ($pelanggan){
               $hapus=$pelanggan->delete();
               if($hapus) unlink("storage/" . $pelanggan->foto);
               }
               return redirect()->route('pelanggan.index')->with('success_message', 'Berhasil menghapus data Pelanggan ');
    }
    public function edit($id)
    {
        //Menampilkan Form Edit
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) return redirect()->route('pelanggan.index')
            ->with('error_message', 'Data Pelanggan dengan id = ' . $id . ' tidak ditemukan');
        return view('pelanggan.edit', [
            'pelanggan' => $pelanggan,
            'users' => User::all() //Mengirimkan semua data bidang studi ke Modal pada halaman edit
        ]);
    }

    public function update(Request $request, $id)
    {
        //Mengedit Data Bidang Studi
        $pelanggan = Pelanggan::find($id);
        $pelanggan->nama_lengkap = $request->nama_lengkap;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->no_hp = $request->no_hp;
        $pelanggan->foto = $request->file('foto')->store('Foto Pelanggan');
        $pelanggan->id_user = $request->id_user;
        $pelanggan->save();
        return redirect()->route('pelanggan.index')->with('success_message', 'Berhasil mengubah Pelanggan');
    }

}
