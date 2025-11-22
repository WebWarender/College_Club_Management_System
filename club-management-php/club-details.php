<?php 
include 'includes/header.php';
require_once 'config/db.php';

if (!$is_logged_in) {
    header('Location: auth/login.php');
    exit;
}

$club_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($club_id <= 0) {
    header('Location: clubs.php');
    exit;
}

// Get club details
try {
    $stmt = $pdo->prepare('SELECT * FROM clubs WHERE club_id = ?');
    $stmt->execute([$club_id]);
    $club = $stmt->fetch();
    
    if (!$club) {
        header('Location: clubs.php');
        exit;
    }
} catch (PDOException $e) {
    header('Location: clubs.php');
    exit;
}

// Get club members
try {
    $stmt = $pdo->prepare('
        SELECT u.*, m.status, m.joined_at 
        FROM memberships m 
        JOIN users u ON m.user_id = u.user_id 
        WHERE m.club_id = ? AND m.status = "approved"
        LIMIT 10
    ');
    $stmt->execute([$club_id]);
    $members = $stmt->fetchAll();
} catch (PDOException $e) {
    $members = [];
}

// Get club events
try {
    $stmt = $pdo->prepare('
        SELECT * FROM events 
        WHERE club_id = ? 
        ORDER BY event_date ASC 
        LIMIT 5
    ');
    $stmt->execute([$club_id]);
    $events = $stmt->fetchAll();
} catch (PDOException $e) {
    $events = [];
}

// Check if user is member
$is_member = false;
try {
    $stmt = $pdo->prepare('SELECT * FROM memberships WHERE user_id = ? AND club_id = ?');
    $stmt->execute([$_SESSION['user_id'], $club_id]);
    $membership = $stmt->fetch();
    $is_member = $membership !== false;
} catch (PDOException $e) {
    $is_member = false;
}

// Handle join club
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['join_club'])) {
    try {
        $stmt = $pdo->prepare('INSERT INTO memberships (user_id, club_id, status) VALUES (?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $club_id, 'pending']);
        $is_member = true;
        $success_msg = 'You have requested to join this club!';
    } catch (PDOException $e) {
        $error_msg = 'Error joining club: ' . $e->getMessage();
    }
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white;">
    <div class="container">
        <h1><i class="fas fa-layer-group me-3"></i><?php echo htmlspecialchars($club['club_name']); ?></h1>
    </div>
</section>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <img src="<?php echo htmlspecialchars($club['image_url']); ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: cover; width: 100%;" alt="<?php echo htmlspecialchars($club['club_name']); ?>">
            
            <div class="mt-4">
                <h3>About This Club</h3>
                <p><?php echo nl2br(htmlspecialchars($club['description'])); ?></p>
                <div class="d-flex gap-3 align-items-center">
                    <div>
                        <h6 class="text-muted">Category</h6>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($club['category']); ?></span>
                    </div>
                    <div>
                        <h6 class="text-muted">Members</h6>
                        <strong><?php echo $club['members_count']; ?></strong>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="mt-5">
                <h3>Upcoming Events</h3>
                <?php if (empty($events)): ?>
                    <p class="text-muted">No events scheduled yet.</p>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($events as $event): ?>
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="<?php echo htmlspecialchars($event['image_url']); ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="">
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo htmlspecialchars($event['event_name']); ?></h6>
                                        <p class="card-text small text-muted"><?php echo date('M d, Y', strtotime($event['event_date'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Members -->
            <div class="mt-5">
                <h3>Club Members</h3>
                <?php if (empty($members)): ?>
                    <p class="text-muted">No members yet.</p>
                <?php else: ?>
                    <div class="row g-2">
                        <?php foreach ($members as $member): ?>
                            <div class="col-md-3">
                                <div class="text-center p-3" style="background: #f8f9fa; border-radius: 8px;">
                                    <i class="fas fa-user-circle" style="font-size: 40px; color: #6366f1; margin-bottom: 10px;"></i>
                                    <h6><?php echo htmlspecialchars($member['name']); ?></h6>
                                    <small class="text-muted"><?php echo date('M Y', strtotime($member['joined_at'])); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card" style="border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h5 class="card-title mb-4">Club Information</h5>
                    
                    <?php if (isset($success_msg)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success_msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error_msg)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <p class="mb-3">
                        <strong>Name:</strong><br>
                        <?php echo htmlspecialchars($club['club_name']); ?>
                    </p>
                    <p class="mb-3">
                        <strong>Category:</strong><br>
                        <?php echo htmlspecialchars($club['category']); ?>
                    </p>
                    <p class="mb-3">
                        <strong>Members:</strong><br>
                        <?php echo $club['members_count']; ?> members
                    </p>

                    <?php if ($is_member): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-check-circle me-2"></i>You are a member of this club
                        </div>
                    <?php else: ?>
                        <form method="POST">
                            <button type="submit" name="join_club" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Join Club
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
