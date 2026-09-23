@extends('admin.layouts.master')

@section('title', 'Update Flash Deal')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Flash Deal</h4>
                    <h6 class="card-subtitle">Edit the details below to update the deal</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.flash-deals.update', $deal) }}">
                        @csrf
                        @method('PUT')

                        <x-admin.input-select name="product_id" :label="__('Product')" :selected="old('product_id', $deal->product_id)">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected(old('product_id', $deal->product_id) == $product->id)>
                                    {{ $product->name }} (৳ {{ number_format($product->selling_amount, 2) }})</option>
                            @endforeach
                        </x-admin.input-select>

                        <x-admin.input-text name="sale_price" type="number" step="0.01" :label="__('Sale Price')"
                            :value="$deal->sale_price" required />

                        <x-admin.input-text name="ends_at" type="datetime-local" :label="__('Ends At')"
                            :value="$deal->ends_at->format('Y-m-d\TH:i')" required />

                        <x-admin.input-select name="is_active" :label="__('Active')" :selected="old('is_active', (string) $deal->is_active)">
                            <option value="1" @selected(old('is_active', (string) $deal->is_active) === '1')>Yes</option>
                            <option value="0" @selected(old('is_active', (string) $deal->is_active) === '0')>No</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Flash Deal')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
