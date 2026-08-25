@extends('layouts.app')

@section('title', 'CV Portal')

@section('content')

<div style="
    max-width:1000px;
    margin:0 auto;
">

    <div
        class="card"
        style="
            text-align:center;
            padding:70px 30px;
        "
    >

        <div style="
            font-size:60px;
            margin-bottom:20px;
        ">
            💼
        </div>

        <h1 style="
            font-size:42px;
            margin-bottom:10px;
        ">
            CV Portal
        </h1>

        <p style="
            color:#6b7280;
            font-size:18px;
            max-width:650px;
            margin:0 auto 30px;
        ">
            CV oluştur, iş ilanlarını keşfet, başvurularını takip et
            ve kariyerine bir adım daha yaklaş.
        </p>

        <div style="
            display:flex;
            justify-content:center;
            gap:12px;
            flex-wrap:wrap;
        ">

            @auth

                @if (auth()->user()->role === 'candidate')

                    <a
                        href="/candidate/dashboard"
                        class="btn"
                    >
                        👤 Aday Paneline Git
                    </a>

                @elseif (auth()->user()->role === 'employer')

                    <a
                        href="/employer/dashboard"
                        class="btn"
                    >
                        🏢 İşveren Paneline Git
                    </a>

                @elseif (auth()->user()->role === 'admin')

                    <a
                        href="/admin/dashboard"
                        class="btn"
                    >
                        🛡️ Admin Paneline Git
                    </a>

                @endif

            @else

                <a
                    href="/login"
                    class="btn"
                >
                    Giriş Yap
                </a>

                <a
                    href="/register"
                    class="btn btn-secondary"
                >
                    Kayıt Ol
                </a>

            @endauth

        </div>

    </div>


    <div
        class="grid grid-3"
        style="margin-top:25px;"
    >

        <div class="card">

            <div style="font-size:35px;">
                📄
            </div>

            <h2>
                Profesyonel CV
            </h2>

            <p style="color:#6b7280;">
                Modern, classic veya minimal şablonlarla
                kolayca CV oluştur.
            </p>

        </div>


        <div class="card">

            <div style="font-size:35px;">
                💼
            </div>

            <h2>
                İş İlanları
            </h2>

            <p style="color:#6b7280;">
                Sana uygun iş ilanlarını ara, filtrele
                ve başvur.
            </p>

        </div>


        <div class="card">

            <div style="font-size:35px;">
                🚀
            </div>

            <h2>
                Kariyerini Yönet
            </h2>

            <p style="color:#6b7280;">
                Başvurularını, favorilerini ve bildirimlerini
                tek yerden takip et.
            </p>

        </div>

    </div>

</div>

@endsection