@extends('layouts.app')

@section('title', '419 - Sayfa Süresi Doldu')

@section('content')

<div style="text-align:center; padding:80px 20px;">

    <div class="card" style="max-width:600px; margin:0 auto;">

        <div style="font-size:64px;">
            ⏱️
        </div>

        <h1 style="font-size:48px; margin:10px 0;">
            419
        </h1>

        <h2>
            Sayfanın süresi doldu.
        </h2>

        <p style="color:#6b7280;">
            Formun süresi dolmuş olabilir. Sayfayı yenileyip tekrar deneyebilirsin.
        </p>

        <a href="/" class="btn">
            🏠 Ana Sayfaya Dön
        </a>

    </div>

</div>

@endsection