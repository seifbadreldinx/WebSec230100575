<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Transcript</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center bg-primary text-white">
            <h2>Student Transcript</h2>
        </div>
        <div class="card-body">
            <p><strong>Student:</strong> {{ $transcript['student'] }}</p>
            <p><strong>ID:</strong> {{ $transcript['id'] }}</p>
            <p><strong>Program:</strong> {{ $transcript['program'] }}</p>

            <table class="table table-bordered mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transcript['courses'] as $course)
                        <tr>
                            <td>{{ $course['code'] }}</td>
                            <td>{{ $course['name'] }}</td>
                            <td>{{ $course['grade'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
