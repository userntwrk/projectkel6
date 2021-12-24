<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Auth;
use Alert;
use Carbon\Carbon;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $products = Product::find($id);

        return view('product', compact('products'));
    }

    public function pesan(Request $request, $id)
    {
        $products = Product::find($id);
        $tanggal = Carbon::now();

        // //validasi apakah melebihi stok
        // if($request->jumlah_pesan > $products->stok)
        // {
        //     return redirect('pesan/'.$id);
        // }

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
    	    	// $pesanan_detail->jumlah = $request->jumlah_pesan;
    	    	$pesanan_detail->jumlah_harga = $products->price;
    	    	$pesanan_detail->save();
      	} else {
    		    $pesanan_detail = PesananDetail::where('barang_id', $products->id)->where('pesanan_id', $pesanan_baru->id)->first();

        		//harga sekarang
        		$harga_pesanan_detail_baru = $products->harga;
    	    	$pesanan_detail->jumlah_harga = $pesanan_detail->jumlah_harga + $harga_pesanan_detail_baru;
    	    	$pesanan_detail->update();
    	  }

      	//jumlah total
      	$pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
      	$pesanan->jumlah_harga = $pesanan->jumlah_harga + $products->price;
      	$pesanan->update();

        Alert::success('Pesanan Sukses Masuk Keranjang', 'Success');
      	return redirect('checkout');
    }

    public function checkout()
    {
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
 	      $pesanan_details = [];
        if(!empty($pesanan))
        {
            $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        }

        return view('checkout', compact('pesanan', 'pesanan_details'));
    }

    public function delete($id)
    {
        $pesanan_detail = PesananDetail::where('id', $id)->first();

        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga-$pesanan_detail->jumlah_harga;
        $pesanan->update();


        $pesanan_detail->delete();

        Alert::error('Pesanan Sukses Dihapus', 'Hapus');
        return redirect('checkout');
    }

    public function konfirmasi()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if(empty($user->alamat))
        {
            Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }

        if(empty($user->no_hp))
        {
            Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }

        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
        $pesanan_id = $pesanan->id;
        $pesanan->status = 1;
        $pesanan->update();

        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan_id)->get();
        foreach ($pesanan_details as $pesanan_detail) {
            $products = Product::where('id', $pesanan_detail->barang_id)->first();
            // $products->stok = $products->stok-$pesanan_detail->jumlah;
            $products->update();
        }

        Alert::success('Pesanan Sukses Check Out Silahkan Lanjutkan Proses Pembayaran', 'Success');
        return redirect('history/'.$pesanan_id);

    }
}
