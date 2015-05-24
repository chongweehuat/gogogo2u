<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verify Your Email Address</h2>

        <div>
            Thanks for creating an account with gogogo2u.com.
            Please follow the link below to verify your email address
            <br/>

			<a href="{{ URL::to('auth/confirm/' . $user->confirmation_code) }}">verify your email address</a>

        </div>

    </body>
</html>