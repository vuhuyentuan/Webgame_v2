<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <div style="padding:20px">
        <b style="font-style:italic">{{__('Hi!')}} {{$email}}</b>
        <div style="text-align:center;font-size:18px;font-weight:bold;margin-bottom:15px">{{__('PASSWORD RECOVERY')}}</div>
        <p>
            {{__('To create a new password for this account, please click')}} <a href="{{$url}}">{{__('come in')}}</a> {{__('or copy the link below into your browser:')}}
        </p>
        <p>
            <a style="color:#ff8401" href="{{$url}}" target="_blank">{{$url}}</a>
        </p>
    </div>
</body>

</html>
