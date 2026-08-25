@extends('layouts.app')

@section('title', 'İlanlarım - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>
            💼 İlanlarım
        </h1>

        <p style="color:#6b7280;">
            Firmanızın iş ilanlarını buradan yönetebilirsiniz.
        </p>

        <a
            href="/employer/jobs/create"
            class="btn"
        >
            + Yeni İlan Oluştur
        </a>

    </div>


    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if ($errors->any())

        <div class="alert alert-error">

            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

        </div>

    @endif


    @if ($jobs->isEmpty())

        <div class="card">

            <h2>
                Henüz ilanınız yok.
            </h2>

            <p style="color:#6b7280;">
                İlk iş ilanınızı oluşturarak adaylara ulaşmaya başlayın.
            </p>

            <a
                href="/employer/jobs/create"
                class="btn"
            >
                İlk İlanı Oluştur
            </a>

        </div>

    @else

        <div class="grid grid-2">

            @foreach ($jobs as $job)

                <div class="card">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:flex-start;
                        gap:15px;
                    ">

                        <div>

                            <h2 style="margin-top:0;">
                                {{ $job->title }}
                            </h2>

                            @if ($job->department)

                                <p style="
                                    color:#6b7280;
                                    margin-top:5px;
                                ">
                                    {{ $job->department }}
                                </p>

                            @endif

                        </div>


                        @if ($job->status === 'published')

                            <span class="badge badge-green">
                                Yayında
                            </span>

                        @elseif ($job->status === 'closed')

                            <span class="badge badge-red">
                                Kapalı
                            </span>

                        @else

                            <span class="badge badge-yellow">
                                Taslak
                            </span>

                        @endif

                    </div>


                    <div style="margin-top:20px;">

                        <p style="color:#6b7280;">
                            📍 {{ $job->location ?? 'Lokasyon belirtilmedi' }}
                        </p>

                        <p style="color:#6b7280;">
                            💼 {{ $job->employment_type }}
                        </p>

                        <p style="color:#6b7280;">
                            🎯 {{ $job->experience_level ?? 'Deneyim belirtilmedi' }}
                        </p>

                        @if ($job->deadline)

                            <p style="color:#6b7280;">
                                ⏰ Son Başvuru:
                                {{ $job->deadline->format('d.m.Y') }}
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
                            href="/employer/jobs/{{ $job->id }}/edit"
                            class="btn btn-secondary"
                        >
                            ✏️ Düzenle
                        </a>


                        <a
                            href="/employer/applications"
                            class="btn"
                        >
                            📋 Başvurular
                        </a>


                        <form
                            action="/employer/jobs/{{ $job->id }}"
                            method="POST"
                            style="display:inline-block;"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Bu ilanı silmek istediğinize emin misiniz?')"
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