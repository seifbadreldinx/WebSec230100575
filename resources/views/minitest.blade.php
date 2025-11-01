<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniTest Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Supermarket Bill</h3>
        </div>
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $bill['customer'] }}</p>
            <p><strong>Date:</strong> {{ $bill['date'] }}</p>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price (EGP)</th>
                        <th>Total (EGP)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($bill['items'] as $index => $item)
                        @php $lineTotal = $item['qty'] * $item['price']; $total += $lineTotal; @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>{{ $lineTotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="4" class="text-end">Total Amount</th>
                        <th>{{ $total }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

</body>
</html>
