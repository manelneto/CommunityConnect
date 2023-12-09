<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>Community Connect</title>
    </head>
    <body>
        <article>
            <header>
                <h1>Community Connect</h1>
                <h2>Password Recovery</h2>
            </header>
                <p>Hello, {{ $data['username'] }}.</p>
                <p>If you forgot your password for Community Connect, you can recover it via this link: <a href="{{ $data['link'] }}">{{ $data['link'] }}</a>.</p>
                <p>If you didn't ask for a password recovery, you can safely ignore this email.</p>
            <footer>
                <p>See you soon,</p>
                <p>Community Connect</p>
            </footer>
        </article>
    </body>
</html>
