<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA Simulator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <h1 class="text-center mb-4">🎓 GPA Simulator</h1>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Credit Hours</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $course['code'] }}</td>
                    <td>{{ $course['title'] }}</td>
                    <td>{{ $course['credits'] }}</td>
                    <td>
                        <select class="form-select grade" onchange="calculateGPA()">
                            <option value="">Select</option>
                            <option value="4">A</option>
                            <option value="3.7">A-</option>
                            <option value="3.3">B+</option>
                            <option value="3">B</option>
                            <option value="2.7">B-</option>
                            <option value="2.3">C+</option>
                            <option value="2">C</option>
                            <option value="1.7">C-</option>
                            <option value="1">D</option>
                            <option value="0">F</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-4">
        <h4>Your GPA: <span id="gpaResult">0.00</span></h4>
    </div>
</div>

<script>
function calculateGPA() {
    const rows = document.querySelectorAll("tbody tr");
    let totalPoints = 0;
    let totalCredits = 0;

    rows.forEach(row => {
        const grade = parseFloat(row.querySelector(".grade").value);
        const credits = parseFloat(row.children[2].textContent);

        if (!isNaN(grade)) {
            totalPoints += grade * credits;
            totalCredits += credits;
        }
    });

    const gpa = totalCredits > 0 ? (totalPoints / totalCredits).toFixed(2) : "0.00";
    document.getElementById("gpaResult").textContent = gpa;
}
</script>

</body>
</html>
