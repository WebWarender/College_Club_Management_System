-- Insert sample events for clubs
INSERT INTO events (club_id, event_name, description, event_date, location, image_url) VALUES
(1, 'Python Workshop', 'Learn Python basics with hands-on coding exercises. Perfect for beginners!', '2025-12-05 10:00:00', 'Tech Lab, Building A', 'public/images/event-placeholder.svg'),
(1, 'Hackathon 2025', 'Annual hackathon competition. Build amazing projects and win prizes!', '2025-12-15 09:00:00', 'Auditorium, Building B', 'public/images/event-placeholder.svg'),
(1, 'Web Development Bootcamp', 'Intensive bootcamp covering HTML, CSS, and JavaScript. 5-day course!', '2025-12-28 10:00:00', 'Tech Lab, Building A', 'public/images/event-placeholder.svg'),
(1, 'AI & Machine Learning Talk', 'Industry expert sharing insights on AI/ML careers and applications.', '2026-01-10 15:00:00', 'Auditorium, Building B', 'public/images/event-placeholder.svg'),
(2, 'Football Tournament', 'Inter-college football championship. Show your skills and spirit!', '2025-12-10 14:00:00', 'Sports Ground', 'public/images/event-placeholder.svg'),
(2, 'Fitness Challenge', 'Monthly fitness competition. Track your progress and compete!', '2025-12-20 06:00:00', 'Gym, Sports Complex', 'public/images/event-placeholder.svg'),
(2, 'Badminton Championship', 'Compete in our annual badminton tournament with prizes!', '2026-01-05 09:00:00', 'Sports Complex', 'public/images/event-placeholder.svg'),
(2, 'Yoga & Wellness Session', 'Learn yoga and mindfulness for physical and mental health.', '2025-12-30 07:00:00', 'Gym, Sports Complex', 'public/images/event-placeholder.svg'),
(3, 'Cultural Fest', 'Celebrate diversity with music, dance, and food from around the world!', '2025-12-18 18:00:00', 'Main Hall, Building C', 'public/images/event-placeholder.svg'),
(3, 'Art Exhibition', 'Display of student artwork. Show your creativity to the campus community!', '2025-12-22 11:00:00', 'Gallery, Building D', 'public/images/event-placeholder.svg'),
(3, 'Music Jam Session', 'Open mic for musicians and artists to showcase their talent!', '2026-01-08 19:00:00', 'Auditorium, Building B', 'public/images/event-placeholder.svg'),
(3, 'Theater Play - ''Dreams Come True''', 'Original student-written play. An entertaining evening of drama!', '2025-12-29 18:00:00', 'Main Hall, Building C', 'public/images/event-placeholder.svg'),
(4, 'Debate Competition', 'Showcase your debating skills. Topics: Technology, Society, and Future!', '2025-12-08 15:00:00', 'Seminar Hall', 'public/images/event-placeholder.svg'),
(4, 'Parliamentary Debate Workshop', 'Learn parliamentary debate format from experienced coaches.', '2026-01-12 14:00:00', 'Seminar Hall', 'public/images/event-placeholder.svg'),
(4, 'Mock Parliament', 'Simulate parliament sessions and practice legislative debate.', '2026-01-20 10:00:00', 'Conference Room', 'public/images/event-placeholder.svg'),
(5, 'Photo Walk', 'Join us for a campus photo walk. Capture the beauty around you!', '2025-12-12 09:00:00', 'Campus Tour Start - Main Gate', 'public/images/event-placeholder.svg'),
(5, 'Photography Workshop', 'Learn professional photography techniques. Bring your cameras!', '2025-12-25 14:00:00', 'Tech Lab', 'public/images/event-placeholder.svg'),
(5, 'Photo Exhibition - ''Campus Stories''', 'Showcase of student photography featuring campus life and events.', '2026-01-15 16:00:00', 'Gallery, Building D', 'public/images/event-placeholder.svg'),
(5, 'Portrait Photography Masterclass', 'Advanced techniques for portrait photography with studio setup.', '2026-01-25 15:00:00', 'Studio, Building A', 'public/images/event-placeholder.svg'),
(6, 'Cleanup Drive', 'Help us maintain a clean and green campus. Every bit counts!', '2025-12-07 08:00:00', 'Campus Grounds', 'public/images/event-placeholder.svg'),
(6, 'Tree Planting Initiative', 'Plant 500 trees on campus. Be part of our green revolution!', '2026-01-05 08:00:00', 'Campus Grounds', 'public/images/event-placeholder.svg'),
(6, 'Recycling Drive', 'Collect and recycle e-waste, plastic, and paper. Make a difference!', '2025-12-14 10:00:00', 'Central Court', 'public/images/event-placeholder.svg'),
(6, 'Sustainable Living Workshop', 'Learn eco-friendly practices for daily life and reducing carbon footprint.', '2026-01-18 14:00:00', 'Seminar Hall', 'public/images/event-placeholder.svg');

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
