<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Futuristic UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Orbitron|Poppins:400,600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: #0d0d0d;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 255, 255, 0.3);
            text-align: center;
            width: 350px;
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        h2 {
            color: #00ffff;
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: transparent;
            border: 2px solid rgba(0, 255, 255, 0.4);
            color: #fff;
            border-radius: 8px;
            outline: none;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus {
            border-color: #00ffff;
            box-shadow: 0 0 10px #00ffff;
        }

        #buttn {
            background: linear-gradient(90deg, #ff3300, #ff6600);
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
        }

        #buttn:hover {
            background: linear-gradient(90deg, #ff6600, #ff3300);
            box-shadow: 0px 0px 15px #ff6600;
        }

        .cta {
            margin-top: 15px;
            color: #fff;
            font-size: 14px;
        }

        .cta a {
            color: #ff3300;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .cta a:hover {
            text-shadow: 0 0 10px #ff3300;
        }

        .error-message {
            color: #ff3300;
            font-size: 14px;
            margin-top: 10px;
        }

        .success-message {
            color: #00ff00;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php
include("connection/connect.php"); 
error_reporting(0); 
session_start();
if(isset($_POST['submit'])) {
    $username = $_POST['username'];  
    $password = $_POST['password'];
    
    if(!empty($_POST["submit"])) {
        $loginquery ="SELECT * FROM users WHERE roll_no='$username' && password='".md5($password)."'";
        $result=mysqli_query($db, $loginquery);
        $row=mysqli_fetch_array($result);
        $arr = explode(' ',trim($row['student_name']));
        
        if(is_array($row)) {
            $_SESSION["user_id"] = $row['u_id'];
            $_SESSION["username"] = $row['roll_no'];
            $_SESSION["studentName"] = $arr[0];

            header("refresh:1;url=index.php");
        } else {
            $message = "Invalid Username or Password!";
        }
    }
}
?>

<div class="container">
    <h2>SIGN IN</h2>
    <?php if(!empty($message)) echo "<div class='error-message'>$message</div>"; ?>
    <?php if(!empty($success)) echo "<div class='success-message'>$success</div>"; ?>
    <form action="" method="post">
        <input type="text" placeholder="Username" name="username" required>
        <input type="password" placeholder="Password" name="password" required>
        <input type="submit" id="buttn" name="submit" value="Login">
    </form>
    <div class="cta">Not registered? <a href="registration.php">Create an account</a></div>
</div>


</body>
</html>
