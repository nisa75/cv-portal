<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Paneli - CV Portal</title>

    <style>
        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #111827;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .number {
            font-size: 32px;
            font-weight: bold;
            margin-top: 10px;
        }

        .links {
            margin-top: 35px;
            background: white;
            padding: 25px;
            border-radius: 14px;
        }

        .links a {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 15px;
            text-decoration: none;
            color: #2563eb;
        }

        .logout {
            margin-top: 30px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Admin Paneli</h1>

    <p>
        Hoş geldin, {{ auth()->user()->name }} 👑
    </p>

    <div class="cards">

        <div class="card">
            <div>Toplam Kullanıcı</div>
            <div class="number">
                {{ $userCount }}
            </div>
        </div>

        <div class="card">
            <div>Adaylar</div>
            <div class="number">
                {{ $candidateCount }}
            </div>
        </div>

        <div class="card">
            <div>İşverenler</div>
            <div class="number">
                {{ $employerCount }}
            </div>
        </div>

        <div class="card">
            <div>Firmalar</div>
            <div class="number">
                {{ $companyCount }}
            </div>
        </div>

        <div class="card">
            <div>Yayındaki İlanlar</div>
            <div class="number">
                {{ $publishedJobCount }}
            </div>
        </div>

        <div class="card">
            <div>Toplam Başvuru</div>
            <div class="number">
                {{ $applicationCount }}
            </div>
        </div>

    </div>

    <div class="links">

        <h2>Yönetim</h2>

        <a href="/admin/users">
            👤 Kullanıcılar
        </a>

        <a href="/admin/companies">
            🏢 Firmalar
        </a>

        <a href="/admin/jobs">
            💼 İş İlanları
        </a>

        <a href="/admin/applications">
            📋 Başvurular
        </a>

    </div>

    <div class="logout">

        <form action="/logout" method="POST">
            @csrf

            <button type="submit">
                Çıkış Yap
            </button>
        </form>

    </div>

</div>

</body>
</html>