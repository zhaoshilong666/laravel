<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<p style='color:red'>
    @if(!empty($errors->first()))
        {{$errors->first()}}
    @endif
</p>
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">测试</h1>

        </div>
        <h3>欢迎使用 hAdmin</h3>

        <form class="m-t" role="form" action="{{ url('/add') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" placeholder="用户名" required="" name="u_name">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="密码" required="" name="u_pwd">

            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button><br>
                <a href="{{url("/wechat")}}">微信扫码登录</a>

            <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
            </p>

        </form>
    </div>

</div>
</body>
</html>


