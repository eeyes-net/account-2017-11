<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - 开放API授权</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <style>
        .passport-authorize .container {
            margin-top: 30px;
        }

        .passport-authorize .scopes {
            margin-top: 20px;
        }

        .passport-authorize .buttons {
            margin-top: 25px;
            text-align: center;
        }

        .passport-authorize .btn {
            width: 125px;
        }

        .passport-authorize .btn-approve {
            margin-right: 15px;
        }

        .passport-authorize form {
            display: inline;
        }
    </style>
</head>
<body class="passport-authorize">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        授权请求
                    </div>
                    <div class="panel-body">
                        <!-- Introduction -->
                        <p><strong>{{ $client->name }}</strong> 请求获取权限：</p>
                        <p>应用创建时间： {{ $client->created_at }}</p>
                        <p>应用开发者： {{ $user->name }}
                            @if ($user->hasRole('eeyes.website.account.verified_developer'))
                                <span class="label label-info">e瞳认证开发者</span>
                            @endif
                        </p>
                        <p>应用跳转网址： {{ $client->redirect }}</p>

                        <!-- Scope List -->
                        @if (count($scopes) > 0)
                            <div class="scopes">
                                <p><strong>应用将获得以下权限：</strong></p>

                                <ul>
                                    @foreach ($scopes as $scope)
                                        <li>{{ $scope->description }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="buttons">
                            <!-- Authorize Button -->
                            <form method="post" action="/oauth/authorize">
                                {{ csrf_field() }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button type="submit" class="btn btn-success btn-approve">授权</button>
                            </form>

                            <!-- Cancel Button -->
                            <form method="post" action="/oauth/authorize">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button class="btn btn-danger">拒绝</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
