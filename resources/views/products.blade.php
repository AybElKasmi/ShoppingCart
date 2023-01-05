@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Add To Cart') }}</div>
                <br>
                    <table class="table table-hover">
                        @if (session('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                        <thead>
                        <tr>
                            <td></td>
                            <th scope="col">Product Name</th>
                            <th scope="col">In Stock</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qte</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <form method="POST" action="{{route('cart.add')}}">
                                @csrf 
                                <tr>
                                    <td>
                                        <input type="hidden" name="product_id" value="{{ $product->id}}">
                                        <input type="hidden" name="product_name" value="{{ $product->name}}">
                                    </td>
                                    <th scope="row">{{ $product->name }}</th>
                                    <th scope="row">{{ $product->qte_stock }}</th>
                                    <td>${{ $product->price }}</td>
                                    <td><input class="form-control" style="width: 90px" type="number" value="1" name="product_quantity" /></td>
                                    <td>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary ">Add To Cart</button>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                            @endforeach
                        </tbody>
                    </table>

                   

                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    {{ __('Shopping Cart') }}
                    <span style="float: right;">{{ $count }} Item</span>
                </div>
                

                <br>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td></td>
                        <th scope="col">P.Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartContent as $item)
                        <form method="POST" action="{{route('cart.remove')}}">
                            @csrf 
                            @method('DELETE')
                            <tr>
                                <td>    
                                    <input type="hidden" name="product_id" value="{{ $item->product_id}}">
                                </td>
                                <th scope="row">{{ $item->name }} <br> ${{ $item->total}}</th>
                                <td>${{ $item->price }}</td>
                                <td>
                                    <input class="form-control" style="width: 60px" type="number" value="{{ $item->quantity}}" name="product_quantity" /></td>
                                <td>
                                    
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-danger btn-sm">X</button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                    @endforeach
                    </tbody>
                </table>


                <div class="row">
                    <div class="col-md-6">
                        <b><h5 style="padding-left:20px;padding-top:10px">Total : ${{$total}}</h5></b>
                    </div>
                    <div class="col-md-6">
                        <form method="POST" action="{{route('cart.clear')}}">
                            @csrf 
                            @method('DELETE')
                            <div style="float:right;padding-right:20px">
                                <button type="submit" class="btn btn-danger">Clear</button>
                            </div>
                        </form>
                    </div>
                    

                </div>

                @if (session('message-checkout'))  <center><br><br><h5>{{ session('message-checkout') }} </h5></center> @endif
                <br>
                <hr>

                

                <center>
                    <form action="{{route('cart.checkout')}}" method="POST">
                        @csrf
                        <div class="">
                            <button type="submit" class="btn btn-secondary">Checkout</button>
                        </div>
                    </form>
                </center>
                
                <br><br>
               
            </div>
        </div>
    </div>

   
</div>
@endsection