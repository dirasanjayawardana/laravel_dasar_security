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

## Gurad
- Guard adalah bagaimana cara User di autentikasi untuk tiap request nya
- Guard hanya memastikan request valid atau tidak, bukan untuk mengambil data user
- untuk membuat Guard, dengan implement turunan dari interface Guard, kemudian registrasikan di method `boot()` di `AuthServiceProvider` dan tambahkan ke `config/auth.php`
- untuk mengambil data Usernya, menggunakan UserProvider
- untuk menggunakan Guard di middleware, dengan `middleware(["auth:namaguardnya"])` pada route yg ingin di protect
- Secara default di file `config.php`, proses authentikasi dilakukan dengan mengecek `session`

## UserProvider
- Defaultnya menggunakan ElloquentUserProvider
- Jika ingin membuat provider sendiri, dengan membuat class implement dari UserProvider
- UserProvider biasanya digunakan oleh Guard untuk mengambil informasi usernya

## Authorization
- Merupakan proses pengecekan hak akses terhadap sebuah aksi
- Pada Laravel, ada dua cara untuk melakukan Authorization, `Gates` dan `Policies`
- Contoh kasus di project ini, menentukan user mana yg bisa mengubah contact

### Gate
- `Gate` itu seperti Routes, berbasis closure, definisi Gates biasanya disimpan di `boot()` dalam AuthServiceProvider, untuk menggunakannya dengan Facade Gate
- `Gate::allows("nama_gate", resource)` mengecek apakah user diperbolehkan
- `Gate::denies("nama_gate", resource)` mengecek apakah user tidak diperbolehkan
- `Gate::any(["nama_gate"], resource)` mengecek apakah user diperbolehkan di salah satu role
- `Gate::none(["nama_gate"], resource)` mengecek apakah user tidak diperbolehkan disemua role
- `Gate::authorize("nama_gate", resource)` jika user tidak diperbolehkan, akan terjadi error AuthorizationException (403)
- Secara default Facade Gate akan mendeteksi user yang sedang login, jika ingin melakukan pengecekan terhadap user lain bisa menggunakan `Gate::forUser(user)` yang akan mengembalikan object `gate` baru
- `Gate::inspect("nama_gate")` Untuk mendapatkan dan mengembalikan object response ketika terjadi error

### Policies
- `Policies` itu seperti Controller, kumpulan authorization logic terhadap model atau resource
- Untuk membuat Policy, dengan `php artisan make:policy NamaPolicy`
- Untuk membuat Policy untuk sebuah model, dengan `php artisan make:policy NamaPolicy --model=NamaModel`
- Setelah membuat Policy, harus diregistrasikan di `AuthServiceProvider` pada bagian attribute `policies`
- Cara menggunakannya sama seperti Gate, menggunakan facade `Gate::methodNya()`

## Authorizable
- Pada User Model, secara default menggunakan trait `Autorizable`
- Trait ini digunakan untuk melakukan pengecekan authorization menggunakan method-method yang telah disediakan, sehingga tidak perlu menggunakan Facade `Gate`
- `can()` shortcut memanggil `Gate::allows()`
- `canAny()`
- `cant()`
- `cannot()`

## Authorize Request
- Selain menggunakan Gate dan Authorizable, trait `AuthorizesRequests` juga bisa digunakan untuk melakukan pengecekan authorization
- Secara default, saat membuat Controller, akan menggunakan trait AuthorizesRequests
- Dengan method `authorize()` shortcut untuk memanggil `Gate::authorize()`

## Blade Template Authorization
- Untuk melakukan pengecekan authorization di blade template, bisa menggunakan `@can`, `@cannot`, `@canany`

## Guest Access
- Secara default, jika Gate atau Policy tidak mendeteksi adanya User, secara otomatis akan mengembalikan false
- Untuk membuat akses Guest (bukan User) bisa dengan menjadikan paramter User pada Gate atau Policy menjadi optional parameter, dengan menambahkan tanda tanya `?` pada parameter methodnya
- Contoh untuk register tidak memerlukan login User

## Before and After
- Gate dan Policy memiliki fitur Before dan After yang akan dieksekusi sebelum dan setelah sebuah Gate atau Policy dieksekusi, berupa method `before()` dan `after()` didalam Policy
- Jika Before mengembalikan boolean, maka eksekusi akan dihentikan, dan langsung dikembalikan sebagai hasil proses authorization
- After akan dieksekusi paling akhir, dan bisa digunakan untuk mengubah hasil dari authorization Gate atau Policy, jika After mengembalikan result, maka hasil dar Gate atau Policy dibuah menjadi hasil dari After

## Encryption
- Secara default laravel menyimpan password menggunakan Hash (tidak bisa dikembalikan ke nilai awal)
- Selain itu, bisa juga menggunakan `Crypt Facade` untuk melakukan enkripsi dan dekripsi
- Konfigurasi untuk Encryption disimpan di `config/app.php` pada `'key' => env('APP_KEY')` untuk menyimpan key yg digunakan untuk dekripsi
- Untuk Key bisa digenerate degan `php artisan key:generate`
