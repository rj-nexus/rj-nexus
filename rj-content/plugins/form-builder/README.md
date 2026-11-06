# RJ Nexus - Form Builder Plugin

A powerful and flexible form creation plugin for RJ Nexus CMS. Build dynamic forms, manage submissions, and receive email notifications without writing any code.

**Current Version:** v1.2.1

## 🚀 Features

- **Dynamic Form Builder:** Easily create forms using an intuitive interface.
- **Custom Fields:** Supports text, email, number, date, time, URL, and file upload fields.
- **Submission Management:** View, read, and manage user submissions directly from the admin panel.
- **Security First:** Built-in protection against Mass Assignment vulnerabilities and XSS attacks.
- **Customizable:** Supports custom placeholder text, help texts, and required fields.

## 🔒 Security Updates (v1.2.1)

In version **1.2.1**, we introduced critical security enhancements:
- **Mass Assignment Protection:** Sensitive attributes like `status`, `ip_address`, and `user_agent` are now strictly protected in Eloquent models to prevent unauthorized payload injection.
- **Strict Validation:** Frontend submissions now only save validated data, blocking malicious users from injecting hidden fields.

*We strongly recommend updating to v1.2.1 or higher for all production environments.*

## 📦 Installation

This plugin is bundled with RJ Nexus. 
1. Navigate to **Admin Panel -> Plugins**.
2. Locate **Form Builder** and click **Activate**.
3. The plugin will automatically run its database migrations.

## 📖 Usage

1. Go to **Admin -> Form Builder**.
2. Click **Create Form** and give your form a name.
3. Add your desired fields and save.
4. Copy the generated shortcode or use the Form Widget in RJBuilder to display the form on your site.

## 📝 Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for more information on what has changed recently.

## 🛡️ Support

For issues, feature requests, or security reports, please contact the RJ Nexus support team.
