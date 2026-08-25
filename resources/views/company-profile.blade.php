@extends('layouts.app')

@section('title', 'Firma Profilim - CV Portal')

@section('content')

<div style="max-width:800px; margin:0 auto;">

    <div style="margin-bottom:30px;">

        <a href="/employer/dashboard">
            ← İşveren Paneline Dön
        </a>

        <h1 style="margin-top:20px;">
            🏢 Firma Profilim
        </h1>

        <p style="color:#6b7280;">
            Firmanızın bilgilerini ve sosyal medya hesaplarını buradan yönetebilirsiniz.
        </p>

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


    <div class="card">

        <form
            action="/employer/company"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <!-- LOGO -->

            <div class="form-group">

                <label for="logo">
                    Firma Logosu
                </label>

                <input
                    type="file"
                    id="logo"
                    name="logo"
                    accept="image/jpeg,image/png,image/webp"
                >

                @if ($company?->logo)

                    <div style="
                        margin-top:15px;
                        padding:15px;
                        background:#f9fafb;
                        border-radius:10px;
                        display:inline-block;
                    ">

                        <img
                            src="{{ asset('storage/' . $company->logo) }}"
                            alt="Firma Logosu"
                            width="150"
                            height="150"
                            style="
                                object-fit:contain;
                                display:block;
                            "
                        >

                    </div>

                @endif

            </div>


            <!-- FİRMA ADI -->

            <div class="form-group">

                <label for="name">
                    Firma Adı
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $company?->name) }}"
                    placeholder="Örn. ABC Teknoloji"
                    required
                >

            </div>


            <!-- FAALİYET ALANI -->

            <div class="form-group">

                <label for="industry">
                    Faaliyet Alanı
                </label>

                <input
                    type="text"
                    id="industry"
                    name="industry"
                    value="{{ old('industry', $company?->industry) }}"
                    placeholder="Örn. Yazılım ve Teknoloji"
                >

            </div>


            <!-- LOKASYON -->

            <div class="form-group">

                <label for="location">
                    Lokasyon
                </label>

                <input
                    type="text"
                    id="location"
                    name="location"
                    value="{{ old('location', $company?->location) }}"
                    placeholder="Örn. İstanbul, Türkiye"
                >

            </div>


            <!-- WEBSITE -->

            <div class="form-group">

                <label for="website">
                    Website
                </label>

                <input
                    type="url"
                    id="website"
                    name="website"
                    value="{{ old('website', $company?->website) }}"
                    placeholder="https://..."
                >

            </div>


            <!-- LINKEDIN -->

            <div class="form-group">

                <label for="linkedin">
                    LinkedIn
                </label>

                <input
                    type="url"
                    id="linkedin"
                    name="linkedin"
                    value="{{ old('linkedin', $company?->linkedin) }}"
                    placeholder="https://linkedin.com/company/..."
                >

            </div>


            <!-- INSTAGRAM -->

            <div class="form-group">

                <label for="instagram">
                    Instagram
                </label>

                <input
                    type="url"
                    id="instagram"
                    name="instagram"
                    value="{{ old('instagram', $company?->instagram) }}"
                    placeholder="https://instagram.com/..."
                >

            </div>


            <!-- AÇIKLAMA -->

            <div class="form-group">

                <label for="description">
                    Firma Hakkında
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="8"
                    placeholder="Firmanız hakkında kısa bir açıklama..."
                >{{ old('description', $company?->description) }}</textarea>

            </div>


            <!-- KAYDET -->

            <button
                type="submit"
                style="width:100%;"
            >
                💾 Firma Bilgilerini Kaydet
            </button>

        </form>

    </div>

</div>

@endsection