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

<table border="2">
    <tr>
        <td>ID</td>
        <td>姓名</td>
        <td>密码</td>
        <td>次数</td>
        <td>操作</td>

    </tr>
    @foreach($data as $k =>$v )
        <tr id="div">
            <td>{{ $v['w_id'] }}</td>
            <td>{{ $v['week_name'] }}</td>
            <td>{{ $v['week_pwd'] }}</td>
            <td>{{ $v['number'] }}</td>
            <td><a href="javascript:;" id="upa" w_id="{{ $v['w_id'] }}">重置</a></td>
        </tr>
    @endforeach
</table>

</body>
</html>
<script src="{{asset('hadmin/js/jquery.min.js')}}"></script>
<script src="{{asset('hadmin/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
    $("#upa").click(function () {

        var w_id=$(this).attr("w_id");



        $.ajax({
            url:"{{ url("/update_add") }}",
            type:"GET",
            data:{w_id:w_id},
            dataType:"json",
            success:function (res) {
                location.href="http://admin.zhaoshilong.com/admin";
            }

        })
    })



</script>
