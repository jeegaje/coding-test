@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('master-items-category')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                <div class="card-header">Master Item</div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>:</td>
                            <td>{{$data->deskripsi}}
                        </td>       
                    </table>
                    <a class="btn btn-info" href="{{url('master-items-category/form/edit')}}/{{$data->id}}">Edit</a>
                    <a class="btn btn-danger" href="{{url('master-items-category/delete')}}/{{$data->id}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </div>
            </div>

            {{-- TAMBAHAN: Daftar Item dalam Kategori Ini --}}
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    Daftar Item dalam Kategori: {{$data->nama}}
                </div>
                <div class="card-body">
                    @if(isset($data->masterItems) && $data->masterItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Item</th>
                                        <th>Nama Item</th>
                                        <th>Harga Beli</th>
                                        <th>Supplier</th>
                                        <th>Jenis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->masterItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                        <td>{{ $item->supplier }}</td>
                                        <td>{{ $item->jenis }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Belum ada item dalam kategori ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection