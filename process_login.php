<?php
// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Connect to the database (replace dbname, username, password with your own)
    $conn = new mysqli('localhost', 'root', '', 'akecommerce');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch user data
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($id, $db_username, $db_password);

    // Fetch the result
    if ($stmt->fetch()) {
        // Verify password
        if ($password==$db_password) {
            // Password is correct, start a new session
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            echo "Login successful!";
            // Redirect to a member page or any desired page
            header("Location: home.php");
            exit();
        } else {
            // Password is incorrect
            echo "Invalid username or password. <br>";      
        }
    } else {
        // Username not found
        echo "Invalid username or password.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
