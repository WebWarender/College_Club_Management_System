<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section py-5" style="background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%); color: white; position: relative;">
    <div class="container text-center py-5 position-relative" style="z-index: 1;">
        <div style="animation: slideInUp 0.8s ease-out;">
            <h1 class="display-3 fw-bold mb-3" style="letter-spacing: -1px;">Welcome to <span class="text-white">Club Connect</span></h1>
            <p class="fs-5 mb-4 text-white-50">Your ultimate platform for discovering, managing, and engaging with college clubs.</p>
            <p class="fs-6 mb-5 text-white-50">Connect with peers, explore opportunities, and be part of amazing communities!</p>
            <?php if (!$is_logged_in): ?>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="auth/register.php" class="btn btn-light btn-lg px-5 py-2">
                        <i class="fas fa-rocket me-2"></i>Get Started
                    </a>
                    <a href="auth/login.php" class="btn btn-outline-light btn-lg px-5 py-2">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </div>
            <?php else: ?>
                <a href="clubs.php" class="btn btn-light btn-lg px-5 py-2">
                    <i class="fas fa-star me-2"></i>Explore Clubs Now
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="feature-card">
                    <h3 class="text-gradient fw-bold">50+</h3>
                    <p class="text-muted">Active Clubs</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card">
                    <h3 class="text-gradient fw-bold">5000+</h3>
                    <p class="text-muted">Members</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card">
                    <h3 class="text-gradient fw-bold">100+</h3>
                    <p class="text-muted">Events</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card">
                    <h3 class="text-gradient fw-bold">24/7</h3>
                    <p class="text-muted">Support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Why Choose Club Connect?</h2>
            <p class="fs-5 text-muted">Everything you need to manage and enjoy your college club experience</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-3">Join Your Clubs</h5>
                    <p class="card-text text-muted">Discover and join clubs that match your interests, passions, and goals. Find your community!</p>
                    <ul class="list-unstyled mt-3 text-start">
                        <li><i class="fas fa-check text-success me-2"></i>Easy browsing</li>
                        <li><i class="fas fa-check text-success me-2"></i>Filter by category</li>
                        <li><i class="fas fa-check text-success me-2"></i>One-click join</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="color: #ec4899;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-3">Never Miss Events</h5>
                    <p class="card-text text-muted">Stay updated with upcoming events, workshops, and activities. Register and attend with ease.</p>
                    <ul class="list-unstyled mt-3 text-start">
                        <li><i class="fas fa-check text-success me-2"></i>Event calendar</li>
                        <li><i class="fas fa-check text-success me-2"></i>Instant notifications</li>
                        <li><i class="fas fa-check text-success me-2"></i>Easy registration</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="color: #f59e0b;">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-3">Stay Connected</h5>
                    <p class="card-text text-muted">Get instant announcements from your clubs. Never miss important updates and information.</p>
                    <ul class="list-unstyled mt-3 text-start">
                        <li><i class="fas fa-check text-success me-2"></i>Real-time updates</li>
                        <li><i class="fas fa-check text-success me-2"></i>Push notifications</li>
                        <li><i class="fas fa-check text-success me-2"></i>Personalized feed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; position: relative;">
    <div class="container text-center">
        <h2 class="fw-bold mb-4 display-5">Ready to Get Involved?</h2>
        <p class="fs-5 mb-4 text-white-50">Join thousands of students already exploring amazing clubs and making lasting friendships!</p>
        <?php if (!$is_logged_in): ?>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="auth/register.php" class="btn btn-light btn-lg px-5 py-2">Create Account</a>
                <a href="auth/login.php" class="btn btn-outline-light btn-lg px-5 py-2">Sign In</a>
            </div>
        <?php else: ?>
            <a href="clubs.php" class="btn btn-light btn-lg px-5 py-2">Explore All Clubs</a>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
