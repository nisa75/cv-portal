@extends('layouts.app')

@section('title', 'Yeni İş İlanı - CV Portal')

@section('content')

<div style="max-width:850px; margin:0 auto;">

    <div style="margin-bottom:30px;">

        <a href="/employer/jobs">
            ← İlanlarıma Dön
        </a>

        <h1 style="margin-top:20px;">
            💼 Yeni İş İlanı
        </h1>

        <p style="color:#6b7280;">
            Adayların görebileceği yeni bir iş ilanı oluştur.
        </p>

    </div>

    <div class="card">

        @if ($errors->any())

            <div class="alert alert-error">

                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

            </div>

        @endif

        <form
            action="/employer/jobs"
            method="POST"
        >

            @csrf

            <div class="form-group">
                <label for="title">İlan Başlığı</label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Örn. Junior Laravel Developer"
                    required
                >
            </div>

            <div class="form-group">
                <label for="department">Departman</label>

                <input
                    type="text"
                    id="department"
                    name="department"
                    value="{{ old('department') }}"
                    placeholder="Örn. Yazılım"
                >
            </div>

            <div class="grid grid-2">

                <div class="form-group">

                    <label for="employment_type">
                        Çalışma Şekli
                    </label>

                    <select
                        id="employment_type"
                        name="employment_type"
                        required
                    >
                        <option value="">
                            Seçiniz
                        </option>

                        <option
                            value="Tam Zamanlı"
                            {{ old('employment_type') === 'Tam Zamanlı' ? 'selected' : '' }}
                        >
                            Tam Zamanlı
                        </option>

                        <option
                            value="Yarı Zamanlı"
                            {{ old('employment_type') === 'Yarı Zamanlı' ? 'selected' : '' }}
                        >
                            Yarı Zamanlı
                        </option>

                        <option
                            value="Hibrit"
                            {{ old('employment_type') === 'Hibrit' ? 'selected' : '' }}
                        >
                            Hibrit
                        </option>

                        <option
                            value="Uzaktan"
                            {{ old('employment_type') === 'Uzaktan' ? 'selected' : '' }}
                        >
                            Uzaktan
                        </option>

                        <option
                            value="Staj"
                            {{ old('employment_type') === 'Staj' ? 'selected' : '' }}
                        >
                            Staj
                        </option>
                    </select>

                </div>

                <div class="form-group">

                    <label for="location">
                        Lokasyon
                    </label>

                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Örn. İstanbul / Uzaktan"
                    >

                </div>

            </div>


            <div class="grid grid-2">

                <div class="form-group">

                    <label for="salary_min">
                        Minimum Maaş
                    </label>

                    <input
                        type="number"
                        id="salary_min"
                        name="salary_min"
                        value="{{ old('salary_min') }}"
                        min="0"
                        step="0.01"
                        placeholder="40000"
                    >

                </div>

                <div class="form-group">

                    <label for="salary_max">
                        Maksimum Maaş
                    </label>

                    <input
                        type="number"
                        id="salary_max"
                        name="salary_max"
                        value="{{ old('salary_max') }}"
                        min="0"
                        step="0.01"
                        placeholder="60000"
                    >

                </div>

            </div>


            <div class="grid grid-2">

                <div class="form-group">

                    <label for="experience_level">
                        Deneyim Seviyesi
                    </label>

                    <select
                        id="experience_level"
                        name="experience_level"
                    >

                        <option value="">
                            Seçiniz
                        </option>

                        <option
                            value="Stajyer"
                            {{ old('experience_level') === 'Stajyer' ? 'selected' : '' }}
                        >
                            Stajyer
                        </option>

                        <option
                            value="Yeni Mezun"
                            {{ old('experience_level') === 'Yeni Mezun' ? 'selected' : '' }}
                        >
                            Yeni Mezun
                        </option>

                        <option
                            value="0-1 Yıl"
                            {{ old('experience_level') === '0-1 Yıl' ? 'selected' : '' }}
                        >
                            0-1 Yıl
                        </option>

                        <option
                            value="1-3 Yıl"
                            {{ old('experience_level') === '1-3 Yıl' ? 'selected' : '' }}
                        >
                            1-3 Yıl
                        </option>

                        <option
                            value="3-5 Yıl"
                            {{ old('experience_level') === '3-5 Yıl' ? 'selected' : '' }}
                        >
                            3-5 Yıl
                        </option>

                        <option
                            value="5+ Yıl"
                            {{ old('experience_level') === '5+ Yıl' ? 'selected' : '' }}
                        >
                            5+ Yıl
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label for="education_level">
                        Eğitim Seviyesi
                    </label>

                    <input
                        type="text"
                        id="education_level"
                        name="education_level"
                        value="{{ old('education_level') }}"
                        placeholder="Örn. Lisans"
                    >

                </div>

            </div>


            <div class="form-group">

                <label for="description">
                    İlan Açıklaması
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="9"
                    placeholder="Pozisyon, sorumluluklar ve beklentiler..."
                    required
                >{{ old('description') }}</textarea>

            </div>


            <div class="form-group">

                <label for="skills">
                    Aranan Yetenekler
                </label>

                <textarea
                    id="skills"
                    name="skills"
                    rows="5"
                    placeholder="Laravel, PHP, MySQL, Git..."
                >{{ old('skills') }}</textarea>

            </div>


            <div class="form-group">

                <label for="benefits">
                    Yan Haklar
                </label>

                <textarea
                    id="benefits"
                    name="benefits"
                    rows="5"
                    placeholder="Yemek, yol, özel sağlık sigortası..."
                >{{ old('benefits') }}</textarea>

            </div>


            <div class="form-group">

                <label for="deadline">
                    Son Başvuru Tarihi
                </label>

                <input
                    type="date"
                    id="deadline"
                    name="deadline"
                    value="{{ old('deadline') }}"
                >

            </div>


            <button
                type="submit"
                style="width:100%;"
            >
                🚀 İlanı Yayınla
            </button>

        </form>

    </div>

</div>

@endsection