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
