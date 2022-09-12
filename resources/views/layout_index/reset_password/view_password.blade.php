<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div style="padding:20px">
        <b style="font-style:italic">{{$email}} thân mến</b>
        <div style="text-align:center;font-size:18px;font-weight:bold;margin-bottom:15px">KHÔI PHỤC MẬT KHẨU</div>
        <p>
            Để tạo mật khẩu mới cho tài khoản này, bạn vui lòng nhấp <a href="{{$route}}">vào đây</a> hoặc sao chép liên kết dưới đây vào trình duyệt:
        </p>
        <p>
            <a style="color:#ff8401" href="{{$route}}" target="_blank">{{$route}}</a>
        </p>
    </div>
</body>

</html>
