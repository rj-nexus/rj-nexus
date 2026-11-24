## [v1.0.5] - 2026-11-24

### 🐛 Fixed
- **Comment form action:** Replaced `route('frontend.comments.store', $post)` with `url()->current() . '/comment'` in `single-post.blade.php` to prevent 404 on translated slugs.
- **Comment form layout:** Replaced Tailwind grid classes with `.rj-form-row` custom class; name/email fields now stack vertically on mobile (`max-width: 768px`).

### 🔧 Changed
- **`single-post.blade.php`:** Extracted comment form action into a single `$commentAction` variable used by both the reply and main comment forms.