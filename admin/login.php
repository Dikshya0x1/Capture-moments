<?php
session_start();
include('../config.php');

if (isset($_POST['login'])) {
    $username = escape($_POST['username']);
    $password = md5(escape($_POST['password']));

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #2a80a8, #1c6a97); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Login Form Container */
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #2a80a8;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #2a80a8; 
            outline: none;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #2a80a8;
            border: none;
            color: white;
            font-size: 1.2rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1c6a97; 
        }

        .error {
            color: red;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .login-container {
                padding: 30px;
                max-width: 350px;
            }

            h2 {
                font-size: 1.8rem;
            }

            input[type="text"],
            input[type="password"] {
                padding: 12px;
            }

            button {
                font-size: 1.1rem;
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
                max-width: 300px;
            }

            h2 {
                font-size: 1.5rem;
            }

            input[type="text"],
            input[type="password"] {
                padding: 10px;
            }

            button {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <form method="post">
            <h2>Admin Login</h2>
            <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>

</body>
</html>
