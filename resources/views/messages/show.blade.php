@extends('layouts.app')

@section('title', 'Mesajlaşma - CV Portal')

@section('content')

@php
    $otherUser = auth()->id() === $conversation->candidate_id
        ? $conversation->employer
        : $conversation->candidate;
@endphp

<div class="message-page">

    <div class="message-header">

        <div class="message-user">

            <div class="message-avatar">
                👤
            </div>

            <div>

                <h1 style="margin:0;">
                    {{ $otherUser->name }}
                </h1>

                <p style="
                    margin:3px 0 0;
                    color:#6b7280;
                ">
                    {{ $conversation->application->job->title }}
                </p>

            </div>

        </div>

        <a
            href="/messages"
            class="btn btn-secondary"
        >
            ← Mesajlar
        </a>

    </div>


    <div class="card">

        <div class="message-list">

            @forelse ($conversation->messages as $message)

                <div class="
                    message-row
                    {{ $message->sender_id === auth()->id() ? 'mine' : '' }}
                ">

                    <div class="message-bubble">

                        <div class="message-body">
                            {{ $message->body }}
                        </div>

                        <div class="message-time">

                            {{ $message->created_at->format('d.m.Y H:i') }}

                            @if ($message->sender_id === auth()->id())

                                @if ($message->read_at)
                                    · Okundu
                                @else
                                    · Gönderildi
                                @endif

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div style="
                    text-align:center;
                    color:#6b7280;
                    padding:50px 20px;
                ">
                    Henüz mesaj yok. İlk mesajı sen gönder.
                </div>

            @endforelse

        </div>


        <form
            action="/messages/{{ $conversation->id }}"
            method="POST"
            class="message-form"
        >

            @csrf

            <textarea
                name="body"
                placeholder="Mesajını yaz..."
                required
                maxlength="5000"
            >{{ old('body') }}</textarea>

            <button type="submit">
                Gönder
            </button>

        </form>

        @if ($errors->any())

            <div class="alert alert-error" style="margin-top:15px;">

                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

            </div>

        @endif

    </div>

</div>

@endsection