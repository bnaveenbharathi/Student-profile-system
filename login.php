<?php 
include("./resources/connection.php");
session_start(); 

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($roll_no) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE roll_no = ? AND email = ?");
        $stmt->bind_param("ss", $roll_no, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['roll_no'] = $roll_no;
                $_SESSION['email'] = $email;
                
                header("Location: dashboard/index.php");
                exit();
            } else {
                $message = "Incorrect password. Please try again.";
            }
        } else {
            $message = "User not found. Please check your roll number and email.";
        }

        $stmt->close();
    }
}
?>

<!doctype html>
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Login</title> 
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
    <div class="signin"> 
        <div class="content"> 
            <h2>Sign In</h2> 
                <div class="form"> 
            <form action="login.php" method="POST">
                    <div class="inputBox"> 
                        <input type="text" name="roll_no" required><i>Roll Number</i>
                    </div> 
                    <div class="inputBox"> 
                        <input type="email" name="email" required><i>Email</i>
                    </div>
                    <div class="inputBox"> 
                        <input type="password" name="password" required><i>Password</i>
                    </div> 

                    <div class="links">
                      <a href=""></a>
                        <a href="verify.php">Sign Up</a> 
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
