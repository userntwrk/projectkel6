<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $pesanan = Pesanan::all();
        $data = array('title' => 'Dashboard');

        if($keyword){
            $pesanan = Pesanan::where("kode","LIKE","%$keyword%")->get();
        }

        return view('admin.data_transaksi', $data, compact('pesanan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function show($id)
    {
        // $pesanan = Pesanan::find($id);
        // $pesanan_details = PesananDetail::find($id);
        // return view('admin.detail_transaksi', ['pesanan'=>$pesanan], ['pesanan_details'=>$pesanan_details]);

        $data = array('title' => 'Dashboard');
        $pesanan = Pesanan::find($id);
 	      $pesanan_details = [];
        if(!empty($pesanan))
        {
            $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        }

        return view('admin.detail_transaksi', $data, compact('pesanan', 'pesanan_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::find($id);
        $pesanan->delete();
        return redirect()->route('admin.data_transaksi');
    }
}
