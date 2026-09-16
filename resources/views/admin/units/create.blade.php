@extends('admin.layouts.master')

@section('title', 'Add Unit')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Unit</h4>
                    <h6 class="card-subtitle">Fill in the details below to create a new unit</h6>
                    <form class="form-horizontal p-t-20" action="{{ route('admin.units.store') }}" method="POST">
                        @csrf

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Piece" required />

                        <x-admin.input-text name="code" :label="__('Code')" placeholder="e.g. PCS" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. A single item counted by units" />

                        <x-admin.input-select name="status" :label="__('Status')" :selected="old('status', 'published')">
                            <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
                            <option value="unpublished" @selected(old('status') === 'unpublished')>Unpublished</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Create Unit')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection