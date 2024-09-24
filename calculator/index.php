<?php
session_start();


$operations = [
    'plus'  => fn($a, $b) => $a + $b,
    'minus' => fn($a, $b) => $a - $b,
    'mul'   => fn($a, $b) => $a * $b,
    'div'   => fn($a, $b) => ($b != 0) ? $a / $b : "Error: Division by zero"
];


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

function clearHistory() {

    unset($_SESSION['history']);
    unset($_SESSION['cache']);
}


$result = 0;
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
        button {
            background-color: red;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: darkred;
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
    <h2>Calculator with History</h2>
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

    <!-- Clear History Button -->
    <form method="POST">
        <input type="hidden" name="clear_history" value="1">
        <button type="submit">Clear History</button>
    </form>

    <!-- Display Calculation History -->
    <div class="history">
        <h3>Calculation History</h3>
        <ul>
            <?php
            
            ob_start();
            if (!empty($_SESSION['history'])) {
                foreach ($_SESSION['history'] as $calc) {
                    echo "<li>" . htmlspecialchars($calc) . "</li>";
                }
            } else {
                echo "<li>No history available.</li>";
            }
            ob_end_flush();
            ?>
        </ul>
    </div>
</body>
</html>
