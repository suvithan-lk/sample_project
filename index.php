<?php

include "config.php"; // Include database connection file


// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form input values and remove any leading/trailing spaces
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Securely hash the password before storing in the database
    // PASSWORD_DEFAULT uses the current strongest algorithm (bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Step 1: Check if the email is already registered
        $checkStmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $checkStmt->execute(['email' => $email]);

        // If a row exists, it means the email is already in use
        if ($checkStmt->rowCount() > 0) {
            echo "<script>alert('Email already registered!'); window.history.back();</script>";
            exit; // Stop the script here
        }

        // Step 2: Insert the new user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) 
                               VALUES (:username, :email, :password)");
        $stmt->execute([
            'username' => $username,     // Bind username
            'email'    => $email,        // Bind email
            'password' => $hashedPassword // Bind hashed password
        ]);

        // Step 3: Show success message and redirect to login page
        echo "<script>alert('Registration successful!'); window.location='index.php';</script>";

    } catch (PDOException $e) {
        // If there’s a database error, stop and show the error
        die("Error: " . $e->getMessage());
    }

  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow p-4">
        <h3 class="text-center mb-4">User Registration</h3>

        <!-- form -->
        <form action="index.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>
