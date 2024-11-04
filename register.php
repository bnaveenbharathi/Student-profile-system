<?php 
include("./resources/connection.php");

session_start();


$name = $_SESSION['name'];
$department = $_SESSION['department'];
$branch = $_SESSION['branch'];
$roll_no = $_SESSION['roll_no']; 

$message = '';

if (!isset($_SESSION['roll_no'])) {
  header("Location: verify.php"); 
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = $_POST['password'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE roll_no = ?");
    $stmt->bind_param("ss", $hashedPassword, $roll_no);

    if ($stmt->execute()) {
        $message = "Password successfully created!";
        
        session_unset();
        session_destroy();
        
        echo "<script>
                alert('$message');
                window.location.href = 'login.php';
              </script>";
        exit();
    } else {
        $message = "Error updating password: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!doctype html>
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <title>Password</title> 
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
        <h2>Password</h2>       
          <div class="form"> 
          <form method="POST" action="">
            <div class="inputBox"> 
              <input type="text" name="username" readonly value="<?php echo htmlspecialchars($name); ?>" >
            </div> 
            <div class="inputBox"> 
              <input type="text" name="department" readonly value="<?php echo htmlspecialchars($branch) . " " . htmlspecialchars($department); ?>">
            </div>
            <div class="inputBox"> 
              <input type="password" name="password" required> <i>New Password</i> 
            </div> 
            <div class="inputBox"> 
              <input type="submit" value="Register"> 
            </div>
            <div class="inputBox"> 
              <a href="verify.php"><input type="button" value="Back"></a>
            </div> 
          </div> 
        </form>
      </div> 
    </div> 
  </section> 
</body>
</html>
