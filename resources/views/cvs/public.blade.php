<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $cv->title }} - {{ $user->name }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            background: #e5e7eb;
            color: #111827;
        }

        .cv {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 45px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .header {
            border-bottom: 2px solid #111827;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .name {
            font-size: 32px;
            font-weight: bold;
        }

        .contact {
            margin-top: 10px;
            color: #6b7280;
        }

        .section {
            margin-top: 25px;
        }

        .section h2 {
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 6px;
        }

        .item {
            margin: 15px 0;
        }

        .skills span {
            display: inline-block;
            background: #f3f4f6;
            padding: 6px 10px;
            margin: 4px;
            border-radius: 5px;
        }

        .qr-section {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid #d1d5db;
            text-align: center;
        }

        .qr-section h2 {
            border: none;
        }

        .qr-code {
            display: block;
            width: 200px;
            height: 200px;
            margin: 20px auto;
        }
    </style>
</head>

<body>

<div class="cv">

    <!-- HEADER -->

    <div class="header">

        <div class="name">
            {{ $user->name }}
        </div>

        <div class="contact">
            {{ $user->email }}

            @if ($profile?->phone)
                | {{ $profile->phone }}
            @endif

            @if ($profile?->city)
                | {{ $profile->city }}
            @endif
        </div>

    </div>


    <!-- HAKKIMDA -->

    @if ($profile?->about)

        <div class="section">

            <h2>Hakkımda</h2>

            <p>
                {{ $profile->about }}
            </p>

        </div>

    @endif


    <!-- EĞİTİM -->

    @if ($educations->count())

        <div class="section">

            <h2>Eğitim</h2>

            @foreach ($educations as $education)

                <div class="item">

                    <strong>
                        {{ $education->school }}
                    </strong>

                    @if ($education->field)
                        <div>
                            {{ $education->field }}
                        </div>
                    @endif

                    @if ($education->degree)
                        <div>
                            {{ $education->degree }}
                        </div>
                    @endif

                    <div>
                        {{ $education->start_date?->format('Y') ?? '' }}
                        -
                        @if ($education->currently_studying)
                            Devam ediyor
                        @else
                            {{ $education->end_date?->format('Y') ?? '' }}
                        @endif
                    </div>

                </div>

            @endforeach

        </div>

    @endif


    <!-- İŞ DENEYİMİ -->

    @if ($experiences->count())

        <div class="section">

            <h2>İş Deneyimi</h2>

            @foreach ($experiences as $experience)

                <div class="item">

                    <strong>
                        {{ $experience->position }}
                    </strong>

                    <div>
                        {{ $experience->company }}
                    </div>

                    <div>
                        {{ $experience->start_date?->format('Y') ?? '' }}
                        -
                        @if ($experience->currently_working)
                            Devam ediyor
                        @else
                            {{ $experience->end_date?->format('Y') ?? '' }}
                        @endif
                    </div>

                    @if ($experience->description)
                        <p>
                            {{ $experience->description }}
                        </p>
                    @endif

                </div>

            @endforeach

        </div>

    @endif


    <!-- YETENEKLER -->

    @if ($skills->count())

        <div class="section">

            <h2>Yetenekler</h2>

            <div class="skills">

                @foreach ($skills as $skill)

                    <span>
                        {{ $skill->name }}
                    </span>

                @endforeach

            </div>

        </div>

    @endif


    <!-- BAĞLANTILAR -->

    @if (
        $profile?->github ||
        $profile?->linkedin ||
        $profile?->portfolio
    )

        <div class="section">

            <h2>Bağlantılar</h2>

            @if ($profile?->github)
                <p>
                    <strong>GitHub:</strong>
                    {{ $profile->github }}
                </p>
            @endif

            @if ($profile?->linkedin)
                <p>
                    <strong>LinkedIn:</strong>
                    {{ $profile->linkedin }}
                </p>
            @endif

            @if ($profile?->portfolio)
                <p>
                    <strong>Portfolio:</strong>
                    {{ $profile->portfolio }}
                </p>
            @endif

        </div>

    @endif


    <!-- QR KOD -->

    <div class="qr-section">

        <h2>CV'yi QR Kod ile Paylaş</h2>

        <p>
            Telefonunuzla QR kodu taratarak bu CV'yi açabilirsiniz.
        </p>

        <img
            class="qr-code"
            src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(url('/cv/' . $cv->public_token)) }}"
            alt="CV QR Kodu"
        >

        <p>
            <small>
                {{ url('/cv/' . $cv->public_token) }}
            </small>
        </p>

    </div>

</div>

</body>
</html>