@extends('layouts.app')

@section('title', $job->title . ' - CV Portal')

@section('content')

<div>

    <!-- GERİ DÖN -->

    <a href="/candidate/jobs">
        ← İş İlanlarına Dön
    </a>


    <!-- İLAN BAŞLIĞI -->

    <div class="card" style="margin-top:20px;">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
            flex-wrap:wrap;
        ">

            <div>

                <h1 style="margin-top:0;">
                    {{ $job->title }}
                </h1>

                <h2 style="margin-bottom:5px;">
                    {{ $job->company->name }}
                </h2>

                @if ($job->department)
                    <p style="color:#6b7280; margin-top:5px;">
                        {{ $job->department }}
                    </p>
                @endif

            </div>

            <div>

                <span class="badge badge-green">
                    İlan Yayında
                </span>

            </div>

        </div>

    </div>


    <!-- İLAN BİLGİLERİ -->

    <div class="grid grid-2" style="margin-top:20px;">


        <div class="card">

            <h2>İlan Bilgileri</h2>

            <p>
                <strong>💼 Çalışma Şekli:</strong>
                {{ $job->employment_type }}
            </p>

            <p>
                <strong>📍 Lokasyon:</strong>
                {{ $job->location ?? 'Belirtilmedi' }}
            </p>

            <p>
                <strong>🎯 Deneyim:</strong>
                {{ $job->experience_level ?? 'Belirtilmedi' }}
            </p>

            <p>
                <strong>🎓 Eğitim:</strong>
                {{ $job->education_level ?? 'Belirtilmedi' }}
            </p>

            <p>
                <strong>💰 Maaş:</strong>

                @if ($job->salary_min || $job->salary_max)

                    @if ($job->salary_min)
                        {{ number_format($job->salary_min, 0, ',', '.') }} TL
                    @else
                        -
                    @endif

                    -

                    @if ($job->salary_max)
                        {{ number_format($job->salary_max, 0, ',', '.') }} TL
                    @else
                        -
                    @endif

                @else

                    Belirtilmedi

                @endif

            </p>

            @if ($job->deadline)

                <p>
                    <strong>⏰ Son Başvuru:</strong>
                    {{ $job->deadline->format('d.m.Y') }}
                </p>

            @endif

        </div>


        <!-- BAŞVURU / FAVORİ -->

        <div class="card">

            <h2>Başvuru</h2>

            <p style="color:#6b7280;">
                Bu pozisyonla ilgileniyorsan CV'n ile hemen başvurabilirsin.
            </p>

            <a
                href="/candidate/jobs/{{ $job->id }}/apply"
                class="btn"
                style="width:100%;"
            >
                📝 Bu İlana Başvur
            </a>

            <br><br>

            <form
                action="/candidate/jobs/{{ $job->id }}/favorite"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-secondary"
                    style="width:100%;"
                >
                    ❤️ Favorilere Ekle
                </button>

            </form>

            @if (session('success'))

                <div class="alert alert-success" style="margin-top:20px;">
                    {{ session('success') }}
                </div>

            @endif

            @if ($errors->any())

                <div class="alert alert-error" style="margin-top:20px;">

                    @foreach ($errors->all() as $error)
                        <div>
                            {{ $error }}
                        </div>
                    @endforeach

                </div>

            @endif

        </div>

    </div>


    <!-- AÇIKLAMA -->

    <div class="card" style="margin-top:20px;">

        <h2>
            İlan Açıklaması
        </h2>

        <p style="white-space:pre-line;">
            {{ $job->description }}
        </p>

    </div>


    <!-- YETENEKLER -->

    <div class="card" style="margin-top:20px;">

        <h2>
            Aranan Yetenekler
        </h2>

        @if ($job->skills)

            <p style="white-space:pre-line;">
                {{ $job->skills }}
            </p>

        @else

            <p style="color:#6b7280;">
                Belirtilmedi.
            </p>

        @endif

    </div>


    <!-- YAN HAKLAR -->

    <div class="card" style="margin-top:20px;">

        <h2>
            Yan Haklar
        </h2>

        @if ($job->benefits)

            <p style="white-space:pre-line;">
                {{ $job->benefits }}
            </p>

        @else

            <p style="color:#6b7280;">
                Belirtilmedi.
            </p>

        @endif

    </div>

</div>

@endsection