@extends('layouts.app')

@section('title', 'Eğitimi Düzenle - CV Portal')

@section('content')

<div style="max-width:750px; margin:0 auto;">

    <div style="margin-bottom:30px;">

        <a href="/candidate/educations">
            ← Eğitimlerime Dön
        </a>

        <h1 style="margin-top:20px;">
            ✏️ Eğitimi Düzenle
        </h1>

        <p style="color:#6b7280;">
            Eğitim bilgilerini güncelle.
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
            action="/candidate/educations/{{ $education->id }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="school">
                    Okul
                </label>

                <input
                    type="text"
                    id="school"
                    name="school"
                    value="{{ old('school', $education->school) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label for="degree">
                    Derece
                </label>

                <input
                    type="text"
                    id="degree"
                    name="degree"
                    value="{{ old('degree', $education->degree) }}"
                    placeholder="Örn. Lisans"
                >

            </div>

            <div class="form-group">

                <label for="field">
                    Bölüm / Alan
                </label>

                <input
                    type="text"
                    id="field"
                    name="field"
                    value="{{ old('field', $education->field) }}"
                    placeholder="Örn. Yazılım Mühendisliği"
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
                        value="{{ old('start_date', optional($education->start_date)->format('Y-m-d')) }}"
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
                        value="{{ old('end_date', optional($education->end_date)->format('Y-m-d')) }}"
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
                        name="currently_studying"
                        value="1"
                        {{ old('currently_studying', $education->currently_studying) ? 'checked' : '' }}
                        style="width:auto;"
                    >

                    Hâlen bu okulda okuyorum

                </label>

            </div>

            <div class="form-group">

                <label for="description">
                    Açıklama
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                >{{ old('description', $education->description) }}</textarea>

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
                    href="/candidate/educations"
                    class="btn btn-secondary"
                >
                    İptal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection