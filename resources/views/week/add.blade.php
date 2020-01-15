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
<form action="">

    <tr>
        账号：<input type="text" name="week_name">
    </tr><br/>
    <tr>
        密码：<input type="password" name="week_pwd">
    </tr><br/>
    <input type="button" value="修改" id="btn">
</form>
</body>
</html>
<script src="{{asset('hadmin/js/jquery.min.js')}}"></script>
<script src="{{asset('hadmin/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
    $("#btn").click(function () {
        var week_name=$("input[name='week_name']").val();
        var week_pwd=$("input[name='week_pwd']").val();


        $.ajax({
            url:"http://www.laravel.com/api/update_do",
            type:"GET",
            data:{week_name:week_name,week_pwd:week_pwd},
            dataType:"json",
            success:function (res) {
                    if(res.ret==203)
                    {
                        alert(res.msg);
                    }
            }

        })
    })



</script>
