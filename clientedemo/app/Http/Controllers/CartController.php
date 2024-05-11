<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        // dd($cartItems);
        return view('cart', compact('cartItems'));
    }


    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');

        return redirect()->route('cart.list');
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return redirect()->route('cart.list');
    }

    public function hacerPedido()
    {
        $cartItems = \Cart::getContent();
        //dd($cartItems);
        //Insertamos en la tabla orders y obtenemos el id
        $order_id = DB::table('orders')->insertGetId([
            'customer_id' => 1,
            'fecha_compra' => now(),
            'total' => 0,
            // 'status' => 'ACTIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $total=0;
        foreach ($cartItems as $producto) {
            //dd($producto);
            $subtotal=$producto['quantity']*$producto['price'];
            $id = DB::table('order_detaile')->insertGetId([
                'order_id' => $order_id,
                'product_id' => $producto['id'],
                'cantidad' => $producto['quantity'],
                'precio'=>$producto['price'],
                'subtotal'=>$subtotal,
                // 'status' => 'ACTIVO',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $total+= $subtotal;
            $prod=DB::table('products')->where('id', $producto['id'])->first();
            DB::table('products')->where('id', $producto['id'])
            ->update([
                'quantity' => $prod->quantity-$producto['quantity'],
                'updated_at' => now(),
            ]);
        }

        DB::table('orders')->where('id', $order_id)
            ->update([
                'total' => $total,
                'updated_at' => now(),
            ]);

        \Cart::clear();

        session()->flash('success', 'pedido realizado!');
        return redirect()->route('products.list');

       

    }
}
