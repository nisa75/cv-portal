@extends('layouts.app')

@section('title', 'Favorilerim - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>❤️ Favorilerim</h1>

        <p style="color:#6b7280;">
            Kaydettiğin iş ilanlarını buradan görüntüleyebilirsin.
        </p>

    </div>


    @if ($favorites->isEmpty())

        <div class="card">

            <h2>
                Henüz favori ilanınız yok.
            </h2>

            <p style="color:#6b7280;">
                Beğendiğin iş ilanlarını favorilere ekleyerek daha sonra kolayca ulaşabilirsin.
            </p>

            <a
                href="/candidate/jobs"
                class="btn"
            >
                💼 İş İlanlarını Gör
            </a>

        </div>

    @else

        <div class="grid grid-2">

            @foreach ($favorites as $favorite)

                <div class="card">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:flex-start;
                        gap:15px;
                    ">

                        <div>

                            <h2 style="margin-top:0;">
                                {{ $favorite->job->title }}
                            </h2>

                            <p style="
                                margin:5px 0;
                                font-weight:600;
                            ">
                                {{ $favorite->job->company->name }}
                            </p>

                        </div>

                        <span class="badge badge-red">
                            ❤️ Favori
                        </span>

                    </div>


                    <div style="margin-top:20px;">

                        <p style="color:#6b7280;">
                            📍
                            {{ $favorite->job->location ?? 'Lokasyon belirtilmedi' }}
                        </p>

                        <p style="color:#6b7280;">
                            💼
                            {{ $favorite->job->employment_type }}
                        </p>

                        <p style="color:#6b7280;">
                            🎯
                            {{ $favorite->job->experience_level ?? 'Deneyim belirtilmedi' }}
                        </p>

                        @if ($favorite->job->salary_min || $favorite->job->salary_max)

                            <p style="color:#6b7280;">
                                💰

                                @if ($favorite->job->salary_min)
                                    {{ number_format($favorite->job->salary_min, 0, ',', '.') }} TL
                                @endif

                                @if ($favorite->job->salary_min && $favorite->job->salary_max)
                                    -
                                @endif

                                @if ($favorite->job->salary_max)
                                    {{ number_format($favorite->job->salary_max, 0, ',', '.') }} TL
                                @endif
                            </p>

                        @endif

                    </div>


                    <div style="
                        display:flex;
                        gap:10px;
                        flex-wrap:wrap;
                        margin-top:20px;
                    ">

                        <a
                            href="/candidate/jobs/{{ $favorite->job->id }}"
                            class="btn"
                        >
                            👁️ İlanı Gör
                        </a>


                        <form
                            action="/candidate/jobs/{{ $favorite->job->id }}/favorite"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >
                                💔 Favorilerden Çıkar
                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection