@extends('layouts.app')

@section('title', '403 - Yetkisiz Erişim')

@section('content')

<div style="text-align:center; padding:80px 20px;">

    <div class="card" style="max-width:600px; margin:0 auto;">

        <div style="font-size:64px;">
            🔒
        </div>

        <h1 style="font-size:48px; margin:10px 0;">
            403
        </h1>

        <h2>
            Bu sayfaya erişim iznin yok.
        </h2>

        <p style="color:#6b7280;">
            Bu işlem için gerekli yetkiye sahip değilsin.
        </p>

        @auth
            <a href="{{ url()->previous() }}" class="btn">
                ← Geri Dön
            </a>
        @else
            <a href="/login" class="btn">
                Giriş Yap
            </a>
        @endauth

    </div>

</div>

@endsection