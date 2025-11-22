<?php 
include 'includes/header.php';
require_once 'config/db.php';

if (!$is_logged_in) {
    header('Location: auth/login.php');
    exit;
}

// Get user's profile info
try {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    $user = [];
}

// Get user's clubs
try {
    $stmt = $pdo->prepare('
        SELECT c.*, m.status, m.joined_at 
        FROM memberships m 
        JOIN clubs c ON m.club_id = c.club_id 
        WHERE m.user_id = ?
    ');
    $stmt->execute([$_SESSION['user_id']]);
    $user_clubs = $stmt->fetchAll();
} catch (PDOException $e) {
    $user_clubs = [];
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white;">
    <div class="container">
        <h1><i class="fas fa-user-circle me-3"></i>My Profile</h1>
        <p>Manage your account and club memberships</p>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card" style="border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle" style="font-size: 80px; color: #6366f1;"></i>
                    </div>
                    <h4 class="card-title"><?php echo htmlspecialchars($user['name']); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                    <div class="mb-3">
                        <span class="badge bg-primary"><?php echo ucfirst($user['role']); ?></span>
                    </div>
                    <p class="text-muted small">Joined: <?php echo date('M d, Y', strtotime($user['created_at'])); ?></p>
                    <a href="#" class="btn btn-primary btn-sm w-100">Edit Profile</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <!-- My Clubs -->
            <div class="card mb-4" style="border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-layer-group me-2"></i>My Clubs (<?php echo count($user_clubs); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($user_clubs)): ?>
                        <p class="text-muted text-center">You haven't joined any clubs yet. <a href="clubs.php">Explore clubs</a></p>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($user_clubs as $club): ?>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3" style="background: #f8f9fa; border-radius: 8px;">
                                        <img src="<?php echo htmlspecialchars($club['image_url']); ?>" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover; margin-right: 15px;" alt="">
                                        <div>
                                            <h6 class="mb-1"><?php echo htmlspecialchars($club['club_name']); ?></h6>
                                            <small class="text-muted">
                                                <span class="badge bg-<?php echo $club['status'] === 'approved' ? 'success' : 'warning'; ?>">
                                                    <?php echo ucfirst($club['status']); ?>
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card text-center" style="border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h3 class="mb-0" style="color: #6366f1;"><?php echo count($user_clubs); ?></h3>
                            <p class="text-muted">Clubs Joined</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center" style="border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h3 class="mb-0" style="color: #ec4899;">0</h3>
                            <p class="text-muted">Events Attended</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center" style="border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h3 class="mb-0" style="color: #f59e0b;">0</h3>
                            <p class="text-muted">Posts</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
