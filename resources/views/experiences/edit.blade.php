@extends('layouts.app')

@section('title', 'İş Deneyimini Düzenle - CV Portal')

@section('content')

<div style="max-width:750px; margin:0 auto;">

    <div style="margin-bottom:30px;">

        <a href="/candidate/experiences">
            ← Deneyimlerime Dön
        </a>

        <h1 style="margin-top:20px;">
            ✏️ İş Deneyimini Düzenle
        </h1>

        <p style="color:#6b7280;">
            Deneyim bilgilerini güncelle.
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


        <div id="ai-experience-error" class="alert alert-error" style="display:none;"></div>


        <form
            action="/candidate/experiences/{{ $experience->id }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="form-group">

                <label for="company">
                    Şirket
                </label>

                <input
                    type="text"
                    id="company"
                    name="company"
                    value="{{ old('company', $experience->company) }}"
                    required
                >

            </div>


            <div class="form-group">

                <label for="position">
                    Pozisyon
                </label>

                <input
                    type="text"
                    id="position"
                    name="position"
                    value="{{ old('position', $experience->position) }}"
                    required
                >

            </div>


            <div class="grid grid-2">

                <div class="form-group">

                    <label for="start_date">
                        Başlangıç Tarihi
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ old('start_date', optional($experience->start_date)->format('Y-m-d')) }}"
                    >

                </div>


                <div class="form-group">

                    <label for="end_date">
                        Bitiş Tarihi
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date', optional($experience->end_date)->format('Y-m-d')) }}"
                    >

                </div>

            </div>


            <div class="form-group">

                <label style="
                    display:flex;
                    align-items:center;
                    gap:8px;
                    font-weight:normal;
                ">

                    <input
                        type="checkbox"
                        name="currently_working"
                        value="1"
                        {{ old('currently_working', $experience->currently_working) ? 'checked' : '' }}
                        style="width:auto;"
                    >

                    Hâlen bu şirkette çalışıyorum

                </label>

            </div>


            <!-- AI AÇIKLAMA -->

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
                        for="description"
                        style="margin:0;"
                    >
                        Açıklama
                    </label>

                    <button
                        type="button"
                        id="ai-experience-button"
                        class="btn"
                        style="min-height:38px;"
                    >
                        ✨ AI ile Açıklamayı Geliştir
                    </button>

                </div>


                <textarea
                    id="description"
                    name="description"
                    rows="8"
                >{{ old('description', $experience->description) }}</textarea>

                <p style="
                    color:#9ca3af;
                    font-size:13px;
                    margin-top:7px;
                ">
                    AI mevcut açıklamanı daha profesyonel bir CV metnine dönüştürür.
                    Metni kaydetmeden önce düzenleyebilirsin.
                </p>

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
                    href="/candidate/experiences"
                    class="btn btn-secondary"
                >
                    İptal
                </a>

            </div>

        </form>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('ai-experience-button');
    const company = document.getElementById('company');
    const position = document.getElementById('position');
    const description = document.getElementById('description');
    const errorBox = document.getElementById('ai-experience-error');

    button.addEventListener('click', async function () {

        errorBox.style.display = 'none';
        errorBox.textContent = '';

        if (!company.value.trim()) {
            errorBox.textContent = 'Önce şirket adını yaz.';
            errorBox.style.display = 'block';
            company.focus();
            return;
        }

        if (!position.value.trim()) {
            errorBox.textContent = 'Önce pozisyonu yaz.';
            errorBox.style.display = 'block';
            position.focus();
            return;
        }

        if (!description.value.trim()) {
            errorBox.textContent = 'Önce deneyim açıklamasını yaz.';
            errorBox.style.display = 'block';
            description.focus();
            return;
        }

        button.disabled = true;
        button.innerHTML = '⏳ AI yazıyor...';

        try {

            const response = await fetch(
                '/candidate/ai/improve-experience',
                {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),

                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        company: company.value,
                        position: position.value,
                        description: description.value
                    })
                }
            );

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(
                    data.message ||
                    'AI açıklamayı geliştirirken bir hata oluştu.'
                );
            }

            description.value = data.description;
            description.focus();

        } catch (error) {

            errorBox.textContent =
                error.message ||
                'AI isteği başarısız oldu.';

            errorBox.style.display = 'block';

        } finally {

            button.disabled = false;
            button.innerHTML =
                '✨ AI ile Açıklamayı Geliştir';

        }

    });

});
</script>

@endsection