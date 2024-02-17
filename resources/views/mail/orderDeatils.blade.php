<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order confirmation for order inv #2222 </title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        p {
            margin: 15px 0;
            font-size: 15px;
        }

        .order-details {
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #464646;
        }
        button {
            padding: 6px 12px;
            color: #ffffff;
            background: #000;
            border-radius: 5px;
            cursor:pointer;
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Confirmation - Anybringr</h1>

        <p>Dear {{ $order->user->name }},</p>

        <p>Thank you for your order. We are pleased to confirm that we have received your order and it has been approved. Below are the details of your order:</p>

        <div class="order-details">
            <p><strong>Order Number:</strong> {{ $order->invoice_id }}</p>
            <p><strong>Date:</strong> {{ date_format($order->created_at, 'j M Y') }}</p>
            <p><strong>Total Amount:</strong> {{ $order->total + $order->fees - $order->discount }}Tk</p>
        </div>

        <p>You've to pay {{ $payment->pay_amount }}Tk via bkash to confirm your order</p>
        <a href="{{ route('account.orders', $order->id) }}"><button>Go to payment page</button></a>

        <p>Your items will be shipped to the following address:</p>

        <address>
            {{ $order->user->address }}<br>
            {{ $order->user->city }}<br>
            {{ $order->user->zone }}<br>
        </address>

        <p>For any questions regarding your order, please contact our customer support at Customer Support {{ $anyBringrSettings->service_email }} or {{ $anyBringrSettings->service_phone }}</p>

        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>Anybringr<br>
            {{ $anyBringrSettings->service_email }}</p>
        </div>
    </div>
</body>
</html>
