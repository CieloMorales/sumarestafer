<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Simple</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .calculator {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
        }
        .calculator h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .calculator input, .calculator select, .calculator button {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .calculator button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .calculator button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="calculator">
    <h1>Calculadora</h1>
    <form method="post" action="">
        <input type="number" name="num1" placeholder="Número 1" required>
        <input type="number" name="num2" placeholder="Número 2" required>
        <select name="operation" required>
            <option value="sum">Suma</option>
            <option value="subtract">Resta</option>
            <option value="multiply">Multiplicación</option>
            <option value="divide">División</option>
        </select>
        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validación de datos
        $num1 = filter_input(INPUT_POST, 'num1', FILTER_VALIDATE_FLOAT);
        $num2 = filter_input(INPUT_POST, 'num2', FILTER_VALIDATE_FLOAT);
        $operation = filter_input(INPUT_POST, 'operation', FILTER_SANITIZE_STRING);

        if ($num1 === false || $num2 === false) {
            echo "<p>Por favor, ingrese números válidos.</p>";
        } else {
            // Gestión de errores y registros
            try {
                $result = 0;
                switch ($operation) {
                    case 'sum':
                        $result = $num1 + $num2;
                        break;
                    case 'subtract':
                        $result = $num1 - $num2;
                        break;
                    case 'multiply':
                        $result = $num1 * $num2;
                        break;
                    case 'divide':
                        if ($num2 == 0) {
                            throw new Exception("División por cero no permitida.");
                        }
                        $result = $num1 / $num2;
                        break;
                    default:
                        throw new Exception("Operación no válida.");
                }
                echo "<p>Resultado: $result</p>";
            } catch (Exception $e) {
                error_log($e->getMessage(), 0); // Registrar el error
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }
        }
    }
    ?>
</div>
</body>
</html>
