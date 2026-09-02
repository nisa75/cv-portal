@extends('layouts.app')

@section('title', 'Profilim - CV Portal')

@section('content')
@php
    use App\Models\CandidateAchievement;
    use App\Models\CandidateCertificate;
    use App\Models\CandidateCourse;
    use App\Models\CandidateLanguage;
    use App\Models\CandidateProject;
    use App\Models\CandidateReference;
    use App\Models\CandidateTechnicalInfo;
    use App\Models\CandidateVolunteering;

    $user = auth()->user();

    $certificates = CandidateCertificate::where('user_id', $user->id)->latest()->get();
    $courses = CandidateCourse::where('user_id', $user->id)->latest()->get();
    $technical = CandidateTechnicalInfo::where('user_id', $user->id)->latest()->get();
    $languages = CandidateLanguage::where('user_id', $user->id)->latest()->get();
    $references = CandidateReference::where('user_id', $user->id)->latest()->get();
    $projects = CandidateProject::where('user_id', $user->id)->latest()->get();
    $volunteering = CandidateVolunteering::where('user_id', $user->id)->latest()->get();
    $achievements = CandidateAchievement::where('user_id', $user->id)->latest()->get();

    $checks = [
        (bool) ($profile?->profile_photo),
        (bool) ($profile?->headline),
        (bool) ($profile?->phone),
        (bool) ($profile?->city),
        (bool) ($profile?->about),
        (bool) ($profile?->github),
        (bool) ($profile?->linkedin),
        (bool) ($profile?->portfolio),
        $user->educations->count() > 0,
        $user->experiences->count() > 0,
        $user->skills->count() > 0,
        $certificates->count() > 0,
        $courses->count() > 0,
        $technical->count() > 0,
        $languages->count() > 0,
        $projects->count() > 0,
        $achievements->count() > 0,
        $volunteering->count() > 0,
    ];

    $score = (int) round(
        (count(array_filter($checks)) / count($checks)) * 100
    );

    $experienceText = $user->experiences
        ->map(
            fn ($e) =>
                $e->position .
                ' - ' .
                $e->company .
                ': ' .
                ($e->description ?? '')
        )
        ->implode("\n");

    $educationText = $user->educations
        ->map(
            fn ($e) =>
                ($e->school ?? '') .
                ' - ' .
                ($e->field ?? '') .
                ' ' .
                ($e->degree ?? '')
        )
        ->implode("\n");
@endphp

