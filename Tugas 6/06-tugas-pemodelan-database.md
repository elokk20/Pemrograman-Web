## Perancangan ERD E-Library Kampus

## 1. Deskripsi Sistem
Sistem E-Library Kampus merupakan basis data relasional yang digunakan untuk mengelola data mahasiswa, buku, penerbit, serta aktivitas peminjaman dan pengembalian buku.

Setiap mahasiswa dapat melakukan peminjaman buku. Setiap buku memiliki satu penerbit, sedangkan satu penerbit dapat menerbitkan banyak buku. Setiap transaksi peminjaman mencatat mahasiswa yang melakukan peminjaman, buku yang dipinjam, tanggal peminjaman, serta informasi pengembalian.

## 2. Identifikasi Entitas
### 2.1 Mahasiswa
Entitas `mahasiswa` menyimpan informasi identitas mahasiswa yang dapat melakukan peminjaman buku.
Atribut:
- `nim` sebagai Primary Key
- `nama_mahasiswa`
- `program_studi`
- `email`

### 2.2 Buku
Entitas `buku` menyimpan informasi buku yang tersedia di perpustakaan.
Atribut:
- `id_buku` sebagai Primary Key
- `judul_buku`
- `isbn`
- `tahun_terbit`
- `id_penerbit` sebagai Foreign Key yang mengacu pada entitas `penerbit`

### 2.3 Penerbit
Entitas `penerbit` menyimpan informasi penerbit buku.
Atribut:
- `id_penerbit` sebagai Primary Key
- `nama_penerbit`
- `alamat_penerbit`

### 2.4 Transaksi Peminjaman
Entitas `transaksi_peminjaman` menyimpan riwayat peminjaman dan pengembalian buku.
Atribut:
- `id_peminjaman` sebagai Primary Key
- `nim` sebagai Foreign Key yang mengacu pada entitas `mahasiswa`
- `id_buku` sebagai Foreign Key yang mengacu pada entitas `buku`
- `tanggal_peminjaman`
- `tanggal_jatuh_tempo`
- `tanggal_pengembalian`
- `status_peminjaman`

## 3. Atribut dan Kunci

### 3.1 Mahasiswa

### 3.2 Buku

### 3.3 Penerbit

### 3.4 Transaksi Peminjaman

## 4. Relasi Antar Entitas
Relasi antar entitas dalam sistem E-Library adalah sebagai berikut:
1. **Mahasiswa dan Transaksi Peminjaman**
   - Satu mahasiswa dapat memiliki banyak transaksi peminjaman.
   - Setiap transaksi peminjaman hanya dilakukan oleh satu mahasiswa.
   - Kardinalitas: **1:N**.
2. **Buku dan Transaksi Peminjaman**
   - Satu buku dapat tercatat dalam banyak transaksi peminjaman pada waktu yang berbeda.
   - Setiap transaksi peminjaman hanya mencatat satu buku.
   - Kardinalitas: **1:N**.
3. **Penerbit dan Buku**
   - Satu penerbit dapat menerbitkan banyak buku.
   - Setiap buku memiliki satu penerbit.
   - Kardinalitas: **1:N**.
`transaksi_peminjaman` menjadi entitas yang menghubungkan mahasiswa dengan buku dalam aktivitas peminjaman.

## 5. Normalisasi
### 5.1 Unnormalized Form (UNF)
Pada bentuk UNF, data mahasiswa, buku, penerbit, dan transaksi peminjaman masih dicatat dalam satu struktur data. Informasi peminjaman dapat berisi lebih dari satu buku dalam satu record sehingga terdapat kelompok data berulang.

Contoh bentuk UNF:
| NIM | Nama Mahasiswa | Program Studi | Buku Dipinjam | Penerbit | Tanggal Peminjaman | Tanggal Jatuh Tempo | Tanggal Pengembalian |
|---|---|---|---|---|---|---|---|
| D121241031 | Tyas | Teknik Informatika | {B001, Basis Data, Rais, 2024}, {B002, Pemrograman Web, Informatika, 2023} | {Rais, Informatika} | {2026-09-01, 2026-09-03} | {2026-09-08, 2026-09-10} | {2026-09-07, -} |
| D121241077 | Yusuf | Teknik Informatika | {B003, Jaringan Komputer, Erlangga, 2022} | {Erlangga} | {2026-09-05} | {2026-09-12} | {2026-09-11} |

Bentuk tersebut belum memenuhi 1NF karena terdapat beberapa nilai dalam satu sel, khususnya pada data buku dan informasi peminjaman. Data mahasiswa dan penerbit juga dapat mengalami pengulangan ketika terdapat lebih dari satu buku atau transaksi.

Masalah pada bentuk UNF:
- Satu mahasiswa dapat memiliki beberapa buku dalam satu record.
- Informasi buku dan penerbit berada dalam kelompok data berulang.
- Informasi tanggal peminjaman dan pengembalian dapat memiliki lebih dari satu nilai.
- Terdapat redundansi data mahasiswa dan penerbit.
- Struktur tersebut dapat menimbulkan anomali saat data ditambahkan, diubah, atau dihapus.

### 5.2 First Normal Form (1NF)
Pada tahap 1NF, kelompok data berulang pada bentuk UNF diuraikan menjadi baris-baris terpisah. Setiap sel hanya berisi satu nilai atomik sehingga satu baris mewakili satu transaksi peminjaman untuk satu buku.

Contoh bentuk 1NF:
| ID Peminjaman | NIM | Nama Mahasiswa | Program Studi | ID Buku | Judul Buku | Nama Penerbit | Tahun Terbit | Tanggal Peminjaman | Tanggal Jatuh Tempo | Tanggal Pengembalian |
|---|---|---|---|---|---|---|---|---|---|---|
| P001 | D121241031 | Tyas | Teknik Informatika | B001 | Basis Data | Rais | 2024 | 2026-09-01 | 2026-09-08 | 2026-09-07 |
| P002 | D121241031 | Tyas | Teknik Informatika | B002 | Pemrograman Web | Informatika | 2023 | 2026-09-03 | 2026-09-10 | - |
| P003 | D121241077 | Yusuf | Teknik Informatika | B003 | Jaringan Komputer | Erlangga | 2022 | 2026-09-05 | 2026-09-12 | 2026-09-11 |

Pada bentuk ini, setiap kolom hanya memiliki satu nilai dan tidak terdapat kelompok data berulang dalam satu sel. Namun, masih terdapat redundansi data. Data mahasiswa 'Tyas' ditulis berulang untuk setiap buku yang dipinjam, dan informasi penerbit serta buku juga dapat muncul kembali pada transaksi yang berbeda.

Untuk tahap normalisasi, `ID Peminjaman` dan `ID Buku` dapat digunakan sebagai kunci komposit pada contoh 1NF. Pada tahap 2NF, akan dianalisis ketergantungan setiap atribut terhadap bagian dari kunci komposit tersebut sehingga atribut yang hanya bergantung pada `ID Peminjaman` atau `ID Buku` dapat dipisahkan.

### 5.3 Second Normal Form (2NF)

### 5.4 Third Normal Form (3NF)

## 6. Rancangan Tabel Akhir

## 7. Visualisasi Relasi

## 8. Kesimpulan