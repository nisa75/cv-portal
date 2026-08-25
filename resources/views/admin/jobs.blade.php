@extends('layouts.app')

@section('title', 'İş İlanları - Admin')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>💼 İş İlanları</h1>

        <p style="color:#6b7280;">
            Sistemdeki tüm iş ilanlarını görüntüle ve yayın durumlarını yönet.
        </p>

    </div>

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if ($jobs->isEmpty())

        <div class="card">

            <h2>Henüz iş ilanı bulunmuyor.</h2>

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

                            <p style="font-weight:600;">
                                {{ $job->company->name ?? 'Bilinmiyor' }}
                            </p>

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

                    <p style="color:#6b7280;">
                        📍 {{ $job->location ?? 'Belirtilmedi' }}
                    </p>

                    <p style="color:#6b7280;">
                        💼 {{ $job->employment_type }}
                    </p>

                    <p style="color:#6b7280;">
                        🎯 {{ $job->experience_level ?? 'Belirtilmedi' }}
                    </p>

                    <p style="color:#6b7280;">
                        📅 {{ $job->created_at->format('d.m.Y H:i') }}
                    </p>

                    <div style="
                        display:flex;
                        gap:10px;
                        flex-wrap:wrap;
                        margin-top:20px;
                    ">

                        <form
                            action="/admin/jobs/{{ $job->id }}/status"
                            method="POST"
                        >

                            @csrf
                            @method('PUT')

                            @if ($job->status === 'published')

                                <button
                                    type="submit"
                                    class="btn btn-secondary"
                                >
                                    ⏸️ Yayından Kaldır
                                </button>

                            @else

                                <button
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    ▶️ Tekrar Yayınla
                                </button>

                            @endif

                        </form>

                        <form
                            action="/admin/jobs/{{ $job->id }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Bu ilanı kalıcı olarak silmek istediğinize emin misiniz?')"
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