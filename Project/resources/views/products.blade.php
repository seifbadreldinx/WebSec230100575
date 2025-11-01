<!DOCTYPE html>
<html>
<head>
    <title>Product Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="text-center mb-4">Product Catalog</h1>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <img src="{{ asset('images/' . $product['image']) }}" class="card-img-top" alt="{{ $product['name'] }}" style="height:220px;object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text text-muted">{{ $product['description'] }}</p>
                    <p class="fw-bold text-success">EGP {{ $product['price'] }}</p>
                    <button class="btn btn-primary w-100">Add to Cart</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>
