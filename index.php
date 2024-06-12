<?php
// Validación de datos
function validateInput($data) {
    if (!is_numeric($data)) {
        throw new Exception("Entrada inválida. Solo se permiten números.");
    }
    return floatval($data);
}

// Gestión de errores y registros
function logError($message) {
    error_log($message, 3, 'errors.log');
}

// Protección de datos
function sanitizeOutput($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

$result = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $num1 = validateInput($_POST['num1']);
        $num2 = validateInput($_POST['num2']);
        $operation = $_POST['operation'];
        
        if ($operation == "sum") {
            $result = $num1 + $num2;
        } elseif ($operation == "subtract") {
            $result = $num1 - $num2;
        } else {
            throw new Exception("Operación inválida.");
        }
    } catch (Exception $e) {
        $error = sanitizeOutput($e->getMessage());
        logError($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calculadora</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .calculator {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 25px;
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }
        .form-control, .form-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .result, .error {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
        }
        .result {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>Calculadora</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="num1" class="form-label">Número 1:</label>
                <input type="text" id="num1" name="num1" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="num2" class="form-label">Número 2:</label>
                <input type="text" id="num2" name="num2" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="operation" class="form-label">Operación:</label>
                <select id="operation" name="operation" class="form-select">
                    <option value="sum">Suma</option>
                    <option value="subtract">Resta</option>
                </select>
            </div>
            <button type="submit" class="btn">Calcular</button>
        </form>
        <?php if ($result !== ""): ?>
            <div class="result">Resultado: <?php echo sanitizeOutput($result); ?></div>
        <?php endif; ?>
        <?php if ($error !== ""): ?>
            <div class="error">Error: <?php echo sanitizeOutput($error); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
