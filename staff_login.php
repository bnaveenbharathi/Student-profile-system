<?php
include("./resources/connection.php");
session_start();

if (isset($_SESSION['staff_id'])) {
    header("Location: staff_dashboard/");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($staff_id) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } else {
        // Prepare the SQL query to fetch password
        $stmt = $conn->prepare("SELECT password FROM staff WHERE staff_id = ? AND email = ?");
        $stmt->bind_param("ss", $staff_id, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Direct password comparison (NOT RECOMMENDED for production)
            if ($password == $user['password']) {
                // Password is correct, set session variables
                $_SESSION['staff_id'] = $staff_id;
                $_SESSION['email'] = $email;

                // Redirect to staff dashboard
                header("Location: staff_dashboard/index.php");
                exit();
            } else {
                $message = "Incorrect password. Please try again.";
            }
        } else {
            $message = "User not found. Please check your staff ID and email.";
        }

        $stmt->close();
    }
}
?>

<!doctype html>
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Staff Login</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/css/signup.css"> 
    <style>
        form .inputBox {
            margin: 10px;
            padding: 10px;
        }
    </style>
</head> 
<body>
<section>
  <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
    <div class="signin"> 
        <div class="content"> 
            <h2>Sign In</h2> 
                <div class="form"> 
            <form action="staff_login.php" method="POST">
                    <div class="inputBox"> 
                        <input type="text" name="staff_id" required><i>Roll Number</i>
                    </div> 
                    <div class="inputBox"> 
                        <input type="email" name="email" required><i>Email</i>
                    </div>
                    <div class="inputBox"> 
                        <input type="password" name="password" required><i>Password</i>
                    </div> 

                    <div class="links">
                      <a href=""></a>
                        <!-- <a href="verify.php">Sign Up</a>  -->
                    </div> 

                    <div class="inputBox"> 
                        <input type="submit" value="Sign In"> 
                    </div> 
                </div> 
            </form>
        </div> 
    </div> 
</section> 
</body>
</html>
