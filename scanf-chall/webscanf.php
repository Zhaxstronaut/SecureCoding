<?php
function custom_scanf($input) {
   
    if (preg_match('/([^\s]+)/', $input, $matches)) {
        $str = $matches[1];  
        return [$str];
    }
    return [null];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $i = isset($_POST['input']) ? trim($_POST['input']) : '';
    if (!$i) {
        echo "No input received.";
    } else {
        list($s) = custom_scanf($i);
        echo "You entered: $s";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Input</title>
</head>
<body>
    <form method="post" action="">
        <label for="input">Enter a string:</label>
        <input type="text" id="input" name="input" required autofocus>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
