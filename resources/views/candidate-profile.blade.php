@extends('layouts.app')

@section('title', 'Profilim - CV Portal')

@section('content')

<div style="max-width:850px; margin:0 auto;">

    <div style="margin-bottom:30px;">

        <h1>👤 Profilim</h1>

        <p style="color:#6b7280;">
            Kişisel ve kariyer bilgilerini buradan güncelleyebilirsin.
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
            action="/candidate/profile"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <!-- PROFİL FOTOĞRAFI -->

            <div class="form-group">

                <label for="profile_photo">
                    Profil Fotoğrafı
                </label>

                <input
                    type="file"
                    id="profile_photo"
                    name="profile_photo"
                    accept="image/jpeg,image/png,image/webp"
                >

                @if ($profile?->profile_photo)

                    <div style="
                        margin-top:15px;
                        padding:15px;
                        background:#f9fafb;
                        border-radius:12px;
                        display:inline-block;
                    ">

                        <img
                            src="{{ asset('storage/' . $profile->profile_photo) }}"
                            alt="Profil Fotoğrafı"
                            width="150"
                            height="150"
                            style="
                                display:block;
                                object-fit:cover;
                                border-radius:50%;
                            "
                        >

                    </div>

                @endif

            </div>


            <!-- TELEFON -->

            <div class="form-group">

                <label for="phone">
                    Telefon
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $profile?->phone) }}"
                    placeholder="+90 5xx xxx xx xx"
                >

            </div>


            <!-- ŞEHİR -->

            <div class="form-group">

                <label for="city">
                    Şehir
                </label>

                <input
                    type="text"
                    id="city"
                    name="city"
                    value="{{ old('city', $profile?->city) }}"
                    placeholder="Örn. İstanbul"
                >

            </div>


            <!-- HAKKIMDA -->

            <div class="form-group">

                <label for="about">
                    Hakkımda
                </label>

                <textarea
                    id="about"
                    name="about"
                    rows="8"
                    placeholder="Kendin, deneyimlerin ve kariyer hedeflerin hakkında kısa bir bilgi..."
                >{{ old('about', $profile?->about) }}</textarea>

            </div>


            <!-- GITHUB -->

            <div class="form-group">

                <label for="github">
                    GitHub
                </label>

                <input
                    type="url"
                    id="github"
                    name="github"
                    value="{{ old('github', $profile?->github) }}"
                    placeholder="https://github.com/..."
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
                    value="{{ old('linkedin', $profile?->linkedin) }}"
                    placeholder="https://linkedin.com/in/..."
                >

            </div>


            <!-- PORTFOLIO -->

            <div class="form-group">

                <label for="portfolio">
                    Portfolio
                </label>

                <input
                    type="url"
                    id="portfolio"
                    name="portfolio"
                    value="{{ old('portfolio', $profile?->portfolio) }}"
                    placeholder="https://..."
                >

            </div>


            <!-- KAYDET -->

            <button
                type="submit"
                style="width:100%;"
            >
                💾 Profil Bilgilerini Kaydet
            </button>

        </form>

    </div>


    <!-- HIZLI LİNKLER -->

    <div
        class="grid grid-3"
        style="margin-top:20px;"
    >

        <a
            href="/candidate/educations"
            class="card"
            style="text-decoration:none; color:inherit;"
        >
            <h3>🎓 Eğitimlerim</h3>

            <p style="color:#6b7280;">
                Eğitim geçmişini yönet.
            </p>
        </a>


        <a
            href="/candidate/experiences"
            class="card"
            style="text-decoration:none; color:inherit;"
        >
            <h3>💼 Deneyimlerim</h3>

            <p style="color:#6b7280;">
                İş deneyimlerini yönet.
            </p>
        </a>


        <a
            href="/candidate/skills"
            class="card"
            style="text-decoration:none; color:inherit;"
        >
            <h3>🛠️ Yeteneklerim</h3>

            <p style="color:#6b7280;">
                Yeteneklerini yönet.
            </p>
        </a>

    </div>

</div>

@endsection