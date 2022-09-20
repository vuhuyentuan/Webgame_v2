@extends('layout_index.master')
@section('content')

<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="{{asset('endgame/img/page-top-bg/4.jpg')}}" style="height: 280px;">
    <div class="page-info">
        <div class="site-breadcrumb">
            <a href="#">{{ __('Home') }}</a> / <span>{{ __('Order history') }}</span>
        </div>
    </div>
</section>
<!-- Page top end-->

<!-- Contact page -->
<section class="contact-page" style="padding-top: 30px">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-2 order-lg-1">
                @include('users.nav')
            </div>
            <div class="col-lg-9 order-1 order-lg-2 contact-text text-white">
                <div class="table-responsive" style="width: 110%;">
                    <table class="table table-striped custom-table float-left">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">{{ __('Order code') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Support system') }}</th>
                                <th scope="col">{{ __('Quantity') }}</th>
                                <th scope="col">{{ __('Total point') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($orderhistory))
                                @foreach ($orderhistory as $history)
                                    <tr>
                                        <td>
                                            <a href="{{ route('order.show', $history->id) }}" target="_blank">
                                                <button class="btn btn-hover">{{ __('Bill') }}</button>
                                            </a>
                                        </td>
                                        <td>{{ $history->order_id }}</a></td>
                                        <td>{{ $history->product->name }}</td>
                                        <td class="text-center">{{ $history->product->os_supported }}</td>
                                        <td class="text-center">{{ $history->quantity }}</td>
                                        <td>{{ $history->point_total }} {{ __('Point') }}</td>
                                        @if ($history->status == 'pending')
                                            <td><span class="badge badge-secondary">{{ __('Pending') }}</span></td>
                                        @elseif ($history->status == 'completed')
                                            <td><span class="badge badge-success">{{ __('Completed') }}</span></td>
                                        @elseif ($history->status == 'canceled')
                                            <td><span class="badge badge-danger">{{ __('Canceled') }}</span></td>
                                        @endif
                                        <td>{{ date('d/m/Y ', strtotime($history->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="site-pagination">
                    {{ $orderhistory->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact page end-->
@endsection

