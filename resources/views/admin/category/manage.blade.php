@extends('admin.layouts.master')

@section('title', 'Manage Categories')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Categories</h4>
                <h6 class="card-subtitle">List of all categories</h6>
                <div class="table-responsive m-t-40">
                    <table id="categoriesTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>
                                    <a href="#" title="Edit" class="btn btn-sm text-primary me-2"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#" title="Delete" class="btn btn-sm text-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
