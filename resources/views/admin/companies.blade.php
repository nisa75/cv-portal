@extends('layouts.app')

@section('title', 'Firmalar - Admin')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>🏢 Firmalar</h1>

        <p style="color:#6b7280;">
            Sistemde kayıtlı firmaları görüntüle.
        </p>

    </div>

    @if ($companies->isEmpty())

        <div class="card">

            <h2>Henüz firma bulunmuyor.</h2>

        </div>

    @else

        <div class="grid grid-2">

            @foreach ($companies as $company)

                <div class="card">

                    @if ($company->logo)

                        <img
                            src="{{ asset('storage/' . $company->logo) }}"
                            alt="{{ $company->name }}"
                            width="100"
                            height="100"
                            style="
                                object-fit:contain;
                                border-radius:10px;
                                margin-bottom:15px;
                            "
                        >

                    @endif

                    <h2 style="margin-top:0;">
                        {{ $company->name }}
                    </h2>

                    <p style="color:#6b7280;">
                        <strong>Sahibi:</strong>
                        {{ $company->user->name ?? 'Bilinmiyor' }}
                    </p>

                    <p style="color:#6b7280;">
                        <strong>Sektör:</strong>
                        {{ $company->industry ?? 'Belirtilmedi' }}
                    </p>

                    <p style="color:#6b7280;">
                        <strong>Lokasyon:</strong>
                        {{ $company->location ?? 'Belirtilmedi' }}
                    </p>

                    @if ($company->website)

                        <p>
                            <a
                                href="{{ $company->website }}"
                                target="_blank"
                            >
                                🌐 Website
                            </a>
                        </p>

                    @endif

                    @if ($company->description)

                        <p style="white-space:pre-line;">
                            {{ $company->description }}
                        </p>

                    @endif

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection