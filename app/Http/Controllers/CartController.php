<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private CartService $cartService; 

    public function __construct(){
        $this->cartService = new CartService;
    }

    public function add_to_cart(Request $request){
       
        $product = Product::find($request->product_id);

        $this->cartService->add($product, $request->product_quantity);

        return redirect()->back()->with('message', $this->cartService->message);

    }

    public function remove_from_cart(Request $request){

        $product = Product::find($request->product_id);

        $this->cartService->removeProduct($product);

        return redirect()->back();

       
    }
    
    public function index()
    {
        $cartContent = $this->cartService->getContent();

        $total = $this->cartService->total;

        $count = $this->cartService->count;

        return view('products')->with(['products' => Product::all(), "cartContent" => $cartContent, "total" => $total, "count" => $count]);

    }

   
    public function clear_cart()
    {
        $this->cartService->clear();

        return redirect()->back();
    }


    public function checkout()
    {
        $this->cartService->checkout();

        return redirect()->back()->with('message-checkout', $this->cartService->message);
    }

    
}
