@extends('layouts.app')

@section('title', 'Başvuru Detayı - CV Portal')

@section('content')

@php
    $statusLabels = [
        'received' => 'Başvuru Alındı',
        'reviewing' => 'İnceleniyor',
        'pre_evaluation' => 'Ön Değerlendirme',
        'technical_interview' => 'Teknik Görüşme',
        'hr_interview' => 'İK Görüşmesi',
        'offer' => 'Teklif',
        'accepted' => 'Kabul Edildi',
        'rejected' => 'Reddedildi',
    ];

    $statusClasses = [
        'received' => 'badge-blue',
        'reviewing' => 'badge-yellow',
        'pre_evaluation' => 'badge-blue',
        'technical_interview' => 'badge-blue',
        'hr_interview' => 'badge-yellow',
        'offer' => 'badge-green',
        'accepted' => 'badge-green',
        'rejected' => 'badge-red',
    ];

    $statusLabel = $statusLabels[$application->status]
        ?? $application->status;

    $statusClass = $statusClasses[$application->status]
        ?? 'badge-blue';
@endphp

<div>

    <div style="margin-bottom:30px;">

        <a href="/employer/applications">
            ← Başvurulara Dön
        </a>

        <h1 style="margin-top:20px;">
            📋 Başvuru Detayı
        </h1>

    </div>


    <!-- ADAY -->

    <div class="card">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
            flex-wrap:wrap;
        ">

            <div>

                <h2 style="margin-top:0;">
                    {{ $application->user->name }}
                </h2>

                <p style="color:#6b7280;">
                    📧 {{ $application->user->email }}
                </p>

                @if ($application->user->candidateProfile?->city)

                    <p style="color:#6b7280;">
                        📍 {{ $application->user->candidateProfile->city }}
                    </p>

                @endif

            </div>

            <span class="badge {{ $statusClass }}">
                {{ $statusLabel }}
            </span>

        </div>

    </div>


    <!-- İLAN -->

    <div class="card" style="margin-top:20px;">

        <h2>
            💼 Başvurulan İlan
        </h2>

        <p>
            <strong>İlan:</strong>
            {{ $application->job->title }}
        </p>

        <p>
            <strong>Firma:</strong>
            {{ $application->job->company->name }}
        </p>

        <p>
            <strong>Başvuru Tarihi:</strong>
            {{ $application->created_at->format('d.m.Y H:i') }}
        </p>

        <p>
            <strong>CV:</strong>
            {{ $application->cv->title }}
        </p>

    </div>


    <!-- DURUM GÜNCELLE -->

    <div class="card" style="margin-top:20px;">

        <h2>
            🔄 Başvuru Durumu
        </h2>

        <form
            action="/employer/applications/{{ $application->id }}/status"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="grid grid-2">

                <div>

                    <label for="status">
                        Yeni Durum
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="received"
                            {{ $application->status === 'received' ? 'selected' : '' }}
                        >
                            Başvuru Alındı
                        </option>

                        <option
                            value="reviewing"
                            {{ $application->status === 'reviewing' ? 'selected' : '' }}
                        >
                            İnceleniyor
                        </option>

                        <option
                            value="pre_evaluation"
                            {{ $application->status === 'pre_evaluation' ? 'selected' : '' }}
                        >
                            Ön Değerlendirme
                        </option>

                        <option
                            value="technical_interview"
                            {{ $application->status === 'technical_interview' ? 'selected' : '' }}
                        >
                            Teknik Görüşme
                        </option>

                        <option
                            value="hr_interview"
                            {{ $application->status === 'hr_interview' ? 'selected' : '' }}
                        >
                            İK Görüşmesi
                        </option>

                        <option
                            value="offer"
                            {{ $application->status === 'offer' ? 'selected' : '' }}
                        >
                            Teklif
                        </option>

                        <option
                            value="accepted"
                            {{ $application->status === 'accepted' ? 'selected' : '' }}
                        >
                            Kabul Edildi
                        </option>

                        <option
                            value="rejected"
                            {{ $application->status === 'rejected' ? 'selected' : '' }}
                        >
                            Reddedildi
                        </option>

                    </select>

                </div>

                <div style="
                    display:flex;
                    align-items:end;
                ">

                    <button
                        type="submit"
                        style="width:100%;"
                    >
                        💾 Durumu Güncelle
                    </button>

                </div>

            </div>

        </form>

    </div>


    <!-- ADAY PROFİLİ -->

    @if ($application->user->candidateProfile)

        <div class="card" style="margin-top:20px;">

            <h2>
                👤 Aday Profili
            </h2>

            @if ($application->user->candidateProfile->about)

                <h3>Hakkında</h3>

                <p style="white-space:pre-line;">
                    {{ $application->user->candidateProfile->about }}
                </p>

            @endif

        </div>

    @endif


    <!-- EĞİTİM -->

    @if ($application->user->educations->count())

        <div class="card" style="margin-top:20px;">

            <h2>
                🎓 Eğitim
            </h2>

            @foreach ($application->user->educations as $education)

                <div style="
                    padding:15px 0;
                    border-bottom:1px solid #e5e7eb;
                ">

                    <strong>
                        {{ $education->school }}
                    </strong>

                    @if ($education->degree)
                        <p style="margin:5px 0;">
                            {{ $education->degree }}
                        </p>
                    @endif

                    @if ($education->field)
                        <p style="margin:5px 0; color:#6b7280;">
                            {{ $education->field }}
                        </p>
                    @endif

                </div>

            @endforeach

        </div>

    @endif


    <!-- DENEYİM -->

    @if ($application->user->experiences->count())

        <div class="card" style="margin-top:20px;">

            <h2>
                💼 İş Deneyimi
            </h2>

            @foreach ($application->user->experiences as $experience)

                <div style="
                    padding:15px 0;
                    border-bottom:1px solid #e5e7eb;
                ">

                    <strong>
                        {{ $experience->position }}
                    </strong>

                    <p style="margin:5px 0;">
                        {{ $experience->company }}
                    </p>

                    @if ($experience->description)

                        <p style="
                            color:#6b7280;
                            white-space:pre-line;
                        ">
                            {{ $experience->description }}
                        </p>

                    @endif

                </div>

            @endforeach

        </div>

    @endif


    <!-- YETENEKLER -->

    @if ($application->user->skills->count())

        <div class="card" style="margin-top:20px;">

            <h2>
                🛠️ Yetenekler
            </h2>

            <div style="
                display:flex;
                flex-wrap:wrap;
                gap:10px;
            ">

                @foreach ($application->user->skills as $skill)

                    <span class="badge badge-blue">
                        {{ $skill->name }}
                    </span>

                @endforeach

            </div>

        </div>

    @endif


    <!-- ÖN YAZI -->

    @if ($application->cover_letter)

        <div class="card" style="margin-top:20px;">

            <h2>
                ✍️ Ön Yazı
            </h2>

            <p style="white-space:pre-line;">
                {{ $application->cover_letter }}
            </p>

        </div>

    @endif


    <!-- CV -->

    @if ($application->cv)

        <div class="card" style="margin-top:20px;">

            <h2>
                📄 Adayın CV'si
            </h2>

            <p>
                {{ $application->cv->title }}
            </p>

            <a
                href="/candidate/cvs/{{ $application->cv->id }}"
                class="btn"
            >
                👁️ CV'yi Gör
            </a>

        </div>

    @endif

</div>

@endsection