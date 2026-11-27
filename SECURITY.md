# Security Policy

RJ Nexus is a self-hosted CMS. Security reports are taken seriously and handled privately.

## Supported Versions

Security fixes are released for the latest minor version only. Please update before reporting, the issue may already be fixed.

| Version  | Supported          |
| -------- | ------------------ |
| 1.12.x   | :white_check_mark: |
| < 1.12   | :x:                |

Update from **Admin → Updates**, or follow the manual upgrade steps in the [documentation](https://rj-nexus.github.io/documents/).

## Reporting a Vulnerability

**Please do not open a public issue, discussion or pull request for a security problem.**

Report it privately in one of these ways:

1. **GitHub (preferred):** open the [Security tab](https://github.com/rj-nexus/rj-nexus/security/advisories/new) and click **Report a vulnerability**.
2. **Email:** [rjnexus@hotmail.com](mailto:rjnexus@hotmail.com?subject=Security%20report) with the subject `Security report`.

### What to include

- RJ Nexus version, PHP version and how it is hosted.
- A clear description of the problem and its impact.
- Steps to reproduce, or a proof of concept.
- Screenshots or logs, if they help.
- Whether you want to be credited.

## What to expect

| Step | Timeframe |
| ---- | --------- |
| We confirm that we received your report | within 3 days |
| We assess it and tell you if it is accepted or declined | within 7 days |
| Updates on progress | at least every 14 days |
| A fix is released for accepted reports | as soon as possible, depending on severity |

- **Accepted:** we work on a fix, release it in a new version, and publish a security advisory. You are credited unless you prefer to stay anonymous.
- **Declined:** we explain why. If you disagree, reply and we will take another look.

Please give us reasonable time to fix the problem before sharing it publicly.

## Scope

In scope: the RJ Nexus core code, the admin panel, RJBuilder and its built-in widgets, the media manager, the installer and the updater.

Out of scope:

- Problems caused by a misconfigured server or hosting.
- Third-party plugins and themes (report those to their authors).
- Missing security headers or best-practice suggestions without a real impact.
- Denial of service through very large traffic, and social engineering.

## Safe testing

Test only on your own installation. Do not access other people's data, and do not run attacks against the public website or other users' sites.

## Hardening tips for site owners

- Keep RJ Nexus updated.
- Set `APP_DEBUG=false` in production.
- Delete the `installer/` folder after installation.
- Use HTTPS and strong admin passwords.
- Back up your database and files regularly.
