@extends('layouts.app')

@section('title', 'İş İlanları - CV Portal')

@section('content')

<div>

    <div style="margin-bottom: 30px;">

        <h1>
            💼 İş İlanları
        </h1>

        <p style="color:#6b7280;">
            Sana uygun iş fırsatlarını ara ve filtrele.
        </p>

    </div>


    <!-- FİLTRELER -->

    <div class="card" style="margin-bottom: 25px;">

        <h2 style="margin-top:0;">
            🔎 İlan Ara ve Filtrele
        </h2>

        <form
            action="/candidate/jobs"
            method="GET"
        >

            <div class="grid grid-2">

                <div>
                    <label for="search">
                        Anahtar Kelime
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Laravel, PHP, Developer..."
                    >
                </div>


                <div>
                    <label for="location">
                        Şehir
                    </label>

                    <select
                        id="location"
                        name="location"
                    >

                        <option value="">
                            Tüm şehirler
                        </option>

                        <option
                            value="İstanbul"
                            {{ request('location') === 'İstanbul' ? 'selected' : '' }}
                        >
                            İstanbul
                        </option>

                        <option
                            value="Ankara"
                            {{ request('location') === 'Ankara' ? 'selected' : '' }}
                        >
                            Ankara
                        </option>

                        <option
                            value="Elazığ"
                            {{ request('location') === 'Elazığ' ? 'selected' : '' }}
                        >
                            Elazığ
                        </option>

                        <option
                            value="İzmir"
                            {{ request('location') === 'İzmir' ? 'selected' : '' }}
                        >
                            İzmir
                        </option>

                    </select>
                </div>


                <div>
                    <label for="employment_type">
                        Çalışma Şekli
                    </label>

                    <select
                        id="employment_type"
                        name="employment_type"
                    >

                        <option value="">
                            Tümü
                        </option>

                        <option
                            value="Tam Zamanlı"
                            {{ request('employment_type') === 'Tam Zamanlı' ? 'selected' : '' }}
                        >
                            Tam Zamanlı
                        </option>

                        <option
                            value="Yarı Zamanlı"
                            {{ request('employment_type') === 'Yarı Zamanlı' ? 'selected' : '' }}
                        >
                            Yarı Zamanlı
                        </option>

                        <option
                            value="Hibrit"
                            {{ request('employment_type') === 'Hibrit' ? 'selected' : '' }}
                        >
                            Hibrit
                        </option>

                        <option
                            value="Uzaktan"
                            {{ request('employment_type') === 'Uzaktan' ? 'selected' : '' }}
                        >
                            Uzaktan
                        </option>

                        <option
                            value="Staj"
                            {{ request('employment_type') === 'Staj' ? 'selected' : '' }}
                        >
                            Staj
                        </option>

                    </select>
                </div>


                <div>
                    <label for="experience_level">
                        Deneyim Seviyesi
                    </label>

                    <select
                        id="experience_level"
                        name="experience_level"
                    >

                        <option value="">
                            Tümü
                        </option>

                        <option
                            value="Stajyer"
                            {{ request('experience_level') === 'Stajyer' ? 'selected' : '' }}
                        >
                            Stajyer
                        </option>

                        <option
                            value="Yeni Mezun"
                            {{ request('experience_level') === 'Yeni Mezun' ? 'selected' : '' }}
                        >
                            Yeni Mezun
                        </option>

                        <option
                            value="0-1 Yıl"
                            {{ request('experience_level') === '0-1 Yıl' ? 'selected' : '' }}
                        >
                            0-1 Yıl
                        </option>

                        <option
                            value="1-3 Yıl"
                            {{ request('experience_level') === '1-3 Yıl' ? 'selected' : '' }}
                        >
                            1-3 Yıl
                        </option>

                        <option
                            value="3-5 Yıl"
                            {{ request('experience_level') === '3-5 Yıl' ? 'selected' : '' }}
                        >
                            3-5 Yıl
                        </option>

                        <option
                            value="5+ Yıl"
                            {{ request('experience_level') === '5+ Yıl' ? 'selected' : '' }}
                        >
                            5+ Yıl
                        </option>

                    </select>
                </div>


                <div>
                    <label for="salary_min">
                        Minimum Maaş
                    </label>

                    <input
                        type="number"
                        id="salary_min"
                        name="salary_min"
                        value="{{ request('salary_min') }}"
                        min="0"
                        placeholder="40000"
                    >
                </div>

            </div>


            <div style="
                display:flex;
                gap:10px;
                margin-top:20px;
                flex-wrap:wrap;
            ">

                <button type="submit">
                    🔎 Filtrele
                </button>

                <a
                    href="/candidate/jobs"
                    class="btn btn-secondary"
                >
                    Temizle
                </a>

            </div>

        </form>

    </div>


    <!-- SONUÇLAR -->

    @if ($jobs->isEmpty())

        <div class="card">

            <h2>
                İlan bulunamadı
            </h2>

            <p style="color:#6b7280;">
                Arama ve filtre kriterlerinize uygun bir iş ilanı bulunamadı.
            </p>

        </div>

    @else

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:15px;
            gap:15px;
            flex-wrap:wrap;
        ">

            <h2 style="margin:0;">
                İş İlanları
            </h2>

            <span style="color:#6b7280;">
                {{ $jobs->total() }} ilan bulundu
            </span>

        </div>


        @foreach ($jobs as $job)

            <div class="card">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:flex-start;
                    gap:20px;
                    flex-wrap:wrap;
                ">

                    <div style="flex:1; min-width:250px;">

                        <h2 style="margin-top:0;">
                            {{ $job->title }}
                        </h2>

                        <p style="margin-bottom:8px;">
                            <strong>
                                {{ $job->company->name }}
                            </strong>
                        </p>

                        <p style="color:#6b7280; margin:5px 0;">
                            📍 {{ $job->location ?? 'Lokasyon belirtilmedi' }}
                        </p>

                        <p style="color:#6b7280; margin:5px 0;">
                            💼 {{ $job->employment_type }}
                        </p>

                        <p style="color:#6b7280; margin:5px 0;">
                            🎯 {{ $job->experience_level ?? 'Deneyim belirtilmedi' }}
                        </p>

                        @if ($job->salary_min || $job->salary_max)

                            <p style="color:#6b7280; margin:5px 0;">
                                💰

                                @if ($job->salary_min)
                                    {{ number_format($job->salary_min, 0, ',', '.') }} TL
                                @endif

                                @if ($job->salary_min && $job->salary_max)
                                    -
                                @endif

                                @if ($job->salary_max)
                                    {{ number_format($job->salary_max, 0, ',', '.') }} TL
                                @endif
                            </p>

                        @endif

                    </div>


                    <div style="
                        display:flex;
                        flex-direction:column;
                        gap:10px;
                        min-width:150px;
                    ">

                        <a
                            href="/candidate/jobs/{{ $job->id }}"
                            class="btn"
                        >
                            İlanı Gör
                        </a>

                    </div>

                </div>

            </div>

        @endforeach


        <!-- PAGINATION -->

        <div style="
            margin-top:30px;
            display:flex;
            justify-content:center;
        ">

            {{ $jobs->links() }}

        </div>

    @endif

</div>

@endsection