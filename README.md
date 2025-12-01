# SIM-POSDA

**Sistem Monitoring Posyandu & Stunting**

SIM-POSDA adalah sistem informasi berbasis web yang membantu Puskesmas
dalam pendataan balita, pencatatan pengukuran, monitoring status gizi,
serta pembuatan laporan terkait stunting. Sistem ini dikembangkan
menggunakan Laravel dan MySQL.

## 🚀 Fitur Utama

### 👶 Pendataan Balita

-   Manajemen data balita (tambah, edit, hapus).
-   Informasi lengkap balita serta orang tua.

### 📏 Pencatatan Pengukuran

-   Input berat badan, tinggi badan, umur.
-   Penentuan status gizi otomatis sesuai standar WHO.

### 📊 Dashboard & Monitoring

-   Statistik balita normal, stunting, dan risiko stunting.
-   Grafik perkembangan balita.

### 📝 Laporan

-   Laporan rekap kegiatan posyandu.
-   Export dalam bentuk PDF/Excel (opsional jika tersedia).

### 👤 Manajemen User

-   Role: Admin Puskesmas & Petugas Posyandu.
-   Hak akses berbeda untuk tiap role.

------------------------------------------------------------------------

## 🛠 Teknologi yang Digunakan

-   Laravel 10+
-   PHP 8.1+
-   MySQL
-   Bootstrap/Tailwind
-   Composer & NPM

------------------------------------------------------------------------

## ⚙️ Instalasi & Setup

### 1️⃣ Clone Repository

``` bash
git clone https://github.com/Apriza17/TA-Puskesmas.git
cd TA-Puskesmas
```

### 2️⃣ Install Dependencies

``` bash
composer install
npm install
npm run build
```

### 3️⃣ Setup Environment

Buat file `.env`:

``` bash
cp .env.example .env
```

Isi konfigurasi database lokal:

    APP_NAME=SIM-POSDA
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=simposda
    DB_USERNAME=root
    DB_PASSWORD=

### 4️⃣ Generate App Key

``` bash
php artisan key:generate
```

### 5️⃣ Migrasi Database

``` bash
php artisan migrate --seed
```

### 6️⃣ Jalankan Server

``` bash
php artisan serve
```


------------------------------------------------------------------------

## 🌐 Hosting

SIstem sudah terhosting silahkan cek domain **[Klik Disini](sim-posda.online)**


------------------------------------------------------------------------

## 🙋 Kontributor

-   **Reylanda Aran Apriza** --- Developer
-   Puskesmas Gunung Sari Ulu --- Mitra
