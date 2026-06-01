<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
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
            'description' => ['nullable', 'string', 'max:5000'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        $filePath = null;

        if ($request->hasFile('print_file')) {
            $filePath = $request->file('print_file')->store('cart-files', 'public');
        }

        $quantity = (int) ($request->quantity ?? 1);

        $price = (float) (
            $request->total_price
            ?? $product->discount_price
            ?? $product->price
            ?? 0
        );

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
            'description' => $request->input('description'),

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

    public function edit($key)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$key])) {
            return redirect()
                ->route('front.cart.index')
                ->with('error', 'آیتم مورد نظر یافت نشد.');
        }

        $item = $cart[$key];

        return view('frontend.cart-edit', compact(
            'item',
            'key'
        ));
    }

    public function update(Request $request, $key)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$key])) {
            return redirect()
                ->route('front.cart.index')
                ->with('error', 'آیتم مورد نظر یافت نشد.');
        }

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        $cart[$key]['quantity'] = $request->quantity;

        $cart[$key]['description'] = $request->description;

        if (isset($cart[$key]['price'])) {
            $cart[$key]['total'] =
                ($cart[$key]['price'] ?? 0)
                * ($cart[$key]['quantity'] ?? 1);
        }

        if ($request->hasFile('print_file')) {

            $filePath = $request->file('print_file')
                ->store('cart-files', 'public');

            $cart[$key]['file_path'] = $filePath;
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('front.cart.index')
            ->with('success', 'سبد خرید بروزرسانی شد.');
    }

    public function checkoutPage()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('front.cart.index')
                ->with('error', 'سبد خرید خالی است.');
        }

        $addresses = Address::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('frontend.checkout', compact('cart', 'addresses'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_type' => ['required', 'in:online,after_call'],
            'receiver_name' => ['nullable', 'string', 'max:255'],
            'receiver_lastname' => ['nullable', 'string', 'max:255'],
            'receiver_mobile' => ['nullable', 'string', 'max:20'],
            'receiver_phone' => ['nullable', 'string', 'max:20'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'province' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'shipping_method' => ['required', 'string', 'max:255'],
            'shipping_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'سبد خرید خالی است.');
        }

        DB::beginTransaction();

        try {
            $productsTotal = collect($cart)->sum(function ($item) {
                return $item['total']
                    ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1));
            });

            $shippingPrice = (float) ($request->shipping_price ?? 0);

            $totalPrice = $productsTotal + $shippingPrice;

            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending_review',
                'payment_type' => $request->payment_type,
                'total_price' => $totalPrice,

                'receiver_name' => $request->receiver_name,
                'receiver_lastname' => $request->receiver_lastname,
                'receiver_mobile' => $request->receiver_mobile,
                'receiver_phone' => $request->receiver_phone,
                'postal_code' => $request->postal_code,
                'province' => $request->province,
                'city' => $request->city,
                'address' => $request->address,
                'shipping_method' => $request->shipping_method,
                'shipping_price' => $shippingPrice
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'] ?? null,
                    'title' => $item['title'] ?? null,
                    'type' => $item['type'] ?? null,
                    'quantity' => $item['quantity'] ?? 1,
                    'price' => $item['price'] ?? 0,
                    'total' => $item['total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1)),
                    'description' => $item['description'] ?? null,
                    'file_path' => $item['file_path'] ?? null,
                    'width' => $item['width'] ?? null,
                    'height' => $item['height'] ?? null,
                    'options' => !empty($item['options']) ? json_encode($item['options']) : null,
                    'options_number' => !empty($item['options_number']) ? json_encode($item['options_number']) : null,
                    'installer_required' => $item['installer_required'] ?? null,
                    'installer_type' => $item['installer_type'] ?? null,
                    'installer_address' => $item['installer_address'] ?? null,
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('front.cart.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        return view('frontend.checkout-success', compact('order'));
    }
}
