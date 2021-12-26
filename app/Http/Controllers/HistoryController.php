<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\PesananDetail;
use Auth;
use Alert;
use Illuminate\Http\Request;
use PDF;


class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status', '!=',0)->get();

    	return view('history.index', compact('pesanans'));
    }

    public function detail($id)
    {
    	$pesanan = Pesanan::where('id', $id)->first();
    	$pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();

     	return view('history.detail', compact('pesanan','pesanan_details'));
    }

    //REPORT
    public function report($id){
        $pesanan = Pesanan::find($id);
        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        $pdf = PDF::loadview('admin.report',['pesanan'=>$pesanan,'pesanan_details'=>$pesanan_details]);

        return $pdf->stream();
    }
}
