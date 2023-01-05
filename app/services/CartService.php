<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class CartService {

    const MINIMUM_QUANTITY = 1;

    public $total = 0;
    public $count = 0;
    public $message;
    public $products_in_cart = [];

    protected $cart_id;
    protected $user_id;

    public function __construct(){
        $this->setUserId();
        $cart = Cart::where('user_id', '=', $this->user_id)->first();
        if($cart){
            $this->total = $cart->total;
            $this->cart_id = $cart->id;
        } 

        $this->count = OrderProduct::where('cart_id', '=', $this->cart_id)->sum('quantity');

        $this->products_in_cart = OrderProduct::where('cart_id', '=', $this->cart_id)->join('products', 'products.id', '=', 'order_products.product_id')->get();

    } 

    private function get_quantity_in_cart_by_product_id($product_id){
        foreach($this->products_in_cart as $item){
            if($item->product_id == $product_id){
                return $item->quantity;
            }
        }
    }

    private function setUserId(){
        //$this->user_id = Auth::user()->id;
        $this->user_id = 1;
    }


    public function getContent(){
        return $this->products_in_cart;
    }

    public function add(Product $product, $qte){

        if($qte < Self::MINIMUM_QUANTITY) $qte = Self::MINIMUM_QUANTITY;

        if($product->qte_stock < $qte + $this->get_quantity_in_cart_by_product_id($product->id) ) $this->message = "Error : Product $product->name not found in Stock (Quantity in Stock :  $product->qte_stock )";
        else{
            $cart = Cart::UpdateOrCreate(
                ['user_id' => $this->user_id],
                ['total' => ($product->price * $qte) + $this->total]
            );
    
            OrderProduct::UpdateOrCreate(
                [
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                ],
                [
                    'quantity' => \DB::raw('quantity + '. $qte),
                    'total' => \DB::raw(' (quantity ) * '. $product->price),
                ],
            );
        }
        
        
    }


    public function checkout(){
        if($this->cart_id){
            OrderProduct::where('cart_id', '=', $this->cart_id)->update(['status' => 1]);
        
            foreach($this->products_in_cart as $item){
                Product::where('id', '=', $item->product_id)->decrement('qte_stock', $item->quantity);
            }
            
            Order::Create([
                'cart_id' => $this->cart_id,
                'total' => $this->total
            ]);
    
             $this->clear();
    
             $this->message = "Thank you for your order";
        }
       
    }

    public function removeProduct(Product $product){
        $item = OrderProduct::where('product_id', '=', $product->id)->where('cart_id', '=', $this->cart_id);
        Cart::where('id', '=', $this->cart_id)->decrement('total', $item->first('total')->total);
        $item->delete();

    }

    public function clear(){
        OrderProduct::where('cart_id', '=', $this->cart_id)->where('status', '=', '0')->delete();
        Cart::where('id', '=', $this->cart_id)->delete();
    }

}



?>