<?php
session_start();

// Include the database connection script
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $designation = $_POST['designation'];
    $courseID = $_POST['course'];
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    
    $sql = "INSERT INTO Lecturer (Name, Email, Designation, CourseID, Gender, Password) 
            VALUES ('$name', '$email', '$designation', $courseID, '$gender', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: login.php");
        exit();
    } else {
        // Handle registration error
        $error_message = "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Registration</title>
</head>
<body>
    <h2>Lecturer Registration</h2>
    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name in full:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="designation">Designation:</label>
        <select name="designation" required>
            <option value="Assistant Lecturer">Assistant Lecturer</option>
            <option value="Senior Lecturer 1">Senior Lecturer 1</option>
            <option value="Senior Lecturer 2">Senior Lecturer 2</option>
        </select><br>

        <label for="course">Course:</label>
        <select name="course" required>
            <!-- Fetch course list from the Course table and populate the dropdown -->
            <?php
            $course_query = "SELECT * FROM Course";
            $result = $conn->query($course_query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['CourseID']}'>{$row['Title']}</option>";
            }
            ?>
        </select><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
