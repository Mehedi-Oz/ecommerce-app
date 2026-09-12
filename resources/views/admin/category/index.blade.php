@extends('admin.layouts.master')

@section('title', 'Add Category')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Category</h4>
                    <h6 class="card-subtitle">Fill in the details below to create a new category</h6>
                    <form class="form-horizontal p-t-20">
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Name <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="e.g. Electronics"
                                        name="name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Description <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="e.g. Mobile phones, laptops and accessories" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3 control-label">Image</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="file" class="dropify" name="image" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                <label class="me-3 form-check form-check-inline"><input type="radio"
                                        name="status" value="published" class="form-check-input">Published</label>
                                <label class="form-check form-check-inline"><input type="radio"
                                        name="status" value="unpublished" class="form-check-input">Unpublished</label>
                            </div>
                        </div>

                        <div class="form-group row m-b-0">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-success waves-effect waves-light text-white">Create Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
