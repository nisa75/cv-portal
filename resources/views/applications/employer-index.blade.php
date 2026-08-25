@extends('layouts.app')

@section('title', 'Gelen Başvurular - CV Portal')

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
@endphp

<div>

    <div style="margin-bottom:30px;">

        <a href="/employer/dashboard">
            ← İşveren Paneline Dön
        </a>

        <h1 style="margin-top:20px;">
            📋 Gelen Başvurular
        </h1>

        <p style="color:#6b7280;">
            İlanlarınıza gelen aday başvurularını buradan inceleyebilirsiniz.
        </p>

    </div>

    @if ($applications->isEmpty())

        <div class="card">

            <h2>Henüz başvuru bulunmuyor.</h2>

            <p style="color:#6b7280;">
                İlanlarınıza başvuru geldiğinde burada görünecek.
            </p>

            <a href="/employer/jobs/create" class="btn">
                + Yeni İlan Oluştur
            </a>

        </div>

    @else

        <div style="
            display:flex;
            flex-direction:column;
            gap:18px;
        ">

            @foreach ($applications as $application)

                @php
                    $statusLabel = $statusLabels[$application->status]
                        ?? $application->status;

                    $statusClass = $statusClasses[$application->status]
                        ?? 'badge-blue';
                @endphp

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

                            <p style="
                                margin:5px 0;
                                font-weight:600;
                            ">
                                {{ $application->job->title }}
                            </p>

                            <p style="
                                margin:5px 0;
                                color:#6b7280;
                            ">
                                📍 {{ $application->job->location ?? 'Lokasyon belirtilmedi' }}
                            </p>

                        </div>

                        <span class="badge {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>

                    </div>

                    <div class="grid grid-2" style="margin-top:20px;">

                        <div>

                            <p style="color:#6b7280;">
                                <strong>CV:</strong>
                                {{ $application->cv->title }}
                            </p>

                            <p style="color:#6b7280;">
                                <strong>Başvuru Tarihi:</strong>
                                {{ $application->created_at->format('d.m.Y H:i') }}
                            </p>

                        </div>

                        <div>

                            <p style="color:#6b7280;">
                                <strong>Email:</strong>
                                {{ $application->user->email }}
                            </p>

                        </div>

                    </div>

                    <div style="
                        display:flex;
                        gap:10px;
                        flex-wrap:wrap;
                        margin-top:20px;
                    ">

                        <a
                            href="/employer/applications/{{ $application->id }}"
                            class="btn"
                        >
                            🔍 Başvuruyu İncele
                        </a>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection