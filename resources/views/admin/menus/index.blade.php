@extends('layouts.admin')

@section('title', 'Menu Management')
@section('page_title', 'Menu Management')

@section('styles')
<style>
    .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }
    .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
    .dd-list .dd-list { padding-left: 30px; }
    .dd-collapsed .dd-list { display: none; }
    .dd-item, .dd-empty, .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
    .dd-handle { display: block; height: 35px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc; background: #fafafa; border-radius: 3px; box-sizing: border-box; }
    .dd-handle:hover { color: #2ea8e5; background: #fff; }
    .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
    .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
    .dd-item > button[data-action="collapse"]:before { content: '-'; }
    .dd-placeholder, .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
    .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5; background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff); background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff); background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff); background-size: 60px 60px; background-position: 0 0, 30px 30px; }
    .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
    .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
    .dd-dragel .dd-handle { -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1); box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1); }
    .dd-nochildren .dd-placeholder { display: none; }
    .nav-tabs .nav-link.active { font-weight: bold; border-top: 3px solid #007bff; }
</style>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $type == 'frontend' ? 'active' : '' }}" href="{{ route('admin.menus.index', ['type' => 'frontend']) }}">
                    <i class="fas fa-desktop mr-1"></i> Frontend Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type == 'admin' ? 'active' : '' }}" href="{{ route('admin.menus.index', ['type' => 'admin']) }}">
                    <i class="fas fa-user-shield mr-1"></i> Admin Sidebar
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    {{ ucfirst($type) }} Menu Structure
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addMenuModal">
                        <i class="fas fa-plus"></i> Add {{ ucfirst($type) }} Item
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        @foreach($menus as $menu)
                            @include('admin.menus.partials.menu_item', ['menu' => $menu])
                        @endforeach
                    </ol>
                </div>
                
                @if($menus->isEmpty())
                    <div class="text-center py-4 text-muted">
                        No {{ $type }} menu items found. Click add to start!
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary" id="save-order">
                    <i class="fas fa-save"></i> Save Order
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">Instructions</h3>
            </div>
            <div class="card-body">
                <ul>
                    <li>Drag and drop items to reorder them.</li>
                    <li>Nesting is supported up to 2 levels deep.</li>
                    <li>For <strong>Admin Sidebar</strong> items, make sure to provide a FontAwesome icon (e.g., <code>fas fa-tachometer-alt</code>).</li>
                    <li>Click <strong>Save Order</strong> after reordering to apply changes.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.menus.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New {{ ucfirst($type) }} Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Dashboard">
                    </div>
                    @if($type == 'admin')
                    <div class="form-group">
                        <label>Icon (FontAwesome)</label>
                        <input type="text" name="icon" class="form-control" placeholder="e.g. fas fa-cog">
                        <small class="text-muted">Find icons at <a href="https://fontawesome.com/v5/search?m=free" target="_blank">fontawesome.com</a></small>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>URL / Route</label>
                        <input type="text" name="url" class="form-control" placeholder="e.g. /admin/settings or admin.settings.edit">
                        <small class="text-muted">You can use relative paths or leave empty for parents.</small>
                    </div>
                    <div class="form-group">
                        <label>Parent Item</label>
                        <select name="parent_id" class="form-control select2" style="width: 100%;">
                            <option value="">None (Top Level)</option>
                            @foreach($menus as $m)
                                <option value="{{ $m->id }}">{{ $m->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Target</label>
                        <select name="target" class="form-control">
                            <option value="_self">Same Tab</option>
                            <option value="_blank">New Tab</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nestable').nestable({
            maxDepth: 2
        });

        $('#save-order').click(function() {
            const order = $('#nestable').nestable('serialize');
            
            $.ajax({
                url: '{{ route('admin.menus.reorder') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order: order,
                    type: '{{ $type }}'
                },
                success: function(response) {
                    if(response.status === 'success') {
                        toastr.success('Menu order saved successfully!');
                        location.reload();
                    }
                },
                error: function() {
                    toastr.error('Failed to save menu order.');
                }
            });
        });
    });
</script>
@endsection
