-- College Club Management System - PHP Version
-- Database Schema

CREATE DATABASE IF NOT EXISTS club_management_php;
USE club_management_php;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') DEFAULT 'student',
    avatar VARCHAR(100),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Clubs table
CREATE TABLE IF NOT EXISTS clubs (
    club_id INT AUTO_INCREMENT PRIMARY KEY,
    club_name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    image_url VARCHAR(255),
    members_count INT DEFAULT 0,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- Memberships table
CREATE TABLE IF NOT EXISTS memberships (
    membership_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    club_id INT NOT NULL,
    status ENUM('approved', 'pending', 'rejected') DEFAULT 'pending',
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_membership (user_id, club_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (club_id) REFERENCES clubs(club_id) ON DELETE CASCADE
);

-- Events table
CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    club_id INT NOT NULL,
    event_name VARCHAR(200) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255),
    image_url VARCHAR(255),
    attendees_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(club_id) ON DELETE CASCADE
);

-- Event attendees
CREATE TABLE IF NOT EXISTS event_attendees (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('registered', 'attended') DEFAULT 'registered',
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_attendance (event_id, user_id),
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Announcements table
CREATE TABLE IF NOT EXISTS announcements (
    announcement_id INT AUTO_INCREMENT PRIMARY KEY,
    club_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(club_id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- Blogs table for club-related student blogs
CREATE TABLE IF NOT EXISTS blogs (
    blog_id INT AUTO_INCREMENT PRIMARY KEY,
    club_id INT NOT NULL,
    author_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    excerpt VARCHAR(500),
    featured_image VARCHAR(255),
    status ENUM('published', 'draft', 'archived') DEFAULT 'published',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(club_id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_club_id (club_id),
    INDEX idx_author_id (author_id),
    INDEX idx_created_at (created_at)
);

-- Blog comments table
CREATE TABLE IF NOT EXISTS blog_comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    author_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(blog_id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Insert sample clubs
INSERT INTO clubs (club_name, description, category, image_url) VALUES
('Tech Club', 'Technology and programming enthusiasts. Join us for coding challenges, hackathons, and tech talks!', 'Tech', 'public/images/tech-club.svg'),
('Sports Club', 'All sports activities and competitions. Fitness, teamwork, and competition await!', 'Sports', 'public/images/sports-club.svg'),
('Cultural Club', 'Cultural events and performances. Celebrate diversity and creative expression!', 'Cultural', 'public/images/cultural-club.svg'),
('Debate Club', 'Debating and public speaking. Sharpen your arguments and leadership skills!', 'Debate', 'public/images/debate-club.svg'),
('Photography Club', 'Photography and visual arts. Capture moments and tell stories through images!', 'Photography', 'public/images/photography-club.svg'),
('Environmental Club', 'Eco-friendly initiatives and sustainability. Make a difference for our planet!', 'Eco', 'public/images/environmental-club.svg');

-- Insert sample users (password: test123)
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@college.edu', '$2y$10$UZM8nWAw8nWAw8nWAw8nWuZM8nWAw8nWAw8nWAw8nWAw8nWAw8nWu', 'admin'),
('John Doe', 'john@college.edu', '$2y$10$UZM8nWAw8nWAw8nWAw8nWuZM8nWAw8nWAw8nWAw8nWAw8nWAw8nWu', 'student'),
('Jane Smith', 'jane@college.edu', '$2y$10$UZM8nWAw8nWAw8nWAw8nWuZM8nWAw8nWAw8nWAw8nWAw8nWAw8nWu', 'student'),
('Mike Johnson', 'mike@college.edu', '$2y$10$UZM8nWAw8nWAw8nWAw8nWuZM8nWAw8nWAw8nWAw8nWAw8nWAw8nWu', 'student'),
('Sarah Williams', 'sarah@college.edu', '$2y$10$UZM8nWAw8nWAw8nWAw8nWuZM8nWAw8nWAw8nWAw8nWAw8nWAw8nWu', 'student');

-- Insert sample memberships (approving members to clubs)
INSERT INTO memberships (user_id, club_id, status) VALUES
(2, 1, 'approved'), -- John to Tech Club
(3, 2, 'approved'), -- Jane to Sports Club
(4, 3, 'approved'), -- Mike to Cultural Club
(5, 4, 'approved'), -- Sarah to Debate Club
(2, 2, 'approved'), -- John to Sports Club
(3, 1, 'approved'), -- Jane to Tech Club
(4, 5, 'approved'), -- Mike to Photography Club
(5, 6, 'approved'); -- Sarah to Environmental Club

-- Insert sample events for clubs
INSERT INTO events (club_id, event_name, description, event_date, location, image_url) VALUES
(1, 'Python Workshop', 'Learn Python basics with hands-on coding exercises. Perfect for beginners!', '2025-12-05 10:00:00', 'Tech Lab, Building A', 'public/images/event-placeholder.svg'),
(1, 'Hackathon 2025', 'Annual hackathon competition. Build amazing projects and win prizes!', '2025-12-15 09:00:00', 'Auditorium, Building B', 'public/images/event-placeholder.svg'),
(2, 'Football Tournament', 'Inter-college football championship. Show your skills and spirit!', '2025-12-10 14:00:00', 'Sports Ground', 'public/images/event-placeholder.svg'),
(2, 'Fitness Challenge', 'Monthly fitness competition. Track your progress and compete!', '2025-12-20 06:00:00', 'Gym, Sports Complex', 'public/images/event-placeholder.svg'),
(3, 'Cultural Fest', 'Celebrate diversity with music, dance, and food from around the world!', '2025-12-18 18:00:00', 'Main Hall, Building C', 'public/images/event-placeholder.svg'),
(3, 'Art Exhibition', 'Display of student artwork. Show your creativity to the campus community!', '2025-12-22 11:00:00', 'Gallery, Building D', 'public/images/event-placeholder.svg'),
(4, 'Debate Competition', 'Showcase your debating skills. Topics: Technology, Society, and Future!', '2025-12-08 15:00:00', 'Seminar Hall', 'public/images/event-placeholder.svg'),
(5, 'Photo Walk', 'Join us for a campus photo walk. Capture the beauty around you!', '2025-12-12 09:00:00', 'Campus Tour Start - Main Gate', 'public/images/event-placeholder.svg'),
(5, 'Photography Workshop', 'Learn professional photography techniques. Bring your cameras!', '2025-12-25 14:00:00', 'Tech Lab', 'public/images/event-placeholder.svg'),
(6, 'Cleanup Drive', 'Help us maintain a clean and green campus. Every bit counts!', '2025-12-07 08:00:00', 'Campus Grounds', 'public/images/event-placeholder.svg');

-- Insert sample blogs
INSERT INTO blogs (club_id, author_id, title, content, excerpt, featured_image, status, views) VALUES
(1, 2, 'Getting Started with Python', '<h2>Introduction to Python</h2><p>Python is one of the most beginner-friendly programming languages. In this blog, we explore the basics and why Python is perfect for learners.</p><p><strong>Key topics covered:</strong></p><ul><li>Variables and data types</li><li>Control flow</li><li>Functions</li><li>Modules</li></ul><p>Join our Tech Club to learn more!</p>', 'Learn why Python is the best language for beginners and get started today!', 'public/images/tech-club.svg', 'published', 45),
(1, 3, 'Web Development Trends 2025', '<h2>The Future of Web Development</h2><p>As we move into 2025, web development continues to evolve rapidly. Here are the top trends to watch:</p><ul><li>AI-powered development tools</li><li>Enhanced security frameworks</li><li>Progressive Web Apps</li><li>Low-code platforms</li></ul><p>Stay tuned for more updates from the Tech Club!</p>', 'Explore the latest trends shaping web development in 2025.', 'public/images/tech-club.svg', 'published', 62),
(2, 4, 'Benefits of Regular Exercise', '<h2>Stay Healthy, Stay Happy</h2><p>Regular physical activity is essential for both mental and physical health. Here are some benefits:</p><ul><li>Improved cardiovascular health</li><li>Better mental clarity</li><li>Stress relief</li><li>Increased energy levels</li></ul><p>Join Sports Club for exciting fitness activities!</p>', 'Discover how regular exercise can transform your life and health.', 'public/images/sports-club.svg', 'published', 38),
(2, 5, 'Team Sports and Leadership', '<h2>Leadership Through Sports</h2><p>Sports teach us valuable life lessons about teamwork, discipline, and leadership. Whether you\'re on a football field or a basketball court, these principles apply everywhere.</p><p>Join us in the Sports Club to develop your skills!</p>', 'Learn how sports develop leadership qualities and team dynamics.', 'public/images/sports-club.svg', 'published', 28),
(3, 2, 'Cultural Diversity on Campus', '<h2>Celebrating Our Diversity</h2><p>Our campus is a melting pot of cultures and traditions. The Cultural Club celebrates this diversity through events and performances.</p><p>Whether it\'s dance, music, or food, join us in celebrating what makes us unique!</p>', 'Explore how cultural diversity enriches our campus community.', 'public/images/cultural-club.svg', 'published', 52),
(4, 3, 'Effective Debate Techniques', '<h2>Master the Art of Debate</h2><p>Debating is a skill that strengthens your argumentation and communication abilities. Here\'s how to improve:</p><ul><li>Research thoroughly</li><li>Listen actively</li><li>Structure your arguments</li><li>Practice regularly</li></ul><p>Join Debate Club to sharpen your skills!</p>', 'Learn proven techniques to become a better debater.', 'public/images/debate-club.svg', 'published', 41),
(5, 4, 'Photography Fundamentals', '<h2>Master the Basics of Photography</h2><p>Photography is about capturing moments and telling stories. Here are the fundamental principles:</p><ul><li>Understanding light</li><li>Composition rules</li><li>Camera settings</li><li>Post-processing tips</li></ul><p>Explore the world through our Photography Club!</p>', 'Learn the fundamental principles that make great photographs.', 'public/images/photography-club.svg', 'published', 35),
(6, 5, 'Sustainability: Small Steps, Big Impact', '<h2>Making a Difference for Our Planet</h2><p>Sustainability isn\'t just a buzzword; it\'s a responsibility. Here are simple ways to contribute:</p><ul><li>Reduce, reuse, recycle</li><li>Save water and energy</li><li>Support eco-friendly products</li><li>Participate in cleanup drives</li></ul><p>Join Environmental Club in making our campus greener!</p>', 'Discover how small sustainable actions can create a big environmental impact.', 'public/images/environmental-club.svg', 'published', 56);

-- Insert sample blog comments
INSERT INTO blog_comments (blog_id, author_id, content) VALUES
(1, 3, 'Great introduction to Python! This really helped me understand the basics.'),
(1, 4, 'Love the simple explanations. Can we have more examples?'),
(2, 5, 'AI tools are definitely changing the landscape. Excited about the future!'),
(3, 2, 'Thanks for the motivation! Starting my fitness journey today.'),
(4, 4, 'Perfectly written. Team sports have taught me so much about life.'),
(5, 3, 'Our campus is truly diverse and beautiful. Love celebrating it!'),
(6, 5, 'These techniques have already improved my debates. Thanks!'),
(7, 2, 'Beautiful photography tips! Looking forward to trying these.');
