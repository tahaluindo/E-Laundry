
# SIM Penggunaan Kendaraan

Aplikasi ini dibuat untuk memanajemen peminjaman kendaraan


## Tool Version
1. Laravel versi 8.0.0
2. PHP versi 7.4.33
3. MySQL versi 8.0.32 

## Installation

1. Jalankan perintah berikut untuk menginstall laravel terlebih dahulu menggunakan composer

```bash
  # cd kedalam direktori project terlebih dahulu
  #jalankan perintah berikut
  composer install
  composer dumpautoload -o
```

2. update .env sesuai dengan environment

3. Jalankan perintah berikut di terminal/command prompt untuk menjalankan migrasi agar table yang dibutuhkan terdapat di dalam database
  ```bash
    php artisan migrate
  ```
4. jalankan perintah berikut di terminal/command prompt agar data yang telah dibuat secara otomatis menggunakan seeder berada pada database
  ```bash
    php artisan db:seed
  ```
5. Jalankan perintah berikut di terminal/command prompt untuk menjalankan program. 
  ```bash
    php artisan serve
  ```

## User List

1. username: admin
password: password

2. username: approval_one
password: password

3. username: approval_two
password: password

## Documentation

1. Fitur Perusahaan Sewa digunakan untuk memanajemen data perusahaan sewa kendaraan yang dipergunakan oleh perusahaan.

2. Fitur kendaraan digunakan untuk memanajemen data kendaraan yang dipergunakan oleh perusahaan baik yang dimiliki perusahaan maupun yang disewa dari perusahaan sewa.

3. Fitur pengemudi digunakan untuk memanajemen data pengemudi kendaraan yang dipergunakan oleh perusahaan.

4. Fitur pemesanan kendaraan digunakan untuk memanajemen data pemesanan kendaraan yang dimiliki oleh perusahaan maupun kendaraan yang disewa dari perusahaan sewa termasuk untuk persetujuan atasan dan pengembalian kendaraan.

5. Fitur laporan pemesanan kendaraan digunakan untuk melihat dan mengeksport data pemesanan kendaraan.
