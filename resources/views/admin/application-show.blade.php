<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvuru Detayı - Admin</title>
</head>

<body>

<a href="/admin/applications">
    ← Başvurulara Dön
</a>

<h1>📋 Başvuru Detayı</h1>

<h2>
    {{ $application->user->name }}
</h2>

<p>
    <strong>Email:</strong>
    {{ $application->user->email }}
</p>

<p>
    <strong>İlan:</strong>
    {{ $application->job->title }}
</p>

<p>
    <strong>Firma:</strong>
    {{ $application->job->company->name }}
</p>

<p>
    <strong>CV:</strong>
    {{ $application->cv->title }}
</p>

<p>
    <strong>Durum:</strong>
    {{ $application->status }}
</p>

@if ($application->cover_letter)

    <h3>Ön Yazı</h3>

    <p>
        {{ $application->cover_letter }}
    </p>

@endif

@if ($application->user->candidateProfile)

    <h3>Aday Profili</h3>

    <p>
        <strong>Şehir:</strong>
        {{ $application->user->candidateProfile->city ?? 'Belirtilmedi' }}
    </p>

    <p>
        <strong>Hakkımda:</strong>
        {{ $application->user->candidateProfile->about ?? 'Belirtilmedi' }}
    </p>

@endif

</body>
</html>