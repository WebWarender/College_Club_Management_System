<?php
session_start();
require_once '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = ?');
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error = 'Email already registered';
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                
                $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
                $stmt->execute([$name, $email, $hashed_password, 'student']);
                
                $success = 'Registration successful! Redirecting to login...';
                echo '<script>setTimeout(function() { window.location.href = "login.php"; }, 2000);</script>';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Club Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../public/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            animation: slideInUp 0.5s ease-out;
        }
        .register-card .card-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border-radius: 15px 15px 0 0;
            color: white;
            border: none;
        }
        .password-strength {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 5px;
        }
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card register-card">
                    <div class="card-header py-4 text-center">
                        <h2 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create Account</h2>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($success); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user me-2"></i>Full Name</label>
                                <input type="text" class="form-control" name="name" required placeholder="Enter your full name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                <input type="email" class="form-control" name="email" required placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                                <input type="password" class="form-control" name="password" id="password" required placeholder="Enter password" onkeyup="checkPasswordStrength()">
                                <div class="password-strength">
                                    <div id="strengthBar" style="width: 0%; height: 100%; background: #e74c3c; border-radius: 2px;"></div>
                                </div>
                                <small id="strengthText" class="text-muted"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm password">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-primary">terms and conditions</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%); border: none;">
                                Create Account
                            </button>
                        </form>

                        <hr class="my-4">

                        <p class="text-center mb-0">
                            Already have an account? <a href="login.php" class="text-primary fw-bold">Sign in</a>
                        </p>
                        <p class="text-center mt-2">
                            <a href="../index.php" class="text-muted text-decoration-none"><i class="fas fa-arrow-left me-1"></i>Back to home</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            let strength = 0;

            if (password.length >= 6) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[$@#&!]+/)) strength++;

            const widths = ['0%', '20%', '40%', '60%', '80%', '100%'];
            const colors = ['#e74c3c', '#e67e22', '#f39c12', '#f1c40f', '#2ecc71', '#27ae60'];
            const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];

            strengthBar.style.width = widths[strength];
            strengthBar.style.background = colors[strength];
            strengthText.textContent = labels[strength];
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
