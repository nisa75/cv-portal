@extends('layouts.app')

@section('title', 'Adayları Keşfet - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
            flex-wrap:wrap;
        ">

            <div>

                <h1>👥 Adayları Keşfet</h1>

                <p style="color:#6b7280;">
                    Sistemdeki adayları inceleyin.
                    Öne çıkarılan Premium profiller üstte gösterilir.
                </p>

            </div>

            <a
                href="/employer/dashboard"
                class="btn btn-secondary"
            >
                ← İşveren Paneli
            </a>

        </div>

    </div>


    @if ($candidates->isEmpty())

        <div class="card">

            <div style="font-size:45px;">
                👥
            </div>

            <h2>
                Henüz aday bulunmuyor.
            </h2>

            <p style="color:#6b7280;">
                Sisteme kayıtlı adaylar burada görünecek.
            </p>

        </div>

    @else

        <div class="grid grid-2">

            @foreach ($candidates as $candidate)

                @php

                    /*
                     * Featured kontrolünü doğrudan database alanından yapıyoruz.
                     * Böylece işveren tarafında is_featured = true ise
                     * aday kesin olarak öne çıkan olarak gösterilir.
                     */
                    $isFeatured = (bool) $candidate->is_featured;

                    $skills = $candidate->skills
                        ->pluck('name')
                        ->take(6);

                @endphp


                <div
                    class="card"
                    style="
                        position:relative;
                        {{ $isFeatured
                            ? 'border:2px solid #f59e0b;'
                            : '' }}
                    "
                >


                    <!-- ÖNE ÇIKAN ROZETİ -->

                    @if ($isFeatured)

                        <div style="
                            position:absolute;
                            top:15px;
                            right:15px;
                        ">

                            <span class="badge badge-yellow">
                                🚀 Öne Çıkan Aday
                            </span>

                        </div>

                    @endif


                    <!-- ADAY BAŞLIK -->

                    <div style="
                        display:flex;
                        gap:15px;
                        align-items:flex-start;
                        padding-right:{{ $isFeatured ? '140px' : '0' }};
                    ">


                        <!-- FOTOĞRAF -->

                        <div
                            style="
                                width:65px;
                                height:65px;
                                border-radius:50%;
                                background:#eef2ff;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:28px;
                                flex-shrink:0;
                                overflow:hidden;
                            "
                        >

                            @if ($candidate->candidateProfile?->profile_photo)

                                <img
                                    src="{{ asset('storage/' . $candidate->candidateProfile->profile_photo) }}"
                                    alt="{{ $candidate->name }}"
                                    style="
                                        width:100%;
                                        height:100%;
                                        object-fit:cover;
                                    "
                                >

                            @else

                                👤

                            @endif

                        </div>


                        <!-- ADAY BİLGİSİ -->

                        <div>

                            <h2 style="margin:0;">
                                {{ $candidate->name }}
                            </h2>

                            @if ($candidate->candidateProfile?->city)

                                <p style="
                                    margin:5px 0;
                                    color:#6b7280;
                                ">
                                    📍 {{ $candidate->candidateProfile->city }}
                                </p>

                            @endif

                        </div>

                    </div>


                    <!-- PREMIUM ROZETİ -->

                    @if ($candidate->plan === 'premium')

                        <div style="
                            margin-top:15px;
                        ">

                            <span class="badge badge-green">
                                ⭐ Premium
                            </span>

                        </div>

                    @endif


                    <!-- HAKKINDA -->

                    @if ($candidate->candidateProfile?->about)

                        <div style="margin-top:20px;">

                            <h3>
                                Hakkında
                            </h3>

                            <p style="
                                color:#6b7280;
                                white-space:pre-line;
                            ">
                                {{ \Illuminate\Support\Str::limit(
                                    $candidate->candidateProfile->about,
                                    220
                                ) }}
                            </p>

                        </div>

                    @endif


                    <!-- YETENEKLER -->

                    @if ($skills->count())

                        <div style="margin-top:20px;">

                            <h3>
                                🛠️ Yetenekler
                            </h3>

                            <div style="
                                display:flex;
                                flex-wrap:wrap;
                                gap:8px;
                            ">

                                @foreach ($skills as $skill)

                                    <span class="badge badge-blue">
                                        {{ $skill }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                    @endif


                    <!-- EĞİTİM -->

                    @if ($candidate->educations->count())

                        @php
                            $education = $candidate->educations->first();
                        @endphp

                        <div style="margin-top:20px;">

                            <p style="color:#6b7280;">

                                🎓

                                <strong>
                                    {{ $education->school }}
                                </strong>

                                @if ($education->field)
                                    · {{ $education->field }}
                                @endif

                            </p>

                        </div>

                    @endif


                    <!-- DENEYİM -->

                    @if ($candidate->experiences->count())

                        @php
                            $experience = $candidate->experiences->first();
                        @endphp

                        <div style="margin-top:15px;">

                            <p style="color:#6b7280;">

                                💼

                                <strong>
                                    {{ $experience->position }}
                                </strong>

                                @if ($experience->company)
                                    · {{ $experience->company }}
                                @endif

                            </p>

                        </div>

                    @endif


                    <!-- BUTONLAR -->

                    <div style="
                        display:flex;
                        gap:10px;
                        flex-wrap:wrap;
                        margin-top:25px;
                    ">


                        @if ($candidate->cvs->count())

                            <a
                                href="/candidate/cvs/{{ $candidate->cvs->first()->id }}"
                                class="btn"
                            >
                                📄 CV'yi Gör
                            </a>

                        @endif


                        @if ($candidate->candidateProfile?->linkedin)

                            <a
                                href="{{ $candidate->candidateProfile->linkedin }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn btn-secondary"
                            >
                                LinkedIn
                            </a>

                        @endif


                        @if ($candidate->candidateProfile?->github)

                            <a
                                href="{{ $candidate->candidateProfile->github }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn btn-secondary"
                            >
                                GitHub
                            </a>

                        @endif

                    </div>


                    <!-- ÖNE ÇIKARMA BİTİŞİ -->

                    @if ($isFeatured && $candidate->featured_until)

                        <p style="
                            margin-top:15px;
                            font-size:13px;
                            color:#9ca3af;
                        ">

                            🚀 Öne çıkarma bitişi:
                            {{ $candidate->featured_until->format('d.m.Y H:i') }}

                        </p>

                    @endif


                </div>

            @endforeach

        </div>


        <div style="margin-top:30px;">

            {{ $candidates->links() }}

        </div>

    @endif

</div>

@endsection