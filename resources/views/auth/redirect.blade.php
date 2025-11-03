<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
    <meta http-equiv="refresh" content="0;url={{ $url }}">
</head>
<body>
    <p>Redirecting...</p>
    <script>
        window.location.href = "{{ $url }}";
    </script>
</body>
</html>
