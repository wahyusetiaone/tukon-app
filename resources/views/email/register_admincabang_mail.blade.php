@component('mail::message')
# Pendaftaran Admin Cabang

Anda telah didaftarkan sebagai admin cabang, mohon untuk segera verifikasi dan melakukan pengisian data diri dengan mengklik tombol dibawah ini.

@component('mail::button', ['url' => $url])
Verifikasi Akun
@endcomponent

Selamat Bergabung,<br>
{{ config('app.name') }}
@endcomponent
