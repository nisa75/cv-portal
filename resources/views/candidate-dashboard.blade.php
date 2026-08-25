@extends('layouts.app')

@section('title', 'Aday Paneli - CV Portal')

@section('content')

@php
    $applicationCount = auth()->user()
        ->applications()
        ->count();

    $favoriteCount = auth()->user()
        ->favorites()
        ->count();

    $unreadNotificationCount = auth()->user()
        ->unreadNotifications()
        ->count();

    $cvCount = auth()->user()
        ->cvs()
        ->count();
@endphp


<div>

    <div style="margin-bottom: 30px;">

        <h1>
            Aday Paneli 👤
        </h1>

        <p style="color:#6b7280; margin-top:5px;">
            Hoş geldin, <strong>{{ auth()->user()->name }}</strong>!
        </p>

        <p style="color:#6b7280;">
            Profilini, CV'lerini, başvurularını ve iş ilanlarını buradan yönetebilirsin.
        </p>

    </div>


    <!-- İSTATİSTİKLER -->

    <div class="grid grid-4">

        <div class="stat-card">

            <div class="stat-label">
                CV'lerim
            </div>

            <div class="stat-number">
                {{ $cvCount }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Başvurularım
            </div>

            <div class="stat-number">
                {{ $applicationCount }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Favoriler
            </div>

            <div class="stat-number">
                {{ $favoriteCount }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Okunmamış Bildirim
            </div>

            <div class="stat-number">
                {{ $unreadNotificationCount }}
            </div>

        </div>

    </div>


    <!-- HIZLI ERİŞİM -->

    <div style="margin-top:35px;">

        <h2>
            Hızlı Erişim
        </h2>

        <div class="grid grid-3" style="margin-top:20px;">


            <a
                href="/candidate/profile"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    👤 Profilim
                </h3>

                <p style="color:#6b7280;">
                    Kariyer bilgilerini ve iletişim bilgilerini yönet.
                </p>

            </a>


            <a
                href="/candidate/cvs"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    📄 CV'lerim
                </h3>

                <p style="color:#6b7280;">
                    CV oluştur, düzenle, PDF indir ve paylaş.
                </p>

            </a>


            <a
                href="/candidate/jobs"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    💼 İş İlanları
                </h3>

                <p style="color:#6b7280;">
                    İş ilanlarını ara ve filtrele.
                </p>

            </a>


            <a
                href="/candidate/applications"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    📋 Başvurularım
                </h3>

                <p style="color:#6b7280;">
                    Gönderdiğin başvuruları ve durumlarını takip et.

                    @if ($applicationCount > 0)
                        <strong>
                            ({{ $applicationCount }})
                        </strong>
                    @endif
                </p>

            </a>


            <a
                href="/candidate/favorites"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    ❤️ Favoriler
                </h3>

                <p style="color:#6b7280;">
                    Kaydettiğin iş ilanlarını görüntüle.

                    @if ($favoriteCount > 0)
                        <strong>
                            ({{ $favoriteCount }})
                        </strong>
                    @endif
                </p>

            </a>


            <a
                href="/candidate/notifications"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    🔔 Bildirimler
                </h3>

                <p style="color:#6b7280;">
                    Sistem bildirimlerini görüntüle.

                    @if ($unreadNotificationCount > 0)
                        <strong>
                            ({{ $unreadNotificationCount }} yeni)
                        </strong>
                    @endif
                </p>

            </a>

        </div>

    </div>

</div>

@endsection