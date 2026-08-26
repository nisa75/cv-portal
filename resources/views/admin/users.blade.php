@extends('layouts.app')

@section('title', 'Kullanıcılar - Admin')

@section('content')

<div>

    <div style="margin-bottom:30px;">

        <h1>👤 Kullanıcılar</h1>

        <p style="color:#6b7280;">
            Sistemde kayıtlı kullanıcıları görüntüle ve yönet.
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

            <h2>
                Kullanıcı bulunmuyor.
            </h2>

        </div>

    @else

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            Ad Soyad
                        </th>

                        <th>
                            E-posta
                        </th>

                        <th>
                            Rol
                        </th>

                        <th>
                            Plan
                        </th>

                        <th>
                            Kayıt Tarihi
                        </th>

                        <th>
                            İşlemler
                        </th>

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

                            <!-- AD -->

                            <td>

                                <strong>
                                    {{ $user->name }}
                                </strong>

                            </td>


                            <!-- EMAIL -->

                            <td>
                                {{ $user->email }}
                            </td>


                            <!-- ROL -->

                            <td>

                                <span class="badge {{ $roleClasses[$user->role] ?? '' }}">

                                    {{ $roleLabels[$user->role] ?? $user->role }}

                                </span>

                            </td>


                            <!-- PLAN -->

                            <td>

                                @if ($user->plan === 'premium')

                                    <span class="badge badge-green">
                                        ⭐ Premium
                                    </span>

                                @else

                                    <span class="badge">
                                        🆓 Free
                                    </span>

                                @endif

                            </td>


                            <!-- TARİH -->

                            <td>
                                {{ $user->created_at->format('d.m.Y H:i') }}
                            </td>


                            <!-- İŞLEMLER -->

                            <td>

                                @if ($user->role === 'candidate')

                                    <form
                                        action="/admin/users/{{ $user->id }}/premium"
                                        method="POST"
                                        style="margin:0;"
                                    >

                                        @csrf
                                        @method('PUT')


                                        @if ($user->plan === 'premium')

                                            <button
                                                type="submit"
                                                class="btn btn-secondary"
                                                onclick="return confirm('Bu kullanıcıyı Free plana geçirmek istediğinize emin misiniz?')"
                                            >
                                                🆓 Free Yap
                                            </button>

                                        @else

                                            <button
                                                type="submit"
                                                class="btn btn-success"
                                                onclick="return confirm('Bu kullanıcıyı Premium yapmak istediğinize emin misiniz?')"
                                            >
                                                ⭐ Premium Yap
                                            </button>

                                        @endif

                                    </form>

                                @else

                                    <span style="color:#9ca3af;">
                                        —
                                    </span>

                                @endif


                                @if ($user->id !== auth()->id())

                                    <form
                                        action="/admin/users/{{ $user->id }}"
                                        method="POST"
                                        style="margin-top:8px;"
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

                                    <div style="margin-top:8px;">

                                        <span class="badge badge-yellow">
                                            Mevcut Admin
                                        </span>

                                    </div>

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