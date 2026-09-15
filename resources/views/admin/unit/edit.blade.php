@extends('admin.layouts.master')

@section('title', 'Update Unit')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Unit</h4>
                    <h6 class="card-subtitle">Edit the details below to update the unit</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.units.update', $unit) }}">
                        @csrf
                        @method('PUT')

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Piece"
                            :value="$unit->name" required />

                        <x-admin.input-text name="code" :label="__('Code')" placeholder="e.g. PCS"
                            :value="$unit->code" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. A single item counted by units" :value="$unit->description" />

                        <x-admin.input-select name="status" :label="__('Status')" :selected="old('status', $unit->status)">
                            <option value="published" @selected(old('status', $unit->status) === 'published')>Published</option>
                            <option value="unpublished" @selected(old('status', $unit->status) === 'unpublished')>Unpublished</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Unit')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection