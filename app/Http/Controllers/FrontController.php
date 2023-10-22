<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('front.auth.login');
        } else if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return redirect()->route('index');
            }

            return redirect()
                ->route('login')
                ->withErrors('Please enter the Currect email or password.');
        }
    }

    public function logOut()
    {
        Auth::logout();

        return redirect()->route('user.index');
    }

    public function index()
    {

        $products = Product::where('status', 1)->get();

        return view('front.product', compact('products'));
    }

    public function addToCart(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(['status' => 401, 'error' => 'unauth access.']);
        }

        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validation->errors()
            ]);
        }

        if (Cart::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->exists()) {
            Cart::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->delete();
            return response()->json(['status' => 409, 'message' => 'Already exists.Deleted.']);
        }

        Cart::insert([
            'product_id' => $request->product_id,
            'user_id' => Auth::user()->id,
            'quantity' => $request->quantity
        ]);

        return response()->json(['status' => 200, 'success' => 'Added to Cart']);
    }

    public function addToWishlist(Request $request)
    {

        if (!Auth::user()) {
            return response()->json(['status' => 401, 'error' => 'unauth access.']);
        }

        $validation = Validator::make($request->all(), [
            'product_id' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validation->errors()
            ]);
        }

        if (Wishlist::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->exists()) {
            //delete it from wishlist
            Wishlist::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->delete();
            return response()->json(['status' => 409, 'message' => 'Already exists. Deleted.']);
        }

        Wishlist::insert([
            'product_id' => $request->product_id,
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['status' => 200, 'success' => 'Added to Wishlist']);
    }
}
