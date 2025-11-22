<?php 
include 'includes/header.php';
require_once 'config/db.php';

// Check if user is logged in
if (!$is_logged_in) {
    header('Location: auth/login.php');
    exit;
}

// Get user's enrolled clubs
try {
    $stmt = $pdo->prepare('
        SELECT c.* FROM clubs c
        JOIN memberships m ON c.club_id = m.club_id
        WHERE m.user_id = ? AND m.status = "approved"
        ORDER BY c.club_name
    ');
    $stmt->execute([$user_id]);
    $enrolled_clubs = $stmt->fetchAll();
} catch (PDOException $e) {
    $enrolled_clubs = [];
}

// Get selected club ID from query string or POST
$selected_club_id = $_GET['club_id'] ?? $_POST['club_id'] ?? null;

// Get blogs for selected club OR all blogs from enrolled clubs
$club_blogs = [];
try {
    if ($selected_club_id) {
        // Get blogs for specific club
        $stmt = $pdo->prepare('
            SELECT b.*, u.name as author_name, c.club_name
            FROM blogs b
            JOIN users u ON b.author_id = u.user_id
            JOIN clubs c ON b.club_id = c.club_id
            WHERE b.club_id = ? AND b.status = "published"
            ORDER BY b.created_at DESC
        ');
        $stmt->execute([$selected_club_id]);
        $club_blogs = $stmt->fetchAll();
    } else {
        // Get all blogs from user's enrolled clubs
        $stmt = $pdo->prepare('
            SELECT b.*, u.name as author_name, c.club_name
            FROM blogs b
            JOIN users u ON b.author_id = u.user_id
            JOIN clubs c ON b.club_id = c.club_id
            JOIN memberships m ON c.club_id = m.club_id
            WHERE m.user_id = ? AND m.status = "approved" AND b.status = "published"
            ORDER BY b.created_at DESC
        ');
        $stmt->execute([$user_id]);
        $club_blogs = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    $club_blogs = [];
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
    <div class="container position-relative" style="z-index: 1;">
        <h1 class="display-4 fw-bold mb-3"><i class="fas fa-blog me-3"></i>Club Blogs</h1>
        <p class="fs-5 text-white-50">Share stories, updates, and insights about your clubs!</p>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar - Club Selection -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-layer-group me-2"></i>Your Clubs
                </div>
                <div class="list-group list-group-flush">
                    <a href="blogs.php" class="list-group-item list-group-item-action <?php echo !$selected_club_id ? 'active' : ''; ?>">
                        <i class="fas fa-star me-2"></i>All Blogs
                    </a>
                    <?php foreach ($enrolled_clubs as $club): ?>
                        <a href="?club_id=<?php echo $club['club_id']; ?>" 
                           class="list-group-item list-group-item-action <?php echo $selected_club_id == $club['club_id'] ? 'active' : ''; ?>">
                            <i class="fas fa-folder me-2"></i><?php echo htmlspecialchars($club['club_name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Create Blog Button -->
            <?php if ($selected_club_id): ?>
                <a href="create-blog.php?club_id=<?php echo $selected_club_id; ?>" class="btn btn-success w-100 mt-3">
                    <i class="fas fa-plus me-2"></i>Create New Blog
                </a>
            <?php else: ?>
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>Select a club to create a blog
                </div>
            <?php endif; ?>
        </div>

        <!-- Main Content - Blogs List -->
        <div class="col-lg-9">
            <?php if (!empty($club_blogs)): ?>
                <div class="mb-4">
                    <h3 class="fw-bold mb-4">
                        <i class="fas fa-newspaper me-2" style="color: #667eea;"></i>
                        <?php echo $selected_club_id ? 'Club Blogs' : 'All Club Blogs'; ?>
                    </h3>
                    <div class="row g-4">
                        <?php foreach ($club_blogs as $blog): ?>
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm" style="transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)';">
                                    <?php if ($blog['featured_image']): ?>
                                        <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <div class="badge bg-info mb-2"><?php echo htmlspecialchars($blog['club_name']); ?></div>
                                        <h5 class="card-title fw-bold"><?php echo htmlspecialchars($blog['title']); ?></h5>
                                        <p class="card-text text-muted"><?php echo htmlspecialchars($blog['excerpt'] ?? substr(strip_tags($blog['content']), 0, 100)) . '...'; ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($blog['author_name']); ?>
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-eye me-1"></i><?php echo $blog['views']; ?>
                                            </small>
                                        </div>
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-calendar me-1"></i><?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                                        </small>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <a href="blog-detail.php?blog_id=<?php echo $blog['blog_id']; ?>" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-arrow-right me-1"></i>Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
                    <h4 class="text-muted">No blogs yet</h4>
                    <p class="text-muted mb-4">Be the first to share your club story!</p>
                    <?php if ($selected_club_id): ?>
                        <a href="create-blog.php?club_id=<?php echo $selected_club_id; ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Blog
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-blog fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
                    <h4 class="text-muted">Select a club to view blogs</h4>
                    <p class="text-muted">Choose from your enrolled clubs to see and create blogs</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
