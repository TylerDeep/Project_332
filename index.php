<?php
require_once "db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>CPSC 332 University Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>University Database</h1>

<section>
    <h2>Professor: View Classes</h2>
    <form method="POST">
        <label>Professor SSN:</label>
        <input type="text" name="professor_ssn" required>
        <button type="submit" name="professor_classes">Search</button>
    </form>

    <?php
    if (isset($_POST["professor_classes"])) {
        $ssn = $_POST["professor_ssn"];

        $sql = "
            SELECT 
                c.title,
                s.classroom,
                s.meet_days,
                s.start_time,
                s.end_time
            FROM Sections s
            JOIN Courses c ON s.course_num = c.course_num
            WHERE s.professor_ssn = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ssn);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Results</h3>";

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Course Title</th><th>Classroom</th><th>Meeting Days</th><th>Start Time</th><th>End Time</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["classroom"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["meet_days"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["start_time"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["end_time"]) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No classes found for this professor.</p>";
        }

        $stmt->close();
    }
    ?>
</section>

<section>
    <h2>Professor: Grade Count by Course Section</h2>
    <form method="POST">
        <label>Course Number:</label>
        <input type="text" name="grade_course_num" required>

        <label>Section Number:</label>
        <input type="text" name="grade_section_num" required>

        <button type="submit" name="grade_count">Search</button>
    </form>

    <?php
    if (isset($_POST["grade_count"])) {
        $course_num = $_POST["grade_course_num"];
        $section_num = $_POST["grade_section_num"];

        $sql = "
            SELECT 
                grade,
                COUNT(*) AS student_count
            FROM Enrollment_records
            WHERE course_num = ? AND section_num = ?
            GROUP BY grade
            ORDER BY grade
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $course_num, $section_num);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Results</h3>";

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Grade</th><th>Number of Students</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["grade"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["student_count"]) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No enrollment records found for this course section.</p>";
        }

        $stmt->close();
    }
    ?>
</section>

<section>
    <h2>Student: View Course Sections</h2>
    <form method="POST">
        <label>Course Number:</label>
        <input type="text" name="section_course_num" required>
        <button type="submit" name="course_sections">Search</button>
    </form>

    <?php
    if (isset($_POST["course_sections"])) {
        $course_num = $_POST["section_course_num"];

        $sql = "
            SELECT 
                s.section_num,
                s.classroom,
                s.meet_days,
                s.start_time,
                s.end_time,
                COUNT(e.student_id) AS enrolled_students
            FROM Sections s
            LEFT JOIN Enrollment_records e
                ON s.course_num = e.course_num
                AND s.section_num = e.section_num
            WHERE s.course_num = ?
            GROUP BY 
                s.section_num,
                s.classroom,
                s.meet_days,
                s.start_time,
                s.end_time
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $course_num);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Results</h3>";

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Section</th><th>Classroom</th><th>Meeting Days</th><th>Start Time</th><th>End Time</th><th>Enrolled Students</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["section_num"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["classroom"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["meet_days"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["start_time"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["end_time"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["enrolled_students"]) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No sections found for this course.</p>";
        }

        $stmt->close();
    }
    ?>
</section>

<section>
    <h2>Student: View Courses and Grades</h2>
    <form method="POST">
        <label>Student CWID:</label>
        <input type="text" name="student_id" required>
        <button type="submit" name="student_courses">Search</button>
    </form>

    <?php
    if (isset($_POST["student_courses"])) {
        $student_id = $_POST["student_id"];

        $sql = "
            SELECT 
                c.course_num,
                c.title,
                e.section_num,
                e.grade
            FROM Enrollment_records e
            JOIN Courses c ON e.course_num = c.course_num
            WHERE e.student_id = ?
            ORDER BY c.course_num
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Results</h3>";

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Course Number</th><th>Course Title</th><th>Section</th><th>Grade</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["course_num"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["section_num"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["grade"]) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No courses found for this student.</p>";
        }

        $stmt->close();
    }
    ?>
</section>

</body>
</html>