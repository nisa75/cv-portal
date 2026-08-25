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


            <div class="form-group">

                <label for="description">
                    Açıklama
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="7"
                >{{ old('description', $experience->description) }}</textarea>

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

@endsection