<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productList()
    {
        $products = Product::all();

        return view('products', compact('products'));
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $product = Product::all();

        if($keyword){
            $product = Product::where("package","LIKE","%$keyword%")->get();
        }

        return view('index',['products'=>$product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::all();
        return view('create',['products'=>$product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;

        if($request->file('images')){
            $image_name = $request->file('images')->store('images','public');
        }

        $product->id = $request->id;
        $product->package = $request->package;
        $product->food = $request->food;
        $product->dessert = $request->dessert;
        $product->drink = $request->drink;
        $product->price = $request->price;
        $product->images = $image_name;

        $product->save();
    }

    public function show($id)
    {
        $product = Product::find($id);
        $komen = Comment::all();
        return view('detail',['products'=>$product,'komen'=>$komen,'id'=>$id]);
    }

    public function checkout($id)
    {
      $pesanan = Product::where('user_id', Auth::user()->id)->where('status',0)->first();
      $pesanan_details = [];
      if(!empty($pesanan))
      {
          $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
      }

      return view('checkout', compact('product', 'product_det'));
    }

      //commentare
      public function insertData(Request $request,$id)
      {
          $faker = Faker::create();
          $hasil = Product::find($id);
          $user = new Comment();
          $user->name = $request->nama;
          $user->comment = $request->komentar;
          $user->id_product = $request->id;
          $user->profile_photo = $faker->imageUrl($width = 50, $height = 50);
          $user->save();
          return redirect()->route(ProductController::class,'show',['id'=>$id]);

      }

      public function about()
      {
          return view('about');
      }
}
