# RJ Builder & Theme Extensions — Changelog

## [v1.9.0] - 2026-11-06

### Security Release (RJ Builder Ecosystem)

This release focuses entirely on hardening the RJ Builder ecosystem, including core widgets, the Theme Editor, and the Form Builder extension. 

### 🔒 Security Fixes

- **Form Builder Extension (Mass Assignment Fix):**
  - Removed `status` from the `Form` model's `$fillable` array.
  - Removed `status`, `ip_address`, and `user_agent` from the `FormSubmission` model's `$fillable` array.
  - Attributes are now assigned manually and safely within `FormController` and `FormSubmitController`.
  - Enforced strict backend validation in the frontend submission controller. Only validated data (`$validated`) is now saved, preventing attackers from injecting hidden payloads into the form data.

- **Theme Editor (Path Traversal Protection):**
  - Hardened the `ThemeEditorService` to ensure safe file paths. Verified that `resolveSafePath()` and `realpath()` properly prevent directory traversal attacks during file reading, saving, and deleting.

- **Core Widgets (XSS Audit):**
  - Audited all built-in widgets (`MultiChatWidget`, `AdvancedSearchWidget`, `FooterBadgesWidget`) for XSS vulnerabilities.
  - Verified that all dynamic HTML injections (`{!! !!}`) are safely handled and protected against Cross-Site Scripting (XSS) payloads.

### 🛠 Maintenance
- Removed outdated `v1.8.0` notes from the changelog to reflect the current stable and secure state of the RJ Builder system.
