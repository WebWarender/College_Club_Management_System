<?php 
include 'includes/header.php';
require_once 'config/db.php';

// Get all announcements
try {
    $stmt = $pdo->prepare('
        SELECT a.*, c.club_name, u.name as author_name
        FROM announcements a 
        JOIN clubs c ON a.club_id = c.club_id 
        LEFT JOIN users u ON a.created_by = u.user_id
        ORDER BY a.created_at DESC
    ');
    $stmt->execute();
    $announcements = $stmt->fetchAll();
} catch (PDOException $e) {
    $announcements = [];
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white;">
    <div class="container">
        <h1><i class="fas fa-bell me-3"></i>Announcements</h1>
        <p>Stay updated with the latest news and updates from all clubs</p>
    </div>
</section>

<div class="container py-5">
    <!-- Announcements List -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <?php foreach ($announcements as $announcement): ?>
                <div class="card mb-4" style="border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-left: 5px solid #6366f1;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-1"><?php echo htmlspecialchars($announcement['title']); ?></h5>
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-layer-group me-1"></i><?php echo htmlspecialchars($announcement['club_name']); ?>
                                    <span class="ms-3"><i class="fas fa-user me-1"></i><?php echo htmlspecialchars($announcement['author_name']); ?></span>
                                </p>
                            </div>
                            <small class="text-muted"><?php echo date('M d, Y H:i', strtotime($announcement['created_at'])); ?></small>
                        </div>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($announcement['message'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($announcements)): ?>
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle me-2"></i>No announcements yet. Check back soon!
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
