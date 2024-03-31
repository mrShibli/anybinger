@extends('dashboard.layouts.app')


@section('contents')
    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4>Payments</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif
                            <form class="input-group" style="width: 30%">
                                <input type="text" name="search" class="form-control"
                                    value="{{ request('search') ?? request('search') }}" placeholder="Search users">
                                <button type="submit" class="input-group-text"><i class="fa-solid fa-search"></i></button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            @if ($payments->isNotEmpty())
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                ID
                                            </th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>trxID</th>
                                            <th>Pay number</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>{{ $payment->user->name }}</td>
                                                <td>{{ $payment->user->phone }}</td>
                                                <td>{{ $payment->trxID ? $payment->trxID : 'Not paid' }}</td>
                                                <td>{{ $payment->payment_number ? $payment->payment_number : 'Not paid' }}
                                                </td>
                                                <td>{{ $payment->pay_amount }}</td>
                                                <td>
                                                    @if ($payment->status == 'pending')
                                                        <span class="badge badge-warning
                                                           badge-shadow text-capitalize">
                                                        {{ $payment->status }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-info
                                                           badge-shadow text-capitalize">
                                                        Completed
                                                        </span>
                                                    @endif
                                                    

                                                </td>
                                                {{-- <td>

                                                    <a href="{{ route('pay.update', $payment->id) }}"
                                                        class="btn btn-success"><i class="fa-solid fa-check"></i>
                                                    </a>

                                                </td> --}}
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <h4 class=" text-center">No Payments found</h4>
                            @endif
                        </div>
                        <div class="mt-3 mx-auto">
                            {{ $payments->links('pagination::bootstrap-5') }}
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('customJs')
@endsection
