@extends('layouts.app')

@section('title', 'Kayıt Ol - CV Portal')

@section('content')

<div class="auth-page">

    <div class="auth-card">

        <div class="auth-header">
            <h1>CV Portal</h1>
            <p>Yeni hesabını oluştur</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/register" method="POST">

            @csrf

            <div class="form-group">
                <label for="name">
                    Ad Soyad
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    required
                >
            </div>

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
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="form-group">

                <label>
                    Hesap Türü
                </label>

                <div style="display:flex; flex-direction:column; gap:10px;">

                    <label
                        style="
                            display:flex;
                            align-items:center;
                            gap:8px;
                            font-weight:normal;
                            cursor:pointer;
                        "
                    >
                        <input
                            type="radio"
                            name="role"
                            value="candidate"
                            {{ old('role', 'candidate') === 'candidate' ? 'checked' : '' }}
                            style="width:auto;"
                        >

                        👤 Adayım
                    </label>

                    <label
                        style="
                            display:flex;
                            align-items:center;
                            gap:8px;
                            font-weight:normal;
                            cursor:pointer;
                        "
                    >
                        <input
                            type="radio"
                            name="role"
                            value="employer"
                            {{ old('role') === 'employer' ? 'checked' : '' }}
                            style="width:auto;"
                        >

                        🏢 İşverenim
                    </label>

                </div>

            </div>

            <div class="form-group">

                <label for="password_confirmation">
                    Şifre Tekrar
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    required
                >

            </div>

            <button type="submit">
                Kayıt Ol
            </button>

        </form>

        <p style="text-align:center; margin-top:20px;">
            Zaten hesabın var mı?
            <a href="/login">Giriş Yap</a>
        </p>

    </div>

</div>

@endsection