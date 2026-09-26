<?php

declare(strict_types=1);

require_once './Transaction.php';

session_start();

if (!isset($_SESSION['balance'])) {
    $_SESSION['balance'] = 0.0;
}

if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Keuangan</title>
</head>
<body>
    <h1>Sistem Manajemen Keuangan Sederhana</h1>

    <form method="POST">
        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
        >

        <label for="type">Jenis Transaksi:</label>
        <select name="type" id="type" required>
            <option value="">-- Pilih Transaksi --</option>
            <option value="deposit">Deposit</option>
            <option value="withdraw">Withdraw</option>
        </select>

        <br><br>

        <label for="amount">Nominal:</label>
        <input
            type="number"
            name="amount"
            id="amount"
            min="0.01"
            step="0.01"
            placeholder="Masukkan nominal"
            required
        >

        <br><br>

        <button type="submit">Proses Transaksi</button>
    </form>
</body>
</html>