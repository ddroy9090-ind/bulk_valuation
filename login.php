<?php
require __DIR__ . '/includes/db.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Reliant — Login</title>

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

        :root {
            --bg: #f5f6f7;
            --card: #fff;
            --muted: #8b8b8b;
            --accent1: #e33a2f;
            --accent2: #be1e1e;
            --input-bg: #fbfbfb;
            --shadow: 0 6px 18px rgba(14, 14, 14, 0.06);
            font-family: "Inter", "Segoe UI", Roboto, Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
            /* ✅ Fix input overflow */
        }

        html,
        body {
            height: 100%;
            margin: 0;
            background-color: #d01f28;
            /* 🔴 Base red color */
            background-image:
                url("./assets/images/texture.jpg");
            background-repeat: repeat;
            background-size: cover;
            /* ✅ Full coverage */
            background-blend-mode: multiply;
            /* 🔥 Blend texture with red */
            color: #fff;
            overflow: hidden;
            /* ✅ Scrollbar off */
            font-family: "Roboto", sans-serif;
        }



        /* center layout */
        .wrap {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: var(--card);
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            /* ✅ prevent inside overflow */
        }

        /* header */
        .card .top {
            padding: 24px 30px;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .brand img {
            width: 150px;
        }

        .shield {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            background: linear-gradient(180deg, var(--accent1), var(--accent2));
            color: #fff;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .lead {
            margin-top: 10px;
            color: var(--muted);
            font-size: 15px;
        }

        /* body */
        .card .body {
            padding: 24px 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #222;
        }

        .input-wrap {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #9aa0a6;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: var(--input-bg);
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: rgba(226, 38, 38, 0.25);
        }

        input {

            width: 100%;
            padding: 14px 16px 14px 46px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: var(--input-bg);
            font-size: 15px;
            outline: none;

        }

        .eye-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #9aa0a6;
            cursor: pointer;
            background: transparent;
            border: none;
        }

        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 3px;
            color: var(--muted);
        }

        .checkbox input {
            accent-color: var(--accent1);
            width: 14px;
            height: 15px;
        }

        .forgot {
            color: var(--accent1);
            font-weight: 600;
            text-decoration: none;
        }

        /* button */
        .cta {
            display: block;
            width: 100%;
            padding: 14px;
            text-align: center;
            border-radius: 10px;
            background: linear-gradient(180deg, var(--accent1), var(--accent2));
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .support {
            text-align: center;
            padding: 20px;
            color: var(--muted);
            border-top: 1px solid rgba(0, 0, 0, 0.03);
            font-size: 14px;
        }

        .support a {
            color: var(--accent1);
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 6px;
        }

        footer.small-foot {
            text-align: center;
            color: var(--muted);
            padding: 12px;
            font-size: 13px;
        }

        @media (max-width:500px) {
            .card {
                border-radius: 12px;
                margin: 0 12px;
            }

            h1 {
                font-size: 20px;
            }

            .lead {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <div class="wrap">
        <div class="card">
            <div class="top">
                <div class="brand">
                    <img src="assets/images/logo/logo.png" alt="">
                </div>
                <p class="lead">Sign in to access the Bulk Valuation Report Generation Portal</p>
            </div>

            <div class="body">
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrap">
                            <i class='bx bx-envelope input-icon'></i>
                            <input id="email" type="email" name="email" required placeholder="Enter your email address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <i class='bx bx-lock input-icon'></i>
                            <input id="password" type="password" name="password" required
                                placeholder="Enter your password">
                            <button type="button" class="eye-toggle" id="togglePwd">
                                <i class='bx bx-hide' id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    <button class="cta" type="submit" name="login">Login</button>
                </form>

            </div>

            <div class="support">
                Need access to the valuation portal? <br>
                <a href="#">Contact System Administrator</a>
            </div>
        </div>
    </div>

    <footer class="small-foot">
        © 2024 Reliant Surveyors. All rights reserved. <br />
        Secure portal for authorized personnel only
    </footer>

    <script>
        const pwd = document.getElementById('password');
        const toggle = document.getElementById('togglePwd');
        const eyeIcon = document.getElementById('eyeIcon');

        toggle.addEventListener('click', () => {
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eyeIcon.className = 'bx bx-show';
            } else {
                pwd.type = 'password';
                eyeIcon.className = 'bx bx-hide';
            }
        });
    </script>
</body>

</html>