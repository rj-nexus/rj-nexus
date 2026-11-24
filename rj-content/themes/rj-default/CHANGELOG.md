## [v1.0.4] - 2026-11-24

### 🚀 Added
- **Frontend Comments System:** Added a fully functional, native comment system for frontend posts, including:
  - A dedicated `CommentController` to securely handle visitor submissions.
  - Registered the `/blog/{post}/comment` route with rate-limiting (`throttle:10,1`) to prevent spam.
  - Modern UI integration in the `rj-default` theme (`single-post.blade.php`).
  - Support for nested replies (threaded comments).
  - Auto-generated user avatars via Gravatar.
  - Form validation with session-based success and error alerts.
  - Global comment toggle support (`comments_enabled` option) and per-post comment settings.