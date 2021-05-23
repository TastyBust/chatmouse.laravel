<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body class="antialiased">
        <script src="https://www.hCaptcha.com/1/api.js" async defer></script>

            <form method="POST" action="/api/login">
            
                <div class="h-captcha" data-sitekey="bd065664-0dde-4dda-b554-888121a15429"></div>
                <input type="text" name="username">
                <input type="password" name="password">
                <button type="submit">Го</button>
            </form>
    </body>
</html>
