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
| Atribut | Keterangan | Kunci |
|---|---|---|
| nim | Nomor induk mahasiswa | PK |
| nama_mahasiswa | Nama lengkap mahasiswa | - |
| program_studi | Program studi mahasiswa | - |
| email | Alamat email mahasiswa | - |

### 3.2 Buku
| Atribut | Keterangan | Kunci |
|---|---|---|
| id_buku | Identitas unik buku | PK |
| judul_buku | Judul buku | - |
| isbn | Nomor ISBN buku | - |
| tahun_terbit | Tahun buku diterbitkan | - |
| id_penerbit | Identitas penerbit buku | FK |

### 3.3 Penerbit
| Atribut | Keterangan | Kunci |
|---|---|---|
| id_penerbit | Identitas unik penerbit | PK |
| nama_penerbit | Nama penerbit | - |
| alamat_penerbit | Alamat penerbit | - |

### 3.4 Transaksi Peminjaman
| Atribut | Keterangan | Kunci |
|---|---|---|
| id_peminjaman | Identitas unik transaksi peminjaman | PK |
| nim | Nomor mahasiswa yang melakukan peminjaman | FK |
| id_buku | Identitas buku yang dipinjam | FK |
| tanggal_peminjaman | Tanggal buku dipinjam | - |
| tanggal_jatuh_tempo | Batas waktu pengembalian buku | - |
| tanggal_pengembalian | Tanggal buku dikembalikan | - |
| status_peminjaman | Status peminjaman buku | - |

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
Pada tahap 2NF, bentuk 1NF dianalisis untuk menghilangkan ketergantungan parsial. Pada tabel 1NF, kunci komposit terdiri dari `ID Peminjaman` dan `ID Buku`. Namun, beberapa atribut hanya bergantung pada salah satu bagian dari kunci tersebut.

`Nama Mahasiswa`, `Program Studi`, `Tanggal Peminjaman`, `Tanggal Jatuh Tempo`, dan `Tanggal Pengembalian` bergantung pada `ID Peminjaman`, sedangkan `Judul Buku`, `Nama Penerbit`, dan `Tahun Terbit` bergantung pada `ID Buku`. Kondisi tersebut menunjukkan adanya ketergantungan parsial.

Untuk menghilangkan ketergantungan parsial, data dipisahkan menjadi beberapa tabel.

**Tabel Transaksi Peminjaman:**
| ID Peminjaman | NIM | Nama Mahasiswa | Program Studi | Tanggal Peminjaman | Tanggal Jatuh Tempo | Tanggal Pengembalian |
|---|---|---|---|---|---|---|
| P001 | D121241031 | Tyas | Teknik Informatika | 2026-09-01 | 2026-09-08 | 2026-09-07 |
| P002 | D121241031 | Tyas | Teknik Informatika | 2026-09-03 | 2026-09-10 | - |
| P003 | D121241077 | Yusuf | Teknik Informatika | 2026-09-05 | 2026-09-12 | 2026-09-11 |

**Tabel Buku:**
| ID Buku | Judul Buku | Nama Penerbit | Tahun Terbit |
|---|---|---|---|
| B001 | Basis Data | Rais | 2024 |
| B002 | Pemrograman Web | Informatika | 2023 |
| B003 | Jaringan Komputer | Erlangga | 2022 |

Dengan pemisahan tersebut, atribut yang sebelumnya hanya bergantung pada sebagian kunci komposit tidak lagi berada dalam satu tabel. Namun, pada tabel Transaksi Peminjaman masih terdapat ketergantungan antara `NIM` dengan `Nama Mahasiswa` dan `Program Studi`. Pada tahap berikutnya, ketergantungan tersebut akan dihilangkan pada bentuk 3NF.

### 5.4 Third Normal Form (3NF)
Pada tahap 3NF, ketergantungan transitif pada bentuk 2NF dihilangkan. Ketergantungan transitif terjadi ketika atribut non-kunci bergantung pada atribut non-kunci lainnya.

Pada tabel Transaksi Peminjaman, terdapat hubungan `ID Peminjaman` -> `NIM` -> `Nama Mahasiswa` dan `Program Studi`. Oleh karena itu, informasi mahasiswa dipisahkan ke dalam tabel Mahasiswa.

