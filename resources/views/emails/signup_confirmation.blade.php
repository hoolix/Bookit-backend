<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Hello, {{ $username }}!</h1>
    <p>Thank you for signing up for BookIt. To complete your registration, please verify your email address using the code below:</p>
    <h2 style="color: #2d89ef;">{{ $verificationCode }}</h2>
    <p>If you did not sign up for BookIt, please ignore this email.</p>
    <p>Best regards,<br>The BookIt Team</p>
</body>
</html>