<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Grade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container-fluid mt-4">

    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Add New Grade</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('grades.index') }}" class="btn btn-secondary">Back to Grades</a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('grades.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="student_name" class="form-label">Student Name</label>
                    <input type="text" name="student_name" id="student_name" class="form-control" value="{{ old('student_name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="course_code" class="form-label">Course Code</label>
                    <input type="text" name="course_code" id="course_code" class="form-control" value="{{ old('course_code') }}" required>
                </div>
                <div class="mb-3">
                    <label for="course_title" class="form-label">Course Title</label>
                    <input type="text" name="course_title" id="course_title" class="form-control" value="{{ old('course_title') }}" required>
                </div>
                <div class="mb-3">
                    <label for="term" class="form-label">Term</label>
                    <select name="term" id="term" class="form-control" required>
                        @foreach($terms as $t)
                            <option value="{{ $t }}" {{ old('term')==$t?'selected':'' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="credit_hours" class="form-label">Credit Hours</label>
                    <input type="number" name="credit_hours" id="credit_hours" class="form-control" value="{{ old('credit_hours') }}" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="grade" class="form-label">Grade</label>
                    <select name="grade" id="grade" class="form-control" required>
                        @foreach($grades as $g)
                            <option value="{{ $g }}" {{ old('grade')==$g?'selected':'' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Add Grade</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
