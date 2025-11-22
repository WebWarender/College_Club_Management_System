<?php 
include 'includes/header.php';
require_once 'config/db.php';

// Check if user is logged in
if (!$is_logged_in) {
    header('Location: auth/login.php');
    exit;
}

$tab = $_GET['tab'] ?? 'my-clubs';
$error = '';
$success = '';

// Get user's clubs
try {
    $stmt = $pdo->prepare('
        SELECT c.*, m.status, 
               (SELECT COUNT(*) FROM memberships WHERE club_id = c.club_id AND status = "approved") as member_count
        FROM clubs c
        JOIN memberships m ON c.club_id = m.club_id
        WHERE m.user_id = ?
        ORDER BY c.club_name
    ');
    $stmt->execute([$user_id]);
    $my_clubs = $stmt->fetchAll();
} catch (PDOException $e) {
    $my_clubs = [];
}

// Handle event creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_event') {
        $club_id = $_POST['club_id'] ?? null;
        $event_name = $_POST['event_name'] ?? '';
        $description = $_POST['description'] ?? '';
        $event_date = $_POST['event_date'] ?? '';
        $location = $_POST['location'] ?? '';
        $image_url = $_POST['image_url'] ?? 'public/images/event-placeholder.svg';

        // Check if user is club admin or member
        if ($club_id) {
            try {
                $stmt = $pdo->prepare('
                    SELECT * FROM memberships 
                    WHERE user_id = ? AND club_id = ? AND status = "approved"
                ');
                $stmt->execute([$user_id, $club_id]);
                if ($stmt->fetch()) {
                    if (empty($event_name) || empty($event_date) || empty($location)) {
                        $error = 'Event name, date, and location are required!';
                    } else {
                        try {
                            $stmt = $pdo->prepare('
                                INSERT INTO events (club_id, event_name, description, event_date, location, image_url)
                                VALUES (?, ?, ?, ?, ?, ?)
                            ');
                            $stmt->execute([$club_id, $event_name, $description, $event_date, $location, $image_url]);
                            $success = 'Event created successfully!';
                        } catch (PDOException $e) {
                            $error = 'Error creating event: ' . $e->getMessage();
                        }
                    }
                } else {
                    $error = 'You are not authorized to create events for this club!';
                }
            } catch (PDOException $e) {
                $error = 'Error: ' . $e->getMessage();
            }
        }
    }
}

// Get club's events (if viewing a specific club)
$club_id = $_GET['club_id'] ?? null;
$club_events = [];
$selected_club = null;

if ($club_id && $tab === 'club-events') {
    try {
        $stmt = $pdo->prepare('
            SELECT * FROM clubs WHERE club_id = ?
        ');
        $stmt->execute([$club_id]);
        $selected_club = $stmt->fetch();

        $stmt = $pdo->prepare('
            SELECT * FROM events 
            WHERE club_id = ?
            ORDER BY event_date DESC
        ');
        $stmt->execute([$club_id]);
        $club_events = $stmt->fetchAll();
    } catch (PDOException $e) {
        $club_events = [];
    }
}
?>

<!-- Page Header -->
<section class="py-5" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; position: relative; overflow: hidden;">
    <div class="container position-relative" style="z-index: 1;">
        <h1 class="display-4 fw-bold mb-3"><i class="fas fa-cog me-3"></i>Club Management</h1>
        <p class="fs-5 text-white-50">Manage your clubs, events, and activities</p>
    </div>
</section>

<div class="container py-5">
    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?php echo $tab === 'my-clubs' ? 'active' : ''; ?>" 
               href="?tab=my-clubs">
                <i class="fas fa-layer-group me-2"></i>My Clubs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $tab === 'club-events' ? 'active' : ''; ?>" 
               href="?tab=club-events">
                <i class="fas fa-calendar-alt me-2"></i>Club Events
            </a>
        </li>
    </ul>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- My Clubs Tab -->
    <?php if ($tab === 'my-clubs'): ?>
        <div class="row g-4">
            <?php if (!empty($my_clubs)): ?>
                <?php foreach ($my_clubs as $club): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($club['image_url']); ?>" class="card-img-top" 
                                 style="height: 200px; object-fit: cover;" alt="<?php echo htmlspecialchars($club['club_name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo htmlspecialchars($club['club_name']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars(substr($club['description'], 0, 100)) . '...'; ?></p>
                                <div class="d-flex justify-content-between mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i><?php echo $club['member_count']; ?> Members
                                    </small>
                                    <span class="badge bg-<?php echo $club['status'] === 'approved' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($club['status']); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="d-grid gap-2">
                                    <a href="club-details.php?id=<?php echo $club['club_id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>View Club
                                    </a>
                                    <a href="?tab=club-events&club_id=<?php echo $club['club_id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-calendar me-1"></i>Events
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
                        <h4 class="text-muted">No clubs joined yet</h4>
                        <p class="text-muted mb-4">Join a club to manage it</p>
                        <a href="clubs.php" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Browse Clubs
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Club Events Tab -->
    <?php if ($tab === 'club-events'): ?>
        <?php if ($selected_club && $club_id): ?>
            <div class="row">
                <!-- Add Event Form -->
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="fas fa-plus me-2"></i>Create Event
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action" value="add_event">
                                <input type="hidden" name="club_id" value="<?php echo $club_id; ?>">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Event Name</label>
                                    <input type="text" class="form-control" name="event_name" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Date & Time</label>
                                    <input type="datetime-local" class="form-control" name="event_date" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Location</label>
                                    <input type="text" class="form-control" name="location" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Image URL</label>
                                    <input type="url" class="form-control" name="image_url" 
                                           value="public/images/event-placeholder.svg">
                                </div>

                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-save me-2"></i>Create Event
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Events List -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">
                            <i class="fas fa-calendar-alt me-2" style="color: #6366f1;"></i>
                            <?php echo htmlspecialchars($selected_club['club_name']); ?> Events
                        </h4>
                        <a href="?tab=club-events" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Clear
                        </a>
                    </div>

                    <?php if (!empty($club_events)): ?>
                        <div class="row g-3">
                            <?php foreach ($club_events as $event): ?>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <img src="<?php echo htmlspecialchars($event['image_url']); ?>" 
                                                     class="img-fluid rounded-start h-100" 
                                                     style="object-fit: cover; min-height: 150px;"
                                                     alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-bold"><?php echo htmlspecialchars($event['event_name']); ?></h6>
                                                    <p class="card-text text-muted"><?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?></p>
                                                    <div class="d-flex flex-wrap gap-3 mb-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar me-1"></i><?php echo date('M d, Y h:i A', strtotime($event['event_date'])); ?>
                                                        </small>
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($event['location']); ?>
                                                        </small>
                                                        <small class="text-muted">
                                                            <i class="fas fa-users me-1"></i><?php echo $event['attendees_count']; ?> attending
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-plus fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
                            <h5 class="text-muted">No events yet</h5>
                            <p class="text-muted">Create an event to get started!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-layer-group fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
                <h4 class="text-muted">Select a club to manage events</h4>
                <p class="text-muted">Go to "My Clubs" tab and click on a club's events button</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
