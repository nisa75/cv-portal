@extends('layouts.app')

@section('title', 'Giriş Yap - CV Portal')

@section('content')

<div class="auth-page">

    <div class="auth-card">

        <div class="auth-header">
            <h1>CV Portal</h1>
            <p>Hesabına giriş yap</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/login" method="POST">

            @csrf

            <div class="form-group">
                <label for="email">
                    E-posta
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">
                    Şifre
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit">
                Giriş Yap
            </button>

        </form>

        <p style="text-align:center; margin-top:20px;">
            Hesabın yok mu?
            <a href="/register">Kayıt Ol</a>
        </p>

    </div>

</div>

@endsection