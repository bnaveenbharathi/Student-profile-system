<?php 
include("./resources/connection.php");

$verificationMessage = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE roll_no = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $roll_no, $email);
    
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $verificationMessage = "Verified"; 
    } else {
        $verificationMessage = "User not found"; 
    }

    $stmt->close();
}
?>

<!doctype html>
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Sign Up</title> 
    <link rel="stylesheet" href="./static/css/signup.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
 form .inputBox{
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
                <h2>Sign Up</h2> 
                <div class="form"> 
                    <form method="POST">
                        <div class="inputBox"> 
                            <input type="text" name="roll_no" required> 
                            <i>Roll Number</i> 
                        </div> 
                        <div class="inputBox"> 
                            <input type="email" name="email" required> 
                            <i>Email</i> 
                        </div> 
                        <div class="links"> 
                            <a href="#"></a> 
                            <a href="login.php">Login</a> 
                        </div> 
                        <div class="inputBox"> 
                            <input type="submit" value="<?php echo $verificationMessage ?: 'Verify'; ?>"> 
                        </div> 
                    </form>
                  
                </div> 
            </div> 
        </div> 
    </section>
</body>
</html>
