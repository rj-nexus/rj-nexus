[v1.11.2] - 2026-11-24
🚀 Added
Frontend Comments System: Added App\Http\Controllers\Frontend\CommentController for visitor-submitted comments on blog posts. Previously only the admin panel could manage comments — now the frontend fully supports submission, moderation queue (pending status), and nested replies.

Post::comments() Relationship: Added hasMany(Comment::class) to the Post model for use across frontend and admin.

Frontend Comment Route: Registered POST /{locale}/blog/{post}/comment with throttle:10,1 rate limiting under frontend.comments.store.

Comment Spam Protection: Added URL count limit (max 2 links per comment) and a basic spam word blocklist to CommentController@store.

Docs Route Restored: Re-added /docs/{slug?} frontend route with a new App\Http\Controllers\Frontend\DocsController.

Language Translation Sorting: Added sorting to the Language → Translate section so untranslated strings can be viewed first. Users can now also manually translate strings and add missing keys directly from this section.

🐛 Fixed
Duplicate Backup Pages: Merged the two separate backup pages (one under Settings, one standalone) into a single consolidated page. Backup is now accessible from Sidebar → Tools → Backup — no longer inside Settings.

Auto Backup Not Running: Fixed the scheduled automatic backup process that was silently failing.

Comment Route Cache: Cleared stale route cache affecting the new comment endpoint.

Missing Post::comments() Method: Resolved BadMethodCallException when rendering comments on single post pages.

Comment store signature: CommentController@store now correctly accepts the {locale} route parameter alongside {post}.

