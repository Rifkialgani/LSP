@extends('adminlte::page')
@section('title', 'List Reservasi')
@section('content_header')
<h1 class="m-0 text-dark">List Reservasi</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('reservasi.create')}}" class="btn btn-primary">Tambah </a>
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr style="background-color:#6495ED">
                            <th>No.</th>
                            <th>ID Pelanggan</th>
                            <th>ID Paket</th>
                            <th>Tanggal Reservasi</th>
                            <th>Harga</th>
                            <th>Jumlah Peserta</th>
                            <th>Diskon</th>
                            <th>Nilai Diskon</th>
                            <th>Total Bayar</th>
                            <th>Bukti Transfer</th>
                            <th>Status Reservasi</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservasi as $key => $rv)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td id={{$key+1}}>{{$rv->fpelanggan->id}}</td>
                            <td id={{$key+1}}>{{$rv->fdpaket->id}}</td>
                            <td>{{$rv->tgl_reservasi_wisata}}
                            </td>
                            <td>{{$rv->harga}}</td>
                            <td>{{$rv->jumlah_peserta}}</td>
                            <td>{{$rv->diskon}}</td>
                            <td>{{$rv->nilai_diskon}}</td>
                            <td>{{$rv->total_bayar}}</td>
                            <td>
                                <img src="storage/{{$rv->file_bukti_tf}}" alt="{{$rv->file_bukti_tf}} tidak tampil"
                                    class="img-thumbnail">
                            </td>
                            <td>
                                @switch($rv->status_reservasi_wisata)
                                @case('Pesan')
                                Pesan
                                @break
                                @case('Dibayar')
                                Dibayar
                                @break
                                @case('Selesai')
                                Selesai
                                @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{route('reservasi.edit', $rv)}}" class="btn btn-primary">Edit</a>
                                <a href="{{route('reservasi.destroy', $rv)}}"
                                    onclick="notificationBeforeDelete(event, this)"
                                    class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
$('#example2').rvTable({
    "responsive": true,
});

function notificationBeforeDelete(event, el) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data reservasi ? ')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}
</script>