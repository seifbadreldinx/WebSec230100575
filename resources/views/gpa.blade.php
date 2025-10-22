<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA Simulator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">🎓 GPA Simulator</h2>
    <div class="card shadow-lg">
        <div class="card-body">
            <form id="gpaForm">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Course Code</th>
                                <th>Course Title</th>
                                <th>Credit Hours</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody id="coursesTableBody"></tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-success" onclick="calculateGPA()">Calculate GPA</button>
                <h4 class="mt-4 text-center text-primary" id="result"></h4>
            </form>
        </div>
    </div>
</div>

<script>
    // Example data passed from route
    const courses = @json($courses);

    // Display courses
    const tbody = document.getElementById('coursesTableBody');
    courses.forEach(course => {
        tbody.innerHTML += `
            <tr>
                <td>${course.code}</td>
                <td>${course.title}</td>
                <td>${course.credit_hours}</td>
                <td>
                    <input type="number" class="form-control" placeholder="Enter Grade (0-100)" id="grade_${course.code}">
                </td>
            </tr>
        `;
    });

    // Calculate GPA
    function calculateGPA() {
        let totalPoints = 0;
        let totalCredits = 0;

        courses.forEach(course => {
            const grade = parseFloat(document.getElementById(`grade_${course.code}`).value);
            if (!isNaN(grade)) {
                let gpaPoint = 0;
                if (grade >= 90) gpaPoint = 4.0;
                else if (grade >= 80) gpaPoint = 3.0;
                else if (grade >= 70) gpaPoint = 2.0;
                else if (grade >= 60) gpaPoint = 1.0;
                else gpaPoint = 0;

                totalPoints += gpaPoint * course.credit_hours;
                totalCredits += course.credit_hours;
            }
        });

        const gpa = totalCredits > 0 ? (totalPoints / totalCredits).toFixed(2) : 0;
        document.getElementById('result').innerText = `Your GPA: ${gpa}`;
    }
</script>
</body>
</html>
