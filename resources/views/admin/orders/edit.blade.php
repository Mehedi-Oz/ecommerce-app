@extends('admin.layouts.master')

@section('title', 'Update Order')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Order #{{ $order->id }}</h4>
                    <h6 class="card-subtitle">Only the next valid status for each field can be selected</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.orders.update', $order) }}">
                        @csrf
                        @method('PUT')

                        <x-admin.input-select name="order_status" :label="__('Order Status')" :selected="old('order_status', $order->order_status)">
                            @foreach ($allowed['order_status'] as $value)
                                <option value="{{ $value }}" @selected(old('order_status', $order->order_status) === $value)>{{ ucfirst($value) }}</option>
                            @endforeach
                        </x-admin.input-select>

                        <x-admin.input-select name="delivery_status" :label="__('Delivery Status')" :selected="old('delivery_status', $order->delivery_status)">
                            @foreach ($allowed['delivery_status'] as $value)
                                <option value="{{ $value }}" @selected(old('delivery_status', $order->delivery_status) === $value)>{{ ucfirst($value) }}</option>
                            @endforeach
                        </x-admin.input-select>

                        <x-admin.input-select name="payment_status" :label="__('Payment Status')" :selected="old('payment_status', $order->payment_status)">
                            @foreach ($allowed['payment_status'] as $value)
                                <option value="{{ $value }}" @selected(old('payment_status', $order->payment_status) === $value)>{{ ucfirst($value) }}</option>
                            @endforeach
                        </x-admin.input-select>

                        <x-admin.input-text-area name="delivery_address" :label="__('Delivery Address')"
                            placeholder="e.g. House 1, Road 2, Dhaka" :value="old('delivery_address', $order->delivery_address)" required />

                        <x-admin.input-text name="note" :label="__('Note (optional)')" placeholder="e.g. Cash collected on delivery"
                            :value="old('note')" />

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Order')" />
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary ms-2"><i
                                    class="fas fa-arrow-left"></i> Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
