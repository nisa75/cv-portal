@extends('layouts.app')

@section('title', 'Yeni CV Oluştur - CV Portal')

@section('content')

<div style="max-width: 700px; margin: 0 auto;">

    <div style="margin-bottom: 30px;">

        <a href="/candidate/cvs">
            ← CV'lerime Dön
        </a>

        <h1 style="margin-top: 20px;">
            📄 Yeni CV Oluştur
        </h1>

        <p style="color:#6b7280;">
            CV'nin adını ve kullanmak istediğin şablonu seç.
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


        <form action="/candidate/cvs" method="POST">

            @csrf


            <div class="form-group">

                <label for="title">
                    CV Adı
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Örn. Frontend Developer CV"
                    required
                >

            </div>


            <div class="form-group">

                <label for="template">
                    CV Şablonu
                </label>

                <select
                    id="template"
                    name="template"
                    required
                >

                    <option value="">
                        Şablon seçiniz
                    </option>

                    <option
                        value="modern"
                        {{ old('template') === 'modern' ? 'selected' : '' }}
                    >
                        Modern
                    </option>

                    <option
                        value="classic"
                        {{ old('template') === 'classic' ? 'selected' : '' }}
                    >
                        Classic
                    </option>

                    <option
                        value="minimal"
                        {{ old('template') === 'minimal' ? 'selected' : '' }}
                    >
                        Minimal
                    </option>

                </select>

            </div>


            <button
                type="submit"
                style="width:100%;"
            >
                CV Oluştur
            </button>

        </form>

    </div>

</div>

@endsection