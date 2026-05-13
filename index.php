<?php
require_once "db.php";

function show_sql_error($conn, $sql) {
    echo "<p style='color:red; font-weight:bold;'>SQL Error: " . htmlspecialchars($conn->error) . "</p>";
    echo "<pre>" . htmlspecialchars($sql) . "</pre>";
}
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
    <p>Requirement: Given the social security number of a professor, list the titles, classrooms, meeting days, and times of their classes.</p>

    <form method="POST">
        <label>Professor SSN:</label>
        <input type="text" name="professor_ssn" placeholder="Example: 111-22-3345" required>
        <button type="submit" name="professor_classes">Search</button>
    </form>

    <?php
    if (isset($_POST["professor_classes"])) {
        $ssn = $_POST["professor_ssn"];

        $sql = "
            SELECT 
                Course.title,
                Sections.classroom,
                Sections.meet_days,
                Sections.start_time,
                Sections.end_time
            FROM Sections
            JOIN Course ON Sections.course_num = Course.course_num
            WHERE Sections.ssn = ?
        ";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            show_sql_error($conn, $sql);
        } else {
            $stmt->bind_param("s", $ssn);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Results</h3>";

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Course Title</th>
                        <th>Classroom</th>
                        <th>Meeting Days</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                      </tr>";

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
    }
    ?>
</section>


<section>
    <h2>Professor: Grade Count by Course Section</h2>
    <p>Requirement: Given a course number and section number, count how many students received each distinct grade.</p>

    <form method="POST">
        <label>Course Number:</label>
        <input type="text" name="grade_course_num" placeholder="Example: 101" required>

        <label>Section Number:</label>
        <input type="text" name="grade_section_num" placeholder="Example: 1" required>

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

        if (!$stmt) {
            show_sql_error($conn, $sql);
        } else {
            $stmt->bind_param("ss", $course_num, $section_num);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Results</h3>";

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Grade</th>
                        <th>Number of Students</th>
                      </tr>";

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
    }
    ?>
</section>


<section>
    <h2>Student: View Course Sections</h2>
    <p>Requirement: Given a course number, list the sections, classrooms, meeting days, times, and number of enrolled students.</p>

    <form method="POST">
        <label>Course Number:</label>
        <input type="text" name="section_course_num" placeholder="Example: 101" required>
        <button type="submit" name="course_sections">Search</button>
    </form>

    <?php
    if (isset($_POST["course_sections"])) {
        $course_num = $_POST["section_course_num"];

        $sql = "
            SELECT 
                Sections.section_num,
                Sections.classroom,
                Sections.meet_days,
                Sections.start_time,
                Sections.end_time,
                COUNT(Enrollment_records.cwid) AS enrolled_students
            FROM Sections
            LEFT JOIN Enrollment_records
                ON Sections.course_num = Enrollment_records.course_num
                AND Sections.section_num = Enrollment_records.section_num
            WHERE Sections.course_num = ?
            GROUP BY 
                Sections.section_num,
                Sections.classroom,
                Sections.meet_days,
                Sections.start_time,
                Sections.end_time
            ORDER BY Sections.section_num
        ";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            show_sql_error($conn, $sql);
        } else {
            $stmt->bind_param("s", $course_num);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Results</h3>";

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Section</th>
                        <th>Classroom</th>
                        <th>Meeting Days</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Enrolled Students</th>
                      </tr>";

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
    }
    ?>
</section>


<section>
    <h2>Student: View Courses and Grades</h2>
    <p>Requirement: Given a student CWID, list all courses the student took and their grades.</p>

    <form method="POST">
        <label>Student CWID:</label>
        <input type="text" name="cwid" placeholder="Example: 1001" required>
        <button type="submit" name="student_courses">Search</button>
    </form>

    <?php
    if (isset($_POST["student_courses"])) {
        $cwid = $_POST["cwid"];

        $sql = "
            SELECT 
                Course.course_num,
                Course.title,
                Enrollment_records.section_num,
                Enrollment_records.grade
            FROM Enrollment_records
            JOIN Course ON Enrollment_records.course_num = Course.course_num
            WHERE Enrollment_records.cwid = ?
            ORDER BY Course.course_num
        ";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            show_sql_error($conn, $sql);
        } else {
            $stmt->bind_param("s", $cwid);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Results</h3>";

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Course Number</th>
                        <th>Course Title</th>
                        <th>Section</th>
                        <th>Grade</th>
                      </tr>";

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
    }
    ?>

</section>

</body>
</html>