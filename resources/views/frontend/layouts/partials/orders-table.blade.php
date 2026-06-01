@if($orders->count())

    <div class="orders-table">

        <table>
            <thead>
            <tr>
                <th>شماره سفارش</th>
                <th>تاریخ ثبت</th>
                <th>تعداد کالا</th>
                <th>مبلغ کل</th>
                <th>نوع پرداخت</th>
                <th>وضعیت سفارش</th>
                <th>عملیات</th>
            </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)

                <tr>
                    <td>
                        <strong>#{{ $order->id }}</strong>
                    </td>

                    <td>
                        {{ $order->created_at->format('Y/m/d') }}
                        <br>
                        <small>{{ $order->created_at->format('H:i') }}</small>
                    </td>

                    <td>
                        {{ $order->items->count() }}
                    </td>

                    <td>
                        <strong style="color:#f0003d;">
                            {{ number_format($order->total_price) }}
                            تومان
                        </strong>
                    </td>

                    <td>
                        {{ paymentTypeText($order->payment_type) }}
                    </td>

                    <td>
                        <span class="status-badge {{ orderStatusClass($order->status) }}">
                            {{ orderStatusText($order->status) }}
                        </span>
                    </td>

                    <td>
                        <div class="order-actions">

                            <a href="{{ route('front.user.orders.show', $order->id) }}"
                               class="order-btn view">
                                مشاهده فاکتور
                            </a>

                            @if(in_array($order->status, ['pending_review', 'waiting_payment']))
                                <a href="{{ route('front.user.orders.payment', $order->id) }}"
                                   class="order-btn continue">
                                    ادامه سفارش
                                </a>
                            @endif

                        </div>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>

    </div>

@else

    <div class="empty-orders">

        <div class="empty-orders-icon">
            🛒
        </div>

        <h3>
            هنوز سفارشی ثبت نشده است
        </h3>

        <p>
            شما هنوز هیچ سفارشی در این بخش ندارید.
        </p>

        <a href="{{ route('front.landing') }}" class="start-shopping-btn">
            شروع خرید
        </a>

    </div>

@endif
