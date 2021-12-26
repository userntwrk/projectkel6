@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('DATA TRANSAKSI') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                     <!--fitur search data-->
                     <div class="card-body">
                        <form action="/report" class="form-inline" method="get">
                            <div class="row">
                                <div class="form-group mx-sm-3 mb-3">
                                    <input name="keyword" type="text" class="form-control" placeholder="kode">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50px">ID</th>
                                        <td>Kode Pembayaran</td>
                                        <th>User ID</th>
                                        <th>Status Pembayaran</th>
                                        <th>Jumlah Harga</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach($pesanan as $p)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $p->kode }}</td>
                                        <td>{{ $p->user_id }}</td>
                                        <td>
                                            @if($p->status == 1)
                                            Sudah Pesan & Belum dibayar
                                            @else
                                            Sudah dibayar
                                            @endif
                                        </td>
                                        <td>{{ $p->jumlah_harga }}</td>
                                        <td>{{ $p->tanggal }}</td>
                                        <td>
                                            <form action="/report/{{$p->id}}" method="post">

                                                <a href="/report/{{$p->id}}" class="btn btn-info">Details</a> |
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
