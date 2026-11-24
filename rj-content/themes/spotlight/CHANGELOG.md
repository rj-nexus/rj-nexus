[1.1.4] - 2026-11-24
🐛 Bug Fixes
Comment form URL: Reply and main comment forms now use url()->current() . '/comment' (stored in $commentAction) instead of route('frontend.comments.store', $post), preventing 404 errors on translated slugs.

🎨 UI
Comment form layout: Replaced Tailwind grid classes (grid grid-cols-1 md:grid-cols-2 gap-4) with the theme's own .rj-form-row class, ensuring proper stacking on mobile via the existing @media (max-width: 640px) rule.