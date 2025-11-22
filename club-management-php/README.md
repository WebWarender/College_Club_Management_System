# College Club Management System - PHP Version

A complete college club management system built with PHP, HTML, Bootstrap, and MySQL. This is a server-side rendering version with session-based authentication.

## Features

✅ **User Authentication**
- Secure login and registration with bcrypt password hashing
- Session-based authentication
- Role-based access (Admin/Student)

✅ **Club Management**
- Browse and discover clubs
- Join clubs (with pending approval)
- View club details, members, and events
- Search and filter clubs by category

✅ **Events**
- View upcoming events by club
- Event details (date, time, location, attendees)
- Register for events (when logged in)

✅ **Announcements**
- View club announcements
- Filter by club
- Real-time updates

✅ **User Profile**
- View personal profile
- Track joined clubs
- View club membership status
- Statistics dashboard

✅ **Modern UI**
- Responsive Bootstrap 5 design
- Gradient backgrounds
- Smooth animations
- Mobile-friendly interface

## Project Structure

```
club-management-php/
├── auth/                    # Authentication pages
│   ├── login.php           # Login page
│   ├── register.php        # Registration page
│   └── logout.php          # Logout handler
├── config/                 # Configuration files
│   ├── db.php              # Database connection
│   └── database.sql        # Database schema
├── includes/               # Reusable components
│   ├── header.php          # Navigation header
│   ├── footer.php          # Footer
│   └── session.php         # Session management
├── public/                 # Public assets
│   ├── css/
│   │   └── style.css       # Global styles
│   ├── js/
│   │   └── main.js         # Main JavaScript
│   └── images/             # Image assets
├── index.php               # Homepage
├── clubs.php               # Clubs listing
├── club-details.php        # Club details page
├── events.php              # Events listing
├── announcements.php       # Announcements page
├── profile.php             # User profile (protected)
└── my-events.php           # User's events
```

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP or similar local development environment

### Steps

1. **Create Database**
   - Open MySQL Workbench or phpMyAdmin
   - Run the SQL script from `config/database.sql`
   - Database: `club_management_php`

2. **Configure Database Connection**
   - Edit `config/db.php`
   - Update database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASSWORD', 'your_password');
     define('DB_NAME', 'club_management_php');
     ```

3. **Place in Web Root**
   - Copy project folder to: `C:\xampp\htdocs\club-management-php`
   - Or your XAMPP `htdocs` directory

4. **Start Services**
   - Start Apache and MySQL in XAMPP Control Panel

5. **Access Application**
   - Open browser: `http://localhost/club-management-php`

## Images & Assets

The system includes professional SVG images for all club categories:

📁 **Image Files** (`public/images/`)
- `tech-club.svg` - Technology & Programming club
- `sports-club.svg` - Sports & Fitness club
- `cultural-club.svg` - Cultural & Arts club
- `debate-club.svg` - Debate & Speaking club
- `photography-club.svg` - Photography & Visual arts club
- `environmental-club.svg` - Environmental & Sustainability club
- `event-placeholder.svg` - Generic event image
- `avatar-placeholder.svg` - User avatar template
- `hero-bg.svg` - Homepage hero background

✨ **Design Features**
- Modern gradient backgrounds
- Responsive SVG images
- Emoji icons for visual appeal
- Professional color schemes
- Smooth animations and transitions

## Default Credentials

```
Email: admin@college.edu
Password: test123
Role: Admin

Email: john@college.edu
Password: test123
Role: Student
```

## Key Features Overview

### Authentication
- Secure password hashing with bcrypt
- Session-based user authentication
- Role-based access control (Admin/Student)
- Logout functionality

### Clubs
- Browse all available clubs
- Search clubs by name
- Filter by category (Tech, Sports, Cultural, etc.)
- Join clubs (pending approval by admin)
- View club details, members, and events

### Events
- View all upcoming events
- Register for events (when logged in)
- See event details (date, time, location)
- Track event attendees

### User Profile
- View personal profile information
- See joined clubs and membership status
- Statistics (clubs joined, events attended)
- Edit profile information (future feature)

## Technologies Used

- **Backend**: PHP 7.4+
- **Frontend**: HTML5, Bootstrap 5.3.0
- **Database**: MySQL
- **Icons**: Font Awesome 6.4.0
- **Images**: Unsplash (dynamic image URLs)

## Security Features

✅ Prepared statements (SQL injection prevention)
✅ Password hashing with bcrypt
✅ Session-based authentication
✅ Role-based access control
✅ Input validation and sanitization
✅ CSRF protection (via sessions)

## File Permissions

Ensure these directories are writable:
```bash
chmod 755 config/
chmod 755 public/
chmod 755 includes/
```

## Troubleshooting

### Database Connection Error
- Check MySQL is running
- Verify credentials in `config/db.php`
- Ensure database exists: `club_management_php`

### Session Not Working
- Check `php.ini` session settings
- Ensure `/tmp` or session directory is writable
- Clear browser cookies and try again

### Styles Not Loading
- Check file paths in `includes/header.php`
- Ensure `public/css/style.css` exists
- Clear browser cache

## Future Enhancements

- [ ] Event registration and attendance tracking
- [ ] Admin dashboard for club management
- [ ] Blog/News section
- [ ] Email notifications
- [ ] File uploads for club logos/images
- [ ] Social sharing features
- [ ] Advanced search and filtering
- [ ] User comments and reviews

## License

This project is open source and available for educational purposes.

## Support

For issues or questions, please check the configuration files and ensure all prerequisites are met.
