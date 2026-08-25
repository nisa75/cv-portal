@extends('layouts.app')

@section('title', 'Kullanıcılar - Admin')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>👤 Kullanıcılar</h1>

        <p style="color:#6b7280;">
            Sistemde kayıtlı tüm kullanıcıları görüntüle ve yönet.
        </p>

    </div>

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if ($errors->any())

        <div class="alert alert-error">

            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

        </div>

    @endif

    @if ($users->isEmpty())

        <div class="card">
            <h2>Kullanıcı bulunmuyor.</h2>
        </div>

    @else

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>Ad Soyad</th>
                        <th>E-posta</th>
                        <th>Rol</th>
                        <th>Kayıt Tarihi</th>
                        <th>İşlem</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($users as $user)

                        @php
                            $roleLabels = [
                                'candidate' => 'Aday',
                                'employer' => 'İşveren',
                                'admin' => 'Admin',
                            ];

                            $roleClasses = [
                                'candidate' => 'badge-blue',
                                'employer' => 'badge-green',
                                'admin' => 'badge-yellow',
                            ];
                        @endphp

                        <tr>

                            <td>
                                <strong>
                                    {{ $user->name }}
                                </strong>
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                <span class="badge {{ $roleClasses[$user->role] ?? '' }}">
                                    {{ $roleLabels[$user->role] ?? $user->role }}
                                </span>
                            </td>

                            <td>
                                {{ $user->created_at->format('d.m.Y H:i') }}
                            </td>

                            <td>

                                @if ($user->id !== auth()->id())

                                    <form
                                        action="/admin/users/{{ $user->id }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')"
                                        >
                                            🗑️ Sil
                                        </button>

                                    </form>

                                @else

                                    <span class="badge badge-yellow">
                                        Mevcut Admin
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>

@endsection