<!DOCTYPE html>
<html>
<head>
    <title>Student Transcript</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3>Student Transcript</h3>
        </div>
        <div class="card-body">
            <h5><strong>Name:</strong> {{ $student['name'] }}</h5>
            <h6><strong>ID:</strong> {{ $student['id'] }}</h6>
            <h6><strong>Program:</strong> {{ $student['program'] }}</h6>
            <hr>

            <table class="table table-striped table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Course Name</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student['courses'] as $course)
                    <tr class="text-center">
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