<div class="profile-page profile-v2">

    {{-- HEADER --}}
    <div class="profile-page-header">
        <div>
            <span class="eyebrow">
                <span class="eyebrow-dot"></span>
                KARİYER PROFİLİ
            </span>

            <h1 class="profile-page-title">
                Profilim
            </h1>

            <p class="profile-page-subtitle">
                Kariyerinin tamamını tek yerde yönet.
                Profilini güçlendir, görünürlüğünü seç ve
                işverenlerin seni keşfetmesini kolaylaştır.
            </p>
        </div>

        <div class="profile-header-actions">

            <a
                class="profile-outline-btn"
                href="{{ route('profile.public', $user->id) }}"
                target="_blank"
            >
                ↗ Profilimi Gör
            </a>

            <a
                class="profile-outline-btn"
                href="/candidate/cvs"
            >
                📄 CV'lerim
            </a>

            <a
                class="profile-outline-btn"
                href="/candidate/dashboard"
            >
                Dashboard
            </a>

        </div>
    </div>


    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="modern-alert modern-alert-success">
            <div class="alert-icon">✓</div>

            <div>
                <strong>İşlem başarılı</strong>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif


    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="modern-alert modern-alert-error">
            <div class="alert-icon">!</div>

            <div>
                <strong>Bir sorun oluştu</strong>

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif


    {{-- PREMIUM --}}
    @if ($user->isPremium())
        <section class="premium-banner">

            <div class="premium-glow premium-glow-one"></div>
            <div class="premium-glow premium-glow-two"></div>

            <div class="premium-content">

                <div class="premium-left">

                    <span class="premium-badge">
                        ⭐ PREMIUM
                    </span>

                    <h2>
                        Profilini işverenlerin önünde konumlandır
                    </h2>

                    <p>
                        Premium üyeliğinle profilini aday listelerinde
                        7 gün boyunca öne çıkarabilirsin.
                    </p>

                    @if ($user->isFeatured())
                        <div class="featured-status">

                            <span class="featured-status-dot"></span>

                            <div>
                                <strong>
                                    Profilin şu anda öne çıkarılmış durumda.
                                </strong>

                                @if ($user->featured_until)
                                    <small>
                                        Bitiş:
                                        {{ $user->featured_until->format('d.m.Y H:i') }}
                                    </small>
                                @endif
                            </div>

                        </div>
                    @endif

                </div>

                <div class="premium-right">

                    @if ($user->isFeatured())

                        <form
                            action="/candidate/profile/feature"
                            method="POST"
                        >
                            @csrf
                            @method('DELETE')

                            <button class="premium-secondary-btn">
                                ⏹ Öne Çıkarmayı Kaldır
                            </button>
                        </form>

                    @else

                        <form
                            action="/candidate/profile/feature"
                            method="POST"
                        >
                            @csrf

                            <button class="premium-primary-btn">
                                🚀 Profilimi Öne Çıkar
                            </button>
                        </form>

                    @endif

                </div>

            </div>

        </section>
    @endif


    {{-- PROFILE HERO --}}
    <section class="profile-hero-card">

        <div class="profile-cover"></div>

        <div class="profile-hero-content">

            <div class="profile-avatar-wrapper">

                @if ($profile?->profile_photo)

                    <img
                        class="profile-avatar"
                        src="{{ asset('storage/' . $profile->profile_photo) }}"
                        alt="Profil Fotoğrafı"
                    >

                @else

                    <div class="profile-avatar profile-avatar-placeholder">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                @endif

                <div class="profile-avatar-camera">
                    📷
                </div>

            </div>


            <div class="profile-identity">

                <div class="profile-name-row">

                    <h2>
                        {{ $user->name }}
                    </h2>

                    @if ($user->isPremium())
                        <span class="profile-premium-pill">
                            ⭐ Premium
                        </span>
                    @endif

                    @if ($user->isFeatured())
                        <span class="profile-featured-pill">
                            🚀 Öne Çıkan
                        </span>
                    @endif

                </div>

                <p class="profile-role">
                    {{ $profile?->headline ?: 'Henüz profesyonel başlık eklenmedi.' }}
                </p>

                <div class="profile-meta">

                    <span>
                        📍 {{ $profile?->city ?: 'Konum belirtilmedi' }}
                    </span>

                    @if ($profile?->phone)
                        <span>
                            ☎ {{ $profile->phone }}
                        </span>
                    @endif

                    <span>
                        👁 {{ $profile?->profile_views_count ?? 0 }}
                        görüntülenme
                    </span>

                </div>

            </div>

        </div>

    </section>


    {{-- MAIN LAYOUT --}}
    <div class="profile-layout profile-layout-wide">

        <main class="profile-main-column">


            {{-- BASIC PROFILE --}}
            <section class="modern-card">

                <div class="section-heading">

                    <div>
                        <span class="section-icon">
                            👤
                        </span>

                        <div>
                            <h2>
                                Temel Profil
                            </h2>

                            <p>
                                İşverenlerin ilk gördüğü bilgiler.
                            </p>
                        </div>
                    </div>

                </div>


                <div class="profile-readonly-row">

                    <div>
                        <span>Ad Soyad</span>
                        <strong>{{ $user->name }}</strong>
                    </div>

                    <div>
                        <span>E-posta</span>
                        <strong>{{ $user->email }}</strong>
                    </div>

                </div>


                <form
                    action="/candidate/profile"
                    method="POST"
                    enctype="multipart/form-data"
                    id="profile-form"
                >
                    @csrf


                    {{-- PHOTO --}}
                    <div class="photo-upload-area">

                        <div id="photo-preview-wrap">

                            @if ($profile?->profile_photo)

                                <img
                                    class="upload-preview"
                                    id="photo-preview"
                                    src="{{ asset('storage/' . $profile->profile_photo) }}"
                                    alt="Profil Fotoğrafı"
                                >

                            @else

                                <div
                                    class="upload-preview upload-preview-placeholder"
                                    id="photo-preview"
                                >
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>

                            @endif

                        </div>

                        <div class="photo-upload-content">

                            <strong>
                                Profesyonel profil fotoğrafı
                            </strong>

                            <p>
                                JPG, PNG veya WEBP.
                                İşverenlere güven veren sade bir fotoğraf kullan.
                            </p>

                            <label class="file-upload-btn">

                                Fotoğraf Seç

                                <input
                                    type="file"
                                    id="profile_photo"
                                    name="profile_photo"
                                    accept="image/jpeg,image/png,image/webp"
                                >

                            </label>

                        </div>

                    </div>


                    {{-- PHONE / CITY --}}
                    <div class="profile-form-grid">

                        <div class="modern-form-group">

                            <label for="phone">
                                Telefon
                            </label>

                            <input
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $profile?->phone) }}"
                                placeholder="+90 5xx xxx xx xx"
                            >

                        </div>


                        <div class="modern-form-group">

                            <label for="city">
                                Şehir
                            </label>

                            <input
                                id="city"
                                name="city"
                                value="{{ old('city', $profile?->city) }}"
                                placeholder="İstanbul"
                            >

                        </div>


                        {{-- ABOUT --}}
                        <div class="modern-form-group full">

                            <label for="about">
                                Hakkımda
                            </label>

                            <div class="form-label-row">

                                <small>
                                    Kariyer hedeflerini, güçlü yönlerini
                                    ve seni öne çıkaran noktaları anlat.
                                </small>

                                <button
                                    type="button"
                                    class="ai-button"
                                    id="ai-about-button"
                                >
                                    ✨ AI ile Oluştur
                                </button>

                            </div>

                            <textarea
                                id="about"
                                name="about"
                                rows="7"
                                placeholder="Kendini profesyonel olarak anlat..."
                            >{{ old('about', $profile?->about) }}</textarea>

                            <div class="textarea-footer">

                                <span>
                                    AI, mevcut eğitim / deneyim /
                                    yetenek bilgilerini kullanır.
                                </span>

                                <span id="about-counter">
                                    0 karakter
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- AI ERROR --}}
                    <div
                        id="ai-error"
                        class="modern-alert modern-alert-error ai-error-box"
                    ></div>


                    {{-- SOCIAL LINKS --}}
                    <div class="social-section">

                        <div class="section-mini-title">
                            🔗 Profesyonel bağlantılar
                        </div>

                        <div class="profile-form-grid">

                            <div class="modern-form-group">

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


                            <div class="modern-form-group">

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


                            <div class="modern-form-group full">

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

                        </div>

                    </div>


                    {{-- SAVE --}}
                    <div class="save-section">

                        <div>

                            <strong>
                                Değişiklikleri kaydet
                            </strong>

                            <p>
                                Profilini güncel tutmak seni daha görünür yapar.
                            </p>

                        </div>

                        <button
                            type="submit"
                            class="save-profile-btn"
                        >
                            Kaydet
                        </button>

                    </div>

                </form>

            </section>


            {{-- PROFILE SETTINGS --}}
            <section class="modern-card compact-settings">

                <div class="section-heading">

                    <div>

                        <span class="section-icon">
                            ⚙️
                        </span>

                        <div>

                            <h2>
                                Profil Ayarları
                            </h2>

                            <p>
                                Profilinin kimler tarafından görülebileceğini seç.
                            </p>

                        </div>

                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ route('candidate.profile.settings') }}"
                >
                    @csrf


                    <div class="profile-form-grid">

                        <div class="modern-form-group full">

                            <label for="headline">
                                Profesyonel Başlık
                            </label>

                            <input
                                id="headline"
                                name="headline"
                                maxlength="150"
                                value="{{ old('headline', $profile?->headline) }}"
                                placeholder="Software Engineering Student · Laravel Developer"
                            >

                        </div>

                    </div>


                    <label class="visibility-toggle">

                        <input
                            type="checkbox"
                            name="is_public"
                            value="1"
                            {{ $profile?->is_public ? 'checked' : '' }}
                        >

                        <span class="switch"></span>

                        <span>

                            <strong>
                                Profilimi herkese açık yap
                            </strong>

                            <small>
                                Aktifken işverenler profilini
                                /profile/{{ $user->id }}
                                adresinden görebilir.
                            </small>

                        </span>

                    </label>


                    <button class="btn btn-primary">
                        Ayarları Kaydet
                    </button>

                </form>

            </section>


            {{-- DYNAMIC PROFILE SECTIONS --}}
            @php
                $sections = [
                    [
                        'Sertifikalar',
                        'certificates',
                        '🏅',
                        [
                            'name' => 'Sertifika adı',
                            'issuer' => 'Kuruluş',
                            'issued_at' => 'Alınma tarihi',
                            'credential_id' => 'Kimlik No',
                            'credential_url' => 'Doğrulama bağlantısı',
                            'description' => 'Açıklama',
                        ],
                    ],

                    [
                        'Kurslar',
                        'courses',
                        '📚',
                        [
                            'name' => 'Kurs adı',
                            'provider' => 'Platform / Kurum',
                            'completed_at' => 'Tamamlanma tarihi',
                            'certificate_url' => 'Sertifika bağlantısı',
                            'description' => 'Açıklama',
                        ],
                    ],

                    [
                        'Teknik Bilgiler',
                        'technical',
                        '💻',
                        [
                            'category' => 'Kategori',
                            'name' => 'Teknoloji / araç',
                            'level' => 'Seviye',
                            'years' => 'Deneyim yılı',
                            'notes' => 'Not',
                        ],
                    ],

                    [
                        'Yabancı Diller',
                        'languages',
                        '🌍',
                        [
                            'language' => 'Dil',
                            'level' => 'Seviye',
                            'certificate' => 'Sertifika',
                        ],
                    ],

                    [
                        'Referanslar',
                        'references',
                        '🤝',
                        [
                            'name' => 'Ad Soyad',
                            'position' => 'Pozisyon',
                            'company' => 'Şirket',
                            'email' => 'E-posta',
                            'phone' => 'Telefon',
                            'note' => 'Not',
                        ],
                    ],

                    [
                        'Projeler',
                        'projects',
                        '🚀',
                        [
                            'title' => 'Proje adı',
                            'tech_stack' => 'Teknolojiler',
                            'description' => 'Açıklama',
                            'project_url' => 'Proje bağlantısı',
                            'github_url' => 'GitHub',
                        ],
                    ],

                    [
                        'Gönüllülük',
                        'volunteering',
                        '💚',
                        [
                            'organization' => 'Kurum',
                            'role' => 'Rol',
                            'start_date' => 'Başlangıç',
                            'end_date' => 'Bitiş',
                            'description' => 'Açıklama',
                        ],
                    ],

                    [
                        'Başarılar',
                        'achievements',
                        '🏆',
                        [
                            'title' => 'Başarı / ödül',
                            'organization' => 'Kurum',
                            'achieved_at' => 'Tarih',
                            'description' => 'Açıklama',
                            'url' => 'Bağlantı',
                        ],
                    ],
                ];
            @endphp


            @foreach ($sections as [$title, $slug, $icon, $fields])

                @php
                    $items = match ($slug) {
                        'certificates' => $certificates,
                        'courses' => $courses,
                        'technical' => $technical,
                        'languages' => $languages,
                        'references' => $references,
                        'projects' => $projects,
                        'volunteering' => $volunteering,
                        'achievements' => $achievements,
                        default => collect(),
                    };
                @endphp


                <section
                    class="modern-card data-section"
                    id="{{ $slug }}"
                >

                    <div class="section-heading">

                        <div>

                            <span class="section-icon">
                                {{ $icon }}
                            </span>

                            <div>

                                <h2>
                                    {{ $title }}
                                </h2>

                                <p>
                                    Profiline
                                    {{ strtolower($title) }}
                                    ekleyerek detaylarını göster.
                                </p>

                            </div>

                        </div>

                        <span class="section-count">
                            {{ $items->count() }}
                        </span>

                    </div>


                    {{-- ITEMS --}}
                    <div class="item-list">

                        @forelse ($items as $item)

                            @php
                                $firstField = array_key_first($fields);
                            @endphp

                            <article class="profile-item">

                                <div class="item-main">

                                    <h3>
                                        {{ $item->{$firstField} ?? 'Bilgi' }}
                                    </h3>

                                    <div class="item-meta">

                                        @if ($item->issuer ?? null)
                                            {{ $item->issuer }} ·
                                        @endif

                                        @if ($item->provider ?? null)
                                            {{ $item->provider }} ·
                                        @endif

                                        @if ($item->company ?? null)
                                            {{ $item->company }} ·
                                        @endif

                                        @if ($item->position ?? null)
                                            {{ $item->position }} ·
                                        @endif

                                        @if ($item->level ?? null)
                                            {{ $item->level }}
                                        @endif

                                    </div>


                                    <p>
                                        {{
                                            $item->description
                                            ?? $item->notes
                                            ?? $item->note
                                            ?? $item->certificate
                                            ?? ''
                                        }}
                                    </p>

                                </div>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'candidate.profile.section.delete',
                                        [$slug, $item->id]
                                    ) }}"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="icon-danger"
                                        title="Sil"
                                    >
                                        ×
                                    </button>

                                </form>

                            </article>

                        @empty

                            <div class="empty-section-state">
                                <span>＋</span>

                                <strong>
                                    Henüz {{ strtolower($title) }} eklenmedi.
                                </strong>

                                <small>
                                    Aşağıdaki formdan ilk kaydını ekleyebilirsin.
                                </small>
                            </div>

                        @endforelse

                    </div>


                    {{-- ADD --}}
                    <details class="add-details">

                        <summary>
                            + {{ $title }} ekle
                        </summary>

                        <form
                            class="section-form"
                            method="POST"
                            action="{{ route(
                                'candidate.profile.section.save',
                                $slug
                            ) }}"
                        >
                            @csrf


                            <div class="profile-form-grid">

                                @foreach ($fields as $field => $label)

                                    <div
                                        class="modern-form-group
                                        {{ in_array($field, ['description', 'notes', 'note']) ? 'full' : '' }}"
                                    >

                                        <label for="{{ $slug }}_{{ $field }}">
                                            {{ $label }}
                                        </label>


                                        @if (in_array($field, ['description', 'notes', 'note']))

                                            <textarea
                                                id="{{ $slug }}_{{ $field }}"
                                                name="{{ $field }}"
                                                rows="4"
                                            ></textarea>


                                        @elseif (
                                            str_ends_with($field, '_url')
                                            || $field === 'url'
                                        )

                                            <input
                                                type="url"
                                                id="{{ $slug }}_{{ $field }}"
                                                name="{{ $field }}"
                                            >


                                        @elseif (
                                            str_ends_with($field, '_at')
                                            || str_ends_with($field, '_date')
                                        )

                                            <input
                                                type="date"
                                                id="{{ $slug }}_{{ $field }}"
                                                name="{{ $field }}"
                                            >


                                        @else

                                            <input
                                                id="{{ $slug }}_{{ $field }}"
                                                name="{{ $field }}"
                                                @if ($field === 'level')
                                                    placeholder="Beginner / Intermediate / Advanced"
                                                @endif
                                            >

                                        @endif

                                    </div>

                                @endforeach

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Kaydet
                            </button>

                        </form>

                    </details>

                </section>

            @endforeach


            {{-- CAREER TOOLS --}}
            <section class="modern-card career-tools-card">

                <div class="section-heading">

                    <div>

                        <span class="section-icon">
                            🧰
                        </span>

                        <div>

                            <h2>
                                Kariyer Araçları
                            </h2>

                            <p>
                                Başvurularını daha profesyonel yönet.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="career-tool-grid">

                    <a
                        href="/cover-letters"
                        class="tool-tile"
                    >
                        <span>✉️</span>
                        <strong>Ön Yazılar</strong>
                        <small>
                            Başvurular için hazır metinlerini yönet.
                        </small>
                    </a>


                    <a
                        href="/candidate/cvs"
                        class="tool-tile"
                    >
                        <span>📄</span>
                        <strong>CV'ler</strong>
                        <small>
                            CV oluştur, düzenle, paylaş.
                        </small>
                    </a>


                    <a
                        href="/candidate/interviews"
                        class="tool-tile"
                    >
                        <span>📅</span>
                        <strong>Mülakatlar</strong>
                        <small>
                            Planlanan görüşmelerini takip et.
                        </small>
                    </a>


                    <a
                        href="/messages"
                        class="tool-tile"
                    >
                        <span>💬</span>
                        <strong>Mesajlar</strong>
                        <small>
                            İşverenlerle konuşmalarını yönet.
                        </small>
                    </a>

                </div>

            </section>

        </main>


        {{-- SIDEBAR --}}
        <aside class="profile-sidebar">

            {{-- PROFILE SCORE --}}
            <section class="modern-card profile-score-card">

                <div class="sidebar-stat-row">

                    <div>

                        <span class="sidebar-label">
                            PROFİL GÜCÜ
                        </span>

                        <strong>
                            {{ $score }}%
                        </strong>

                    </div>

                    <div class="sidebar-stat-icon">
                        ◎
                    </div>

                </div>


                <div class="score-bar">

                    <span style="width: {{ $score }}%"></span>

                </div>


                <p>
                    Ne kadar çok bölüm doldurursan
                    profilin o kadar güçlü görünür.
                </p>

            </section>


            {{-- MINI STATS --}}
            <section class="modern-card profile-mini-stats">

                <div>
                    <strong>
                        {{ $projects->count() }}
                    </strong>

                    <span>
                        Proje
                    </span>
                </div>


                <div>
                    <strong>
                        {{ $certificates->count() }}
                    </strong>

                    <span>
                        Sertifika
                    </span>
                </div>


                <div>
                    <strong>
                        {{ $languages->count() }}
                    </strong>

                    <span>
                        Dil
                    </span>
                </div>


                <div>
                    <strong>
                        {{ $profile?->profile_views_count ?? 0 }}
                    </strong>

                    <span>
                        Görüntülenme
                    </span>
                </div>

            </section>


            {{-- QUICK MENU --}}
            <section class="modern-card quick-panel">

                <h3>
                    Hızlı erişim
                </h3>

                <a href="/candidate/educations">
                    🎓 Eğitimler
                    <b>→</b>
                </a>

                <a href="/candidate/experiences">
                    💼 Deneyimler
                    <b>→</b>
                </a>

                <a href="/candidate/skills">
                    🛠️ Yetenekler
                    <b>→</b>
                </a>

                <a href="/notifications">
                    🔔 Bildirimler
                    <b>→</b>
                </a>

                <a href="/favorites">
                    ♡ Favoriler
                    <b>→</b>
                </a>

            </section>


            {{-- PREMIUM --}}
            @if (!$user->isPremium())

                <section class="premium-small-card">

                    <span class="premium-small-icon">
                        ⭐
                    </span>

                    <h3>
                        Premium'a geç
                    </h3>

                    <p>
                        Daha fazla CV oluştur,
                        profilini öne çıkar ve
                        daha fazla görünürlük kazan.
                    </p>

                </section>

            @endif

        </aside>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    const about = document.getElementById('about');
    const counter = document.getElementById('about-counter');
    const aiButton = document.getElementById('ai-about-button');
    const errorBox = document.getElementById('ai-error');


    /* -----------------------------
       ABOUT COUNTER
    ----------------------------- */

    const updateCounter = () => {

        if (!about || !counter) {
            return;
        }

        counter.textContent =
            about.value.length + ' karakter';

    };

    updateCounter();

    if (about) {
        about.addEventListener('input', updateCounter);
    }


    /* -----------------------------
       PHOTO PREVIEW
    ----------------------------- */

    const photoInput =
        document.getElementById('profile_photo');

    if (photoInput) {

        photoInput.addEventListener(
            'change',
            event => {

                const file =
                    event.target.files?.[0];

                if (!file) {
                    return;
                }

                const reader =
                    new FileReader();

                reader.onload = event => {

                    let image =
                        document.getElementById(
                            'photo-preview'
                        );

                    if (
                        image &&
                        image.tagName === 'IMG'
                    ) {

                        image.src =
                            event.target.result;

                        return;
                    }


                    const newImage =
                        document.createElement('img');

                    newImage.id =
                        'photo-preview';

                    newImage.className =
                        'upload-preview';

                    newImage.src =
                        event.target.result;


                    const wrapper =
                        document.getElementById(
                            'photo-preview-wrap'
                        );

                    if (wrapper) {

                        wrapper.replaceChildren(
                            newImage
                        );

                    }

                };

                reader.readAsDataURL(file);

            }
        );

    }


    /* -----------------------------
       AI ABOUT
    ----------------------------- */

    if (aiButton) {

        aiButton.addEventListener(
            'click',
            async () => {

                if (!about) {
                    return;
                }

                if (errorBox) {

                    errorBox.style.display =
                        'none';

                    errorBox.innerHTML =
                        '';

                }


                aiButton.disabled =
                    true;

                aiButton.textContent =
                    '⏳ AI yazıyor...';


                const formData =
                    new FormData();


                formData.append(
                    'name',
                    @json($user->name)
                );


                formData.append(
                    'skills',
                    @json(
                        $user->skills
                            ->pluck('name')
                            ->implode(', ')
                    )
                );


                formData.append(
                    'experience',
                    @json($experienceText)
                );


                formData.append(
                    'education',
                    @json($educationText)
                );


                formData.append(
                    'current_about',
                    about.value || ''
                );


                try {

                    const response =
                        await fetch(
                            '/candidate/ai/generate-about',
                            {
                                method: 'POST',

                                headers: {
                                    'X-CSRF-TOKEN':
                                        document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            ?.getAttribute(
                                                'content'
                                            ),

                                    'Accept':
                                        'application/json'
                                },

                                body: formData
                            }
                        );


                    const data =
                        await response.json();


                    if (
                        !response.ok ||
                        !data.success
                    ) {
                        throw new Error(
                            data.message ||
                            'AI metni oluşturulamadı.'
                        );
                    }


                    about.value =
                        data.about;

                    updateCounter();

                    about.focus();


                } catch (error) {

                    if (errorBox) {

                        errorBox.innerHTML =
                            '<div class="alert-icon">!</div>' +
                            '<div>' +
                            '<strong>AI işlemi başarısız</strong>' +
                            '<p>' +
                            (
                                error.message ||
                                'AI isteği başarısız oldu.'
                            ) +
                            '</p>' +
                            '</div>';

                        errorBox.style.display =
                            'flex';

                    }

                } finally {

                    aiButton.disabled =
                        false;

                    aiButton.textContent =
                        '✨ AI ile Oluştur';

                }

            }
        );

    }

});
</script>

@endsection