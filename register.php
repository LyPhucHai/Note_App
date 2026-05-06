<?php
    include("database.php");
    
    $error = "";
    $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST["name"] ?? '');
        $email = trim($_POST["email"] ?? '');
        $password = trim($_POST["password"] ?? '');
        $confirm = trim($_POST["confirm"] ?? '');

        if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
            $error = "Vui lòng điền đầy đủ thông tin";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email không hợp lệ";
        } elseif (strlen($password) < 6) {
            $error = "Mật khẩu phải có ít nhất 6 ký tự";
        }
         elseif ($password !== $confirm) {
            $error = "Mật khẩu xác nhận không khớp";
        } else {
            $check = $conn->query("SELECT * FROM users WHERE email='$email'");
            
            if ($check->num_rows > 0) {
                $error = "Email đã tồn tại";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
                
                if ($conn->query($sql)) {
                    $success = "Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.";
                } else {
                    $error = "Lỗi: " . $conn->error;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Times New Roman', serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
        }
        
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 320px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #ff7e5f;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .show-password {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .show-password input {
            width: auto;
            margin: 0;
        }

        button:hover {
            background: #ff6b4a;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        .link a {
            color: #ff7e5f;
            text-decoration: none;
            font-weight: bold;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>
    <div class="container">
        <h2>Create Account</h2>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="name" placeholder="Tên" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirm" name="confirm" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>

        <div class="link">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập tại đây</a></p>
        </div>
    </div>
    <script>
        function togglePassword(id) {
            var input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>