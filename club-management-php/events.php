<?php 
include 'includes/header.php';
require_once 'config/db.php';

// Get all events
try {
    $stmt = $pdo->prepare('
        SELECT e.*, c.club_name 
        FROM events e 
        JOIN clubs c ON e.club_id = c.club_id 
        ORDER BY e.event_date ASC
    ');
    $stmt->execute();
    $events = $stmt->fetchAll();
} catch (PDOException $e) {
    $events = [];
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #ec4899 0%, #f59e0b 100%); color: white; position: relative; overflow: hidden;">
    <div class="container position-relative" style="z-index: 1;">
        <h1 class="display-4 fw-bold mb-3"><i class="fas fa-calendar-alt me-3"></i>Upcoming Events</h1>
        <p class="fs-5 text-white-50">Don't miss out on exciting club events, workshops, and activities!</p>
    </div>
</section>

<div class="container py-5">
    <!-- Filter Section -->
    <div class="row mb-5">
        <div class="col-md-8">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-white border-0" style="border-radius: 10px 0 0 10px;">
                    <i class="fas fa-search text-warning"></i>
                </span>
                <input type="text" class="form-control" id="searchInput" placeholder="Search events by name..." onkeyup="filterEvents()" style="border: 2px solid #e5e7eb; border-radius: 0 10px 10px 0;">
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select form-select-lg" id="sortFilter" onchange="filterEvents()" style="border: 2px solid #e5e7eb; border-radius: 10px;">
                <option value="date">📅 By Date</option>
                <option value="club">🏢 By Club</option>
            </select>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="row g-4" id="eventsContainer">
        <?php foreach ($events as $event): 
            $eventDate = new DateTime($event['event_date']);
            $today = new DateTime();
            $isUpcoming = $eventDate > $today;
        ?>
            <div class="col-md-6 col-lg-4 event-card" data-name="<?php echo htmlspecialchars($event['event_name']); ?>" data-club="<?php echo htmlspecialchars($event['club_name']); ?>" data-date="<?php echo $event['event_date']; ?>">
                <div class="card h-100">
                    <div class="position-relative" style="overflow: hidden;">
                        <img src="<?php echo htmlspecialchars($event['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                        <div class="position-absolute top-0 start-0 m-3">
                            <?php if ($isUpcoming): ?>
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Upcoming
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-calendar-times me-1"></i>Past
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="position-absolute top-0 end-0 m-3">
                            <div class="bg-white rounded p-2 text-center" style="min-width: 60px;">
                                <div class="fw-bold" style="color: #ec4899; font-size: 1.3rem;"><?php echo $eventDate->format('d'); ?></div>
                                <div class="text-muted small"><?php echo $eventDate->format('M'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1"><?php echo htmlspecialchars($event['event_name']); ?></h5>
                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-users me-1" style="color: #6366f1;"></i><?php echo htmlspecialchars($event['club_name']); ?>
                        </p>
                        <p class="card-text text-muted flex-grow-1" style="font-size: 0.95rem;"><?php echo htmlspecialchars(substr($event['description'], 0, 100)) . (strlen($event['description']) > 100 ? '...' : ''); ?></p>
                        <div class="d-flex flex-column gap-2 pt-3 border-top">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-map-marker-alt me-2" style="color: #ec4899;"></i>
                                <small><?php echo htmlspecialchars($event['location']); ?></small>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-clock me-2" style="color: #f59e0b;"></i>
                                <small><?php echo $eventDate->format('h:i A'); ?></small>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-users-check me-2" style="color: #10b981;"></i>
                                <small><?php echo $event['attendees_count']; ?> registered</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top">
                        <div class="d-grid gap-2">
                            <?php if ($is_logged_in): ?>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal<?php echo $event['event_id']; ?>">
                                    <i class="fas fa-ticket-alt me-1"></i><?php echo $isUpcoming ? 'Register Now' : 'View Details'; ?>
                                </button>
                            <?php else: ?>
                                <a href="auth/login.php" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login to Register
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($events)): ?>
        <div class="text-center py-5">
            <i class="fas fa-calendar-plus fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
            <h4 class="text-muted">No events scheduled</h4>
            <p class="text-muted">Check back soon for exciting events!</p>
        </div>
    <?php endif; ?>
</div>

<script>
function filterEvents() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const sortFilter = document.getElementById('sortFilter').value;
    const cards = document.querySelectorAll('.event-card');
    const cardsArray = Array.from(cards);

    // Filter
    cardsArray.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const matchesSearch = name.includes(searchTerm);
        card.style.display = matchesSearch ? '' : 'none';
    });

    // Sort visible cards
    const visibleCards = cardsArray.filter(card => card.style.display !== 'none');
    if (sortFilter === 'date') {
        visibleCards.sort((a, b) => new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date')));
    } else if (sortFilter === 'club') {
        visibleCards.sort((a, b) => a.getAttribute('data-club').localeCompare(b.getAttribute('data-club')));
    }

    // Reorder DOM
    const container = document.getElementById('eventsContainer');
    visibleCards.forEach(card => container.appendChild(card));
}
</script>

<?php include 'includes/footer.php'; ?>
