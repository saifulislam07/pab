<li class="dd-item" data-id="{{ $menu->id }}">
    <div class="dd-handle">
        @if($menu->icon) <i class="{{ $menu->icon }} mr-1"></i> @endif
        <span class="text-bold">{{ $menu->title }}</span>
        <span class="text-muted ml-2 text-xs">({{ $menu->url ?: '#' }})</span>
    </div>
    
    <div class="dd-actions shadow-sm" style="position: absolute; right: 5px; top: 5px; z-index: 10;">
        <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#editMenuModal{{ $menu->id }}">
            <i class="fas fa-edit"></i>
        </button>
        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this menu item and all its submenus?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>

    @if($menu->children->count())
        <ol class="dd-list">
            @foreach($menu->children as $child)
                @include('admin.menus.partials.menu_item', ['menu' => $child])
            @endforeach
        </ol>
    @endif

    <!-- Edit Modal for this specific item -->
    <div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Menu Item: {{ $menu->title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $menu->title }}" required>
                        </div>
                        @if($menu->type == 'admin')
                        <div class="form-group">
                            <label>Icon (FontAwesome)</label>
                            <input type="text" name="icon" class="form-control" value="{{ $menu->icon }}" placeholder="e.g. fas fa-cog">
                        </div>
                        @endif
                        <div class="form-group">
                            <label>URL / Route</label>
                            <input type="text" name="url" class="form-control" value="{{ $menu->url }}" placeholder="e.g. /about or https://google.com">
                        </div>
                        <div class="form-group">
                            <label>Target</label>
                            <select name="target" class="form-control">
                                <option value="_self" {{ $menu->target == '_self' ? 'selected' : '' }}>Same Tab</option>
                                <option value="_blank" {{ $menu->target == '_blank' ? 'selected' : '' }}>New Tab</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="isActive{{ $menu->id }}" name="is_active" value="1" {{ $menu->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="isActive{{ $menu->id }}">Is Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</li>
