<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Auth;
use Carbon\Carbon;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $products = Product::where('id', $id)->first();

        return view('index', compact('products'));
    }

    public function pesan(Request $request, $id)
    {
        $products = Product::where('id', $id)->first();
        $tanggal = Carbon::now();

        //validasi apakah melebihi stok
        if($request->jumlah_pesan > $products->stok)
        {
            return redirect('pesan/'.$id);
        }

        //cek validasi
        $cek_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
        //simpan ke database pesanan
        if(empty($cek_pesanan))
        {
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = 0;
            $pesanan->kode = mt_rand(100, 999);
            $pesanan->save();
        }


        //simpan ke database pesanan detail
    	  $pesanan_baru = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();

      	//cek pesanan detail
      	$cek_pesanan_detail = PesananDetail::where('barang_id', $products->id)->where('pesanan_id', $pesanan_baru->id)->first();
      	if(empty($cek_pesanan_detail))
      	{
        		$pesanan_detail = new PesananDetail;
    	    	$pesanan_detail->barang_id = $products->id;
    	    	$pesanan_detail->pesanan_id = $pesanan_baru->id;
    	    	$pesanan_detail->jumlah = $request->jumlah_pesan;
    	    	$pesanan_detail->jumlah_harga = $products->harga*$request->jumlah_pesan;
    	    	$pesanan_detail->save();
      	} else {
    		    $pesanan_detail = PesananDetail::where('barang_id', $products->id)->where('pesanan_id', $pesanan_baru->id)->first();

        		$pesanan_detail->jumlah = $pesanan_detail->jumlah+$request->jumlah_pesan;

        		//harga sekarang
        		$harga_pesanan_detail_baru = $products->harga*$request->jumlah_pesan;
    	    	$pesanan_detail->jumlah_harga = $pesanan_detail->jumlah_harga+$harga_pesanan_detail_baru;
    	    	$pesanan_detail->update();
    	  }

      	//jumlah total
      	$pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
      	$pesanan->jumlah_harga = $pesanan->jumlah_harga+$products->harga*$request->jumlah_pesan;
      	$pesanan->update();

        Alert::success('Pesanan Sukses Masuk Keranjang', 'Success');
      	return redirect('check-out');
    }
}
