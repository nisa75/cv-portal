@extends('layouts.app')

@section('title', 'İş Deneyimlerim - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>💼 İş Deneyimlerim</h1>

        <p style="color:#6b7280;">
            Çalışma geçmişini ekle, düzenle ve yönet.
        </p>

        <a
            href="/candidate/experiences/create"
            class="btn"
        >
            + Deneyim Ekle
        </a>

    </div>


    @if ($experiences->isEmpty())

        <div class="card">

            <h2>Henüz iş deneyimi eklenmemiş.</h2>

            <p style="color:#6b7280;">
                Çalışma geçmişini ekleyerek CV'ni güçlendirebilirsin.
            </p>

            <a
                href="/candidate/experiences/create"
                class="btn"
            >
                💼 İlk Deneyimi Ekle
            </a>

        </div>

    @else

        <div class="grid grid-2">

            @foreach ($experiences as $experience)

                <div class="card">

                    <h2 style="margin-top:0;">
                        {{ $experience->position }}
                    </h2>

                    <p>
                        <strong>
                            {{ $experience->company }}
                        </strong>
                    </p>

                    <p style="color:#6b7280;">
                        {{ $experience->start_date?->format('m.Y') ?? '' }}
                        -
                        @if ($experience->currently_working)
                            Devam ediyor
                        @else
                            {{ $experience->end_date?->format('m.Y') ?? '' }}
                        @endif
                    </p>

                    @if ($experience->description)

                        <p>
                            {{ $experience->description }}
                        </p>

                    @endif

                    <div style="
                        display:flex;
                        gap:10px;
                        flex-wrap:wrap;
                        margin-top:20px;
                    ">

                        <a
                            href="/candidate/experiences/{{ $experience->id }}/edit"
                            class="btn btn-secondary"
                        >
                            ✏️ Düzenle
                        </a>

                        <form
                            action="/candidate/experiences/{{ $experience->id }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Bu deneyim kaydını silmek istediğinize emin misiniz?')"
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