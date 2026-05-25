<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
class CartsController extends Controller
{
    public function addTaki(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::with('options.values')
            ->findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        $itemKey = 'taki_' . $product->id . '_' . md5(json_encode($request->options ?? []));

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $request->quantity;
        } else {
            $cart[$itemKey] = [
                'type'      => 'taki',
                'product_id'=> $product->id,
                'title'     => $product->title,
                'price'     => $product->discount_price ?? $product->price,
                'quantity'  => $request->quantity,
                'image'     => optional($product->images()->where('is_main', 1)->first())->image,
                'options'   => $request->options ?? [],
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->back()
            ->with('success', 'محصول به سبد خرید اضافه شد.');
    }

    public function addPrint(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'print_file' => ['nullable', 'file'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        $filePath = null;

        if ($request->hasFile('print_file')) {
            $filePath = $request->file('print_file')->store('cart-files', 'public');
        }

        $quantity = (int) ($request->quantity ?? 1);
        $price = (float) ($request->total_price ?? $product->discount_price ?? $product->price ?? 0);

        $cart = session()->get('cart', []);

        $itemKey = 'print_' . uniqid();

        $cart[$itemKey] = [
            'type' => 'print',
            'product_id' => $product->id,
            'title' => $product->title,
            'quantity' => $quantity,
            'price' => $price,
            'total' => $price * $quantity,
            'image' => optional($product->images()->where('is_main', 1)->first())->image,
            'file_path' => $filePath,
            'width' => $request->width,
            'height' => $request->height,
            'options' => $request->input('options', []),
            'options_number' => $request->input('options_number', []),
            'installer_required' => $request->installer_required,
            'installer_type' => $request->installer_type,
            'installer_address' => $request->installer_address,
        ];

        session()->put('cart', $cart);

        return redirect()
            ->route('front.cart.index')
            ->with('success', 'سفارش چاپی به سبد خرید اضافه شد.');
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        $totalPrice = collect($cart)->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        });

        return view('frontend.carts', compact(
            'cart',
            'totalPrice'
        ));
    }

    public function remove($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return back();
    }

    public function clear()
    {
        session()->forget('cart');

        return back();
    }
}
