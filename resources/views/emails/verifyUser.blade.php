<!DOCTYPE html>
<html>
    <head>
        <title>Welcome Email</title>
    </head>
    <body>
        <h2>welcome dear {{$user['name']}}</h2>
        <br>
        your registers email is {{$user['email']}} , Please click on the below link to verify Email acount
        <br>
        <a href="{{url('user/verify',$user->verifyUser->code)}}">Verify Email</a>
    </body>
</html>