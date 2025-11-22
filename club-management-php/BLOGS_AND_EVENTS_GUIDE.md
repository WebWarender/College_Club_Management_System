# Club Management System - Blogs & Events Guide

## 🎉 New Features Added

Your Club Connect website now includes powerful features for students to:
- ✅ Create and manage club-related blogs
- ✅ Add and manage upcoming club events
- ✅ Comment on blogs
- ✅ View and organize club activities

---

## 📚 Blog System

### What Can Students Do?

**Create Blogs:**
- Students who are approved members of a club can create blogs related to that club
- Each blog can include:
  - Title
  - Featured image
  - Detailed content (with HTML formatting support)
  - Excerpt/preview text

**Manage Blogs:**
- View all blogs from your enrolled clubs
- Track view counts
- Edit and delete your own blogs
- Comment on other members' blogs

**Share Knowledge:**
- Document club activities and experiences
- Share project updates and achievements
- Create tutorials or guides
- Post event recaps and learnings

### How to Access Blogs

1. **Login to the website**
2. **Click "Blogs" in the navigation menu** (or in the dropdown menu)
3. **Select a club** from the sidebar to view its blogs
4. **Click "Create New Blog"** to write a blog post

### Blog Creation Workflow

```
1. Login → 2. Go to Blogs → 3. Select Club → 4. Create Blog → 5. Publish
```

**Step-by-Step:**
1. Click "Blogs" in the top navigation
2. Select your club from the "Your Clubs" section
3. Click "Create New Blog" button
4. Fill in:
   - **Blog Title** - Make it catchy and descriptive
   - **Featured Image** - Paste a direct image URL (optional)
   - **Excerpt** - Brief summary for preview
   - **Blog Content** - Your full post (supports HTML formatting)
5. Click "Publish Blog"

### Features Included

✨ **Live Preview** - See how your blog looks as you type
✨ **HTML Support** - Format text with bold, italics, links, etc.
✨ **Auto-Excerpt** - System generates preview if you don't provide one
✨ **View Tracking** - See how many people read your blog
✨ **Comments** - Readers can comment and discuss
✨ **Author Info** - Display author details on each blog

### Blog Page Structure

- **Main Content Area**: Display blog with featured image and content
- **Comments Section**: View and add comments
- **Sidebar**: Related blogs and club info
- **Blog Meta**: Author, date, views, and category

---

## 🎯 Event Management

### What Can Students Do?

**Create Events:**
- Add upcoming club events with:
  - Event name and description
  - Date and time
  - Location
  - Featured image
  - Automatic attendee tracking

**Manage Events:**
- View all club events
- Edit event details
- Track attendee registrations
- Cancel or reschedule events

### How to Access Event Management

1. **Login to the website**
2. **Click user dropdown menu** → "Manage Clubs"
3. **Select "Club Events" tab**
4. **Choose a club** and add events

### Event Creation Workflow

```
1. Login → 2. Manage Clubs → 3. Club Events Tab → 4. Create Event → 5. Save
```

**Step-by-Step:**
1. Login and go to your profile dropdown
2. Click "Manage Clubs"
3. Click on "Club Events" tab
4. Select a club from "My Clubs" section
5. Fill in the event form:
   - **Event Name** - Clear, descriptive title
   - **Date & Time** - When the event happens
   - **Location** - Where it takes place
   - **Description** - Event details (optional)
   - **Image URL** - Event poster/image (optional)
6. Click "Create Event"

### Club Management Dashboard Features

**My Clubs Tab:**
- View all your enrolled clubs
- See member count
- Check membership status
- Quick access to view club details
- Go to club events management

**Club Events Tab:**
- Left Side: Event creation form
- Right Side: List of all club events
- Show event date, time, location
- Display number of registered attendees
- Edit/delete options for event organizers

---

## 📋 Database Changes

### New Tables Added

#### `blogs` Table
```sql
CREATE TABLE blogs (
    blog_id INT AUTO_INCREMENT PRIMARY KEY,
    club_id INT NOT NULL,
    author_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    excerpt VARCHAR(500),
    featured_image VARCHAR(255),
    status ENUM('published', 'draft', 'archived'),
    views INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(club_id),
    FOREIGN KEY (author_id) REFERENCES users(user_id)
);
```

#### `blog_comments` Table
```sql
CREATE TABLE blog_comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    author_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(blog_id),
    FOREIGN KEY (author_id) REFERENCES users(user_id)
);
```

### How to Update Your Database

1. **Backup your current database** (important!)
   ```bash
   mysqldump -u root -p club_management_php > backup.sql
   ```

2. **Run the updated SQL script:**
   ```bash
   mysql -u root -p club_management_php < config/database.sql
   ```

3. Or **import via phpMyAdmin:**
   - Go to http://localhost/phpmyadmin
   - Select database `club_management_php`
   - Click "Import"
   - Choose `config/database.sql`
   - Click "Import"

