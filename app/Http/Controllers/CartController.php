<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OrderCreated;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function cart () 
    {
        $cart = session('cart') ?? [];
        $products = Product::whereIn('id', array_keys($cart))
                    ->get()
                    ->transform(function ($product) use ($cart) {
                        $product->quantity = $cart[$product->id];
                        return $product;
                    });
        $user = Auth::user();
        $address = $user ? $user->addresses()->where('main', 1)->first()->address ?? '' : '';
        return view('cart', compact('products', 'user', 'address'));
    }

    public function addToCart ()
    {
       $productId = request('id');
       $cart = session('cart') ?? [];
       
       if (isset($cart[$productId])) {
            $cart[$productId] = ++$cart[$productId]; 
       } else {
           $cart[$productId] = 1;
       }
       session()->put('cart', $cart);
       return $cart[$productId];
    }

    public function removeFromCart ()
    {
        $productId = request('id');
        $cart = session('cart') ?? [];

        if (!isset($cart[$productId]))
            return 0;

        $quantity = $cart[$productId];
        if ($quantity > 1) {
            $cart[$productId] = --$quantity;
        } else {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);
        return $cart[$productId] ?? 0;
    }

    public function createOrder ()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        DB::transaction(function() { //DB::transaction ???????????????????????? ?????? ???????????????????? ??????????????, ???????? ?????????????????? ????????????, ???? ???????????????????? ?????? ??????????????????, ?????????????? ???????? ?????????????? ?? ????????, ???? ??????????.
            $user = Auth::user();
            
            if (!$user) {
                $password = Str::random(8);
                if (User::where('email', request('email'))->first()) {
                    session()->flash('emailError');
                    return back();
                }
                $user = User::create([
                    'name' => request('name'),
                    'email' => request('email'),
                    'password' => Hash::make($password),
                ]);
                
                $address = Address::create([
                    'user_id' => $user->id,
                    'address' => request('address'),
                    'main' => 1
                ]);
                request()->validate([
                    'register_confirmation' => 'accepted'
                ]);
                Auth::loginUsingId($user->id);
            }
                        
            if ($user) {
                $address = $user->getMainAddress();
                   
                $cart = session('cart');

                $order = Order::create([
                    'user_id' => $user->id,
                    'address_id' => $address->id,
                ]);
                foreach ($cart as $id => $quantity) {
                    $product = Product::find($id);
                    $order->products()->attach($product, [
                        'quantity' => $quantity,
                        'price' => $product->price
                    ]);
                }
            }

            $data = [
                'name' => $user->name,
                'products' => $order->products,
                'password' => $password ?? null,
            ];
            Mail::to($user->email)->send(new OrderCreated($data));
        });
        
        session()->forget('cart');
        return back();
    }

    public function repeatOrder ()
    {
        $orderId = request('order_id');
        $orders = Order::find($orderId)->products->pluck('pivot');
        $cart = [];
        foreach ($orders as $order) {
            $cart[$order->product_id] = $order->quantity;
        }
        session()->put('cart', $cart);
        return redirect('cart');
    }
}
