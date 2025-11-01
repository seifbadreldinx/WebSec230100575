<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container-fluid mt-4">

    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Grades List</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('grades.create') }}" class="btn btn-primary">Add New Grade</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($grades->count())
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Student Name</th>
                            <th>Course Code</th>
                            <th>Course Title</th>
                            <th>Term</th>
                            <th>Credit Hours</th>
                            <th>Grade</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                        <tr>
                            <td>{{ $grade->student_name }}</td>
                            <td>{{ $grade->course_code }}</td>
                            <td>{{ $grade->course_title }}</td>
                            <td>{{ $grade->term }}</td>
                            <td>{{ $grade->credit_hours }}</td>
                            <td>{{ $grade->grade }}</td>
                            <td class="text-center">
                                <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5>Term Totals & GPA</h5>
            <ul>
                @foreach($termTotals as $term => $data)
                    <li>{{ $term }} - Total CH: {{ $data['totalCH'] }}, GPA: {{ $data['gpa'] }}</li>
                @endforeach
            </ul>
            <p><strong>Cumulative CH:</strong> {{ array_sum(array_column($termTotals, 'totalCH')) }}</p>
            <p><strong>CGPA:</strong> {{ $cgpa }}</p>
        </div>
    </div>

    @else
    <div class="alert alert-info">
        No grades found.
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
