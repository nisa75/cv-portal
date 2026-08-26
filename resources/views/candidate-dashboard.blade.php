@extends('layouts.app')

@section('title', 'Aday Paneli - CV Portal')

@section('content')

@php
    $user = auth()->user();

    $applicationCount = $user
        ->applications()
        ->count();

    $favoriteCount = $user
        ->favorites()
        ->count();

    $unreadNotificationCount = $user
        ->unreadNotifications()
        ->count();

    $cvCount = $user
        ->cvs()
        ->count();

    $interviewCount = $user
        ->applications()
        ->whereHas('interview', function ($query) {
            $query->whereIn('status', [
                'pending',
                'accepted',
            ]);
        })
        ->count();

    $isPremium = $user->plan === 'premium';

    $isFeatured =
        $user->is_featured &&
        $user->featured_until &&
        $user->featured_until->isFuture();
@endphp


<div>

    <!-- BAŞLIK -->

    <div style="margin-bottom:30px;">

        <h1>
            Aday Paneli 👤
        </h1>

        <p style="color:#6b7280; margin-top:5px;">
            Hoş geldin, <strong>{{ $user->name }}</strong>!
        </p>

        <p style="color:#6b7280;">
            Profilini, CV'lerini, başvurularını ve mülakatlarını buradan yönetebilirsin.
        </p>

    </div>


    <!-- PREMIUM / ÖNE ÇIKARMA -->

    @if ($isPremium)

        <div
            class="card"
            style="
                margin-bottom:25px;
                border:1px solid #f59e0b;
                background:linear-gradient(135deg, #fffbeb, #ffffff);
            "
        >

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:20px;
                flex-wrap:wrap;
            ">

                <div>

                    <span class="badge badge-green">
                        ⭐ Premium
                    </span>

                    @if ($isFeatured)

                        <h2 style="margin:12px 0 5px;">
                            🚀 Profilin Öne Çıkarıldı
                        </h2>

                        <p style="
                            margin:0;
                            color:#6b7280;
                        ">
                            Profilin şu anda işveren aday listelerinde öne çıkarılıyor.
                        </p>

                        @if ($user->featured_until)

                            <p style="
                                margin-top:8px;
                                color:#92400e;
                            ">
                                <strong>
                                    Bitiş:
                                    {{ $user->featured_until->format('d.m.Y H:i') }}
                                </strong>
                            </p>

                        @endif

                    @else

                        <h2 style="margin:12px 0 5px;">
                            🚀 Profilini Öne Çıkar
                        </h2>

                        <p style="
                            margin:0;
                            color:#6b7280;
                        ">
                            Premium avantajını kullanarak profilini 7 gün boyunca
                            işverenlerin aday listelerinde üst sıralarda göster.
                        </p>

                    @endif

                </div>


                <div>

                    @if ($isFeatured)

                        <form
                            action="/candidate/profile/feature"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-secondary"
                            >
                                ⏹️ Öne Çıkarmayı Kaldır
                            </button>

                        </form>

                    @else

                        <form
                            action="/candidate/profile/feature"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn"
                            >
                                🚀 Profilimi Öne Çıkar
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    @endif


    <!-- İSTATİSTİKLER -->

    <div class="grid grid-3">

        <div class="card">

            <div style="font-size:30px;">
                📄
            </div>

            <h3>
                CV'lerim
            </h3>

            <p style="
                font-size:32px;
                font-weight:700;
                margin:5px 0;
            ">
                {{ $cvCount }}
            </p>

        </div>


        <div class="card">

            <div style="font-size:30px;">
                📋
            </div>

            <h3>
                Başvurularım
            </h3>

            <p style="
                font-size:32px;
                font-weight:700;
                margin:5px 0;
            ">
                {{ $applicationCount }}
            </p>

        </div>


        <div class="card">

            <div style="font-size:30px;">
                🗓️
            </div>

            <h3>
                Mülakatlarım
            </h3>

            <p style="
                font-size:32px;
                font-weight:700;
                margin:5px 0;
            ">
                {{ $interviewCount }}
            </p>

        </div>


        <div class="card">

            <div style="font-size:30px;">
                ❤️
            </div>

            <h3>
                Favoriler
            </h3>

            <p style="
                font-size:32px;
                font-weight:700;
                margin:5px 0;
            ">
                {{ $favoriteCount }}
            </p>

        </div>


        <div class="card">

            <div style="font-size:30px;">
                🔔
            </div>

            <h3>
                Bildirimler
            </h3>

            <p style="
                font-size:32px;
                font-weight:700;
                margin:5px 0;
            ">
                {{ $unreadNotificationCount }}
            </p>

        </div>

    </div>


    <!-- HIZLI ERİŞİM -->

    <div style="margin-top:35px;">

        <h2>
            Hızlı Erişim
        </h2>

        <div
            class="grid grid-3"
            style="margin-top:20px;"
        >

            <a
                href="/candidate/profile"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    👤 Profilim
                </h3>

                <p style="color:#6b7280;">
                    Kişisel ve kariyer bilgilerini yönet.
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
                    CV oluştur, düzenle ve PDF indir.
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
                    Başvurularını takip et.
                </p>

            </a>


            <a
                href="/candidate/interviews"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    🗓️ Mülakatlarım
                </h3>

                <p style="color:#6b7280;">
                    Planlanan mülakatlarını görüntüle.
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
                    Kaydettiğin ilanları görüntüle.
                </p>

            </a>


            <a
                href="/messages"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    💬 Mesajlar
                </h3>

                <p style="color:#6b7280;">
                    İşverenlerle mesajlaş.
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
                    Bildirimlerini görüntüle.
                </p>

            </a>

        </div>

    </div>

</div>

@endsection