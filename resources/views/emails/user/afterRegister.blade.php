<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset some default styles for email clients */
        body,
        table,
        td,
        th {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <h1>Welcome to W Florist Pekanbaru</h1>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p>
                    Hai {{ $user->name }},
                    <br>
                    Selamat datang di W Florist Pekanbaru. Akun Anda telah berhasil dibuat.
                    Sekarang Anda dapat memilih papan bunga sesuai dengan selera Anda!
                </p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <a href="{{ route('login') }}"
                    style="display: inline-block; padding: 10px 20px; background-color: #3490dc; color: #ffffff; text-decoration: none;">Sign
                    In</a>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p>Thanks,<br>{{ config('app.name') }}</p>
            </td>
        </tr>
    </table>

</body>

</html>


{{-- <x-mail::message>
    <h1>Welcome!</h1>

    <p>Hai {{ $user->name }},</p>
    <p>Selamat datang di W Florist Pekanbaru. Akun Anda telah berhasil dibuat.</p>
    <p>Sekarang Anda dapat memilih papan bunga sesuai dengan selera Anda!</p>

    <x-mail::button :url="route('login')">
        Sign In
    </x-mail::button>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</x-mail::message> --}}


{{-- @component('mail::message')
    # Welcome!

    Hi {{ $user->name }}
    <br>
    Selamat datang di W Florist Pekanbaru, Akun anda telah berhasil dibuat.
    <br>
    Sekarang anda bisa pilih papan bunga sesuai selera!

    @component('mail::button', ['url' => route('login')])
        Sign In
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent --}}
