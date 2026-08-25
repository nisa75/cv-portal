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

    $interviewCount = auth()->user()
        ->applications()
        ->whereHas('interview', function ($query) {
            $query->whereIn('status', [
                'pending',
                'accepted',
            ]);
        })
        ->count();
@endphp

<div>

    <div style="margin-bottom:30px;">

        <h1>
            Aday Paneli 👤
        </h1>

        <p style="color:#6b7280; margin-top:5px;">
            Hoş geldin, <strong>{{ auth()->user()->name }}</strong>!
        </p>

        <p style="color:#6b7280;">
            Profilini, CV'lerini, başvurularını ve mülakatlarını buradan yönetebilirsin.
        </p>

    </div>


    <div class="grid grid-3">

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
                Mülakatlarım
            </div>

            <div class="stat-number">
                {{ $interviewCount }}
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
                <h3>👤 Profilim</h3>

                <p style="color:#6b7280;">
                    Kariyer ve iletişim bilgilerini yönet.
                </p>
            </a>


            <a
                href="/candidate/cvs"
                class="card"
                style="text-decoration:none; color:inherit;"
            >
                <h3>📄 CV'lerim</h3>

                <p style="color:#6b7280;">
                    CV oluştur, düzenle ve PDF indir.
                </p>
            </a>


            <a
                href="/candidate/jobs"
                class="card"
                style="text-decoration:none; color:inherit;"
            >
                <h3>💼 İş İlanları</h3>

                <p style="color:#6b7280;">
                    İş ilanlarını ara ve filtrele.
                </p>
            </a>


            <a
                href="/candidate/applications"
                class="card"
                style="text-decoration:none; color:inherit;"
            >
                <h3>📋 Başvurularım</h3>

                <p style="color:#6b7280;">
                    Başvuru durumlarını takip et.
                </p>
            </a>


            <a
                href="/candidate/interviews"
                class="card"
                style="text-decoration:none; color:inherit;"
            >
                <h3>🗓️ Mülakatlarım</h3>

                <p style="color:#6b7280;">
                    Planlanan mülakatlarını görüntüle ve cevapla.

                    @if ($interviewCount > 0)
                        <strong>
                            ({{ $interviewCount }})
                        </strong>
                    @endif
                </p>
            </a>


            <a
                href="/candidate/favorites"
                class="card"
                style="text-decoration:none; color:inherit;"
            >
                <h3>❤️ Favoriler</h3>

                <p style="color:#6b7280;">
                    Kaydettiğin ilanları görüntüle.
                </p>
            </a>


            <a
                href="/candidate/notifications"
                class="card"
                style="text-decoration:none; color:inherit;"
            >
                <h3>🔔 Bildirimler</h3>

                <p style="color:#6b7280;">
                    Sistem bildirimlerini görüntüle.
                </p>
            </a>

        </div>

    </div>

</div>

@endsection