<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Add Font Awesome stylesheet link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            margin-top: 20px;
        }

        .container {
            max-width: 800px;
            margin: 25px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }


        .headOders {
            max-width: 800px;
            margin: 8px auto;
            background-color: #fff;
            padding: 8px 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .button {
            padding: 7px 13px;
            background: rgb(30, 100, 231);
            border: 1px solid rgb(255, 255, 255);
            font-size: 13px;
            color: #ffffff;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background: #fa433c;
            color: #f8f8f8;
            border: 1px solid red;
        }

        h1 {
            font-size: 20px;
            font-weight: bold;

        }

        h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        p {
            margin: 8px 0;
            font-size: 14px
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-right: 12px;
        }

        .product-details {
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            justify-content: start;
            margin: 30px 0px;
        }

        .product-info {
            display: flex;
            gap: 5px;
            align-items: flex-start;
        }

        .tracking-info {
            display: flex;
            gap: 5px;
            margin-top: 20px;
            padding: 16px;
            background-color: #e6f7ff;
            border-radius: 8px;
        }

        .tracking-icon {
            color: #3498db;
            margin-right: 8px;
        }

        .payNotify {
            padding: 8px 18px;
            background: rgb(255, 102, 102);
            color: white;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .payNotify .button {
            border: 1px solid rgb(106, 196, 223)
        }

        .payNotify .button:hover {
            border: 1px solid rgb(255, 211, 211)
        }
    </style>

    <style>
        .container2 {
            max-width: 800px;
            margin: 10px auto;
            padding: 20px;
            background-color: #ffffff !important;
            box-shadow: 0px 0px 8px #d4d3d3;
            border-radius: 10px;
        }

        .hh-grayBox {
            padding: 10px;

        }

        .orderHistory {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
        }

        .pt45 {
            padding-top: 45px;
        }



        .order-tracking .is-complete {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            height: 30px;
            width: 30px;
            border: 0px solid #AFAFAF;
            background-color: #f7be16;
            margin: 0 auto;
            transition: background 0.25s linear;
            -webkit-transition: background 0.25s linear;
            z-index: 2;
        }


        .order-tracking.completed .is-complete {
            border-color: #27aa80;
            border-width: 0px;
            background-color: #27aa80;
        }


        .order-tracking p {
            color: #A4A4A4;
            font-size: 15px;
            margin-top: 8px;
            margin-bottom: 0;
            line-height: 20px;
        }

        .order-tracking p span {
            font-size: 14px;
        }

        .order-tracking.completed p {
            color: #007a29;
        }

        .order-tracking::before {
            content: '';
            display: block;
            height: 3px;
            width: calc(100% - 40px);
            background-color: #f7be16;
            top: 13px;
            position: absolute;
            left: calc(-50% + 20px);
            z-index: 0;
        }

        .order-tracking:first-child:before {
            display: none;
        }

        .order-tracking.completed:before {
            background-color: #009e6c;
        }

        .icons {
            margin-left: 1px;
            color: #ffffff;
        }

        .CreatedDate {
            position: absolute;
            top: -25px;
            left: 50px;
            rotate: 360deg;
        }

        .CreatedDate span {
            font-size: 13px;
            color: #0b76bd
        }

        @media screen and (max-width: 450px) {

            .order-tracking {
                text-align: center;
                width: 50%;
                position: relative;
                display: block;
                margin-top: 30px;
            }



            .order-tracking:nth-child(odd)::before {
                content: none;
            }

            .container {
                margin: 5px 15px
            }

            .container2 {
                margin: 5px 15px
            }

            .headOders {
                margin: 5px 15px
            }
        }

        @media screen and (max-width: 650px) {

            .container {
                margin: 5px 15px
            }

            .container2 {
                margin: 5px 15px
            }

            .headOders {
                margin: 5px 15px
            }


            .CreatedDate {
                position: absolute;
                top: -25px;
                left: 15px;
                rotate: 360deg;
            }

            .CreatedDate span {
                font-size: 12px;
                color: #0b76bd
            }

            .button {
                font-size: 12px;
                padding: 5px 12px;
            }

            .payNotify span {
                font-size: 13px
            }

            .payNotify {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-content: center padding: 5px;
                gap: 10px
            }

        }

        @media (min-width: 451px) {

            .order-tracking {
                text-align: center;
                width: 33.33%;
                position: relative;
                display: block;
                margin-top: 30px;
            }

            .order-tracking:nth-child(4)::before {
                content: none;
            }

            .order-tracking:nth-child(7)::before {
                content: none;
            }

            p {
                margin: 8px 0;
                font-size: 15px
            }

            .order-tracking p {
                font-size: 13px
            }



        }

        @media (min-width: 800px) {
            .order-tracking {
                text-align: center;
                width: 25%;
                position: relative;
                display: block;
                margin-top: 30px;
            }

            .order-tracking:nth-child(4)::before {
                content: '';
                display: block;
                height: 3px;
                width: calc(100% - 40px);
                top: 13px;
                position: absolute;
                left: calc(-50% + 20px);
                z-index: 0;
            }

            .order-tracking:nth-child(5)::before {
                content: none;
            }

            .order-tracking:nth-child(6)::before {
                content: '';
                display: block;
                height: 3px;
                width: 100%;
                top: 13px;
                position: absolute;
                left: calc(50% + -225px) !important;
                z-index: 0;
            }

            .order-tracking:nth-child(7)::before {
                content: '';
                display: block;
                height: 3px;
                width: 100%;
                top: 13px;
                position: absolute;
                left: calc(50% + -225px) !important;
                z-index: 0;
            }

        }
    </style>
</head>

<body>

    <div class="headOders">
        <h1>Order Details</h1>
        <a href="{{ route('account.orders') }}"><button class="button">Back</button></a>
    </div>
    <div class="container">

        @if (Session::has('error'))
            <h4 style="color: red">{{ Session::get('error') }}</h4>
        @endif

        @if (Session::has('success'))
            <h4 style="color: rgb(0, 128, 202)">{{ Session::get('success') }}</h4>
        @endif


        @if ($order->status == 'cancelled')
        @else
            @if ($payment)
                <div class="payNotify">
                    <span>You have a pending payment of {{ $payment->pay_amount }}&#2547;, Please pay it</span>
                    <div style="display: flex; justify-content: center; align-items: center: gap:4px">
                        <a
                            href="{{ route('bkash.create.payment', ['order_id' => $order->id, 'payment_id' => $payment->id]) }}"><button
                                class="button">Pay with bkash</button></a> &nbsp;
                        <a
                            href="{{ route('account.payFromWallet', ['order_id' => $order->id, 'payment_id' => $payment->id]) }}"><button
                                class="button" style="background: #2d9c58">Pay from wallet</button></a>
                    </div>
                </div>
            @endif
        @endif


        <!-- Order Information -->
        <div>
            <h2>Invoice id {{ $order->invoice_id }}</h2>
            <p>Date: {{ date_format($order->created_at, 'j M Y') }}</p>
            <p>Status: {{ $order->status == 'pending_payment' ? 'Pending Payment' : $order->status }}</p>
            <p>Items Total: <b>{{ number_format($order->total, 2) }}&#2547;</b> </p>
            <p>Discount: <b>{{ number_format($order->discount, 2) }}&#2547;</b> </p>
            <p>Delivery charge: <b>{{ number_format($order->fees, 2) }}&#2547;</b> </p>
            <p>Total: <b>{{ number_format($order->total + $order->fees - $order->discount, 2) }}&#2547;</b>
                @if ($order->fees)
                    with <b>{{ $order->fees }}&#2547;</b> delivery charge
                @else
                    without delivery charge
                @endif
            <p>Due payment:
                <b>{{ number_format($order->total - $order->paid + $order->fees - $order->discount, 2) }}&#2547;</b>
            </p>
        </div>

        <!-- Product Details -->
        <div class="product-details" style="gap: 10px; width: 100%">
            @if ($order->orderItem->isNotEmpty() && $order->orderItem->first()->product_id != '')
                @foreach ($order->orderItem as $item)
                    <div class="product-info">
                        <img src="{{ asset('uploads/products/' . $item->image) }}" style="width: 50px"
                            alt="Product Image">
                        <div style="display: flex; gap: 10px">
                            <p class="font-semibold">{{ $item->name }}</p>
                            @if ($item->status == 'cancelled')
                                <p style="color: red">Product cancelled by admin</p>
                            @else
                                <p>Quantity: {{ $item->qty }}</p>
                                <p>Price: <b>{{ number_format($item->price) }}&#2547;</b></p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @elseif($order->orderItem->isNotEmpty() && $order->orderItem->first()->r_product_id != '')
                @foreach ($order->orderItem as $item)
                    <div class="product-info">
                        <img src="{{ asset('uploads/requests/' . $item->image) }}" style="width: 50px"
                            alt="Product Image">
                        <div style="display: flex; gap: 10px">
                            <p class="font-semibold">{{ $item->name }}</p>
                            <p>Quantity: {{ $item->qty }}</p>
                            <p>Price: <b>{{ number_format($item->price) }}&#2547;</b></p>
                        </div>
                    </div>
                @endforeach

            @endif
        </div>

        <!-- Billing Information -->
        <div>
            <h2>Customer information</h2>
            <p>Name: {{ $order->user->name }}</p>
            <p>Email: {{ $order->user->email }}</p>
            <p>Address: {{ $order->user->address }}</p>
            <p>City: {{ $order->user->city }}</p>
            <p>Zone: {{ $order->user->zone }}</p>
            <p>Customer note: {{ $order->user->notes ? $order->user->notes : 'No notes added' }}</p>
        </div>


        <!-- Tracking Information -->
        <div class="tracking-info"
            style="padding: 10px; display: flex; flex-direction: column; overflow-x: auto; background:rgb(218, 246, 255)">
            <p style="font-size: 16px; font-weight: bold">Payment information</p>
            <table style="border: 1px solid gray; ">
                <thead>
                    <tr>
                        <th style="font-size: 14px; padding: 5px">Id</th>
                        <th style="font-size: 14px; padding: 5px">trxID</th>
                        <th style="font-size: 14px; padding: 5px">Payment number</th>
                        <th style="font-size: 14px; padding: 5px">Amount</th>
                        <th style="font-size: 14px; padding: 5px">Status</th>
                    </tr>
                </thead>
                @if ($payments->isNotEmpty())
                    @foreach ($payments as $payment)
                        <tr>
                            <td style="border-top: 1px solid gray; font-size: 13px; padding:6px; text-align: center">
                                {{ $payment->id }}</td>
                            <td style="border-top: 1px solid gray; font-size: 13px; padding:6px; text-align: center">
                                {{ $payment->trxID ? $payment->trxID : 'Not Paid' }}</td>
                            <td style="border-top: 1px solid gray; font-size: 13px; padding:6px;  text-align: center">
                                {{ $payment->payment_number ? $payment->payment_number : 'Not Paid' }}</td>
                            <td style="border-top: 1px solid gray; font-size: 13px; padding:6px;  text-align: center">
                                {{ $payment->pay_amount }}</td>

                            <td
                                style="border-top: 1px solid gray; font-size: 13px; padding:6px;  text-align: center; color: {{ $payment->status == 'pending' ? 'red' : 'green' }}">
                                {{ $payment->status == 'pending' ? ($order->status == 'cancelled' ? 'Cancelled' : 'Pending') : 'Paid' }}
                            </td>
                            {{-- @if ($payment->status == 'pending')
                                <td style="border-top: 1px solid gray; padding:6px;  text-align: center"><a href="" style="color:rgb(255, 48, 12); text-decoration: underline; font-size: 13px; ">Checkout</a></td>
                            @endif --}}

                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

    </div>


    <div class="container2">
        <div class="hh-grayBox ">
            @if ($order->admin_notes)
                <span
                    style="font-size: 14px; margin-bottom: 8px; display:block; background: rgb(186, 233, 241); padding: 8px 20px; color: rgb(26, 16, 43); border-radius: 5px">Admin
                    Notes: {{ $order->admin_notes }}</span>
            @endif

            @if ($order->status != 'cancelled')
                <div class="orderHistory">
                    @php
                        $pending = $order->status == 'pending';
                        $pending_payment = $order->status == 'pending_payment';
                        $approved = $order->status == 'approved';
                        $flight = $order->status == 'flight';
                        $country = $order->status == 'in_country';
                        $delivering = $order->status == 'delivering';
                        $delivered = $order->status == 'delivered';

                        $isPending = $pending || $pending_payment || $approved || $flight || $country || $delivering || $delivered;
                        $isPendingPay = $pending_payment || $approved || $flight || $country || $delivering || $delivered;
                        $isApproved = $approved || $flight || $country || $delivering || $delivered;
                        $isFlight = $flight || $country || $delivering || $delivered;
                        $isCountry = $country || $delivering || $delivered;
                        $isDelivering = $delivering || $delivered;
                        $isDelivered = $delivered;
                    @endphp
                    <div class="order-tracking {{ $isPending ? 'completed' : '' }}"
                        style="position: relative !important">
                        <div class="CreatedDate"><span><i class="fa-regular fa-calendar"
                                    style="margin-right: 5px"></i>{{ date_format($order->created_at, 'j M Y') }}</span>
                        </div>
                        <span class="is-complete "><i class="icons fa-regular fa-circle-check"></i></span>
                        <p>Order Created</p>
                    </div>
                    <div class="order-tracking {{ $isPendingPay ? 'completed' : '' }}">
                        <span class="is-complete"><i class="icons fa-regular fa-hourglass-half"></i></span>
                        <p>Pending Payment</p>
                    </div>
                    <div class="order-tracking {{ $isApproved ? 'completed' : '' }}">
                        <span class="is-complete"><i class="icons fa-solid fa-check"></i></span>
                        <p>Confirmed</p>
                    </div>
                    <div class="order-tracking {{ $isFlight ? 'completed' : '' }}">
                        <span class="is-complete"><i class="icons fa-solid fa-plane-departure"></i></span>
                        <p>In flight</p>
                    </div>
                    <div class="order-tracking {{ $isCountry ? 'completed' : '' }}">
                        <span class="is-complete"><i class="icons fa-solid fa-location-dot"></i></span>
                        <p>In Country</p>
                    </div>
                    <div class="order-tracking {{ $isDelivering ? 'completed' : '' }}">
                        <span class="is-complete"><i class="icons fa-solid fa-truck"></i></span>
                        <p>Delivering</p>
                    </div>
                    <div class="order-tracking {{ $isDelivered ? 'completed' : '' }}">
                        <span class="is-complete"><i class="icons fa-solid fa-clipboard-check"></i></span>
                        <p>Delivered</p>

                        @if ($order->status == 'delivered')
                            <div class="CreatedDate" style="left: 30px"><span><i class="fa-regular fa-calendar"
                                        style="margin-right: 5px"></i>{{ date_format($order->updated_at, 'j M Y') }}</span>
                            </div>
                        @endif
                    </div>

                </div>
            @else
                <div class="orderHistory">
                    <div class="order-tracking">
                        <span class="is-complete" style="background: red"><i class="icons fa-solid fa-xmark"></i></span>
                        <p style="color: red">Order
                            cancelled<br><span>{{ date_format($order->updated_at, 'h:i:s A ,j M Y') }}</span></p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</body>

</html>
