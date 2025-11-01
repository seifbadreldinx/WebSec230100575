<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container-fluid mt-4">

    <div class="row mb-3">
        <div class="col-md-6">
            <h2>MCQ Exam</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Back to Questions</a>
        </div>
    </div>

    @if($questions->count())
    <form action="{{ route('questions.submit') }}" method="POST">
        @csrf
        <div class="card shadow-sm">
            <div class="card-body">
                @foreach($questions as $index => $q)
                <div class="mb-4 p-3 border rounded">
                    <h5>Q{{ $index + 1 }}: {{ $q->question }}</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question_{{ $q->id }}" id="q{{ $q->id }}a" value="A" required>
                        <label class="form-check-label" for="q{{ $q->id }}a">A: {{ $q->option_a }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question_{{ $q->id }}" id="q{{ $q->id }}b" value="B" required>
                        <label class="form-check-label" for="q{{ $q->id }}b">B: {{ $q->option_b }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question_{{ $q->id }}" id="q{{ $q->id }}c" value="C" required>
                        <label class="form-check-label" for="q{{ $q->id }}c">C: {{ $q->option_c }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question_{{ $q->id }}" id="q{{ $q->id }}d" value="D" required>
                        <label class="form-check-label" for="q{{ $q->id }}d">D: {{ $q->option_d }}</label>
                    </div>
                </div>
                @endforeach
                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg">Submit Exam</button>
                </div>
            </div>
        </div>
    </form>
    @else
    <div class="alert alert-info">
        No questions available for the exam.
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
