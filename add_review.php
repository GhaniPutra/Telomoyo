<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengguna = isset($_POST['anonim']) && $_POST['anonim'] == '1' ? 'Anonim' : htmlspecialchars(trim($_POST['nama_pengguna']), ENT_QUOTES, 'UTF-8');
    $komentar = htmlspecialchars(trim($_POST['komentar']), ENT_QUOTES, 'UTF-8');

    if (!empty($komentar)) {
        $sql = "INSERT INTO review (nama_pengguna, komentar) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nama_pengguna, $komentar);

        if ($stmt->execute()) {
            header("Location: index.html");
            exit();
        } else {
            error_log("Error: " . $stmt->error);
            echo "<p style='color: red;'>Terjadi kesalahan saat menyimpan data. Silakan coba lagi.</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Semua kolom wajib diisi!</p>";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gunung Berapi Tidak Aktif dan Aman</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="fakta\fakta.css">
</head>

<body>
    <div class="container">
        <div class="image-section" data-aos="fade-right">
            <img src="img\fakta_1.jpg"
                alt="Aerial view of a green mountain with a winding road and buildings on top, surrounded by clouds."
                width="450" height="600">
        </div>
        <div class="content-section" data-aos="fade-left">
            <h1>Tambah Review</h1>
            <form method="post" action="">
                Nama: <input type="text" name="nama_pengguna" required><br>
                Komentar: <textarea name="komentar" required></textarea><br>
                <input type="checkbox" name="anonim" value="1" id="anonim-checkbox">
                <label for="anonim-checkbox">Kirim sebagai anonim silakan klik totek kecil itu</label>
                <div class="button-container">
                    <button class="button-submit" type="submit">Kirim Review</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>