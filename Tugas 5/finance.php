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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postToken = $_POST['csrf_token'] ?? '';

    if (
        !is_string($postToken) ||
        !hash_equals($_SESSION['csrf_token'], $postToken)
    ) {
        die('Kesalahan Keamanan: Token CSRF tidak cocok.');
    }

    $type = $_POST['type'] ?? '';
    $amount = $_POST['amount'] ?? '';

    if (!is_string($type) || !in_array($type, ['deposit', 'withdraw'], true)) {
        die('Jenis transaksi tidak valid.');
    }

    if (
        !is_string($amount) ||
        !preg_match('/^\d+(\.\d+)?$/', $amount) ||
        (float) $amount <= 0
    ) {
        die('Nominal harus berupa angka desimal positif.');
    }

    $amount = (float) $amount;

    $transaction = new Transaction(
        bin2hex(random_bytes(8)),
        $type,
        $amount
    );

    if ($transaction->process()) {
        $_SESSION['transactions'][] = [
            'id' => $transaction->getId(),
            'type' => $transaction->getType(),
            'amount' => $transaction->getAmount(),
            'date' => date('Y-m-d H:i:s'),
        ];

        $message = 'Transaksi berhasil diproses.';
    } else {
        $message = 'Saldo tidak mencukupi untuk melakukan penarikan.';
    }
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

    <h2>Saldo Saat Ini</h2>
    <p>Rp <?= number_format($_SESSION['balance'], 2, ',', '.') ?></p>

    <?php if (isset($message)): ?>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <h2>Riwayat Transaksi</h2>

    <?php if (empty($_SESSION['transactions'])): ?>
        <p>Belum ada transaksi.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['transactions'] as $transaction): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($transaction['id'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($transaction['type'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td>
                            Rp <?= number_format($transaction['amount'], 2, ',', '.') ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($transaction['date'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

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