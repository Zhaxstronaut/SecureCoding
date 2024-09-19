<?php
session_start();  


$result = 0;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve inputs
    $angka1 = $_POST['angka1'] ?? null;
    $angka2 = $_POST['angka2'] ?? null;
    $operator = $_POST['operator'] ?? null;

    
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
            default:
                $result = "Invalid operator";
        }

       
        $_SESSION['history'][] = "$angka1 $operator $angka2 = $result";
    } else {
        $result = "Error: Please enter valid numbers.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator with History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        form, .history {
            margin-bottom: 20px;
        }
        input[type="text"], select, input[type="submit"] {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
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
    </style>
</head>
<body>
    <h2>Calculator History</h2>
    <form method="POST">
        <input type="text" name="angka1" placeholder="Angka 1" required />
        <select name="operator">
            <option value="plus">+</option>
            <option value="minus">-</option>
            <option value="mul">x</option>
            <option value="div">/</option>
        </select>
        <input type="text" name="angka2" placeholder="Angka 2" required />
        <input type="text" value="<?= htmlspecialchars($result) ?>" readonly />
        <input type="submit" value="Calculate" />
    </form>

    <!-- Display Calculation History -->
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
</body>
</html>