---

## 📄 New Pages Created

### For Students (Logged In)

| Page | URL | Purpose |
|------|-----|---------|
| Blogs | `/blogs.php` | View and manage club blogs |
| Create Blog | `/create-blog.php?club_id=X` | Write a new blog post |
| Blog Detail | `/blog-detail.php?blog_id=X` | Read a blog and comments |
| Manage Clubs | `/manage-clubs.php` | Manage clubs and events |

### Navigation Updates

**Main Menu:**
- Added "Blogs" link (appears when logged in)

**User Dropdown Menu:**
- Added "Manage Clubs" option
- Added "My Blogs" option (links to blogs.php)

---

## 🔐 Permissions & Security

### Who Can Do What?

**Create Blogs:**
- ✅ Approved members of a club
- ❌ Non-members cannot access create form
- ❌ Students can only create for clubs they've joined

**Create Events:**
- ✅ Club members can create events
- ✅ Automatic validation checks membership
- ❌ Non-members cannot create events

**Edit/Delete:**
- ✅ Blog author can edit their own blog
- ✅ Blog author can delete their own blog
- ❌ Other users cannot modify blogs
- ⏳ Event edit/delete (coming soon)

---

## 💡 User Guide Examples

### Example 1: Share Your Experience at a Club Event

```
1. Login to Club Connect
2. Go to Blogs menu
3. Select "Tech Club" from sidebar
4. Click "Create New Blog"
5. Title: "My First Hackathon Experience!"
6. Content: Write about your experience...
7. Click "Publish Blog"
8. Other members see and comment on it!
```

### Example 2: Schedule a Club Meeting

```
1. Login and go to user dropdown
2. Click "Manage Clubs"
3. Click "Club Events" tab
4. Select "Sports Club" from My Clubs
5. Fill in event form:
   - Event Name: "Weekly Team Practice"
   - Date: Saturday 3:00 PM
   - Location: Sports Field
6. Click "Create Event"
7. Members can see it on Events page!
```

### Example 3: Read Blogs and Comment

```
1. Go to Blogs page
2. Select a club
3. Click "Read More" on any blog
4. Read the blog post
5. Scroll to Comments section
6. Click "Post Comment" (if logged in)
7. Write and submit your comment
```

---

## 🎨 Features Overview

### Blog Features

| Feature | Details |
|---------|---------|
| **Rich Content** | HTML formatting support |
| **Featured Images** | Custom header image for blogs |
| **Excerpts** | Auto-generated or custom preview text |
| **View Count** | Track reader engagement |
| **Comments** | Community discussion on blogs |
| **Author Info** | Display author details |
| **Status** | Published/Draft/Archived |
| **Timestamps** | Creation and update dates |

### Event Features

| Feature | Details |
|---------|---------|
| **Event Details** | Name, date, time, location |
| **Descriptions** | Detailed event information |
| **Images** | Featured event poster/image |
| **Attendees** | Track registrations |
| **Status Tracking** | Upcoming/Past events |
| **Quick View** | Event card preview |
| **Full Details** | Complete event information |

---

## 🚀 Upcoming Features (Optional Enhancements)

- [ ] Draft blogs (save and publish later)
- [ ] Blog categories/tags
- [ ] Blog search functionality
- [ ] Event registration system
- [ ] Event reminders/notifications
- [ ] Blog rating system
- [ ] Event calendar view
- [ ] Export blogs to PDF
- [ ] Share blogs on social media
- [ ] Email notifications for new blogs
- [ ] Event feedback/reviews

---

## 🆘 Troubleshooting

### "Database error when creating blog"
**Solution:** Make sure you've run the updated `database.sql` file to create the new tables.

### "Can't see Blogs menu when logged in"
**Solution:** Refresh the page. Blogs link only appears after login.

### "Can't create blog - authorization error"
**Solution:** Make sure you're an approved member of the club. Check "My Clubs" to confirm status.

### "Event not showing up"
**Solution:** Clear browser cache. Event might be in the future - check date/time.

---

## 📞 Support

For issues or questions:
1. Check if database tables exist in phpMyAdmin
2. Verify user is logged in and is club member
3. Check browser console for JavaScript errors
4. Verify file permissions on server

---

## ✅ Testing Checklist

After setup, test these scenarios:

- [ ] Login as a student
- [ ] Navigate to Blogs page
- [ ] See "Your Clubs" sidebar
- [ ] Select a club
- [ ] Click "Create New Blog"
- [ ] Fill in blog form
- [ ] Publish blog
- [ ] View published blog
- [ ] Add a comment
- [ ] Go to Manage Clubs
- [ ] Click Club Events tab
- [ ] Create a new event
- [ ] See event in club events list

**Congratulations! Your blog and event system is ready! 🎉**
