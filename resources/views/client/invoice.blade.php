<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Anybringr Invoice</title>
</head>

<body style="position: relative; width: 21cm; margin: 0 auto; color: #001028; background: #FFFFFF; font-family: Arial, sans-serif; font-size: 12px; font-family: Arial;">

  <header style="padding: 10px 0; margin-bottom: 30px; width: 90%;">
    <div id="logo" style="text-align: center; margin-bottom: 10px;">
      <img src="{{ public_path('uploads/settings/'.$logo->logo) }}" style="width: 90px;">
    </div>
    <h1 style="border-top: 1px solid #5D6975; border-bottom: 1px solid #5D6975; color: #5D6975; font-size: 2.4em; line-height: 1.4em; font-weight: normal; text-align: center; margin: 0 0 20px 0; background: url(dimension.png);">INVOICE {{ $order->invoice_id }}</h1>
    <div id="company" class="clearfix" style="float: right; text-align: right;">
      <div>Anybringr</div>
      <div>09602111145</div>
      <div><a href="mailto:anybringr@support.com">anybringr@support.com</a></div>
    </div>
    <div id="project" style="float: left;">
        @php
            $user = $order->user_id;
            $user = \App\Models\User::where('id', $user)->first();
        @endphp
      <div><span>CLIENT : </span> {{ $user->name }} </div>
      <div><span>ADDRESS : </span> {{ $user->address }}</div>
      <div><span>EMAIL : </span> <a href="mailto:anybringr@support.com">anybringr@support.com</a> </div>
      <div><span>DATE : </span> {{ optional($order->updated_at)->format('Y-m-d') ?? '' }} </div>
    </div>
  </header>

  <main style = "margin-top:100px;">

    <table style="width: 100%; border-collapse: collapse; border-spacing: 0; margin-bottom: 20px;">
      <thead>
        <tr>
            <th class="service" style="text-align: left; padding: 5px 20px; color: #5D6975; border-bottom: 1px solid #C1CED9; white-space: nowrap; font-weight: normal;">Name</th>
            <th class="desc" style="text-align: left; padding: 5px 20px; color: #5D6975; border-bottom: 1px solid #C1CED9; white-space: nowrap; font-weight: normal;">Item ID</th>
          <th style="text-align: left; padding: 5px 20px; color: #5D6975; border-bottom: 1px solid #C1CED9; white-space: nowrap; font-weight: normal;">PRICE</th>
          <th style="text-align: left; padding: 5px 20px; color: #5D6975; border-bottom: 1px solid #C1CED9; white-space: nowrap; font-weight: normal;">QTY</th>
          <th style="text-align: left; padding: 5px 20px; color: #5D6975; border-bottom: 1px solid #C1CED9; white-space: nowrap; font-weight: normal;">TOTAL</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->orderItem as $item)
        <tr style="border-bottom: 1px solid #C1CED9;">
            <td class="service" style="text-align: left;">{{ Str::limit($item->name, 30) }}</td>
            <td class="desc" style="text-align: left;">{{ '#' . $item->id }}</td>
            <td style="text-align: left; padding: 20px;">{{ $item->price }} Tk</td>
            <td style="text-align: left; padding: 20px;">{{ $item->qty }}</td>
            <td class="total" style="text-align: left; padding: 20px;">{{ $item->price * $item->qty }} Tk</td>
        </tr>
        @endforeach
        <tr>
          <td colspan="4" style="text-align: left;">SUBTOTAL</td>
          <td class="total" style="text-align: left; padding: 20px;">{{ $order->total }} Tk</td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: left;">Delivery Chearge</td>
          <td class="total" style="text-align: left; padding: 20px;">{{ $order->fees }} Tk</td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: left;">Discount</td>
          <td class="total" style="text-align: left; padding: 20px;">{{ $order->discount }} Tk</td>
        </tr>
        <tr style="border-bottom: 1px solid #C1CED9;">
          <td colspan="4" class="grand total" style="text-align: left;">GRAND TOTAL</td>
          <td class="grand total" style="text-align: left; padding: 20px;">{{ $order->total + $order->fees - $order->discount }} Tk</td>
        <hr/>
        <tr>
            <td colspan="4" class="grand total" style="text-align: left;">PAID TOTAL</td>
            <td class="grand total" style="text-align: left; padding: 20px;">{{ $order->paid }} Tk</td>
          </tr>
      </tbody>
    </table>
    <!-- <div id="notices">
      <div style="text-align: left;">NOTICE:</div>
      <div class="notice" style="color: #5D6975; font-size: 1.2em;">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div> -->
  </main>

  <footer style="color: #5D6975; width: 100%; height: 30px; position: absolute; bottom: 0; border-top: 1px solid #C1CED9; padding: 8px 0; text-align: center;">
    Invoice was created on a computer and is valid without the signature and seal.
  </footer>

</body>

</html>
