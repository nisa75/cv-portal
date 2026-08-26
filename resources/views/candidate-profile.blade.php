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


    @if (session('featured_warning'))

        <div class="alert alert-error">
            {{ session('featured_warning') }}
        </div>

    @endif


    <!-- PREMIUM / ÖNE ÇIKARMA -->

    @if (auth()->user()->plan === 'premium')

        <div
            class="card"
            style="
                margin-bottom:20px;
                border:1px solid #f59e0b;
                background:linear-gradient(135deg, #fffbeb, #ffffff);
            "
        >

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:flex-start;
                gap:20px;
                flex-wrap:wrap;
            ">

                <div>

                    <span class="badge badge-green">
                        ⭐ Premium
                    </span>

                    <h2 style="margin-bottom:8px;">
                        🚀 Profilini Öne Çıkar
                    </h2>

                    <p style="color:#6b7280; margin:0;">
                        Profilin 7 gün boyunca işverenlerin aday listesinde
                        öne çıkarılır.
                    </p>

                    @if (auth()->user()->isFeatured())

                        <p style="
                            margin-top:12px;
                            color:#92400e;
                        ">
                            🚀 Profilin şu anda öne çıkarılmış durumda.

                            @if (auth()->user()->featured_until)
                                <br>
                                <strong>
                                    Bitiş:
                                    {{ auth()->user()->featured_until->format('d.m.Y H:i') }}
                                </strong>
                            @endif
                        </p>

                    @endif

                </div>


                <div>

                    @if (auth()->user()->isFeatured())

                        <form
                            action="/candidate/profile/feature"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-secondary"
                            >
                                ⏹️ Öne Çıkarmayı Kaldır
                            </button>

                        </form>

                    @else

                        <form
                            action="/candidate/profile/feature"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn"
                            >
                                🚀 Profilimi Öne Çıkar
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    @endif


    <!-- PROFİL FORMU -->

    <div id="ai-error" class="alert alert-error" style="display:none;"></div>


    <div class="card">

        <form
            action="/candidate/profile"
            method="POST"
            enctype="multipart/form-data"
            id="profile-form"
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


            <!-- HAKKIMDA + AI -->

            <div class="form-group">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:15px;
                    flex-wrap:wrap;
                    margin-bottom:8px;
                ">

                    <label
                        for="about"
                        style="margin:0;"
                    >
                        Hakkımda
                    </label>

                    <button
                        type="button"
                        id="ai-about-button"
                        class="btn"
                        style="min-height:38px;"
                    >
                        ✨ AI ile Hakkımda Oluştur
                    </button>

                </div>

                <textarea
                    id="about"
                    name="about"
                    rows="9"
                    placeholder="Kendin, deneyimlerin ve kariyer hedeflerin hakkında kısa bir bilgi..."
                >{{ old('about', $profile?->about) }}</textarea>

                <p style="
                    color:#9ca3af;
                    font-size:13px;
                    margin-top:7px;
                ">
                    AI mevcut profil bilgilerini kullanarak profesyonel
                    bir metin oluşturur.
                </p>

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


<script>
document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('ai-about-button');
    const about = document.getElementById('about');
    const errorBox = document.getElementById('ai-error');

    if (!button) {
        return;
    }

    button.addEventListener('click', async function () {

        errorBox.style.display = 'none';
        errorBox.textContent = '';

        button.disabled = true;
        button.innerHTML = '⏳ AI yazıyor...';

        const formData = new FormData();

        formData.append(
            'name',
            @json(auth()->user()->name)
        );

        formData.append(
            'skills',
            @json(
                auth()->user()
                    ->skills
                    ->pluck('name')
                    ->implode(', ')
            )
        );

        formData.append(
            'experience',
            @json(
                auth()->user()
                    ->experiences
                    ->map(function ($experience) {
                        return
                            $experience->position
                            . ' - '
                            . $experience->company
                            . ': '
                            . ($experience->description ?? '');
                    })
                    ->implode("\n")
            )
        );

        formData.append(
            'education',
            @json(
                auth()->user()
                    ->educations
                    ->map(function ($education) {
                        return
                            ($education->school ?? '')
                            . ' - '
                            . ($education->field ?? '')
                            . ' '
                            . ($education->degree ?? '');
                    })
                    ->implode("\n")
            )
        );

        formData.append(
            'current_about',
            about.value
        );

        try {

            const response = await fetch(
                '/candidate/ai/generate-about',
                {
                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN':
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content'),

                        'Accept': 'application/json'
                    },

                    body: formData
                }
            );

            const data = await response.json();

            if (!response.ok || !data.success) {

                throw new Error(
                    data.message ||
                    'AI metni oluştururken bir hata oluştu.'
                );

            }

            about.value = data.about;
            about.focus();

        } catch (error) {

            errorBox.textContent =
                error.message ||
                'AI isteği başarısız oldu.';

            errorBox.style.display = 'block';

        } finally {

            button.disabled = false;

            button.innerHTML =
                '✨ AI ile Hakkımda Oluştur';

        }

    });

});
</script>

@endsection