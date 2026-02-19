<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        {{ optional($site_setting)->site_name ?: 'PAB' }} Admin Panel
    </div>
    <!-- Default to the left -->
    {!! optional($site_setting)->footer_copyright ?: '<strong>Copyright &copy; ' . date('Y') . ' <a href="' . route('home') . '">' . (optional($site_setting)->site_name ?: config('app.name', 'PAB')) . '</a>.</strong> All rights reserved.' !!}
</footer>
