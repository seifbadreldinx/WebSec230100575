<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container-fluid mt-4">

    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Exam Result</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('questions.startExam') }}" class="btn btn-secondary me-2">Retake Exam</a>
            <a href="{{ route('questions.index') }}" class="btn btn-primary">Return to Questions</a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Total Questions:</strong> {{ $total }}</p>
            <p><strong>Correct Answers:</strong> {{ $score }}</p>
            <p><strong>Your Score:</strong> {{ round(($score / $total) * 100) }}%</p>
        </div>
    </div>

    <h4>Question Details</h4>
    @foreach($questions as $index => $q)
        @php
            $userAnswer = $userAnswers[$q->id] ?? null;
            $isCorrect = $userAnswer === $q->correct_option;
        @endphp
        <div class="card mb-3 {{ $isCorrect ? 'border-success' : 'border-danger' }}">
            <div class="card-body">
                <h5>Q{{ $index + 1 }}: {{ $q->question }}</h5>
                <ul class="list-unstyled mb-0">
                    <li>A: {{ $q->option_a }} {{ $userAnswer === 'A' ? '← Your answer' : '' }} {{ $q->correct_option === 'A' ? '✔ Correct' : '' }}</li>
                    <li>B: {{ $q->option_b }} {{ $userAnswer === 'B' ? '← Your answer' : '' }} {{ $q->correct_option === 'B' ? '✔ Correct' : '' }}</li>
                    <li>C: {{ $q->option_c }} {{ $userAnswer === 'C' ? '← Your answer' : '' }} {{ $q->correct_option === 'C' ? '✔ Correct' : '' }}</li>
                    <li>D: {{ $q->option_d }} {{ $userAnswer === 'D' ? '← Your answer' : '' }} {{ $q->correct_option === 'D' ? '✔ Correct' : '' }}</li>
                </ul>
            </div>
        </div>
    @endforeach

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
