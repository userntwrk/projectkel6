@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('MENU') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="/product" method="post" enctype="multipart/form-data" >
                        @csrf
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" class="form-control" required="required" name="id"><br>
                        </div>
                        <div class="form-group">
                            <label for="package">Package</label>
                            <input type="text" class="form-control" required="required" name="package"><br>
                        </div>
                        <div class="form-group">
                            <label for="food">Food</label>
                            <input type="text" class="form-control" required="required" name="food"></br>
                        </div>
                        <div class="form-group">
                            <label for="dessert">Dessert</label>
                            <input type="text" class="form-control" required="required" name="dessert"></br>
                        </div>
                        <div class="form-group">
                            <label for="drink">Drink</label>
                            <input type="text" class="form-control" required="required" name="drink"></br>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" required="required" name="price"></br>
                        </div>
                        <div class="form-group">
                            <label for="images">Images</label>
                            <input type="file" class="form-control" required="required"  name="images"></br>
                        <div>
                        <button type="submit" name="add" class="btn btn-primary float-right">Add Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
