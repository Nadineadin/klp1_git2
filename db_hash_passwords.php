<?php
// db_hash_passwords.php
// Jalankan via CLI: php db_hash_passwords.php
// Pastikan PHP CLI tersedia dan file ini tidak dapat diakses publik.

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'klp1';
$DB_PORT = 3306;

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
if ($mysqli->connect_errno) {
    fwrite(STDERR, "Gagal konek ke DB: {$mysqli->connect_error}\n");
    exit(1);
}
$mysqli->set_charset('utf8mb4');

function is_hashed($hash) {
    if ($hash === null || $hash === '') return false;
    // Periksa prefix hash umum
    $prefixes = ['$2y$', '$2b$', '$2a$', '$argon2i$', '$argon2id$'];
    foreach ($prefixes as $p) {
        if (strpos($hash, $p) === 0) return true;
    }
    return false;
}

// Pilih algoritma yang tersedia: prefer argon2id jika ada, fallback bcrypt
if (defined('PASSWORD_ARGON2ID')) {
    $algo = PASSWORD_ARGON2ID;
    $algo_name = 'argon2id';
    $options = []; // bisa set memory/cost/threads jika perlu
} else {
    $algo = PASSWORD_BCRYPT;
    $algo_name = 'bcrypt';
    $options = ['cost' => 12];
}

echo "Menggunakan algoritma hashing: $algo_name\n";

// Ambil semua user
$sql = "SELECT id, nim, password FROM `user`";
$result = $mysqli->query($sql);
if (!$result) {
    fwrite(STDERR, "Query gagal: {$mysqli->error}\n");
    exit(1);
}

$cntTotal = 0;
$cntHashed = 0;
$cntSkipped = 0;
$cntFailed = 0;

$mysqli->begin_transaction();

$updateStmt = $mysqli->prepare("UPDATE `user` SET `password` = ? WHERE id = ?");
if (!$updateStmt) {
    fwrite(STDERR, "Prepare update gagal: {$mysqli->error}\n");
    $mysqli->rollback();
    exit(1);
}

while ($row = $result->fetch_assoc()) {
    $cntTotal++;
    $id = $row['id'];
    $nim = $row['nim'];
    $pw = $row['password'];

    if (is_hashed($pw)) {
        $cntSkipped++;
        continue;
    }

    if ($pw === null || $pw === '') {
        // tidak ada password -- skip
        $cntSkipped++;
        continue;
    }

    // Hash sekarang
    $newHash = password_hash($pw, $algo, $options);
    if ($newHash === false) {
        fwrite(STDERR, "Gagal hash untuk id=$id nim=$nim\n");
        $cntFailed++;
        continue;
    }

    $updateStmt->bind_param('si', $newHash, $id);
    if (!$updateStmt->execute()) {
        fwrite(STDERR, "Gagal update id=$id nim=$nim : {$updateStmt->error}\n");
        $cntFailed++;
        continue;
    }

    $cntHashed++;
    echo "Hashed id=$id nim=$nim\n";
}

$mysqli->commit();

echo "\nSelesai.\n";
echo "Total rows: $cntTotal\n";
echo "Hashed now: $cntHashed\n";
echo "Already hashed/skipped: $cntSkipped\n";
echo "Failed: $cntFailed\n";

$updateStmt->close();
$mysqli->close();
