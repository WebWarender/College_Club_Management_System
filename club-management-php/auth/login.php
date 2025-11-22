<?php
session_start();
require_once '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Email and password are required';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT user_id, name, email, password, role FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                header('Location: ../index.php');
                exit;
            } else {
                $error = 'Invalid email or password';
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
    <title>Login - Club Connect</title>
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
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            animation: slideInUp 0.5s ease-out;
        }
        .login-card .card-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border-radius: 15px 15px 0 0;
            color: white;
            border: none;
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
                <div class="card login-card">
                    <div class="card-header py-4 text-center">
                        <h2 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Welcome Back</h2>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                <input type="email" class="form-control" name="email" required placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                                <input type="password" class="form-control" name="password" required placeholder="Enter your password">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%); border: none;">
                                Sign In
                            </button>
                        </form>

                        <hr class="my-4">

                        <p class="text-center mb-0">
                            Don't have an account? <a href="register.php" class="text-primary fw-bold">Create one</a>
                        </p>
                        <p class="text-center mt-2">
                            <a href="../index.php" class="text-muted text-decoration-none"><i class="fas fa-arrow-left me-1"></i>Back to home</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
