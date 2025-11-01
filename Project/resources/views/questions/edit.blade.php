<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container-fluid mt-4">

    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Edit Question</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Back to Questions</a>
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
            <form action="{{ route('questions.update', $question) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <input type="text" name="question" id="question" class="form-control" value="{{ old('question', $question->question) }}" required>
                </div>
                <div class="mb-3">
                    <label for="option_a" class="form-label">Option A</label>
                    <input type="text" name="option_a" id="option_a" class="form-control" value="{{ old('option_a', $question->option_a) }}" required>
                </div>
                <div class="mb-3">
                    <label for="option_b" class="form-label">Option B</label>
                    <input type="text" name="option_b" id="option_b" class="form-control" value="{{ old('option_b', $question->option_b) }}" required>
                </div>
                <div class="mb-3">
                    <label for="option_c" class="form-label">Option C</label>
                    <input type="text" name="option_c" id="option_c" class="form-control" value="{{ old('option_c', $question->option_c) }}" required>
                </div>
                <div class="mb-3">
                    <label for="option_d" class="form-label">Option D</label>
                    <input type="text" name="option_d" id="option_d" class="form-control" value="{{ old('option_d', $question->option_d) }}" required>
                </div>
                <div class="mb-3">
                    <label for="correct_option" class="form-label">Correct Option</label>
                    <select name="correct_option" id="correct_option" class="form-select" required>
                        <option value="">Select Correct Option</option>
                        <option value="A" {{ old('correct_option', $question->correct_option) == 'A' ? 'selected' : '' }}>Option A</option>
                        <option value="B" {{ old('correct_option', $question->correct_option) == 'B' ? 'selected' : '' }}>Option B</option>
                        <option value="C" {{ old('correct_option', $question->correct_option) == 'C' ? 'selected' : '' }}>Option C</option>
                        <option value="D" {{ old('correct_option', $question->correct_option) == 'D' ? 'selected' : '' }}>Option D</option>
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Question</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
