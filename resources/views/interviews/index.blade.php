@extends('layouts.app')

@section('title', 'Mülakatlarım - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">
        <h1>🗓️ Mülakatlarım</h1>

        <p style="color:#6b7280;">
            Planlanan mülakatlarını buradan takip edebilirsin.
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($interviews->isEmpty())

        <div class="card">
            <h2>Henüz planlanmış bir mülakat yok.</h2>
            <p style="color:#6b7280;">
                İşveren bir mülakat planladığında burada göreceksin.
            </p>
        </div>

    @else

        <div style="
            display:flex;
            flex-direction:column;
            gap:18px;
        ">

            @foreach ($interviews as $application)

                @php
                    $interview = $application->interview;

                    $statusLabels = [
                        'pending' => 'Bekliyor',
                        'accepted' => 'Kabul Edildi',
                        'rejected' => 'Reddedildi',
                        'completed' => 'Tamamlandı',
                        'cancelled' => 'İptal Edildi',
                    ];

                    $statusClasses = [
                        'pending' => 'badge-yellow',
                        'accepted' => 'badge-green',
                        'rejected' => 'badge-red',
                        'completed' => 'badge-blue',
                        'cancelled' => 'badge-red',
                    ];
                @endphp

                <div class="interview-card">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        gap:20px;
                        flex-wrap:wrap;
                    ">

                        <div>

                            <h2 style="margin-top:0;">
                                {{ $application->job->title }}
                            </h2>

                            <p style="font-weight:600;">
                                {{ $application->job->company->name }}
                            </p>

                        </div>

                        <span class="badge {{ $statusClasses[$interview->status] ?? 'badge-blue' }}">
                            {{ $statusLabels[$interview->status] ?? $interview->status }}
                        </span>

                    </div>

                    <div class="interview-meta">

                        <div class="interview-meta-item">
                            <span class="interview-label">Tarih</span>

                            <span class="interview-value">
                                {{ $interview->scheduled_at->format('d.m.Y H:i') }}
                            </span>
                        </div>

                        <div class="interview-meta-item">
                            <span class="interview-label">Süre</span>

                            <span class="interview-value">
                                {{ $interview->duration }} dakika
                            </span>
                        </div>

                        <div class="interview-meta-item">
                            <span class="interview-label">Tür</span>

                            <span class="interview-value">
                                {{ match($interview->type) {
                                    'online' => 'Online',
                                    'office' => 'Ofiste',
                                    'phone' => 'Telefon',
                                    default => $interview->type,
                                } }}
                            </span>
                        </div>

                        @if ($interview->location)
                            <div class="interview-meta-item">
                                <span class="interview-label">Konum</span>

                                <span class="interview-value">
                                    {{ $interview->location }}
                                </span>
                            </div>
                        @endif

                    </div>

                    @if ($interview->meeting_link)

                        <div style="margin-top:20px;">
                            <a
                                href="{{ $interview->meeting_link }}"
                                target="_blank"
                                class="btn"
                            >
                                🎥 Toplantıya Katıl
                            </a>
                        </div>

                    @endif

                    @if ($interview->notes)

                        <div style="margin-top:20px;">
                            <strong>Not:</strong>

                            <p style="white-space:pre-line;">
                                {{ $interview->notes }}
                            </p>
                        </div>

                    @endif

                    @if ($interview->status === 'pending')

                        <div style="
                            display:flex;
                            gap:10px;
                            flex-wrap:wrap;
                            margin-top:20px;
                        ">

                            <form
                                action="/candidate/interviews/{{ $interview->id }}/respond"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="accepted"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    ✅ Mülakatı Kabul Et
                                </button>

                            </form>

                            <form
                                action="/candidate/interviews/{{ $interview->id }}/respond"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="rejected"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                >
                                    ❌ Reddet
                                </button>

                            </form>

                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection