<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        @if(isset($site_setting->logo) && $site_setting->logo)
            <img src="{{ asset('storage/' . $site_setting->logo) }}" alt="{{ $site_setting->site_name ?? config('app.name') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
        @else
            <i class="fas fa-camera brand-image img-circle elevation-3 text-center" style="line-height: 33px; font-size: 18px; opacity: .8;"></i>
        @endif
        <span class="brand-text font-weight-light">{{ $site_setting->site_name ?? config('app.name', 'PAB Admin') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=40&background=007bff&color=fff' }}"
                     class="img-circle elevation-2" alt="User Image"
                     style="width: 34px; height: 34px; object-fit: cover;">
            </div>
            <div class="info">
                <a href="{{ route('admin.profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach($admin_menus as $menu)
                    @php
                        $hasChildren = $menu->children->count() > 0;
                        $isActive = request()->is(trim($menu->url, '/') . '*') || ($menu->url && request()->fullUrlIs(url($menu->url) . '*'));
                        
                        // Special check for nested active state
                        if (!$isActive && $hasChildren) {
                            foreach($menu->children as $child) {
                                if (request()->is(trim($child->url, '/') . '*') || ($child->url && request()->fullUrlIs(url($child->url) . '*'))) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        }
                    @endphp

                    <li class="nav-item {{ $hasChildren && $isActive ? 'menu-open' : '' }}">
                        <a href="{{ $menu->url ? (Route::has($menu->url) ? route($menu->url) : (Str::startsWith($menu->url, 'http') ? $menu->url : url($menu->url))) : '#' }}" 
                           class="nav-link {{ $isActive ? 'active' : '' }}">
                            <i class="nav-icon {{ $menu->icon ?: 'fas fa-circle' }}"></i>
                            <p>
                                {{ $menu->title }}
                                @if($hasChildren)
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </p>
                        </a>
                        @if($hasChildren)
                            <ul class="nav nav-treeview">
                                @foreach($menu->children as $child)
                                    @php
                                        $childActive = request()->is(trim($child->url, '/') . '*') || ($child->url && request()->fullUrlIs(url($child->url) . '*'));
                                    @endphp
                                    <li class="nav-item">
                                        <a href="{{ $child->url ? (Route::has($child->url) ? route($child->url) : (Str::startsWith($child->url, 'http') ? $child->url : url($child->url))) : '#' }}" 
                                           class="nav-link {{ $childActive ? 'active' : '' }}">
                                            <i class="{{ $child->icon ?: 'far fa-circle' }} nav-icon"></i>
                                            <p>{{ $child->title }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