Pada tabel Buku, terdapat hubungan `ID Buku` -> `ID Penerbit` -> `Nama Penerbit`. Oleh karena itu, informasi penerbit dipisahkan ke dalam tabel Penerbit.

Hasil pemisahan pada bentuk 3NF:

**Tabel Mahasiswa:**
| NIM | Nama Mahasiswa | Program Studi | Email |
|---|---|---|---|
| D121241031 | Tyas | Teknik Informatika | tyas@gmail.com |
| D121241077 | Yusuf | Teknik Informatika | yusuf@gmail.com |

**Tabel Penerbit:**
| ID Penerbit | Nama Penerbit | Alamat Penerbit |
|---|---|---|
| T001 | Rais | Makassar |
| T002 | Informatika | Jakarta |
| T003 | Erlangga | Jakarta |

**Tabel Buku:**
| ID Buku | Judul Buku | ISBN | Tahun Terbit | ID Penerbit |
|---|---|---|---|---|
| B001 | Basis Data | 978000000001 | 2024 | T001 |
| B002 | Pemrograman Web | 978000000002 | 2023 | T002 |
| B003 | Jaringan Komputer | 978000000003 | 2022 | T003 |

**Tabel Transaksi Peminjaman:**
| ID Peminjaman | NIM | ID Buku | Tanggal Peminjaman | Tanggal Jatuh Tempo | Tanggal Pengembalian |
|---|---|---|---|---|---|
| P001 | D121241031 | B001 | 2026-09-01 | 2026-09-08 | 2026-09-07 |
| P002 | D121241031 | B002 | 2026-09-03 | 2026-09-10 | - |
| P003 | D121241077 | B003 | 2026-09-05 | 2026-09-12 | 2026-09-11 |

Dengan pemisahan tersebut, setiap atribut non-kunci bergantung langsung pada primary key tabelnya. Data mahasiswa, buku, dan penerbit juga tidak perlu diulang pada setiap transaksi peminjaman.

## 6. Rancangan Tabel Akhir
### 6.1 Tabel Mahasiswa
| Kolom | Tipe Data | Kunci | Keterangan |
|---|---|---|---|
| nim | VARCHAR(15) | PK | Nomor induk mahasiswa |
| nama_mahasiswa | VARCHAR(100) | - | Nama lengkap mahasiswa |
| program_studi | VARCHAR(100) | - | Program studi mahasiswa |
| email | VARCHAR(100) | - | Alamat email mahasiswa |

### 6.2 Tabel Penerbit
| Kolom | Tipe Data | Kunci | Keterangan |
|---|---|---|---|
| id_penerbit | VARCHAR(10) | PK | Identitas unik penerbit |
| nama_penerbit | VARCHAR(100) | - | Nama penerbit |
| alamat_penerbit | VARCHAR(255) | - | Alamat penerbit |

### 6.3 Tabel Buku
| Kolom | Tipe Data | Kunci | Keterangan |
|---|---|---|---|
| id_buku | VARCHAR(10) | PK | Identitas unik buku |
| judul_buku | VARCHAR(200) | - | Judul buku |
| isbn | VARCHAR(20) | - | Nomor ISBN buku |
| tahun_terbit | YEAR | - | Tahun buku diterbitkan |
| id_penerbit | VARCHAR(10) | FK | Mengacu pada id_penerbit pada tabel penerbit |

### 6.4 Tabel Transaksi Peminjaman
| Kolom | Tipe Data | Kunci | Keterangan |
|---|---|---|---|
| id_peminjaman | VARCHAR(10) | PK | Identitas unik transaksi peminjaman |
| nim | VARCHAR(15) | FK | Mengacu pada nim pada tabel mahasiswa |
| id_buku | VARCHAR(10) | FK | Mengacu pada id_buku pada tabel buku |
| tanggal_peminjaman | DATE | - | Tanggal buku dipinjam |
| tanggal_jatuh_tempo | DATE | - | Batas waktu pengembalian buku |
| tanggal_pengembalian | DATE | - | Tanggal buku dikembalikan |
| status_peminjaman | VARCHAR(20) | - | Status peminjaman buku |
## 7. Visualisasi Relasi

## 8. Kesimpulan