@extends('layouts.admin')

@section('title', 'Financial Categories')
@section('page_title', 'Account Categories')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="card-title font-weight-bold text-gray-800">
                    <i class="fas fa-plus-circle text-primary mr-2"></i>
                    Add New Category
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.finance.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Category Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Office Rent" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Transaction Type</label>
                        <select name="type" class="form-control" required>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label font-weight-bold">FA Icon Class</label>
                        <input type="text" name="icon" class="form-control" placeholder="e.g. fas fa-wallet">
                        <small class="text-muted">Optional FontAwesome class.</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm">
                        Create Category
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="card-title font-weight-bold text-gray-800">
                    <i class="fas fa-tags text-success mr-2"></i>
                    All Account Categories
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 border-0">Category Name</th>
                                <th class="border-0">Type</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="px-4 border-0 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 mr-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                <i class="{{ $category->icon ?? 'fas fa-circle' }} text-muted opacity-50"></i>
                                            </div>
                                            <span class="font-weight-bold">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge {{ $category->type == 'income' ? 'bg-success-light text-success border border-success' : 'bg-danger-light text-danger border border-danger' }} px-3 py-1 font-weight-bold text-uppercase" style="font-size: 0.65rem;">
                                            {{ $category->type }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        @if($category->is_active)
                                            <span class="text-success"><i class="fas fa-check-circle"></i> Active</span>
                                        @else
                                            <span class="text-muted"><i class="fas fa-times-circle"></i> Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button type="button" class="btn btn-sm btn-outline-info shadow-sm mr-2" data-toggle="modal" data-target="#editCategory{{ $category->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.finance.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" onclick="return confirm('Delete this category?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-bold">Edit Account Category</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form action="{{ route('admin.finance.categories.update', $category->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label class="font-weight-bold">Category Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="font-weight-bold">Transaction Type</label>
                                                        <select name="type" class="form-control" required>
                                                            <option value="income" {{ $category->type == 'income' ? 'selected' : '' }}>Income</option>
                                                            <option value="expense" {{ $category->type == 'expense' ? 'selected' : '' }}>Expense</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">FA Icon Class</label>
                                                        <input type="text" name="icon" class="form-control" value="{{ $category->icon }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary font-weight-bold">Update Category</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-success-light { background-color: rgba(40, 167, 69, 0.1); }
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
    .badge { border-radius: 50px; font-size: 0.75rem; }
    .table td { vertical-align: middle; }
</style>
@endsection
