<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the site {{$user['name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account
<br/>
<<<<<<< HEAD
<a href="{{route('verify', $user->VerificationToken->token)}}">Verify Email</a>
=======
<a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email</a>
>>>>>>> cc9deab8c8b1... User registration
</body>

</html>
