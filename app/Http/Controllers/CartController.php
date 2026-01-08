<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'movie_id' => 'required',
        ]);

        Cart::create([
            'user_id' => Auth::id(),
            'movie_id' => $request->movie_id,
        ]);

        return redirect()->route('cart.index')
            ->with('success', 'Berhasil ditambahkan ke keranjang!');
    }

    public function remove($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Item dihapus dari keranjang');
    }
}
