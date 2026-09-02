@extends('layouts.app')
@section('title','Ön Yazılar - CV Portal')
@section('content')
<div class="career-tool-page">
    <div class="tool-header"><div><span class="eyebrow">KARİYER ARAÇLARI</span><h1>Ön Yazılar</h1><p>Her başvuru için ayrı, profesyonel ve yeniden kullanılabilir ön yazılar oluştur.</p></div><a class="btn btn-primary" href="#new-letter">+ Yeni Ön Yazı</a></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
    <div class="tool-grid">
        @foreach($letters as $letter)<article class="letter-card"><div class="letter-top"><span class="letter-kicker">{{ $letter->job_title ?: 'Genel Başvuru' }}</span>@if($letter->is_default)<span class="pill pill-primary">Varsayılan</span>@endif</div><h2>{{ $letter->title }}</h2><p class="letter-company">{{ $letter->company ?: 'Şirket belirtilmedi' }}</p><div class="letter-preview">{{ \Illuminate\Support\Str::limit($letter->content, 260) }}</div><div class="letter-actions"><form method="POST" action="{{ route('cover-letters.delete',$letter->id) }}">@csrf @method('DELETE')<button class="btn btn-danger-outline" onclick="return confirm('Bu ön yazı silinsin mi?')">Sil</button></form></div></article>@endforeach
        @if(!$letters->count())<div class="empty-state">Henüz ön yazın yok. İlk ön yazını aşağıdan oluştur.</div>@endif
    </div>
    <section id="new-letter" class="tool-form-card"><div class="public-section-title"><span>+</span><div><h2>Yeni Ön Yazı</h2><p>Başvuruna uygun metni kaydet</p></div></div><form method="POST" action="{{ route('cover-letters.save') }}">@csrf<div class="form-grid-2"><div><label>Başlık</label><input name="title" required placeholder="Frontend Developer Başvurusu"></div><div><label>Pozisyon</label><input name="job_title" placeholder="Frontend Developer"></div><div><label>Şirket</label><input name="company" placeholder="Şirket adı"></div><div class="check-row"><label><input type="checkbox" name="is_default" value="1"> Varsayılan ön yazım yap</label></div></div><label>İçerik</label><textarea name="content" rows="13" required placeholder="Sayın İnsan Kaynakları..."></textarea><button class="btn btn-primary">Ön Yazıyı Kaydet</button></form></section>
</div>
@endsection
