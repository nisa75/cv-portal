@extends('layouts.app')

@section('title', 'Mesajlar - CV Portal')

@section('content')

<div class="message-page">

    <div class="message-header">

        <div>
            <h1>💬 Mesajlar</h1>

            <p style="color:#6b7280;">
                Başvurular üzerinden yaptığın görüşmeler.
            </p>
        </div>

        @if (auth()->user()->role === 'candidate')

            <a href="/candidate/dashboard" class="btn btn-secondary">
                ← Aday Paneli
            </a>

        @else

            <a href="/employer/dashboard" class="btn btn-secondary">
                ← İşveren Paneli
            </a>

        @endif

    </div>


    @if ($conversations->isEmpty())

        <div class="card">

            <div style="font-size:45px;">
                💬
            </div>

            <h2>
                Henüz bir konuşman yok.
            </h2>

            <p style="color:#6b7280;">
                Başvurular üzerinden mesajlaşmaya başlayabilirsin.
            </p>

        </div>

    @else

        <div style="
            display:flex;
            flex-direction:column;
            gap:15px;
        ">

            @foreach ($conversations as $conversation)

                @php
                    $lastMessage = $conversation->messages->first();

                    $otherUser = auth()->id() === $conversation->candidate_id
                        ? $conversation->employer
                        : $conversation->candidate;
                @endphp

                <a
                    href="/messages/{{ $conversation->id }}"
                    class="conversation-card"
                >

                    <div class="conversation-preview">

                        <div style="flex:1; min-width:0;">

                            <div class="message-user">

                                <div class="message-avatar">
                                    👤
                                </div>

                                <div>

                                    <div class="conversation-title">
                                        {{ $otherUser->name }}
                                    </div>

                                    <div style="
                                        color:#6b7280;
                                        font-size:14px;
                                    ">
                                        {{ $conversation->application->job->title }}
                                    </div>

                                </div>

                            </div>


                            @if ($lastMessage)

                                <div
                                    class="conversation-last-message"
                                    style="margin-top:15px;"
                                >
                                    {{ $lastMessage->body }}
                                </div>

                            @else

                                <div
                                    class="conversation-last-message"
                                    style="margin-top:15px;"
                                >
                                    Henüz mesaj yok.
                                </div>

                            @endif

                        </div>


                        <div style="
                            text-align:right;
                            flex-shrink:0;
                        ">

                            @if ($lastMessage)

                                <small style="color:#9ca3af;">
                                    {{ $lastMessage->created_at->format('d.m.Y H:i') }}
                                </small>

                            @endif

                        </div>

                    </div>

                </a>

            @endforeach

        </div>

    @endif

</div>

@endsection