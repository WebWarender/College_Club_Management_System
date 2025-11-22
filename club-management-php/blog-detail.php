<?php 
include 'includes/header.php';
require_once 'config/db.php';

$blog_id = $_GET['blog_id'] ?? null;

if (!$blog_id) {
    header('Location: blogs.php');
    exit;
}

// Get blog details
try {
    $stmt = $pdo->prepare('
        SELECT b.*, u.name as author_name, u.user_id as author_id, c.club_name, c.club_id
        FROM blogs b
        JOIN users u ON b.author_id = u.user_id
        JOIN clubs c ON b.club_id = c.club_id
        WHERE b.blog_id = ? AND b.status = "published"
    ');
    $stmt->execute([$blog_id]);
    $blog = $stmt->fetch();
    
    if (!$blog) {
        header('Location: blogs.php');
        exit;
    }

    // Update view count
    $stmt = $pdo->prepare('UPDATE blogs SET views = views + 1 WHERE blog_id = ?');
    $stmt->execute([$blog_id]);

    // Get comments
    $stmt = $pdo->prepare('
        SELECT bc.*, u.name as author_name
        FROM blog_comments bc
        JOIN users u ON bc.author_id = u.user_id
        WHERE bc.blog_id = ?
        ORDER BY bc.created_at DESC
    ');
    $stmt->execute([$blog_id]);
    $comments = $stmt->fetchAll();

} catch (PDOException $e) {
    header('Location: blogs.php');
    exit;
}

// Handle comment submission
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $is_logged_in) {
    $comment = $_POST['comment'] ?? '';
    
    if (empty($comment)) {
        $error = 'Comment cannot be empty!';
    } else {
        try {
            $stmt = $pdo->prepare('
                INSERT INTO blog_comments (blog_id, author_id, content)
                VALUES (?, ?, ?)
            ');
            $stmt->execute([$blog_id, $user_id, $comment]);
            $success = 'Comment posted successfully!';
            header("Location: blog-detail.php?blog_id=$blog_id");
            exit;
        } catch (PDOException $e) {
            $error = 'Error posting comment: ' . $e->getMessage();
        }
    }
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
    <div class="container position-relative" style="z-index: 1;">
        <a href="blogs.php?club_id=<?php echo $blog['club_id']; ?>" class="text-white-50 text-decoration-none mb-2 d-inline-block">
            <i class="fas fa-arrow-left me-2"></i>Back to Blogs
        </a>
        <h1 class="display-4 fw-bold"><?php echo htmlspecialchars($blog['title']); ?></h1>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="mb-5">
                <!-- Featured Image -->
                <?php if ($blog['featured_image']): ?>
                    <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" class="img-fluid rounded mb-4" 
                         style="max-height: 400px; object-fit: cover; width: 100%;" 
                         alt="<?php echo htmlspecialchars($blog['title']); ?>">
                <?php endif; ?>

                <!-- Blog Meta -->
                <div class="d-flex flex-wrap gap-4 mb-4 pb-4 border-bottom">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-user me-2"></i>By <strong><?php echo htmlspecialchars($blog['author_name']); ?></strong>
                        </small>
                    </div>
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-2"></i><?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                        </small>
                    </div>
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-eye me-2"></i><?php echo $blog['views']; ?> views
                        </small>
                    </div>
                    <div>
                        <span class="badge bg-primary">
                            <i class="fas fa-tag me-1"></i><?php echo htmlspecialchars($blog['club_name']); ?>
                        </span>
                    </div>
                </div>

                <!-- Blog Content -->
                <div class="blog-content" style="line-height: 1.8; font-size: 1.05rem; color: #333;">
                    <?php echo $blog['content']; ?>
                </div>

                <!-- Blog Footer -->
                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">About the Author</h6>
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($blog['author_name']); ?></p>
                        </div>
                        <?php if ($is_logged_in && $user_id == $blog['author_id']): ?>
                            <div>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </article>

            <!-- Comments Section -->
            <section class="mt-5">
                <h3 class="fw-bold mb-4">
                    <i class="fas fa-comments me-2" style="color: #667eea;"></i>
                    Comments (<?php echo count($comments); ?>)
                </h3>

                <!-- Add Comment Form -->
                <?php if ($is_logged_in): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form method="POST">
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Your Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" 
                                              placeholder="Share your thoughts..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-comment me-2"></i>Post Comment
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <a href="auth/login.php">Login</a> to post a comment
                    </div>
                <?php endif; ?>

                <!-- Comments List -->
                <?php if (!empty($comments)): ?>
                    <div class="comments-list">
                        <?php foreach ($comments as $comment): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($comment['author_name']); ?></h6>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i><?php echo date('M d, Y h:i A', strtotime($comment['created_at'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                    <p class="mb-0"><?php echo htmlspecialchars($comment['content']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted">No comments yet. Be the first to comment!</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Blogs -->
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-related-posts me-2"></i>More from <?php echo htmlspecialchars($blog['club_name']); ?>
                </div>
                <div class="list-group list-group-flush">
                    <?php 
                    try {
                        $stmt = $pdo->prepare('
                            SELECT blog_id, title FROM blogs
                            WHERE club_id = ? AND blog_id != ? AND status = "published"
                            ORDER BY created_at DESC
                            LIMIT 5
                        ');
                        $stmt->execute([$blog['club_id'], $blog_id]);
                        $related = $stmt->fetchAll();
                        
                        if (!empty($related)):
                            foreach ($related as $post):
                    ?>
                                <a href="blog-detail.php?blog_id=<?php echo $post['blog_id']; ?>" 
                                   class="list-group-item list-group-item-action">
                                    <small><?php echo htmlspecialchars(substr($post['title'], 0, 50)); ?></small>
                                </a>
                    <?php 
                            endforeach;
                        else:
                    ?>
                                <div class="list-group-item">
                                    <small class="text-muted">No related blogs</small>
                                </div>
                    <?php
                        endif;
                    } catch (PDOException $e) {}
                    ?>
                </div>
            </div>

            <!-- Club Info -->
            <div class="card">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-info-circle me-2"></i>About This Club
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-2"><?php echo htmlspecialchars($blog['club_name']); ?></h6>
                    <a href="club-details.php?id=<?php echo $blog['club_id']; ?>" class="btn btn-sm btn-primary w-100">
                        <i class="fas fa-eye me-1"></i>View Club
                    </a>
                    <a href="blogs.php?club_id=<?php echo $blog['club_id']; ?>" class="btn btn-sm btn-outline-primary w-100 mt-2">
                        <i class="fas fa-newspaper me-1"></i>All Blogs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
