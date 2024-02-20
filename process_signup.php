<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Perform some basic validation (you can add more)
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        // Connect to the database (replace dbname, username, password with your own)
        $conn = new mysqli('localhost', 'root', '', 'akecommerce');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Sign up successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    // Redirect back to the sign-up page if accessed directly
    header("Location: signup.php");
    exit();
}
?>
