<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('frontend.user.profile');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['nullable', 'string', 'max:255'],
            'email'      => ['nullable', 'email', 'max:255'],
            'code_meli'  => ['nullable', 'string', 'max:20'],
            'base_phone' => ['nullable', 'string', 'max:20'],
            'job'        => ['nullable', 'string', 'max:255'],
            'refund'     => ['nullable', 'string', 'max:255'],
            'day'        => ['nullable', 'integer', 'between:1,31'],
            'month'      => ['nullable', 'integer', 'between:1,12'],
            'year'       => ['nullable', 'integer', 'between:1300,1500'],
            'messaging'  => ['nullable'],
            'avatar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        $user->update([
            'name'  => $validated['name'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $destination = public_path('uploads/users/avatar');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file = $request->file('avatar');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            $file->move($destination, $fileName);

            $user->update([
                'avatar' => 'uploads/users/avatar/' . $fileName,
            ]);
        }

        $birthDate = null;

        if (
            !empty($validated['year']) &&
            !empty($validated['month']) &&
            !empty($validated['day'])
        ) {
            $birthDate = sprintf(
                '%04d-%02d-%02d',
                $validated['year'],
                $validated['month'],
                $validated['day']
            );
        }

        $user->member()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name'    => $validated['name'] ?? null,
                'national_code' => $validated['code_meli'] ?? null,
                'phone'         => $validated['base_phone'] ?? null,
                'job'           => $validated['job'] ?? null,
                'refund'        => $validated['refund'] ?? null,
                'birth_date'    => $birthDate,
                'newsletter'    => $request->boolean('messaging'),
            ]
        );

        return back()->with('success', 'اطلاعات پروفایل با موفقیت بروزرسانی شد.');
    }

    public function allOrders()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $newOrders = $orders->whereIn('status', [
            'pending_review',
            'waiting_payment',
            'processing',
        ]);

        $readyOrders = $orders->whereIn('status', [
            'ready',
            'ready_delivery',
            'ready_to_send',
        ]);

        $completedOrders = $orders->whereIn('status', [
            'completed',
            'done',
            'finished',
        ]);

        return view('frontend.allOrders', compact(
            'orders',
            'newOrders',
            'readyOrders',
            'completedOrders'
        ));
    }

    public function showOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items');

        return view('frontend.show-order', compact('order'));
    }

    public function orderPayment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending_review', 'waiting_payment'])) {
            return redirect()
                ->route('front.user.orders')
                ->with('error', 'امکان ادامه این سفارش وجود ندارد.');
        }

        $order->load('items');

        return view('frontend.order-payment', compact('order'));
    }

    public function continueOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return redirect()->route('front.user.orders.payment', $order->id);
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'receiver_name' => ['required', 'string', 'max:255'],
            'receiver_lastname' => ['nullable', 'string', 'max:255'],
            'receiver_mobile' => ['required', 'string', 'max:20'],
            'receiver_phone' => ['nullable', 'string', 'max:20'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
        ]);

        $address = Address::create([
            'user_id' => auth()->id(),
            'receiver_name' => $request->receiver_name,
            'receiver_lastname' => $request->receiver_lastname,
            'receiver_mobile' => $request->receiver_mobile,
            'receiver_phone' => $request->receiver_phone,
            'postal_code' => $request->postal_code,
            'province' => $request->province,
            'city' => $request->city,
            'address' => $request->address,
            'is_default' => false,
        ]);

        return response()->json([
            'success' => true,
            'address' => $address,
        ]);
    }
}
