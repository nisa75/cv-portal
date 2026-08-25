<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #111827;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 15px;
            margin-top: 20px;
            border-bottom: 1px solid #cccccc;
            padding-bottom: 5px;
        }

        .contact {
            color: #666666;
            margin-bottom: 20px;
        }

        .item {
            margin-bottom: 12px;
        }

        .title {
            font-weight: bold;
        }

        .date {
            color: #666666;
        }

        .skill {
            display: inline-block;
            margin-right: 8px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <h1>{{ $user->name }}</h1>

    <div class="contact">
        {{ $user->email }}

        @if ($profile?->phone)
            | {{ $profile->phone }}
        @endif

        @if ($profile?->city)
            | {{ $profile->city }}
        @endif
    </div>


    @if ($profile?->about)

        <h2>Hakkımda</h2>

        <p>
            {{ $profile->about }}
        </p>

    @endif


    @if ($educations->count())

        <h2>Eğitim</h2>

        @foreach ($educations as $education)

            <div class="item">

                <div class="title">
                    {{ $education->school }}
                </div>

                @if ($education->degree)
                    <div>
                        {{ $education->degree }}
                    </div>
                @endif

                @if ($education->field)
                    <div>
                        {{ $education->field }}
                    </div>
                @endif

                <div class="date">
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

    @endif


    @if ($experiences->count())

        <h2>İş Deneyimi</h2>

        @foreach ($experiences as $experience)

            <div class="item">

                <div class="title">
                    {{ $experience->position }}
                </div>

                <div>
                    {{ $experience->company }}
                </div>

                <div class="date">
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

    @endif


    @if ($skills->count())

        <h2>Yetenekler</h2>

        @foreach ($skills as $skill)

            <span class="skill">
                {{ $skill->name }}
            </span>

        @endforeach

    @endif


    @if (
        $profile?->github ||
        $profile?->linkedin ||
        $profile?->portfolio
    )

        <h2>Bağlantılar</h2>

        @if ($profile?->github)
            <p>
                GitHub: {{ $profile->github }}
            </p>
        @endif

        @if ($profile?->linkedin)
            <p>
                LinkedIn: {{ $profile->linkedin }}
            </p>
        @endif

        @if ($profile?->portfolio)
            <p>
                Portfolio: {{ $profile->portfolio }}
            </p>
        @endif

    @endif

</body>
</html>