@extends('layouts.app')

@section('title', 'Mülakat Planla - CV Portal')

@section('content')

<div style="max-width:750px;margin:0 auto;">

    <div style="margin-bottom:30px;">

        <a href="/employer/applications/{{ $application->id }}">
            ← Başvuruya Dön
        </a>

        <h1 style="margin-top:20px;">
            🗓️ Mülakat Planla
        </h1>

        <p style="color:#6b7280;">
            {{ $application->user->name }} · {{ $application->job->title }}
        </p>

    </div>

    <div class="interview-card">

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form
            action="/employer/applications/{{ $application->id }}/interview"
            method="POST"
        >
            @csrf

            <div class="grid grid-2">

                <div class="form-group">
                    <label for="type">Mülakat Türü</label>

                    <select id="type" name="type" required>
                        <option value="online">Online</option>
                        <option value="office">Ofiste</option>
                        <option value="phone">Telefon</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="duration">Süre</label>

                    <select id="duration" name="duration" required>
                        <option value="30">30 dakika</option>
                        <option value="45">45 dakika</option>
                        <option value="60">60 dakika</option>
                        <option value="90">90 dakika</option>
                        <option value="120">120 dakika</option>
                    </select>
                </div>

            </div>

            <div class="form-group">
                <label for="scheduled_at">
                    Tarih ve Saat
                </label>

                <input
                    type="datetime-local"
                    id="scheduled_at"
                    name="scheduled_at"
                    required
                >
            </div>

            <div class="form-group">
                <label for="location">
                    Konum
                </label>

                <input
                    type="text"
                    id="location"
                    name="location"
                    placeholder="Ofis adresi"
                >
            </div>

            <div class="form-group">
                <label for="meeting_link">
                    Toplantı Linki
                </label>

                <input
                    type="url"
                    id="meeting_link"
                    name="meeting_link"
                    placeholder="https://meet.google.com/..."
                >
            </div>

            <div class="form-group">
                <label for="notes">
                    Not
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="6"
                    placeholder="Adaya iletmek istediğiniz bilgiler..."
                ></textarea>
            </div>

            <button type="submit" style="width:100%;">
                🗓️ Mülakatı Planla
            </button>

        </form>

    </div>

</div>

@endsection