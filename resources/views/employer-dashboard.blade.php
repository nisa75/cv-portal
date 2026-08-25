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

    <div style="margin-bottom: 30px;">

        <h1>
            İşveren Paneli 🏢
        </h1>

        <p style="color:#6b7280; margin-top:5px;">
            Hoş geldin, <strong>{{ auth()->user()->name }}</strong>!
        </p>

        <p style="color:#6b7280;">
            Firma bilgilerini, iş ilanlarını ve başvuruları buradan yönetebilirsin.
        </p>

    </div>


    <!-- İSTATİSTİKLER -->

    <div class="grid grid-3">

        <div class="stat-card">

            <div class="stat-label">
                İlanlarım
            </div>

            <div class="stat-number">
                {{ $jobCount }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Toplam Başvuru
            </div>

            <div class="stat-number">
                {{ $applicationCount }}
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

        <div class="grid grid-2" style="margin-top:20px;">


            <a
                href="/employer/company"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    🏢 Firma Profilim
                </h3>

                <p style="color:#6b7280;">
                    Firma bilgilerini görüntüle ve güncelle.
                </p>

            </a>


            <a
                href="/employer/jobs"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    💼 İlanlarım
                </h3>

                <p style="color:#6b7280;">
                    İş ilanlarını oluştur, düzenle ve yönet.

                    @if ($jobCount > 0)
                        <strong>
                            ({{ $jobCount }})
                        </strong>
                    @endif
                </p>

            </a>


            <a
                href="/employer/applications"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    📋 Başvurular
                </h3>

                <p style="color:#6b7280;">
                    İş ilanlarına gelen aday başvurularını incele.

                    @if ($applicationCount > 0)
                        <strong>
                            ({{ $applicationCount }})
                        </strong>
                    @endif
                </p>

            </a>


            <a
                href="/employer/notifications"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    🔔 Bildirimler
                </h3>

                <p style="color:#6b7280;">
                    Yeni başvurular ve sistem bildirimlerini görüntüle.

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