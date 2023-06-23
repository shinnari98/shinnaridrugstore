<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carts /* extends Model */
{
    // use HasFactory;

    public $products = null;
    public $totalPrice = 0;
    public $totalQuantity = 0;

    public function __construct($cart)
    {
        if($cart) {
            $this->products = $cart->products;
            $this->totalPrice = $cart->totalPrice;
            $this->totalQuantity = $cart->totalQuantity;
        }
    }

    public function addCart($product, $id, $quantity) 
    {
        $newProduct = ['quantity'=>0 , 'price'=> ($product->price*(100-$product->sale_off)/100) ,'productInfo'=>$product];
        if($this->products) {
            if(array_key_exists($id, $this->products)) {
                $newProduct = $this->products[$id];
            }
        }
        $newProduct['quantity'] += $quantity;
        $newProduct['price'] = $newProduct['quantity'] * ($product->price*(100-$product->sale_off)/100);

        $this->products[$id] = $newProduct;
        $this->totalPrice = 0;
        $this->totalQuantity = 0;

        foreach ($this->products as $product) {
            $this->totalPrice += $product['price'];
            $this->totalQuantity += $product['quantity'];
        }
    }

    public function deleteItemCart($id)
    {
        $this->totalPrice -= $this->products[$id]['price'];
        $this->totalQuantity -= $this->products[$id]['quantity'];
        unset($this->products[$id]);
    }
}
