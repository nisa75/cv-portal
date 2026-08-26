@extends('layouts.app')

@section('title', 'CV\'lerim - CV Portal')

@section('content')

@php
    $user = auth()->user();

    $cvCount = $cvs->count();

    $isPremium = $user->isPremium();

    $freeLimit = 3;

    $remainingCv = max($freeLimit - $cvCount, 0);
@endphp

<div>

    <div style="margin-bottom:30px;">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
            flex-wrap:wrap;
        ">

            <div>

                <h1>📄 CV'lerim</h1>

                <p style="color:#6b7280;">
                    CV'lerini oluştur, düzenle, indir ve paylaş.
                </p>

            </div>


            @if ($isPremium)

                <span class="badge badge-green">
                    ⭐ Premium Üye
                </span>

            @else

                <span class="badge badge-blue">
                    🆓 Ücretsiz Plan
                </span>

            @endif

        </div>

    </div>


    <!-- PLAN DURUMU -->

    <div class="card" style="margin-bottom:25px;">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
            flex-wrap:wrap;
        ">

            <div>

                @if ($isPremium)

                    <h2 style="margin-top:0;">
                        ⭐ Premium Plan
                    </h2>

                    <p style="color:#6b7280;">
                        Sınırsız CV oluşturabilirsin.
                    </p>

                @else

                    <h2 style="margin-top:0;">
                        🆓 Ücretsiz Plan
                    </h2>

                    <p style="color:#6b7280;">

                        {{ $cvCount }} / {{ $freeLimit }} CV kullandın.

                        @if ($remainingCv > 0)
                            {{ $remainingCv }} CV oluşturma hakkın kaldı.
                        @else
                            Ücretsiz CV limitine ulaştın.
                        @endif

                    </p>

                @endif

            </div>


            @if (!$isPremium)

                <div style="
                    padding:12px 16px;
                    border-radius:10px;
                    background:#f9fafb;
                    color:#6b7280;
                ">
                    ✨ Daha fazla CV için Premium
                </div>

            @endif

        </div>

    </div>


    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if (session('error'))

        <div class="alert alert-error">
            {{ session('error') }}
        </div>

    @endif


    <!-- YENİ CV -->

    @if ($isPremium || $cvCount < $freeLimit)

        <div style="margin-bottom:25px;">

            <a
                href="/candidate/cvs/create"
                class="btn"
            >
                + Yeni CV Oluştur
            </a>

        </div>

    @else

        <div
            class="card"
            style="
                margin-bottom:25px;
                border:1px solid #f59e0b;
            "
        >

            <h2 style="margin-top:0;">
                🔒 Ücretsiz CV limitine ulaştın
            </h2>

            <p style="color:#6b7280;">
                Ücretsiz planda en fazla {{ $freeLimit }} CV oluşturabilirsin.
                Daha fazla CV oluşturmak için Premium üyeliğe geçebilirsin.
            </p>

        </div>

    @endif


    @if ($cvs->isEmpty())

        <div class="card">

            <h2>
                Henüz CV oluşturmadın.
            </h2>

            <p style="color:#6b7280;">
                İlk CV'ni oluşturarak başlayabilirsin.
            </p>

            @if ($isPremium || $cvCount < $freeLimit)

                <a
                    href="/candidate/cvs/create"
                    class="btn"
                >
                    📄 İlk CV'yi Oluştur
                </a>

            @endif

        </div>

    @else

        <div class="grid grid-2">

            @foreach ($cvs as $cv)

                <div class="card">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:flex-start;
                        gap:15px;
                    ">

                        <div>

                            <h2 style="margin-top:0;">
                                {{ $cv->title }}
                            </h2>

                            <p style="color:#6b7280;">
                                Şablon:
                                {{ ucfirst($cv->template) }}
                            </p>

                        </div>

                        @if ($cv->is_public)

                            <span class="badge badge-green">
                                🌐 Public
                            </span>

                        @else

                            <span class="badge">
                                🔒 Gizli
                            </span>

                        @endif

                    </div>


                    <div style="
                        display:flex;
                        flex-wrap:wrap;
                        gap:10px;
                        margin-top:20px;
                    ">

                        <a
                            href="/candidate/cvs/{{ $cv->id }}"
                            class="btn"
                        >
                            👁️ Önizle
                        </a>

                        <a
                            href="/candidate/cvs/{{ $cv->id }}/edit"
                            class="btn btn-secondary"
                        >
                            ✏️ Düzenle
                        </a>

                        <a
                            href="/candidate/cvs/{{ $cv->id }}/pdf"
                            class="btn btn-secondary"
                        >
                            📄 PDF
                        </a>

                    </div>


                    @if ($cv->is_public && $cv->public_token)

                        <div style="
                            margin-top:20px;
                            padding:15px;
                            background:#f9fafb;
                            border-radius:10px;
                        ">

                            <strong>
                                🔗 Paylaşılabilir link
                            </strong>

                            <p style="
                                margin-bottom:0;
                                word-break:break-all;
                            ">

                                <a
                                    href="{{ url('/cv/' . $cv->public_token) }}"
                                    target="_blank"
                                >
                                    {{ url('/cv/' . $cv->public_token) }}
                                </a>

                            </p>

                        </div>

                    @endif


                    <div style="
                        display:flex;
                        gap:10px;
                        flex-wrap:wrap;
                        margin-top:20px;
                    ">

                        <form
                            action="/candidate/cvs/{{ $cv->id }}/visibility"
                            method="POST"
                            style="margin:0;"
                        >

                            @csrf
                            @method('PUT')

                            @if ($cv->is_public)

                                <button
                                    type="submit"
                                    class="btn btn-secondary"
                                >
                                    🔒 Gizli Yap
                                </button>

                            @else

                                <button
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    🌐 Herkese Aç
                                </button>

                            @endif

                        </form>


                        <form
                            action="/candidate/cvs/{{ $cv->id }}"
                            method="POST"
                            style="margin:0;"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Bu CV\'yi silmek istediğinize emin misiniz?')"
                            >
                                🗑️ Sil
                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection