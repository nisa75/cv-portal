<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvuru Yap - CV Portal</title>
</head>
<body>

    <h1>Başvuru Yap</h1>

    <a href="/candidate/jobs/{{ $job->id }}">
        ← İlana Dön
    </a>

    <h2>{{ $job->title }}</h2>

    <p>
        <strong>Firma:</strong>
        {{ $job->company->name }}
    </p>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/candidate/jobs/{{ $job->id }}/apply" method="POST">

        @csrf

        <div>
            <label for="cv_id">CV Seç</label>

            <select name="cv_id" id="cv_id" required>
                <option value="">CV seçiniz</option>

                @foreach ($cvs as $cv)
                    <option value="{{ $cv->id }}">
                        {{ $cv->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label for="cover_letter">Ön Yazı</label>

            <textarea
                name="cover_letter"
                id="cover_letter"
                rows="10"
                placeholder="Bu pozisyona neden uygun olduğunuzu anlatabilirsiniz..."
            >{{ old('cover_letter') }}</textarea>
        </div>

        <br>

        <button type="submit">
            Başvuruyu Gönder
        </button>

    </form>

</body>
</html>