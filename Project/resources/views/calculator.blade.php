<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function calculate(op) {
            let num1 = parseFloat(document.getElementById("num1").value);
            let num2 = parseFloat(document.getElementById("num2").value);
            let result = 0;

            if (isNaN(num1) || isNaN(num2)) {
                alert("Please enter valid numbers!");
                return;
            }

            switch(op) {
                case '+': result = num1 + num2; break;
                case '-': result = num1 - num2; break;
                case '*': result = num1 * num2; break;
                case '/': result = num2 !== 0 ? num1 / num2 : 'Infinity'; break;
            }

            document.getElementById("result").value = result;
        }
    </script>
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg p-4" style="width: 22rem;">
        <h4 class="text-center mb-3 text-primary">Simple Calculator</h4>
        <input type="number" id="num1" class="form-control mb-2" placeholder="Enter first number">
        <input type="number" id="num2" class="form-control mb-3" placeholder="Enter second number">

        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-outline-primary" onclick="calculate('+')">+</button>
            <button class="btn btn-outline-primary" onclick="calculate('-')">-</button>
            <button class="btn btn-outline-primary" onclick="calculate('*')">*</button>
            <button class="btn btn-outline-primary" onclick="calculate('/')">/</button>
        </div>

        <input type="text" id="result" class="form-control text-center" placeholder="Result" readonly>
    </div>
</body>
</html>

