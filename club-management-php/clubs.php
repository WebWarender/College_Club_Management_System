<?php 
include 'includes/header.php';
require_once 'config/db.php';

// Get all clubs
try {
    $stmt = $pdo->prepare('SELECT * FROM clubs ORDER BY club_name');
    $stmt->execute();
    $clubs = $stmt->fetchAll();
} catch (PDOException $e) {
    $clubs = [];
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; position: relative; overflow: hidden;">
    <div class="container position-relative" style="z-index: 1;">
        <h1 class="display-4 fw-bold mb-3"><i class="fas fa-layer-group me-3"></i>Explore All Clubs</h1>
        <p class="fs-5 text-white-50">Discover amazing clubs and join communities that match your interests and passions!</p>
    </div>
</section>

<div class="container py-5">
    <!-- Search & Filter Section -->
    <div class="row mb-5">
        <div class="col-md-6 mb-3">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-white border-0" style="border-radius: 10px 0 0 10px;">
                    <i class="fas fa-search text-primary"></i>
                </span>
                <input type="text" class="form-control" id="searchInput" placeholder="Search clubs by name..." onkeyup="filterClubs()" style="border: 2px solid #e5e7eb; border-radius: 0 10px 10px 0; font-size: 1rem;">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <select class="form-select form-select-lg" id="categoryFilter" onchange="filterClubs()" style="border: 2px solid #e5e7eb; border-radius: 10px;">
                <option value="">📂 All Categories</option>
                <option value="Tech">💻 Tech</option>
                <option value="Sports">⚽ Sports</option>
                <option value="Cultural">🎭 Cultural</option>
                <option value="Debate">🎤 Debate</option>
                <option value="Photography">📷 Photography</option>
                <option value="Eco">🌱 Eco</option>
            </select>
        </div>
    </div>

    <!-- Clubs Grid -->
    <div class="row g-4" id="clubsContainer">
        <?php foreach ($clubs as $club): ?>
            <div class="col-md-6 col-lg-4 club-card" data-name="<?php echo htmlspecialchars($club['club_name']); ?>" data-category="<?php echo htmlspecialchars($club['category']); ?>">
                <div class="card h-100">
                    <div class="position-relative" style="overflow: hidden;">
                        <img src="<?php echo htmlspecialchars($club['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($club['club_name']); ?>">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge" style="background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%); padding: 0.6rem 1rem;">
                                <i class="fas fa-star me-1"></i><?php echo htmlspecialchars($club['category']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2" style="font-size: 1.2rem;"><?php echo htmlspecialchars($club['club_name']); ?></h5>
                        <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars(substr($club['description'], 0, 100)) . (strlen($club['description']) > 100 ? '...' : ''); ?></p>
                        <div class="d-flex justify-content-between align-items-center mb-3 pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-users me-1" style="color: #6366f1;"></i>
                                <span class="fw-bold"><?php echo $club['members_count']; ?></span> Members
                            </small>
                            <small class="badge bg-light text-primary">
                                <i class="fas fa-check-circle me-1"></i>Active
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top">
                        <div class="d-grid gap-2">
                            <?php if ($is_logged_in): ?>
                                <a href="club-details.php?id=<?php echo $club['club_id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-arrow-right me-1"></i>View Details
                                </a>
                            <?php else: ?>
                                <a href="auth/login.php" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login to Join
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($clubs)): ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
            <h4 class="text-muted">No clubs found</h4>
            <p class="text-muted">Check back soon for new clubs!</p>
        </div>
    <?php endif; ?>
</div>

<script>
function filterClubs() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const cards = document.querySelectorAll('.club-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const category = card.getAttribute('data-category');

        const matchesSearch = name.includes(searchTerm);
        const matchesCategory = categoryFilter === '' || category === categoryFilter;

        if (matchesSearch && matchesCategory) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide no results message
    const container = document.getElementById('clubsContainer');
    if (visibleCount === 0) {
        container.insertAdjacentHTML('afterend', '<div class="text-center py-5" id="noResults"><i class="fas fa-search fa-3x text-muted mb-3" style="opacity: 0.3;"></i><h4 class="text-muted">No clubs match your search</h4><p class="text-muted">Try a different search or filter!</p></div>');
    } else {
        const noResults = document.getElementById('noResults');
        if (noResults) noResults.remove();
    }
}
</script>

<?php include 'includes/footer.php'; ?></script>

