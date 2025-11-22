# 🎯 Quick Start - Blogs & Events

## What's New?

Students can now **create & manage blogs** and **add club events** after logging in!

---

## 📝 Create a Blog (Student)

### Access Blog System
```
Login → Click "Blogs" in navbar → Select your club → Click "Create New Blog"
```

### Blog Fields
- **Title**: Post title (required)
- **Featured Image**: Image URL (optional)
- **Excerpt**: Preview text (optional)
- **Content**: Full blog post (supports HTML) (required)

### Who Can Blog?
✅ Approved club members only
❌ Non-members get blocked

---

## 🎪 Create Club Events

### Access Event Management
```
Login → Dropdown menu → "Manage Clubs" → "Club Events" tab → Select club
```

### Event Fields
- **Event Name**: Title (required)
- **Date & Time**: When it happens (required)
- **Location**: Where (required)
- **Description**: Details (optional)
- **Image URL**: Event poster (optional)

### Who Can Add Events?
✅ Club members
❌ Non-members blocked

---

## 📄 New Files Created

| File | URL | Purpose |
|------|-----|---------|
| `blogs.php` | `/blogs.php` | View/manage blogs |
| `create-blog.php` | `/create-blog.php` | Write blog |
| `blog-detail.php` | `/blog-detail.php` | Read blog |
| `manage-clubs.php` | `/manage-clubs.php` | Manage clubs & events |

---

## 🗄️ Database Tables Added

```
blogs              - Store blog posts
blog_comments      - Store comments
```

### Update Database

**Option 1: Command Line**
```bash
mysql -u root -p club_management_php < config/database.sql
```

**Option 2: phpMyAdmin**
1. Go to http://localhost/phpmyadmin
2. Select `club_management_php`
3. Click Import
4. Choose `config/database.sql`
5. Click Import

---

## ✨ Features

### Blogs
- Write rich content (HTML supported)
- Featured images
- Auto view counter
- Comment system
- Multiple clubs

### Events
- Create events with all details
- Set date and time
- Track attendees
- Add descriptions
- Display on Events page

---

## 🔒 Permissions

| Action | Student | Admin |
|--------|---------|-------|
| Create Blog | ✅ In joined clubs | ✅ All |
| Create Event | ✅ In joined clubs | ✅ All |
| View Blogs | ✅ Public | ✅ Public |
| Edit Own Blog | ✅ | ✅ All |
| Delete Own Blog | ✅ | ✅ All |

---

## 🎓 Example Workflows

### Workflow 1: Share Club News
```
1. Login
2. Blogs → Select Club → Create New Blog
3. Write about club activity/achievement
4. Publish
5. Other members see and comment!
```

### Workflow 2: Announce Event
```
1. Login
2. Manage Clubs → Club Events tab
3. Fill event form (name, date, location)
4. Save
5. Shows on Events page automatically
```

---

## 📱 Mobile Friendly
✅ All new pages are responsive
✅ Works on phones, tablets, desktops
✅ Touch-friendly buttons and forms

---

## 🧪 Test It!

1. **Create a blog:**
   - Login → Blogs → Select Club → Create → Publish
   - Verify it shows in blog list

2. **Add an event:**
   - Login → Manage Clubs → Club Events → Create
   - Check if it appears on Events page

3. **Post a comment:**
   - Go to any blog → Scroll to Comments
   - Write and submit (if logged in)

---

## 🚀 Features Enabled

- ✅ Blog creation for club members
- ✅ Blog commenting system
- ✅ Event creation for club members
- ✅ Event management dashboard
- ✅ View tracking on blogs
- ✅ Rich content support
- ✅ Mobile responsive design
- ✅ User authentication checks
- ✅ Membership validation
- ✅ Database integration

---

## 💾 What Changed

### New Tables
- `blogs` - Blog posts
- `blog_comments` - Comments on blogs

### Updated Files
- `includes/header.php` - Added navigation links
- `config/database.sql` - Added new tables

### New Files
- `blogs.php` - Blog listing
- `create-blog.php` - Blog creation
- `blog-detail.php` - Blog detail view
- `manage-clubs.php` - Club management

---

## 📞 Help?

**Check if database updated:**
- phpMyAdmin → Select database → Tables
- Look for `blogs` and `blog_comments`

**Navigation not showing?**
- Log out and log back in
- Hard refresh browser (Ctrl+F5)

**Can't create blog?**
- Verify you're an approved club member
- Check "My Clubs" for status

---

## ✅ You're All Set!

Your students can now:
- 📝 Write and share blogs
- 🎪 Create club events
- 💬 Comment and discuss
- 📊 Track engagement

**Happy blogging! 🎉**
