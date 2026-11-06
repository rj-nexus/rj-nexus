# Changelog

All notable changes to this project will be documented in this file.

## [1.2.0] - 2026-11-06

### Security Release

This release addresses critical security vulnerabilities and is highly recommended for all Form Builder users.

- **Mass Assignment Vulnerability Fixed:** 
  - Removed `status` from the `$fillable` array in the `Form` model.
  - Removed `status`, `ip_address`, and `user_agent` from the `$fillable` array in the `FormSubmission` model.
- **Controller Security:** Manually assigned the removed attributes safely within `FormController` and `FormSubmitController` to maintain functionality.
- **Frontend Data Filtering:** Enforced strict data validation in the frontend submission controller. The system now stores only the validated input data (`$validated`) to prevent malicious users from injecting hidden payloads.

## [1.1.1] - Previous Stable Release
- Prior release changes.
