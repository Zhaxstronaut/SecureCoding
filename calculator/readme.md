Kalkulator dengan Riwayat
Ini adalah program kalkulator sederhana berbasis PHP yang bisa melakukan operasi aritmatika dasar (penjumlahan, pengurangan, perkalian, dan pembagian). Selain itu, program ini juga menyimpan riwayat perhitungan selama sesi berlangsung dan menyediakan tombol untuk menghapus riwayat tersebut.

Fitur
Melakukan operasi aritmatika dasar: penjumlahan (+), pengurangan (-), perkalian (x), dan pembagian (/).
Menyimpan hasil perhitungan dalam cache untuk mempercepat jika perhitungan yang sama dilakukan lagi.
Menyimpan riwayat perhitungan dalam sesi.
Tombol untuk menghapus riwayat perhitungan.
Cara Kerja Program
1. Session Start
Program dimulai dengan memanggil session_start(). Ini membuat data seperti hasil perhitungan dan riwayat tetap ada selama pengguna masih menggunakan program (sesi belum berakhir).

php
Salin kode
session_start();
2. Operasi Aritmatika
Operasi dasar disimpan dalam array $operations yang berisi fungsi anonim (lambda). Setiap fungsi bertugas untuk melakukan perhitungan sesuai dengan operator yang dipilih (penjumlahan, pengurangan, dll).

php
Salin kode
$operations = [
    'plus'  => fn($a, $b) => $a + $b,
    'minus' => fn($a, $b) => $a - $b,
    'mul'   => fn($a, $b) => $a * $b,
    'div'   => fn($a, $b) => ($b != 0) ? $a / $b : "Error: Division by zero"
];
3. Fungsi calculate()
Fungsi calculate() bertugas menghitung dua angka berdasarkan operator yang dipilih. Sebelum menghitung, program mengecek apakah hasil perhitungan yang sama sudah pernah dihitung sebelumnya. Jika sudah, hasilnya diambil dari cache untuk mempercepat proses. Jika belum, hasilnya dihitung dan disimpan dalam cache.

php
Salin kode
function calculate($angka1, $angka2, $operator, $operations) {
    $cacheKey = md5("$angka1-$operator-$angka2");

    if (isset($_SESSION['cache'][$cacheKey])) {
        return $_SESSION['cache'][$cacheKey];
    }

    if (!array_key_exists($operator, $operations)) {
        return "Invalid operator";
    }

    $result = $operations[$operator]($angka1, $angka2);
    $_SESSION['cache'][$cacheKey] = $result;

    return $result;
}
4. Fungsi clearHistory()
Fungsi ini digunakan untuk menghapus riwayat perhitungan dan cache dari sesi.

php
Salin kode
function clearHistory() {
    unset($_SESSION['history']);
    unset($_SESSION['cache']);
}
5. Logika Utama
Saat pengguna mengirim data dari form (menggunakan metode POST), angka pertama ($angka1), angka kedua ($angka2), dan operator ($operator) diambil dari input. Jika data valid, hasil perhitungan ditampilkan dan disimpan dalam riwayat sesi. Jika pengguna menekan tombol "Clear History", riwayat dan cache akan dihapus.

php
Salin kode
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['clear_history'])) {
        clearHistory();
    } else {
        $angka1 = filter_input(INPUT_POST, 'angka1', FILTER_VALIDATE_FLOAT);
        $angka2 = filter_input(INPUT_POST, 'angka2', FILTER_VALIDATE_FLOAT);
        $operator = $_POST['operator'] ?? null;

        if ($angka1 !== false && $angka2 !== false && $operator) {
            $result = calculate($angka1, $angka2, $operator, $operations);
            $calculation = "$angka1 $operator $angka2 = $result";

            if (!isset($_SESSION['history']) || !in_array($calculation, $_SESSION['history'])) {
                $_SESSION['history'][] = $calculation;
            }
        } else {
            $result = "Error: Please enter valid numbers.";
        }
    }
}
6. Menampilkan Riwayat Perhitungan
Setelah perhitungan selesai, hasilnya disimpan dalam sesi dan ditampilkan dalam bentuk daftar.

php
Salin kode
<div class="history">
    <h3>Calculation History</h3>
    <ul>
        <?php
        if (!empty($_SESSION['history'])) {
            foreach ($_SESSION['history'] as $calc) {
                echo "<li>" . htmlspecialchars($calc) . "</li>";
            }
        } else {
            echo "<li>No history available.</li>";
        }
        ?>
    </ul>
</div>
Jika riwayat kosong, akan muncul pesan "No history available".

7. Menghapus Riwayat
Terdapat tombol untuk menghapus riwayat perhitungan. Jika tombol ini diklik, riwayat dan cache akan dihapus.

html
Salin kode
<form method="POST">
    <input type="hidden" name="clear_history" value="1">
    <button type="submit">Clear History</button>
</form>
Tampilan
Program ini menggunakan CSS sederhana untuk membuat tampilan lebih rapi dan mudah dibaca.

css
Salin kode
body {
    font-family: Arial, sans-serif;
    margin: 40px;
}
input[type="text"], select, input[type="submit"] {
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}
button {
    background-color: red;
    color: white;
    border: none;
    padding: 10px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 5px;
}
ul {
    list-style-type: none;
    padding: 0;
}
ul li {
    background: #f9f9f9;
    margin: 5px 0;
    padding: 10px;
    border-radius: 5px;
}
Kesimpulan
Kalkulator ini memungkinkan pengguna untuk melakukan perhitungan sederhana dengan fitur tambahan seperti riwayat perhitungan yang bisa dihapus. Semua riwayat dan cache disimpan dalam sesi, sehingga tetap ada selama sesi belum diakhiri atau dihapus oleh pengguna.







