@extends('layouts.app')

@section('title', 'İlanı Düzenle - CV Portal')

@section('content')

<div style="max-width:850px; margin:0 auto;">

    <div style="margin-bottom:30px;">

        <a href="/employer/jobs">
            ← İlanlarıma Dön
        </a>

        <h1 style="margin-top:20px;">
            ✏️ İlanı Düzenle
        </h1>

        <p style="color:#6b7280;">
            İş ilanının bilgilerini güncelleyebilirsin.
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
            action="/employer/jobs/{{ $job->id }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="form-group">

                <label for="title">
                    İlan Başlığı
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $job->title) }}"
                    required
                >

            </div>


            <div class="form-group">

                <label for="department">
                    Departman
                </label>

                <input
                    type="text"
                    id="department"
                    name="department"
                    value="{{ old('department', $job->department) }}"
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
                            {{ old('employment_type', $job->employment_type) === 'Tam Zamanlı' ? 'selected' : '' }}
                        >
                            Tam Zamanlı
                        </option>

                        <option
                            value="Yarı Zamanlı"
                            {{ old('employment_type', $job->employment_type) === 'Yarı Zamanlı' ? 'selected' : '' }}
                        >
                            Yarı Zamanlı
                        </option>

                        <option
                            value="Hibrit"
                            {{ old('employment_type', $job->employment_type) === 'Hibrit' ? 'selected' : '' }}
                        >
                            Hibrit
                        </option>

                        <option
                            value="Uzaktan"
                            {{ old('employment_type', $job->employment_type) === 'Uzaktan' ? 'selected' : '' }}
                        >
                            Uzaktan
                        </option>

                        <option
                            value="Staj"
                            {{ old('employment_type', $job->employment_type) === 'Staj' ? 'selected' : '' }}
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
                        value="{{ old('location', $job->location) }}"
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
                        value="{{ old('salary_min', $job->salary_min) }}"
                        min="0"
                        step="0.01"
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
                        value="{{ old('salary_max', $job->salary_max) }}"
                        min="0"
                        step="0.01"
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
                            {{ old('experience_level', $job->experience_level) === 'Stajyer' ? 'selected' : '' }}
                        >
                            Stajyer
                        </option>

                        <option
                            value="Yeni Mezun"
                            {{ old('experience_level', $job->experience_level) === 'Yeni Mezun' ? 'selected' : '' }}
                        >
                            Yeni Mezun
                        </option>

                        <option
                            value="0-1 Yıl"
                            {{ old('experience_level', $job->experience_level) === '0-1 Yıl' ? 'selected' : '' }}
                        >
                            0-1 Yıl
                        </option>

                        <option
                            value="1-3 Yıl"
                            {{ old('experience_level', $job->experience_level) === '1-3 Yıl' ? 'selected' : '' }}
                        >
                            1-3 Yıl
                        </option>

                        <option
                            value="3-5 Yıl"
                            {{ old('experience_level', $job->experience_level) === '3-5 Yıl' ? 'selected' : '' }}
                        >
                            3-5 Yıl
                        </option>

                        <option
                            value="5+ Yıl"
                            {{ old('experience_level', $job->experience_level) === '5+ Yıl' ? 'selected' : '' }}
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
                        value="{{ old('education_level', $job->education_level) }}"
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
                    required
                >{{ old('description', $job->description) }}</textarea>

            </div>


            <div class="form-group">

                <label for="skills">
                    Aranan Yetenekler
                </label>

                <textarea
                    id="skills"
                    name="skills"
                    rows="5"
                >{{ old('skills', $job->skills) }}</textarea>

            </div>


            <div class="form-group">

                <label for="benefits">
                    Yan Haklar
                </label>

                <textarea
                    id="benefits"
                    name="benefits"
                    rows="5"
                >{{ old('benefits', $job->benefits) }}</textarea>

            </div>


            <div class="grid grid-2">

                <div class="form-group">

                    <label for="deadline">
                        Son Başvuru Tarihi
                    </label>

                    <input
                        type="date"
                        id="deadline"
                        name="deadline"
                        value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}"
                    >

                </div>


                <div class="form-group">

                    <label for="status">
                        İlan Durumu
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="published"
                            {{ old('status', $job->status) === 'published' ? 'selected' : '' }}
                        >
                            Yayında
                        </option>

                        <option
                            value="draft"
                            {{ old('status', $job->status) === 'draft' ? 'selected' : '' }}
                        >
                            Taslak
                        </option>

                        <option
                            value="closed"
                            {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}
                        >
                            Kapalı
                        </option>

                    </select>

                </div>

            </div>


            <div style="
                display:flex;
                gap:10px;
                flex-wrap:wrap;
            ">

                <button type="submit">
                    💾 Değişiklikleri Kaydet
                </button>

                <a
                    href="/employer/jobs"
                    class="btn btn-secondary"
                >
                    İptal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection