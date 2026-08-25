@extends('layouts.app')

@section('title', 'Yeteneklerim - CV Portal')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>🛠️ Yeteneklerim</h1>

        <p style="color:#6b7280;">
            Sahip olduğun teknik ve kişisel yetenekleri ekle.
        </p>

    </div>


    <div class="grid grid-2">

        <!-- YENİ YETENEK -->

        <div class="card">

            <h2>
                Yetenek Ekle
            </h2>

            @if ($errors->any())

                <div class="alert alert-error">

                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach

                </div>

            @endif

            <form
                action="/candidate/skills"
                method="POST"
            >

                @csrf

                <div class="form-group">

                    <label for="name">
                        Yetenek
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Örn. Laravel"
                        maxlength="100"
                        required
                    >

                </div>

                <button
                    type="submit"
                    style="width:100%;"
                >
                    + Yetenek Ekle
                </button>

            </form>

        </div>


        <!-- MEVCUT YETENEKLER -->

        <div class="card">

            <h2>
                Yeteneklerim
            </h2>

            @if ($skills->isEmpty())

                <p style="color:#6b7280;">
                    Henüz yetenek eklemedin.
                </p>

            @else

                <div style="
                    display:flex;
                    flex-wrap:wrap;
                    gap:10px;
                ">

                    @foreach ($skills as $skill)

                        <div style="
                            display:flex;
                            align-items:center;
                            gap:8px;
                            padding:8px 12px;
                            border-radius:999px;
                            background:#f3f4f6;
                            border:1px solid #e5e7eb;
                        ">

                            <span>
                                {{ $skill->name }}
                            </span>

                            <form
                                action="/candidate/skills/{{ $skill->id }}"
                                method="POST"
                                style="margin:0;"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    style="
                                        min-height:auto;
                                        padding:4px 8px;
                                        font-size:12px;
                                    "
                                    onclick="return confirm('Bu yeteneği silmek istediğinize emin misiniz?')"
                                >
                                    ×
                                </button>

                            </form>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</div>

@endsection