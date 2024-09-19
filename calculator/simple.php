<?php
session_start();  // Start session to track calculation history

$result = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $angka1 = $_POST['angka1'];
    $angka2 = $_POST['angka2'];
    $operator = $_POST['operator'];

    if (is_numeric($angka1) && is_numeric($angka2)) {
        switch ($operator) {
            case "plus":
                $result = $angka1 + $angka2;
                break;
            case "minus":
                $result = $angka1 - $angka2;
                break;
            case "mul":
                $result = $angka1 * $angka2;
                break;
            case "div":
                $result = ($angka2 != 0) ? $angka1 / $angka2 : "Error: Division by zero";
                break;
        }

        $_SESSION['history'][] = "$angka1 $operator $angka2 = $result";
    } else {
        $result = "Error: Invalid input";
    }
}
?>

<html>
    <form method="POST">
        <input type="text" name="angka1" required />
        <select name="operator">
            <option value="plus">+</option>
            <option value="minus">-</option>
            <option value="mul">x</option>
            <option value="div">/</option>
        </select>
        <input type="text" name="angka2" required />
        <input type="text" value="<?= htmlspecialchars($result) ?>" readonly />
        <input type="submit" value="Calculate" />
    </form>

    <h3>History</h3>
    <ul>
        <?php
        if (!empty($_SESSION['history'])) {
            foreach ($_SESSION['history'] as $calc) {
                echo "<li>" . htmlspecialchars($calc) . "</li>";
            }
        }
        ?>
    </ul>
</html>
