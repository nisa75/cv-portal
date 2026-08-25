@extends('layouts.app')

@section('title', 'Eğitimlerim - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>🎓 Eğitimlerim</h1>

        <p style="color:#6b7280;">
            Eğitim bilgilerini ekle, düzenle ve yönet.
        </p>

        <a
            href="/candidate/educations/create"
            class="btn"
        >
            + Eğitim Ekle
        </a>

    </div>


    @if ($educations->isEmpty())

        <div class="card">

            <h2>Henüz eğitim bilgisi eklenmemiş.</h2>

            <p style="color:#6b7280;">
                Eğitim geçmişini ekleyerek CV'ni güçlendirebilirsin.
            </p>

            <a
                href="/candidate/educations/create"
                class="btn"
            >
                🎓 İlk Eğitimi Ekle
            </a>

        </div>

    @else

        <div class="grid grid-2">

            @foreach ($educations as $education)

                <div class="card">

                    <h2 style="margin-top:0;">
                        {{ $education->school }}
                    </h2>

                    @if ($education->degree)
                        <p>
                            <strong>{{ $education->degree }}</strong>
                        </p>
                    @endif

                    @if ($education->field)
                        <p style="color:#6b7280;">
                            {{ $education->field }}
                        </p>
                    @endif

                    <p style="color:#6b7280;">
                        {{ $education->start_date?->format('Y') ?? '' }}
                        -
                        @if ($education->currently_studying)
                            Devam ediyor
                        @else
                            {{ $education->end_date?->format('Y') ?? '' }}
                        @endif
                    </p>

                    @if ($education->description)
                        <p>
                            {{ $education->description }}
                        </p>
                    @endif

                    <div style="
                        display:flex;
                        gap:10px;
                        flex-wrap:wrap;
                        margin-top:20px;
                    ">

                        <a
                            href="/candidate/educations/{{ $education->id }}/edit"
                            class="btn btn-secondary"
                        >
                            ✏️ Düzenle
                        </a>

                        <form
                            action="/candidate/educations/{{ $education->id }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Bu eğitim kaydını silmek istediğinize emin misiniz?')"
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