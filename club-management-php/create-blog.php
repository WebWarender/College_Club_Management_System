<?php 
include 'includes/header.php';
require_once 'config/db.php';

// Check if user is logged in
if (!$is_logged_in) {
    header('Location: auth/login.php');
    exit;
}

$club_id = $_GET['club_id'] ?? null;

// Verify user is a member of this club
if ($club_id) {
    try {
        $stmt = $pdo->prepare('
            SELECT * FROM memberships 
            WHERE user_id = ? AND club_id = ? AND status = "approved"
        ');
        $stmt->execute([$user_id, $club_id]);
        if (!$stmt->fetch()) {
            header('Location: blogs.php');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: blogs.php');
        exit;
    }
}

// Get club details
$club = null;
if ($club_id) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM clubs WHERE club_id = ?');
        $stmt->execute([$club_id]);
        $club = $stmt->fetch();
    } catch (PDOException $e) {
        $club = null;
    }
}

// Handle blog creation
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $excerpt = $_POST['excerpt'] ?? '';
    $featured_image = $_POST['featured_image'] ?? '';
    
    if (empty($title) || empty($content)) {
        $error = 'Title and content are required!';
    } else {
        try {
            $stmt = $pdo->prepare('
                INSERT INTO blogs (club_id, author_id, title, content, excerpt, featured_image, status)
                VALUES (?, ?, ?, ?, ?, ?, "published")
            ');
            $stmt->execute([$club_id, $user_id, $title, $content, $excerpt, $featured_image]);
            $blog_id = $pdo->lastInsertId();
            $success = 'Blog created successfully!';
            header("Location: blog-detail.php?blog_id=$blog_id");
            exit;
        } catch (PDOException $e) {
            $error = 'Error creating blog: ' . $e->getMessage();
        }
    }
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
    <div class="container position-relative" style="z-index: 1;">
        <h1 class="display-4 fw-bold mb-3"><i class="fas fa-pen-fancy me-3"></i>Create Blog</h1>
        <p class="fs-5 text-white-50">Share your thoughts and stories with the <?php echo htmlspecialchars($club['club_name'] ?? 'club'); ?> community</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <!-- Blog Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Blog Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="title" name="title" 
                                   placeholder="Enter an engaging title..." required>
                            <small class="text-muted">Make it catchy and descriptive</small>
                        </div>

                        <!-- Featured Image URL -->
                        <div class="mb-4">
                            <label for="featured_image" class="form-label fw-bold">Featured Image URL</label>
                            <input type="url" class="form-control" id="featured_image" name="featured_image" 
                                   placeholder="https://example.com/image.jpg">
                            <small class="text-muted">Paste a direct image URL (JPG, PNG, SVG)</small>
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-4">
                            <label for="excerpt" class="form-label fw-bold">Excerpt (Preview Text)</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="2" 
                                      placeholder="Brief summary of your blog post (will be shown in preview)..."></textarea>
                            <small class="text-muted">Max 500 characters</small>
                        </div>

                        <!-- Blog Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">Blog Content <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="content" name="content" rows="12" 
                                      placeholder="Write your blog content here... You can use HTML formatting." required></textarea>
                            <small class="text-muted">
                                You can use HTML tags for formatting: &lt;b&gt;bold&lt;/b&gt;, &lt;i&gt;italic&lt;/i&gt;, &lt;a href=&quot;url&quot;&gt;links&lt;/a&gt;, etc.
                            </small>
                        </div>

                        <!-- Club Info -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Publishing to:</strong> <?php echo htmlspecialchars($club['club_name'] ?? 'Unknown Club'); ?>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="fas fa-save me-2"></i>Publish Blog
                            </button>
                            <a href="blogs.php?club_id=<?php echo $club_id; ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Panel -->
            <div class="card mt-4">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-eye me-2"></i>Preview
                </div>
                <div class="card-body">
                    <h5 id="preview_title" class="fw-bold">Your blog title will appear here</h5>
                    <small class="text-muted">
                        <i class="fas fa-user me-1"></i>By <?php echo htmlspecialchars($user_name); ?>
                    </small>
                    <div id="preview_content" class="mt-3 p-3 bg-light rounded">
                        <p class="text-muted">Your blog content preview will appear here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview
document.getElementById('title').addEventListener('input', function() {
    document.getElementById('preview_title').textContent = this.value || 'Your blog title will appear here';
});

document.getElementById('content').addEventListener('input', function() {
    const preview = this.value.substring(0, 200) || 'Your blog content preview will appear here...';
    document.getElementById('preview_content').innerHTML = preview;
});
</script>

<?php include 'includes/footer.php'; ?>
