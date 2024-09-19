<?php
session_start(); // Mulai sesi

// Inisialisasi variabel dengan nama yang tidak bermakna
$a = 0;

// Fungsi encode base64 untuk output
function obf($str) {
    return base64_decode($str);
}

// Cek jika form dikirimkan
if ($_SERVER["REQUEST_METHOD"] === obf("UE9TVA==")) {
    $b = $_POST[obf("YW5na2Ex")] ?? null;
    $c = $_POST[obf("YW5na2Ey")] ?? null;
    $d = $_POST[obf("b3BlcmF0b3I=")] ?? null;

    if (is_numeric($b) && is_numeric($c)) {
        switch ($d) {
            case obf("cGx1cw=="):
                $a = $b + $c;
                break;
            case obf("bWludXM="):
                $a = $b - $c;
                break;
            case obf("bXVs"):
                $a = $b * $c;
                break;
            case obf("ZGl2"):
                $a = ($c != 0) ? $b / $c : obf("RXJyb3I6IERpdmlzaW9uIGJ5IHplcm8=");
                break;
            default:
                $a = obf("SW52YWxpZCBvcGVyYXRvcg==");
        }

        $_SESSION[obf("aGlzdG9yeQ==")][] = "$b $d $c = $a";
    } else {
        $a = obf("RXJyb3I6IFBsZWFzZSBlbnRlciB2YWxpZCBudW1iZXJzLg==");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= obf("Q2FsY3VsYXRvciBXaXRoIEhpZGVuIEhpc3Rvcnk=") ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form, .history { margin-bottom: 20px; }
        input[type="text"], select, input[type="submit"] { padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc; }
        ul { list-style-type: none; padding: 0; }
        ul li { background: #f9f9f9; margin: 5px 0; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h2><?= obf("Q2FsY3VsYXRvciBXaXRoIEhpZGVuIEhpc3Rvcnk=") ?></h2>
    <form method="POST">
        <input type="text" name="<?= obf("YW5na2Ex") ?>" placeholder="<?= obf("QW5na2EgMQ==") ?>" required />
        <select name="<?= obf("b3BlcmF0b3I=") ?>">
            <option value="<?= obf("cGx1cw==") ?>">+</option>
            <option value="<?= obf("bWludXM=") ?>">-</option>
            <option value="<?= obf("bXVs") ?>">x</option>
            <option value="<?= obf("ZGl2") ?>">/</option>
        </select>
        <input type="text" name="<?= obf("YW5na2Ey") ?>" placeholder="<?= obf("QW5na2EgMg==") ?>" required />
        <input type="text" value="<?= htmlspecialchars($a) ?>" readonly />
        <input type="submit" value="<?= obf("Q2FsY3VsYXRl") ?>" />
    </form>

    <div class="history">
        <h3><?= obf("SGlzdG9yeQ==") ?></h3>
        <ul>
            <?php
            if (!empty($_SESSION[obf("aGlzdG9yeQ==")])) {
                foreach ($_SESSION[obf("aGlzdG9yeQ==")] as $calc) {
                    echo "<li>" . htmlspecialchars($calc) . "</li>";
                }
            } else {
                echo "<li>" . obf("Tm8gaGlzdG9yeSBhdmFpbGFibGUu") . "</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
