@extends('layouts.apps')

@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<br><br><br><br>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">{{ $products->package }}</h3>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6">
                    <div class="white-box text-center"><img width="435px" src="{{asset('storage/'.$products->images)}}" class="img-responsive"></div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6">
                    <h4 class="box-title mt-5">Product description</h4>
                      <div class="card-body">
                        <form action="{{ url('pesan') }}/{{ $products->id }}" method="POST" enctype="multipart/form-data">
                          @csrf
                              Food : {{ $products->food }} <br>
                              Dessert : {{ $products->dessert }} <br>
                              Drink : {{ $products->drink }} <br>
                              Price : {{ $products->price }} <br>
                              <!-- <button class="btn btn-primary btn-rounded">Buy Now</button> | -->
                              <button type="submit" class="btn btn-info"><i class="fa fa-shopping-cart"> Add To Cart</i></button>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <br>
            <!-- Comment-->
            <div class="card my-4">
                <h5 class="card-header">Leave a Comment</h5>
                <div class="card-body">
                    <form action="/product/{{$products->id}}" method="post">
                    @csrf
                        <div class="form-group" name="_token" value="<?php echo csrf_token() ?>">
                            <p>Name        : </p>
                            <input class="form-control" type="text" required="required" name="nama">
                        </div>
                        <div class="form-group">
                            <p>Comment     :</p>
                            <input class="form-control" type="text" required="required" name="komentar">
                        </div>
                        <input type="submit" class="btn btn-primary"></button>
                    </form>
                </div>
            </div>
            <br>

            <!--Single Comment-->
            @foreach($komen as $k)
            @if($k->id_product==$id)
            <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle" src="{{$k->profile_photo}}" alt="">
                    <div class="media-body">
                        <h5 class="mt-0">{{$k->name}}</h5>
                        <p>{{$k->comment}}</p>
                    </div>
            </div>
            @endif
            @endforeach
</div>
@endsection
