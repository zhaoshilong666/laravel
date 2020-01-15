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

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">测试</h1>

        </div>
        <h3>欢迎使用 hAdmin</h3>


    </div>
    <div style="padding-left: 5%;">
        <img src="{{$imgPath}}" width="200px">
        <br>
        <a href="{{url("/login")}}">账号登录</a>
    </div>
</div>
</body>
</html>
<script src="{{asset('hadmin/js/jquery.min.js')}}"></script>
<script src="{{asset('hadmin/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">

    //js的时间设置
    var t = setInterval("check();",2000);
    // alert(t);

    //获取二维码的唯一标识
    var status = "{{$status}}";
    // alert(status);
    //封装一个查询跳转登录的方法
    function check()
    {
        $.ajax({
            url:"{{url('/do_wechatlogin')}}",
            dataType:"JSON",
            //将二维码的唯一标识传递到后台
            data:{status:status},
            success:function(res)
            {
                if(res.ret==1){
                    //关闭定时器
                    clearInterval(t);
                    //扫码登录成功
                    alert(res.msg);
                    location.href = "{{url('/index')}}";
                }
            }
        })
    }
</script>
