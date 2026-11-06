# RJ Nexus — Changelog

Bütün əhəmiyyətli dəyişikliklər bu faylda qeyd olunacaq.

## [1.0.0] - 2026-11-06

### 🎉 İlk Stabil Buraxılış (Stable Release)

Bu buraxılış RJ Nexus-un ilk tam stabil versiyasıdır. Buraxılış əsasən **tam həcmli təhlükəsizlik auditi** və aşkar edilmiş bütün zəifliklərin aradan qaldırılmasına həsr olunub. Layihə daxilində istifadə olunan bütün təhlükəsizlik skanerləri (LaraScan, Laravel Pentest, Laravel Security) yoxlanılıb və real risklər bağlanıb.

### 🛡️ Təhlükəsizlik Yenilikləri (Security Fixes)

#### Mass Assignment (Kütləvi Təyinat) Qoruması
- **Modellər:** `User`, `Post`, `Comment`, `FormSubmission`, `KycVerification`, `NewsletterSubscriber`, `CustomField`, `AiLog` və Form Builder plagini daxil olmaqla bütün həssas modellərdə `status`, `role`, `password`, `user_id`, `token` kimi təhlükəli sahələr `$fillable` massivindən çıxarıldı.
- **Controller və Service-lər:** Çıxarılan bu sahələr `PostController`, `PostService`, `CommentService`, `KycManager`, `NewsletterSubscriber` və digər müvafiq yerlərdə əl ilə təhlükəsiz şəkildə təyin edilməsi təmin edildi.

#### XSS (Cross-Site Scripting) Qoruması
- **Admin və Frontend View-ları:** `posts/show.blade.php`, `rj-default/home.blade.php`, `page.blade.php`, `post.blade.php`, `contact.blade.php` kimi fayllarda `{!! !!}` ilə çıxarılan istifadəçi məzmunu `strip_tags` funksiyası ilə təmizləndi. Bu, Stored XSS hücumlarının qarşısını alır.
- **Widget-lər və Builder:** RJBuilder widget-lərində (`multi-chat`, `advanced-search` və s.) istifadəçi məlumatlarının `esc()` və `safeUrl()` ilə qorunduğu təsdiqləndi.

#### Command Injection & Path Traversal Qoruması
- **Symfony Process:** `GenerateAiContext.php`, `BackupSettingsController.php` və `ThemeEditorService.php` fayllarındakı təhlükəli `shell_exec()` və `exec()` çağırışları çıxarılaraq Laravel-in `Process::run()` fasadı ilə əvəz edildi.
- **Fayl Silinməsi:** `MediaCleanupController` daxilində `unlink()` funksiyasına təhlükəsiz yol validasiyası (`realpath`, `str_starts_with`) əlavə edilərək Path Traversal hücumlarının qarşısı alındı.

#### Network və Host Təhlükəsizliyi
- **Host Header Injection:** `AppServiceProvider` və `bootstrap/app.php` fayllarında `URL::forceRootUrl()` və `TrustHosts` middleware-i əlavə edilərək Host başlığı saxtakarlığının qarşısı alındı.
- **Proxy/Cloudflare Dəstəyi:** IP əsaslı funksiyalar üçün `rj_proxy_status()` yaradıldı. Cloudflare və ya proxy arxasında olan istifadəçilərin özlərini bloklamasının qarşısını almaq üçün `AdminMiddleware`-də "Fail-Open" mexanizmi tətbiq edildi.
- **HTTP Headers:** `SecurityHeaders` middleware-i ilə bütün cavablara `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `HSTS` başlıqları əlavə edildi (Xəta səhifələri daxil olmaqla).
- **Force HTTPS:** SSL sertifikatı olduqda HTTP sorğularını avtomatik HTTPS-ə yönləndirən `ForceHttps` middleware-i əlavə edildi.

#### Authentication və Rate Limiting
- **Brute-Force Qoruması:** Login, Register, 2FA və Şifrə yeniləmə (`PUT /password`) route-larına dinamik `RateLimiter` (throttle) qaydaları tətbiq edildi.
- **Admin Paneli Limitləri:** Admin paneldəki bütün resurs route-ları (`posts`, `users`, `media`, `rjbuilder` və s.) DoS hücumlarına qarşı `throttle:60,1` və `throttle:120,1` ilə qorundu.
- **Session Təhlükəsizliyi:** `SESSION_SECURE_COOKIE` parametri üçün avtomatik SSL aşkarlanması əlavə edildi.

#### Asılılıqlar və Plaginlər
- **Composer/NPM:** `composer update` və `npm audit fix` işlədilərək Symfony CVE-ləri və `follow-redirects` kimi zəifliklər aradan qaldırıldı.
- **Form Builder Plagini:** Plagin `v1.2.0` (Security Release) versiyasına yeniləndi. Plagindəki Mass Assignment və Frontend validasiya boşluqları bağlandı.

---

**Qeyd:** Bu buraxılışdan sonra sistem kod səviyyəsində tam təhlükəsizdir. İstehsalat (production) mühitinə keçid zamanı yalnız server səviyyəsində `.env` icazələri və MySQL istifadəçi hüquqlarının düzgün konfiqurasiya edilməsi tövsiyə olunur.