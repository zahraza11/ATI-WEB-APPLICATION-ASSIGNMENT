<?php
session_start();

// Include the database connection script
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    echo "Email: $email<br>";
    echo "Password: $password<br>";


    // Validate login credentials
    $sql = "SELECT * FROM Lecturer WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row['Password'];

        // Verify the password
        if (password_verify($password, $storedHashedPassword)) {
            // Password is correct, set session variables and redirect to the dashboard
            $_SESSION['email'] = $row['Email'];
            header("Location: dashboard.php");
            
        } else {
            // Password is incorrect
            $error_message = "Incorrect password";
        }
    } else {
        // Lecturer not found
        $error_message = "Lecturer not found";
    }
    if (!$result) {
        // Handle database query error
        echo "Error: " . $conn->error;
    }
    

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Login</title>
</head>
<body>
    <h2>Lecturer Login</h2>
    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
