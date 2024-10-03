# Laravel Security
- Laravel menyediakan fitur untuk melakukan proses Authentication dan Authorization.
- Laravel menyediakan beberapa package untuk Authentication, defaultnya Laravel menggunakan Session yang disimpan didalam Cookie untuk menyimpan Authentication.
- Laravel Passport (OAuth 2 Authentication Provider) --> lebih advance
- Laravel Sanctum (direkomendasikan utnuk membuat project Laravel yang menggunakan SPA/Single Page Application) --> lebih advance

## User Model
- Model yang digunakan untuk melakukan Authentication user
- jika ingin mengubah informasi User Model, bisa mengubahnya sebelum menjalankan migration

## Laravel Breeze
- Fitur untuk membuat halaman proses authentication secara otomatis
- Mendukung halaman registration, login, password reset, email verification dan password confirmation
- Laravel Breeze membuat halamannya menggunakan Blaze template dan menggunakan TailwindCSS
- Jika tidak ingin menggunakan Laravel Breeze, bisa buat manual
- Untuk menambahkan Laravel Breeze, dengan perintah `composer require laravel/breeze=v1.26.2 --dev`
- Lalu perlu install halaman authorization dengan perintah `php artisan breeze:install`

## Authentication
- Merupakan proses melakukan verifikasi apakah request dari user dikenali atau tidak
- Proses Authentication menggunakan Facade Auth, tidak langsung menggunakan Model User
- `Auth::attempt(credential, remember)` melakukan login dengan credential, dan disimpan untuk beberapa waktu, jika berhasil akan otomatis memanggil `Auth::login()`
- `Auth::login(credential)` melakukan login untuk credential, otomatis data user akan disimpan di Session, bisa melakukan generate Session agar disimpan di Cookie
- `Auth::logout()` mengeluarkan user yang sedang login
- `Auth::user()` mendapatkan informasi user yang sedang login
- `Session::invalidate()` untuk menghapus session dan logout

## Hash Facade
- Digunakan untuk membuat Hash (kode unik yg tidak bisa dikembalikan ke bentuk asalnya)
- Di laravel secara default menggunakan algoritma BCrypt, bisa digantu menjadi argon atau argon2id
- Pengaturan Hash bisa dilakukan di file `config/hashing.php`
- Saat menggunakan `Auth::attempt()` otomatis pengecekan hasnya dilakukan oleh laravel
- `Hash::make($contoh)` membuat hashing
- `Hash::check($contoh, $hashnya)` melakukan check hasil hashing dengan nilai aslinya

## Auth Middleware
- Bisa digunakan untuk memastikan bahwa user sudah ter-authentikasi terlabih dahulu sebelum mengakses halaman yang diinginkan
- Jika belum authenticate, akan mengembalikan error AuthenticationException, secara default akan di redirect ke route `login`

## Learning
- test/UserTest.php
- UserController.php
