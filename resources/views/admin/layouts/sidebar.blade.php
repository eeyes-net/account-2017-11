<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li @if (request()->is('admin')) class="active" @endif><a href="{{ url('admin') }}">主页 <span class="sr-only">(current)</span></a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li @if (request()->is('admin/user')) class="active" @endif><a href="{{ url('admin/user') }}">用户</a></li>
        <li @if (request()->is('admin/role')) class="active" @endif><a href="{{ url('admin/role') }}">角色</a></li>
        <li @if (request()->is('admin/permission')) class="active" @endif><a href="{{ url('admin/permission') }}">权限</a></li>
    </ul>
</div>
