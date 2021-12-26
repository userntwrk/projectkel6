@extends('layouts.dashboard')

@section('content')
<div class="card mt-2">
    <div class="card-body">
        <h3><i class="fa fa-shopping-cart"></i> Detail Pemesanan</h3>
        @if(!empty($pesanan))
        <p align="right">Tanggal Pesan : {{ $pesanan->tanggal }}</p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total Harga</th>

                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($pesanan_details as $pesanan_detail)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>
                        <img src="{{ url('storage') }}/{{ $pesanan_detail->product->images }}" width="100" alt="...">
                    </td>
                    <td>{{ $pesanan_detail->product->package }}</td>
                    <td>Rp. {{ number_format($pesanan_detail->product->price) }}</td>
                    <td>Rp. {{ number_format($pesanan_detail->jumlah_harga) }}</td>

                </tr>
                @endforeach

                <tr>
                    <td colspan="5" align="right"><strong>Total Harga :</strong></td>
                    <td align="right"><strong>Rp. {{ number_format($pesanan->jumlah_harga) }}</strong></td>

                </tr>
                <tr>
                    <td colspan="5" align="right"><strong>Kode Unik :</strong></td>
                    <td align="right"><strong>Rp. {{ number_format($pesanan->kode) }}</strong></td>

                </tr>
                 <tr>
                    <td colspan="5" align="right"><strong>Total yang harus ditransfer :</strong></td>
                    <td align="right"><strong>Rp. {{ number_format($pesanan->kode+$pesanan->jumlah_harga) }}</strong></td>

                </tr>
            </tbody>
        </table><br>
        @endif
        <a href="/admin/{{$pesanan->id}}/report" class="btn btn-primary" target="_blank">PRINT PDF</a>

    </div>
</div>
@endsection
