@extends('layouts.app')

@section('title', 'Admin Paneli - CV Portal')

@section('content')

<div>

    <div style="margin-bottom: 30px;">

        <h1>
            Admin Paneli 🛡️
        </h1>

        <p style="color:#6b7280; margin-top:5px;">
            Hoş geldin, <strong>{{ auth()->user()->name }}</strong>!
        </p>

        <p style="color:#6b7280;">
            Kullanıcıları, firmaları, iş ilanlarını ve başvuruları buradan yönetebilirsin.
        </p>

    </div>


    <!-- İSTATİSTİKLER -->

    <div class="grid grid-3">

        <div class="stat-card">

            <div class="stat-label">
                Toplam Kullanıcı
            </div>

            <div class="stat-number">
                {{ $userCount }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Adaylar
            </div>

            <div class="stat-number">
                {{ $candidateCount }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                İşverenler
            </div>

            <div class="stat-number">
                {{ $employerCount }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Firmalar
            </div>

            <div class="stat-number">
                {{ $companyCount }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Yayındaki İlanlar
            </div>

            <div class="stat-number">
                {{ $publishedJobCount }}
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

    </div>


    <!-- YÖNETİM -->

    <div style="margin-top:35px;">

        <h2>
            Yönetim
        </h2>

        <div class="grid grid-2" style="margin-top:20px;">


            <a
                href="/admin/users"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    👤 Kullanıcılar
                </h3>

                <p style="color:#6b7280;">
                    Aday, işveren ve admin hesaplarını görüntüle ve yönet.
                </p>

            </a>


            <a
                href="/admin/companies"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    🏢 Firmalar
                </h3>

                <p style="color:#6b7280;">
                    Sistemde kayıtlı firmaları görüntüle.
                </p>

            </a>


            <a
                href="/admin/jobs"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    💼 İş İlanları
                </h3>

                <p style="color:#6b7280;">
                    Yayındaki ve kapalı ilanları yönet.
                </p>

            </a>


            <a
                href="/admin/applications"
                class="card"
                style="text-decoration:none; color:inherit;"
            >

                <h3>
                    📋 Başvurular
                </h3>

                <p style="color:#6b7280;">
                    Sistemdeki tüm iş başvurularını incele.
                </p>

            </a>

        </div>

    </div>

</div>

@endsection