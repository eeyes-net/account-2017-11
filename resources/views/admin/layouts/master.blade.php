<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ganlv,eeyes.net">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>e瞳统一用户管理</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    @include('admin.layouts.nav')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="admin">
                @yield('main')
            </div>
            @include('admin.layouts.sidebar')
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            @include('admin.layouts.footer')
        </div>
    </div>
    <script src="/js/admin.js"></script>
</body>
</html>
