@extends('layouts.app')

@section('title', 'İş Deneyimi Ekle - CV Portal')

@section('content')

<div style="max-width:750px; margin:0 auto;">

    <div style="margin-bottom:30px;">

        <a href="/candidate/experiences">
            ← Deneyimlerime Dön
        </a>

        <h1 style="margin-top:20px;">
            💼 İş Deneyimi Ekle
        </h1>

        <p style="color:#6b7280;">
            Çalışma geçmişindeki bir deneyimi ekle.
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
            action="/candidate/experiences"
            method="POST"
        >

            @csrf


            <div class="form-group">

                <label for="company">
                    Şirket
                </label>

                <input
                    type="text"
                    id="company"
                    name="company"
                    value="{{ old('company') }}"
                    placeholder="Örn. ABC Teknoloji"
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
                    value="{{ old('position') }}"
                    placeholder="Örn. Software Developer"
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
                        value="{{ old('start_date') }}"
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
                        value="{{ old('end_date') }}"
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
                        {{ old('currently_working') ? 'checked' : '' }}
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
                    placeholder="Görevlerin, sorumlulukların ve başarıların..."
                >{{ old('description') }}</textarea>

            </div>


            <button
                type="submit"
                style="width:100%;"
            >
                💾 Deneyimi Kaydet
            </button>

        </form>

    </div>

</div>

@endsection