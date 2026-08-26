@extends('layouts.app')

@section('title', 'İşveren Paneli - CV Portal')

@section('content')

@php
    $company = auth()->user()->company;

    $jobCount = $company
        ? $company->jobs()->count()
        : 0;

    $applicationCount = $company
        ? $company->jobs()
            ->withCount('applications')
            ->get()
            ->sum('applications_count')
        : 0;

    $unreadNotificationCount = auth()->user()
        ->unreadNotifications()
        ->count();
@endphp

<div>

    <div style="margin-bottom:30px;">

        <h1>🏢 İşveren Paneli</h1>

        <p style="color:#6b7280;">
            Hoş geldin, <strong>{{ auth()->user()->name }}</strong>!
        </p>

        <p style="color:#6b7280;">
            Firma, ilan, aday ve başvurularını buradan yönetebilirsin.
        </p>

    </div>


    <!-- İSTATİSTİKLER -->

    <div class="grid grid-3">

        <div class="card">

            <div style="font-size:30px;">
                💼
            </div>

            <h3>
                İlanlarım
            </h3>

            <p style="
                font-size:32px;
                font-weight:700;
                margin:5px 0;
            ">
                {{ $jobCount }}
            </p>

        </div>


        <div class="card">

            <div style="font-size:30px;">
                📋
            </div>

            <h3>
                Başvurular
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
                🔔
            </div>

            <h3>
                Okunmamış Bildirim
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

        <div class="grid grid-3" style="margin-top:20px;">

            <a
                href="/employer/company"
                class="card"
                style="
                    text-decoration:none;
                    color:inherit;
                "
            >

                <h3>🏢 Firma Profilim</h3>

                <p style="color:#6b7280;">
                    Firma bilgilerini ve logonu yönet.
                </p>

            </a>


            <a
                href="/employer/jobs"
                class="card"
                style="
                    text-decoration:none;
                    color:inherit;
                "
            >

                <h3>💼 İlanlarım</h3>

                <p style="color:#6b7280;">
                    İş ilanlarını oluştur ve yönet.
                </p>

            </a>


            <a
                href="/employer/applications"
                class="card"
                style="
                    text-decoration:none;
                    color:inherit;
                "
            >

                <h3>📋 Gelen Başvurular</h3>

                <p style="color:#6b7280;">
                    Aday başvurularını incele.
                </p>

            </a>


            <!-- YENİ: ADAYLARI KEŞFET -->

            <a
                href="/employer/candidates"
                class="card"
                style="
                    text-decoration:none;
                    color:inherit;
                    border:1px solid #dbeafe;
                "
            >

                <div style="font-size:32px;">
                    👥
                </div>

                <h3>
                    Adayları Keşfet
                </h3>

                <p style="color:#6b7280;">
                    Sistemdeki adayları incele.
                    Öne çıkarılmış Premium profilleri
                    keşfet.
                </p>

                <span class="btn" style="margin-top:10px;">
                    👥 Adayları Gör
                </span>

            </a>


            <a
                href="/messages"
                class="card"
                style="
                    text-decoration:none;
                    color:inherit;
                "
            >

                <h3>💬 Mesajlar</h3>

                <p style="color:#6b7280;">
                    Adaylarla iletişim kur.
                </p>

            </a>


            <a
                href="/employer/notifications"
                class="card"
                style="
                    text-decoration:none;
                    color:inherit;
                "
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