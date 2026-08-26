<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'CV Portal')
    </title>
<meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
</head>

<body>

    <nav class="navbar">

        <div class="navbar-inner">

            <a href="/" class="logo">
                CV Portal
            </a>

            @auth

                <div class="nav-links">

                    @if (auth()->user()->role === 'candidate')

                        <a href="/candidate/dashboard">
                            Panel
                        </a>

                        <a href="/candidate/jobs">
                            İş İlanları
                        </a>

                        <a href="/candidate/cvs">
                            CV'lerim
                        </a>

                        <a href="/candidate/applications">
                            Başvurularım
                        </a>

                    @elseif (auth()->user()->role === 'employer')

                        <a href="/employer/dashboard">
                            Panel
                        </a>

                        <a href="/employer/jobs">
                            İlanlarım
                        </a>

                        <a href="/employer/applications">
                            Başvurular
                        </a>

                    @elseif (auth()->user()->role === 'admin')

                        <a href="/admin/dashboard">
                            Admin Paneli
                        </a>

                        <a href="/admin/users">
                            Kullanıcılar
                        </a>

                        <a href="/admin/jobs">
                            İlanlar
                        </a>

                        <a href="/admin/applications">
                            Başvurular
                        </a>

                    @endif

                    <form
                        action="/logout"
                        method="POST"
                        class="logout-form"
                    >
                        @csrf

                        <button type="submit" class="nav-logout">
                            Çıkış
                        </button>
                    </form>

                </div>

            @else

                <div class="nav-links">

                    <a href="/login">
                        Giriş Yap
                    </a>

                    <a href="/register" class="nav-register">
                        Kayıt Ol
                    </a>

                </div>

            @endauth

        </div>

    </nav>


    <main class="page-container">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        @if ($errors->any())
            <div class="alert alert-error">

                @foreach ($errors->all() as $error)
                    <div>
                        {{ $error }}
                    </div>
                @endforeach

            </div>
        @endif


        @yield('content')

    </main>


    <footer class="footer">
        <p>
            © {{ date('Y') }} CV Portal
        </p>
    </footer>

</body>
</html>