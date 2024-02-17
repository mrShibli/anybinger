@extends('client.layouts.app')

@section('headers')
    <title>My Transactions </title>

    @include('client.layouts.pagination')
@endsection

@section('contents')
    <!-- main -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('account.index') }}" class="link">Account</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">Transactions</a>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center gap-3">
            <h2 style="font-size:24px" class="my-2 font-medium text-blue-dark bg-white inline-block">
                My Transactions
            </h2>
            <br>
		</div>
		<div class="w-full flex flex-col items-center justify-center gap-3">
			<div class="w-[98%] sm:w-[90%] flex flex-col shadow-sm">

				<div class="relative overflow-x-auto shadow-md">
					<table class="min-w-full text-sm text-left rtl:text-right text-gray-500 ">
						<thead class="text-xs text-gray-700 uppercase bg-gray-100  ">
							<tr>
								<th scope="col" class="px-6 py-3"> Invoice ID </th>
								<th scope="col" class="px-6 py-3">
									<div class="flex items-center"> Transaction_Id
										<a href="#">
											<svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
												<path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" /> </svg>
										</a>
									</div>
								</th>
								<th scope="col" class="px-6 py-3">
									<div class="flex items-center"> Number 
										<a href="#">
											<svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
												<path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" /> </svg>
										</a>
									</div>
								</th>
								<th scope="col" class="px-6 py-3">
									<div class="flex items-center"> Amount
										<a href="#">
											<svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
												<path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" /> </svg>
										</a>
									</div>
								</th>
								<th scope="col" class="px-6 py-3">
									<div class="flex items-center"> Status
										<a href="#">
											<svg class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
												<path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" /> </svg>
										</a>
									</div>
								</th>
							</tr>
						</thead>
						<tbody>
                            @if ($payments->isNotEmpty())
                                @foreach ($payments as $payment)
                                    <tr class="bg-white border-b ">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap "> {{ $payment->order->invoice_id }} </th>
                                        <td class="px-6 py-4"> {{ $payment->trxID ? $payment->trxID : 'Pending' }} </td>
                                        <td class="px-6 py-4"> {{ $payment->payment_number ? $payment->payment_number : 'Pending' }} </td>
                                        <td class="px-6 py-4"> {{ $payment->pay_amount }} </td>
                                        <td class="px-6 py-4 {{ $payment->status == 'pending' ? 'text-red-600' : 'text-blue' }}"> {{ $payment->status }} </td>
                                    </tr>
                                @endforeach 
                            
                            @else

                            @endif
                            
							
							
						</tbody>
					</table>
				</div>
			</div>

            @if ($payments->hasPages())
                <div class="custom-pagination" style="margin-top: 50px !important">
                    <ul class="pagination">
                        @if ($payments->onFirstPage())
                            <li class="disabled"><span><i class="fa-solid fa-angle-left"></i> Previous</span></li>
                        @else
                            <li><a href="{{ $payments->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i> Previous</a></li>
                        @endif

                        @foreach ($payments->links()->elements as $element)
                            @if (is_string($element))
                                <li class="disabled"><span>{{ $element }}</span></li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <li class="{{ $page == $payments->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach

                        @if ($payments->hasMorePages())
                            <li><a href="{{ $payments->nextPageUrl() }}">Next <i class="fa-solid fa-angle-right"></i></a></li>
                        @else
                            <li class="disabled"><span>Next <i class="fa-solid fa-angle-right"></i></span></li>
                        @endif
                    </ul>
                </div>
            @endif

        </div>

    </main>

@endsection

@section('customJs')
@endsection
