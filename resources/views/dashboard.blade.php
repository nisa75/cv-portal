<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - CV Portal</title>
</head>

<body>

    <h1>CV Portal</h1>

    <h2>Hoş geldin, {{ auth()->user()->name }}! 🎉</h2>

    <p>Başarıyla giriş yaptın.</p>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit">Çıkış Yap</button>
    </form>

</body>
</html>