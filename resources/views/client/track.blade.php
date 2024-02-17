<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track your orders</title>
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
            padding: 7px 18px;
            background: rgb(30, 100, 231);
            border: 1px solid rgb(255, 255, 255);
            font-size: 14px;
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

        .container {
            padding-top: 20px;
            padding-bottom: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column
        }

        .container form {
            display: block;
            margin: 20px auto;
        }

        .container h1 {
            font-size: 24px;
            color: #3b69ff
        }

        #searchForm {
            width: 350px;
            background: #ffffff;
            box-shadow: 0px 0px 10px hsl(192, 11%, 83%);
            padding: 10px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        form input {
            padding: 9px 13px;
            width: 314px;
            font-size: 14px;
            color: rgb(11, 11, 44);
            border: 1px solid #2b2b2b;
            border-radius: 24px;
        }
        form input:focus{
            outline: 2px solid rgba(43, 135, 255, 0.767);
            border: 1px solid rgb(63, 63, 255);
        }
        form button {
            padding: 8px 15px;
            border-radius: 25px;
            color: #ffffff;
            background: rgb(69, 69, 255);
            border: 1px solid rgb(69, 69, 255);
            position: absolute;
            right: 20px;
            transition: ease-in 0.2s;
        }
        form button:hover {
            outline: 2px solid rgba(43, 135, 255, 0.767);
            background: rgb(9, 9, 236);
            border: 1px solid rgb(13, 13, 255);
            cursor: pointer;
        }
    </style>

    <style>
        .container2 {
            max-width: 800px;
            margin: 10px auto;
            margin-top: -40px;
            padding: 20px;
            background-color: #ffffff !important;
            
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
            .headOders h1{
               
                font-size: 18px !important
            }

            #searchForm {
            width: 220px;
            background: #ffffff;
            box-shadow: 0px 0px 10px hsl(192, 11%, 83%);
            padding: 10px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .container h1 {
            font-size: 21px
        }

        form input {
            padding: 9px 13px;
            width: 314px;
            font-size: 14px;
            color: rgb(11, 11, 44);
            border: 1px solid #2b2b2b;
            border-radius: 24px;
        }
        form input:focus{
            outline: 2px solid rgba(43, 135, 255, 0.767);
            border: 1px solid rgb(63, 63, 255);
        }
        form button {
            padding: 8px 15px;
            border-radius: 25px;
            color: #ffffff;
            background: rgb(69, 69, 255);
            border: 1px solid rgb(69, 69, 255);
            position: absolute;
            right: 12px;
            transition: ease-in 0.2s;
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
        <h1>Track Order</h1>
        <a href="{{ route('index') }}"><button class="button">Back</button></a>
    </div>
    <div class="container">
        <h1>Track Your Order</h1>

        <form action="">
            <div id="searchForm">
                <input type="text" value="{{ $invoice ? $invoice : '' }}" name="invoice_id" placeholder="Enter order invoice id">

                <button type="submit">Track</button>
            </div>

        </form>

        @if(!empty($order))
            <h1 style="font-size: 19px; text-align: center">{{ $invoice }} Your order  current status is: {{ $order->status == 'pending_payment' ? 'Pending Payment' : $order->status }}</h1>
        @endif

        @if (empty($order) && !empty($invoice))
            <h1 style="font-size: 19px; color: red; text-align: center">Your requested order with invoice id {{ $invoice }} was not found or deleted</h1>
        @endif
        
        
    </div>
        @if (!empty($order))
            <div class="container2">
                <div class="hh-grayBox ">
                    @if ($order->admin_notes)
                        <span style="font-size: 14px; margin-bottom: 8px; display:block; background: rgb(186, 233, 241); padding: 8px 20px; color: rgb(26, 16, 43); border-radius: 5px">Admin Notes: {{ $order->admin_notes }}</span>
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
                        <div class="order-tracking {{ $isPending ? 'completed' : '' }}" style="position: relative !important">
                            <div class="CreatedDate"><span><i class="fa-regular fa-calendar" style="margin-right: 5px"></i>{{ date_format($order->created_at, 'j M Y') }}</span></div>
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
                                <div class="CreatedDate" style="left: 30px"><span><i class="fa-regular fa-calendar" style="margin-right: 5px"></i>{{ date_format($order->updated_at, 'j M Y') }}</span></div>
                            @endif
                        </div>
                        
                    </div>
                    @else
                        <div class="orderHistory">
                            <div class="order-tracking">
                                <span class="is-complete" style="background: red"><i class="icons fa-solid fa-xmark"></i></span>
                                <p style="color: red">Order cancelled<br><span>{{ date_format($order->updated_at, 'h:i:s A ,j M Y') }}</span></p>
                            </div> 
                        </div>
                    @endif
                    
                </div>
            </div>
        @endif


    
</body>

</html>


{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
        }

        .header p {
            font-size: 14px;
            color: #777;
        }

        .details {
            margin-bottom: 20px;
        }

        .details h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .item p {
            margin: 0;
        }

        .total {
            margin-top: 20px;
            padding: 16px;
            background-color: #e6f7ff;
            border-radius: 8px;
        }

        .total p {
            margin: 0;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .footer p {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <div class="header">
            <h1>Invoice</h1>
            <p>Date: January 1, 2023</p>
        </div>

        <div class="details">
            <h2>Order Details</h2>
            <div class="item">
                <p>Product Name</p>
                <p>$50</p>
            </div>
            <!-- Add more items as needed -->

            <div class="total">
                <h2>Total</h2>
                <p>$50</p>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your purchase!</p>
        </div>
    </div>

</body>

</html> --}}
