<?php 
include("./resources/connection.php");
session_start(); 

$verificationMessage = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['roll_no']) || empty($_POST['email'])) {
        $verificationMessage = "Roll number and email are required.";
    } else {
        $roll_no = $_POST['roll_no'];
        $email = $_POST['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: verify.php");
            return;
        } else {
            try {
                $sql = "SELECT name, department, branch, roll_no FROM users WHERE roll_no = ? AND email = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    throw new Exception("Failed to prepare the SQL statement.");
                }

                $stmt->bind_param("ss", $roll_no, $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result === false) {
                    throw new Exception("Failed to execute the query.");
                }

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['department'] = $user['department'];
                    $_SESSION['branch'] = $user['branch'];
                    $_SESSION['roll_no'] = $user['roll_no']; 

                    header("Location: register.php");
                    exit();
                } else {
                    $verificationMessage = "User not found"; 
                }

                $stmt->close();
            } catch (Exception $e) {
                $verificationMessage = "An error occurred. Please try again.";
                error_log($e->getMessage()); 
            }
        }
    }
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
                <h2>Sign Up</h2> 
                <div class="form"> 
                    <form method="POST" id="verificationForm" onsubmit="return validateForm();">
                        <div class="inputBox"> 
                            <input type="number" name="roll_no" required> 
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
                            <input type="submit" id="verifyButton" value="<?php echo $verificationMessage ?: 'Verify'; ?>"> 
                        </div> 
                    </form>                 
                </div> 
            </div> 
        </div> 
    </section>

    <script>
        function validateForm() {
            const rollNo = document.querySelector('input[name="roll_no"]').value;
            const email = document.querySelector('input[name="email"]').value;

            if (!rollNo || !email) {
                alert("Please enter both roll number and email.");
                return false; 
            }

            showLoader(); 
            return true; 
        }

        function showLoader() {
            const submitButton = document.getElementById('verifyButton');
            submitButton.value = "Verifying...";
            submitButton.disabled = true;

            setTimeout(() => {
                document.getElementById('verificationForm').submit();
            }, 2000);
        }

        const verificationMessage = "<?php echo $verificationMessage; ?>";
        if (verificationMessage) {
            alert(verificationMessage); 
            if (verificationMessage === "User not found") {
                document.getElementById('verifyButton').value = "Verify Again";
                document.getElementById('verifyButton').disabled = false; 
            }
        }
    </script>
</body>
</html>
