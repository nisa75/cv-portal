@extends('layouts.app')

@section('title', 'CV\'lerim - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>📄 CV'lerim</h1>

        <p style="color:#6b7280;">
            CV'lerini oluştur, düzenle, indir ve paylaş.
        </p>

        <a
            href="/candidate/cvs/create"
            class="btn"
        >
            + Yeni CV Oluştur
        </a>

    </div>

    @if ($cvs->isEmpty())

        <div class="card">

            <h2>Henüz CV oluşturmadın.</h2>

            <p style="color:#6b7280;">
                İlk CV'ni oluşturarak başlayabilirsin.
            </p>

            <a
                href="/candidate/cvs/create"
                class="btn"
            >
                CV Oluştur
            </a>

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


                    <div style="margin-top:20px;">

                        <form
                            action="/candidate/cvs/{{ $cv->id }}/visibility"
                            method="POST"
                            style="display:inline-block;"
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
                            style="display:inline-block; margin-left:8px;"
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