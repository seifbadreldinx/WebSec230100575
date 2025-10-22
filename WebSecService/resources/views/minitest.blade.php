<!DOCTYPE html>
<html>
<head>
    <title>MiniTest - Supermarket Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container">
        <h2 class="mb-4 text-center">Supermarket Bill</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <p><strong>Customer:</strong> {{ $bill['customer'] }}</p>
                <p><strong>Date:</strong> {{ $bill['date'] }}</p>

                <table class="table table-bordered table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price (EGP)</th>
                            <th>Total (EGP)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bill['items'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>{{ number_format($item['price'], 2) }}</td>
                            <td>{{ number_format($item['qty'] * $item['price'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @php
                    $total = collect($bill['items'])->sum(fn($i) => $i['qty'] * $i['price']);
                @endphp

                <h5 class="text-end mt-3">Total Amount: <strong>{{ number_format($total, 2) }} EGP</strong></h5>
            </div>
        </div>
    </div>
</body>
</html>
