@extends('layouts.app')

@section('title', 'Bildirimler - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>🔔 Bildirimler</h1>

        <p style="color:#6b7280;">
            Sistem ve başvuru bildirimlerini buradan takip edebilirsin.
        </p>

    </div>


    @if ($role === 'employer')

        <a href="/employer/dashboard" class="btn btn-secondary">
            ← İşveren Paneline Dön
        </a>

    @else

        <a href="/candidate/dashboard" class="btn btn-secondary">
            ← Aday Paneline Dön
        </a>

    @endif


    <div style="margin-top:25px;">

        @if ($notifications->isEmpty())

            <div class="card">

                <h2>
                    Bildirim yok
                </h2>

                <p style="color:#6b7280;">
                    Şu anda görüntülenecek bir bildirimin bulunmuyor.
                </p>

            </div>

        @else

            <div style="
                display:flex;
                flex-direction:column;
                gap:15px;
            ">

                @foreach ($notifications as $notification)

                    <div
                        class="card"
                        style="
                            border-left:
                            5px solid
                            {{ is_null($notification->read_at) ? '#2563eb' : '#d1d5db' }};
                        "
                    >

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:flex-start;
                            gap:20px;
                            flex-wrap:wrap;
                        ">

                            <div style="flex:1;">

                                @if ($notification->type === 'App\\Notifications\\ApplicationReceived')

                                    <h3 style="margin-top:0;">
                                        📩 Başvuru Gönderildi
                                    </h3>

                                @elseif ($notification->type === 'App\\Notifications\\NewApplicationReceived')

                                    <h3 style="margin-top:0;">
                                        📨 Yeni Başvuru
                                    </h3>

                                @else

                                    <h3 style="margin-top:0;">
                                        🔔 Bildirim
                                    </h3>

                                @endif


                                <p style="margin:8px 0;">
                                    {{ $notification->data['message'] ?? 'Yeni bir bildiriminiz var.' }}
                                </p>


                                @if (!empty($notification->data['candidate_name']))

                                    <p style="color:#6b7280;">
                                        <strong>Aday:</strong>
                                        {{ $notification->data['candidate_name'] }}
                                    </p>

                                @endif


                                @if (!empty($notification->data['job_title']))

                                    <p style="color:#6b7280;">
                                        <strong>İlan:</strong>
                                        {{ $notification->data['job_title'] }}
                                    </p>

                                @endif


                                @if (!empty($notification->data['company_name']))

                                    <p style="color:#6b7280;">
                                        <strong>Firma:</strong>
                                        {{ $notification->data['company_name'] }}
                                    </p>

                                @endif


                                <small style="color:#9ca3af;">
                                    {{ $notification->created_at->format('d.m.Y H:i') }}
                                </small>

                            </div>


                            <div>

                                @if (is_null($notification->read_at))

                                    <span class="badge badge-blue">
                                        Yeni
                                    </span>

                                @else

                                    <span class="badge">
                                        Okundu
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div style="margin-top:20px;">

                            @if (is_null($notification->read_at))

                                @if ($role === 'employer')

                                    <a
                                        href="/employer/notifications/{{ $notification->id }}/read"
                                        class="btn btn-secondary"
                                    >
                                        ✓ Okundu Olarak İşaretle
                                    </a>

                                @else

                                    <a
                                        href="/candidate/notifications/{{ $notification->id }}/read"
                                        class="btn btn-secondary"
                                    >
                                        ✓ Okundu Olarak İşaretle
                                    </a>

                                @endif

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>

@endsection