@extends('layouts.app')
@section('title', $candidate->name.' - CV Portal')
@section('content')
<div class="public-profile-page">
    <div class="public-profile-hero">
        <div class="public-cover"></div>
        <div class="public-hero-body">
            @if($profile?->profile_photo)
                <img class="public-avatar" src="{{ asset('storage/'.$profile->profile_photo) }}" alt="{{ $candidate->name }}">
            @else
                <div class="public-avatar public-avatar-fallback">{{ strtoupper(substr($candidate->name,0,1)) }}</div>
            @endif
            <div class="public-identity">
                <div class="public-name-line"><h1>{{ $candidate->name }}</h1>@if($candidate->isPremium())<span class="pill pill-premium">⭐ Premium</span>@endif</div>
                <p>{{ $profile?->headline ?: 'Kariyer profilini keşfet.' }}</p>
                <div class="public-meta"><span>📍 {{ $profile?->city ?: 'Konum belirtilmedi' }}</span><span>👁 {{ $profile?->profile_views_count ?? 0 }} profil görüntülenmesi</span></div>
                <div class="public-links">
                    @foreach([['GitHub',$profile?->github],['LinkedIn',$profile?->linkedin],['Portfolio',$profile?->portfolio]] as [$label,$url])
                        @if($url)<a href="{{ $url }}" target="_blank" rel="noopener">{{ $label }} ↗</a>@endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if($profile?->about)
    <section class="public-card"><div class="public-section-title"><span>01</span><div><h2>Hakkımda</h2><p>Kariyer özeti</p></div></div><p class="public-copy">{{ $profile->about }}</p></section>
    @endif

    @foreach([
        ['Projeler','projects','title','description','project_url'],
        ['Sertifikalar','certificates','name','description','credential_url'],
        ['Kurslar','courses','name','description','certificate_url'],
        ['Teknik Bilgiler','technical','name','notes',null],
        ['Yabancı Diller','languages','language','certificate',null],
        ['Referanslar','references','name','note',null],
        ['Gönüllülük','volunteering','organization','description',null],
        ['Başarılar','achievements','title','description','url'],
    ] as [$title,$key,$nameKey,$descKey,$urlKey])
        @php($items=${$key})
        @if($items->count())
            <section class="public-card"><div class="public-section-title"><span>{{ str_pad((string)($loop->iteration+1),2,'0',STR_PAD_LEFT) }}</span><div><h2>{{ $title }}</h2><p>Profil bilgileri</p></div></div>
                <div class="public-items">
                @foreach($items as $item)
                    <article class="public-item"><div><h3>{{ $item->{$nameKey} }}</h3><div class="public-item-meta">@if($item->issuer ?? null){{ $item->issuer }} · @endif @if($item->provider ?? null){{ $item->provider }} · @endif @if($item->level ?? null){{ $item->level }} · @endif @if($item->company ?? null){{ $item->company }} @endif</div><p>{{ $item->{$descKey} }}</p></div>@if($urlKey && ($item->{$urlKey} ?? null))<a target="_blank" rel="noopener" href="{{ $item->{$urlKey} }}">Görüntüle ↗</a>@endif</article>
                @endforeach
                </div>
            </section>
        @endif
    @endforeach

    @if($candidate->educations->count() || $candidate->experiences->count() || $candidate->skills->count())
    <section class="public-card"><div class="public-section-title"><span>10</span><div><h2>Temel Kariyer Geçmişi</h2><p>Mevcut CV Portal kayıtları</p></div></div>
        @if($candidate->educations->count())<h3 class="subhead">Eğitim</h3>@foreach($candidate->educations as $e)<div class="timeline-item"><strong>{{ $e->school }}</strong><span>{{ $e->degree ?? '' }} {{ $e->field ?? '' }}</span></div>@endforeach@endif
        @if($candidate->experiences->count())<h3 class="subhead">Deneyim</h3>@foreach($candidate->experiences as $e)<div class="timeline-item"><strong>{{ $e->position }}</strong><span>{{ $e->company }}</span><p>{{ $e->description }}</p></div>@endforeach@endif
        @if($candidate->skills->count())<h3 class="subhead">Yetenekler</h3><div class="tag-list">@foreach($candidate->skills as $s)<span>{{ $s->name }}</span>@endforeach</div>@endif
    </section>
    @endif
</div>
@endsection
