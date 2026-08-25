@extends('layouts.app')

@section('title', $cv->title . ' - CV Portal')

@section('content')

<style>
    .cv-page {
        padding-bottom: 40px;
    }

    .cv-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .cv-paper {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
        background: white;
        padding: 35px;
        box-sizing: border-box;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.10);
        color: #111827;
    }

    .cv-header {
        margin-bottom: 30px;
    }

    .cv-name {
        font-size: 32px;
        font-weight: 700;
    }

    .cv-contact {
        margin-top: 10px;
        color: #6b7280;
    }

    .cv-section {
        margin-top: 25px;
    }

    .cv-section h2 {
        font-size: 18px;
        margin-bottom: 15px;
        padding-bottom: 6px;
    }

    .cv-item {
        margin: 15px 0;
    }

    .cv-item-title {
        font-weight: 700;
        font-size: 16px;
    }

    .cv-item-subtitle {
        margin-top: 4px;
    }

    .cv-item-date {
        margin-top: 4px;
        color: #6b7280;
    }

    .cv-skills span {
        display: inline-block;
        padding: 6px 10px;
        margin: 4px;
        border-radius: 5px;
    }

    .cv-links a {
        text-decoration: none;
    }


    /* MODERN */

    .template-modern .cv-header {
        border-bottom: 3px solid #111827;
        padding-bottom: 20px;
    }

    .template-modern .cv-section h2 {
        border-bottom: 1px solid #d1d5db;
    }

    .template-modern .cv-skills span {
        background: #f3f4f6;
    }


    /* CLASSIC */

    .template-classic {
        font-family: Georgia, serif;
    }

    .template-classic .cv-name {
        text-align: center;
        font-size: 30px;
    }

    .template-classic .cv-contact {
        text-align: center;
        font-size: 14px;
    }

    .template-classic .cv-header {
        border-bottom: 1px solid #111827;
        padding-bottom: 15px;
    }

    .template-classic .cv-section h2 {
        text-transform: uppercase;
        border-bottom: 1px solid #111827;
        letter-spacing: 1px;
    }

    .template-classic .cv-skills span {
        background: transparent;
        border: 1px solid #9ca3af;
    }


    /* MINIMAL */

    .template-minimal {
        font-family: Arial, sans-serif;
        padding: 50px;
    }

    .template-minimal .cv-name {
        font-size: 28px;
        font-weight: 400;
    }

    .template-minimal .cv-header {
        margin-bottom: 40px;
    }

    .template-minimal .cv-section {
        margin-top: 35px;
    }

    .template-minimal .cv-section h2 {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #6b7280;
    }

    .template-minimal .cv-skills span {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
    }


    /* MOBİL */

    @media (max-width: 900px) {

        .cv-paper {
            width: 100%;
            min-height: auto;
            padding: 25px;
        }

    }


    /* YAZDIR */

    @media print {

        .navbar,
        .footer,
        .cv-actions,
        .alert {
            display: none !important;
        }

        body {
            background: white;
            padding: 0;
        }

        .page-container {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .cv-paper {
            width: 100%;
            min-height: auto;
            margin: 0;
            padding: 20px;
            box-shadow: none;
        }
    }
</style>


@php
    $templateClass = match ($cv->template) {
        'classic' => 'template-classic',
        'minimal' => 'template-minimal',
        default => 'template-modern',
    };
@endphp


<div class="cv-page">

    <div class="cv-actions">

        <a
            href="/candidate/cvs"
            class="btn btn-secondary"
        >
            ← CV'lerime Dön
        </a>

        <a
            href="/candidate/cvs/{{ $cv->id }}/pdf"
            class="btn"
        >
            📄 PDF İndir
        </a>

        <button
            type="button"
            onclick="window.print()"
            class="btn btn-secondary"
        >
            🖨️ Yazdır
        </button>

    </div>


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="cv-paper {{ $templateClass }}">

        <!-- HEADER -->

        <div class="cv-header">

            <div class="cv-name">
                {{ $user->name }}
            </div>

            <div class="cv-contact">

                {{ $user->email }}

                @if ($profile?->phone)
                    | {{ $profile->phone }}
                @endif

                @if ($profile?->city)
                    | {{ $profile->city }}
                @endif

            </div>

        </div>


        <!-- HAKKIMDA -->

        @if ($profile?->about)

            <div class="cv-section">

                <h2>Hakkımda</h2>

                <p>
                    {{ $profile->about }}
                </p>

            </div>

        @endif


        <!-- EĞİTİM -->

        @if ($educations->count())

            <div class="cv-section">

                <h2>Eğitim</h2>

                @foreach ($educations as $education)

                    <div class="cv-item">

                        <div class="cv-item-title">
                            {{ $education->school }}
                        </div>

                        @if ($education->field)
                            <div class="cv-item-subtitle">
                                {{ $education->field }}
                            </div>
                        @endif

                        @if ($education->degree)
                            <div class="cv-item-subtitle">
                                {{ $education->degree }}
                            </div>
                        @endif

                        <div class="cv-item-date">

                            {{ $education->start_date?->format('Y') ?? '' }}

                            -

                            @if ($education->currently_studying)
                                Devam ediyor
                            @else
                                {{ $education->end_date?->format('Y') ?? '' }}
                            @endif

                        </div>

                        @if ($education->description)
                            <p>
                                {{ $education->description }}
                            </p>
                        @endif

                    </div>

                @endforeach

            </div>

        @endif


        <!-- İŞ DENEYİMİ -->

        @if ($experiences->count())

            <div class="cv-section">

                <h2>İş Deneyimi</h2>

                @foreach ($experiences as $experience)

                    <div class="cv-item">

                        <div class="cv-item-title">
                            {{ $experience->position }}
                        </div>

                        <div class="cv-item-subtitle">
                            {{ $experience->company }}
                        </div>

                        <div class="cv-item-date">

                            {{ $experience->start_date?->format('Y') ?? '' }}

                            -

                            @if ($experience->currently_working)
                                Devam ediyor
                            @else
                                {{ $experience->end_date?->format('Y') ?? '' }}
                            @endif

                        </div>

                        @if ($experience->description)
                            <p>
                                {{ $experience->description }}
                            </p>
                        @endif

                    </div>

                @endforeach

            </div>

        @endif


        <!-- YETENEKLER -->

        @if ($skills->count())

            <div class="cv-section">

                <h2>Yetenekler</h2>

                <div class="cv-skills">

                    @foreach ($skills as $skill)

                        <span>
                            {{ $skill->name }}
                        </span>

                    @endforeach

                </div>

            </div>

        @endif


        <!-- BAĞLANTILAR -->

        @if (
            $profile?->github ||
            $profile?->linkedin ||
            $profile?->portfolio
        )

            <div class="cv-section cv-links">

                <h2>Bağlantılar</h2>

                @if ($profile?->github)

                    <p>
                        <strong>GitHub:</strong>

                        <a
                            href="{{ $profile->github }}"
                            target="_blank"
                        >
                            {{ $profile->github }}
                        </a>
                    </p>

                @endif

                @if ($profile?->linkedin)

                    <p>
                        <strong>LinkedIn:</strong>

                        <a
                            href="{{ $profile->linkedin }}"
                            target="_blank"
                        >
                            {{ $profile->linkedin }}
                        </a>
                    </p>

                @endif

                @if ($profile?->portfolio)

                    <p>
                        <strong>Portfolio:</strong>

                        <a
                            href="{{ $profile->portfolio }}"
                            target="_blank"
                        >
                            {{ $profile->portfolio }}
                        </a>
                    </p>

                @endif

            </div>

        @endif

    </div>

</div>

@endsection