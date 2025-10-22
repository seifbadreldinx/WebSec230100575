<!DOCTYPE html>
<html>
<head>
    <title>Simple Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4 text-primary">Simple Calculator</h2>

        <div class="row mb-3">
            <div class="col">
                <input type="number" id="num1" class="form-control" placeholder="Enter first number">
            </div>
            <div class="col">
                <input type="number" id="num2" class="form-control" placeholder="Enter second number">
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2 mb-3">
            <button class="btn btn-primary" onclick="calculate('+')">+</button>
            <button class="btn btn-success" onclick="calculate('-')">−</button>
            <button class="btn btn-warning" onclick="calculate('*')">×</button>
            <button class="btn btn-danger" onclick="calculate('/')">÷</button>
        </div>

        <div class="text-center">
            <h4 class="text-dark">Result: <span id="result" class="text-success fw-bold"></span></h4>
        </div>
    </div>
</div>

<script>
function calculate(operator) {
    let n1 = parseFloat(document.getElementById("num1").value);
    let n2 = parseFloat(document.getElementById("num2").value);
    let result = "";

    if (isNaN(n1) || isNaN(n2)) {
        result = "Please enter both numbers!";
    } else {
        switch (operator) {
            case '+': result = n1 + n2; break;
            case '-': result = n1 - n2; break;
            case '*': result = n1 * n2; break;
            case '/': result = n2 !== 0 ? (n1 / n2).toFixed(2) : "Cannot divide by 0"; break;
        }
    }

    document.getElementById("result").innerText = result;
}
</script>

</body>
</html>
