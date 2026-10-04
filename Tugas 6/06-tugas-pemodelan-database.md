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

### 5.2 First Normal Form (1NF)

### 5.3 Second Normal Form (2NF)

### 5.4 Third Normal Form (3NF)

## 6. Rancangan Tabel Akhir

## 7. Visualisasi Relasi

## 8. Kesimpulan