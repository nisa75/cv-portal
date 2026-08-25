@extends('layouts.app')

@section('title', 'CV Düzenle - CV Portal')

@section('content')

<div style="max-width: 700px; margin: 0 auto;">

    <div style="margin-bottom: 30px;">

        <a href="/candidate/cvs">
            ← CV'lerime Dön
        </a>

        <h1 style="margin-top: 20px;">
            ✏️ CV Düzenle
        </h1>

        <p style="color:#6b7280;">
            CV adını ve şablonunu buradan güncelleyebilirsin.
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
            action="/candidate/cvs/{{ $cv->id }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="form-group">

                <label for="title">
                    CV Adı
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $cv->title) }}"
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

                    <option
                        value="modern"
                        {{ old('template', $cv->template) === 'modern' ? 'selected' : '' }}
                    >
                        Modern
                    </option>

                    <option
                        value="classic"
                        {{ old('template', $cv->template) === 'classic' ? 'selected' : '' }}
                    >
                        Classic
                    </option>

                    <option
                        value="minimal"
                        {{ old('template', $cv->template) === 'minimal' ? 'selected' : '' }}
                    >
                        Minimal
                    </option>

                </select>

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
                    href="/candidate/cvs/{{ $cv->id }}"
                    class="btn btn-secondary"
                >
                    👁️ Önizle
                </a>

            </div>

        </form>

    </div>

</div>

@endsection