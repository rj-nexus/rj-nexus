-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: rj_cms
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('rj-cms-cache-rj_active_theme','O:16:\"App\\Models\\Theme\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"rj_themes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:19:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"RJ Default\";s:4:\"slug\";s:10:\"rj-default\";s:7:\"version\";s:5:\"0.9.0\";s:11:\"description\";s:69:\"The official default theme for RJ CMS. Clean, minimal, builder-first.\";s:6:\"author\";s:6:\"RJ CMS\";s:10:\"author_url\";s:27:\"https://github.com/mr-ruhid\";s:13:\"preview_image\";s:14:\"screenshot.png\";s:6:\"folder\";s:10:\"rj-default\";s:6:\"status\";s:6:\"active\";s:8:\"is_child\";i:0;s:11:\"parent_slug\";N;s:8:\"supports\";s:225:\"{\"builder_header\":true,\"builder_footer\":true,\"builder_page\":true,\"builder_popup\":true,\"custom_logo\":true,\"custom_colors\":true,\"custom_fonts\":true,\"post_thumbnail\":true,\"post_excerpt\":true,\"menus\":[\"header\",\"footer\",\"mobile\"]}\";s:8:\"settings\";N;s:8:\"metadata\";s:3899:\"{\"name\":\"RJ Default\",\"slug\":\"rj-default\",\"version\":\"0.9.0\",\"author\":\"RJ CMS\",\"author_url\":\"https:\\/\\/github.com\\/mr-ruhid\",\"description\":\"The official default theme for RJ CMS. Clean, minimal, builder-first.\",\"license\":\"MIT\",\"preview\":\"screenshot.png\",\"requires\":{\"rj_cms\":\">=1.0.0\",\"php\":\">=8.2\"},\"supports\":{\"builder_header\":true,\"builder_footer\":true,\"builder_page\":true,\"builder_popup\":true,\"custom_logo\":true,\"custom_colors\":true,\"custom_fonts\":true,\"post_thumbnail\":true,\"post_excerpt\":true,\"menus\":[\"header\",\"footer\",\"mobile\"]},\"views\":{\"layout\":\"views\\/layout.blade.php\",\"single_post\":\"views\\/single-post.blade.php\",\"single_page\":\"views\\/single-page.blade.php\",\"archive\":\"views\\/archive.blade.php\"},\"custom_templates\":[{\"id\":\"contact\",\"label\":\"Contact Page\",\"description\":\"Two-column layout with contact form and info sidebar.\",\"view\":\"views\\/templates\\/contact.blade.php\",\"icon\":\"mail\"},{\"id\":\"landing\",\"label\":\"Landing Page\",\"description\":\"Full-width hero with centered CTA. No sidebar.\",\"view\":\"views\\/templates\\/landing.blade.php\",\"icon\":\"rocket\"},{\"id\":\"full-width\",\"label\":\"Full Width\",\"description\":\"Edge-to-edge content without container padding.\",\"view\":\"views\\/templates\\/full-width.blade.php\",\"icon\":\"expand\"}],\"assets\":{\"css\":[],\"js\":[]},\"customizer\":{\"sections\":{\"colors\":{\"label\":\"Colors\",\"icon\":\"palette\",\"controls\":{\"primary_color\":{\"type\":\"color\",\"label\":\"Primary Color\",\"default\":\"#7c3aed\"},\"secondary_color\":{\"type\":\"color\",\"label\":\"Secondary Color\",\"default\":\"#ec4899\"},\"text_color\":{\"type\":\"color\",\"label\":\"Text Color\",\"default\":\"#111827\"},\"background_color\":{\"type\":\"color\",\"label\":\"Background Color\",\"default\":\"#ffffff\"},\"link_color\":{\"type\":\"color\",\"label\":\"Link Color\",\"default\":\"#7c3aed\"}}},\"typography\":{\"label\":\"Typography\",\"icon\":\"type\",\"controls\":{\"font_body\":{\"type\":\"select\",\"label\":\"Body Font\",\"default\":\"Inter\",\"options\":{\"Inter\":\"Inter\",\"Figtree\":\"Figtree\",\"Roboto\":\"Roboto\",\"Open Sans\":\"Open Sans\",\"Lato\":\"Lato\",\"Poppins\":\"Poppins\",\"system-ui\":\"System Default\"}},\"font_heading\":{\"type\":\"select\",\"label\":\"Heading Font\",\"default\":\"Inter\",\"options\":{\"Inter\":\"Inter\",\"Figtree\":\"Figtree\",\"Roboto\":\"Roboto\",\"Open Sans\":\"Open Sans\",\"Lato\":\"Lato\",\"Poppins\":\"Poppins\",\"system-ui\":\"System Default\"}},\"font_size_base\":{\"type\":\"range\",\"label\":\"Base Font Size\",\"default\":16,\"min\":12,\"max\":24,\"step\":1,\"suffix\":\"px\"},\"line_height\":{\"type\":\"range\",\"label\":\"Line Height\",\"default\":1.6,\"min\":1.2,\"max\":2.2,\"step\":0.1}}},\"layout\":{\"label\":\"Layout\",\"icon\":\"layout\",\"controls\":{\"container_width\":{\"type\":\"range\",\"label\":\"Container Width\",\"default\":1200,\"min\":960,\"max\":1600,\"step\":20,\"suffix\":\"px\"},\"sidebar_position\":{\"type\":\"select\",\"label\":\"Sidebar Position\",\"default\":\"right\",\"options\":{\"right\":\"Right\",\"left\":\"Left\",\"none\":\"No Sidebar\"}},\"sticky_header\":{\"type\":\"toggle\",\"label\":\"Sticky Header\",\"default\":true}}},\"header\":{\"label\":\"Header\",\"icon\":\"header\",\"controls\":{\"logo_text\":{\"type\":\"text\",\"label\":\"Logo Text\",\"default\":\"RJ CMS\"},\"logo_image\":{\"type\":\"text\",\"label\":\"Logo Image URL\",\"default\":\"\"},\"header_bg\":{\"type\":\"color\",\"label\":\"Header Background\",\"default\":\"#ffffff\"},\"header_text_color\":{\"type\":\"color\",\"label\":\"Header Text Color\",\"default\":\"#111827\"}}},\"footer\":{\"label\":\"Footer\",\"icon\":\"footer\",\"controls\":{\"footer_text\":{\"type\":\"textarea\",\"label\":\"Footer Text\",\"default\":\"\\u00a9 2026 RJ CMS. All rights reserved.\"},\"footer_bg\":{\"type\":\"color\",\"label\":\"Footer Background\",\"default\":\"#1a1030\"},\"footer_text_color\":{\"type\":\"color\",\"label\":\"Footer Text Color\",\"default\":\"#d1d5db\"}}},\"social\":{\"label\":\"Social Links\",\"icon\":\"link\",\"controls\":{\"facebook\":{\"type\":\"url\",\"label\":\"Facebook URL\",\"default\":\"\"},\"twitter\":{\"type\":\"url\",\"label\":\"Twitter \\/ X URL\",\"default\":\"\"},\"instagram\":{\"type\":\"url\",\"label\":\"Instagram URL\",\"default\":\"\"},\"youtube\":{\"type\":\"url\",\"label\":\"YouTube URL\",\"default\":\"\"},\"linkedin\":{\"type\":\"url\",\"label\":\"LinkedIn URL\",\"default\":\"\"}}}}}}\";s:13:\"error_message\";N;s:12:\"activated_at\";s:19:\"2026-10-24 23:59:57\";s:10:\"created_at\";s:19:\"2026-10-16 22:33:44\";s:10:\"updated_at\";s:19:\"2026-10-24 23:59:57\";}s:11:\"\0*\0original\";a:19:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"RJ Default\";s:4:\"slug\";s:10:\"rj-default\";s:7:\"version\";s:5:\"0.9.0\";s:11:\"description\";s:69:\"The official default theme for RJ CMS. Clean, minimal, builder-first.\";s:6:\"author\";s:6:\"RJ CMS\";s:10:\"author_url\";s:27:\"https://github.com/mr-ruhid\";s:13:\"preview_image\";s:14:\"screenshot.png\";s:6:\"folder\";s:10:\"rj-default\";s:6:\"status\";s:6:\"active\";s:8:\"is_child\";i:0;s:11:\"parent_slug\";N;s:8:\"supports\";s:225:\"{\"builder_header\":true,\"builder_footer\":true,\"builder_page\":true,\"builder_popup\":true,\"custom_logo\":true,\"custom_colors\":true,\"custom_fonts\":true,\"post_thumbnail\":true,\"post_excerpt\":true,\"menus\":[\"header\",\"footer\",\"mobile\"]}\";s:8:\"settings\";N;s:8:\"metadata\";s:3899:\"{\"name\":\"RJ Default\",\"slug\":\"rj-default\",\"version\":\"0.9.0\",\"author\":\"RJ CMS\",\"author_url\":\"https:\\/\\/github.com\\/mr-ruhid\",\"description\":\"The official default theme for RJ CMS. Clean, minimal, builder-first.\",\"license\":\"MIT\",\"preview\":\"screenshot.png\",\"requires\":{\"rj_cms\":\">=1.0.0\",\"php\":\">=8.2\"},\"supports\":{\"builder_header\":true,\"builder_footer\":true,\"builder_page\":true,\"builder_popup\":true,\"custom_logo\":true,\"custom_colors\":true,\"custom_fonts\":true,\"post_thumbnail\":true,\"post_excerpt\":true,\"menus\":[\"header\",\"footer\",\"mobile\"]},\"views\":{\"layout\":\"views\\/layout.blade.php\",\"single_post\":\"views\\/single-post.blade.php\",\"single_page\":\"views\\/single-page.blade.php\",\"archive\":\"views\\/archive.blade.php\"},\"custom_templates\":[{\"id\":\"contact\",\"label\":\"Contact Page\",\"description\":\"Two-column layout with contact form and info sidebar.\",\"view\":\"views\\/templates\\/contact.blade.php\",\"icon\":\"mail\"},{\"id\":\"landing\",\"label\":\"Landing Page\",\"description\":\"Full-width hero with centered CTA. No sidebar.\",\"view\":\"views\\/templates\\/landing.blade.php\",\"icon\":\"rocket\"},{\"id\":\"full-width\",\"label\":\"Full Width\",\"description\":\"Edge-to-edge content without container padding.\",\"view\":\"views\\/templates\\/full-width.blade.php\",\"icon\":\"expand\"}],\"assets\":{\"css\":[],\"js\":[]},\"customizer\":{\"sections\":{\"colors\":{\"label\":\"Colors\",\"icon\":\"palette\",\"controls\":{\"primary_color\":{\"type\":\"color\",\"label\":\"Primary Color\",\"default\":\"#7c3aed\"},\"secondary_color\":{\"type\":\"color\",\"label\":\"Secondary Color\",\"default\":\"#ec4899\"},\"text_color\":{\"type\":\"color\",\"label\":\"Text Color\",\"default\":\"#111827\"},\"background_color\":{\"type\":\"color\",\"label\":\"Background Color\",\"default\":\"#ffffff\"},\"link_color\":{\"type\":\"color\",\"label\":\"Link Color\",\"default\":\"#7c3aed\"}}},\"typography\":{\"label\":\"Typography\",\"icon\":\"type\",\"controls\":{\"font_body\":{\"type\":\"select\",\"label\":\"Body Font\",\"default\":\"Inter\",\"options\":{\"Inter\":\"Inter\",\"Figtree\":\"Figtree\",\"Roboto\":\"Roboto\",\"Open Sans\":\"Open Sans\",\"Lato\":\"Lato\",\"Poppins\":\"Poppins\",\"system-ui\":\"System Default\"}},\"font_heading\":{\"type\":\"select\",\"label\":\"Heading Font\",\"default\":\"Inter\",\"options\":{\"Inter\":\"Inter\",\"Figtree\":\"Figtree\",\"Roboto\":\"Roboto\",\"Open Sans\":\"Open Sans\",\"Lato\":\"Lato\",\"Poppins\":\"Poppins\",\"system-ui\":\"System Default\"}},\"font_size_base\":{\"type\":\"range\",\"label\":\"Base Font Size\",\"default\":16,\"min\":12,\"max\":24,\"step\":1,\"suffix\":\"px\"},\"line_height\":{\"type\":\"range\",\"label\":\"Line Height\",\"default\":1.6,\"min\":1.2,\"max\":2.2,\"step\":0.1}}},\"layout\":{\"label\":\"Layout\",\"icon\":\"layout\",\"controls\":{\"container_width\":{\"type\":\"range\",\"label\":\"Container Width\",\"default\":1200,\"min\":960,\"max\":1600,\"step\":20,\"suffix\":\"px\"},\"sidebar_position\":{\"type\":\"select\",\"label\":\"Sidebar Position\",\"default\":\"right\",\"options\":{\"right\":\"Right\",\"left\":\"Left\",\"none\":\"No Sidebar\"}},\"sticky_header\":{\"type\":\"toggle\",\"label\":\"Sticky Header\",\"default\":true}}},\"header\":{\"label\":\"Header\",\"icon\":\"header\",\"controls\":{\"logo_text\":{\"type\":\"text\",\"label\":\"Logo Text\",\"default\":\"RJ CMS\"},\"logo_image\":{\"type\":\"text\",\"label\":\"Logo Image URL\",\"default\":\"\"},\"header_bg\":{\"type\":\"color\",\"label\":\"Header Background\",\"default\":\"#ffffff\"},\"header_text_color\":{\"type\":\"color\",\"label\":\"Header Text Color\",\"default\":\"#111827\"}}},\"footer\":{\"label\":\"Footer\",\"icon\":\"footer\",\"controls\":{\"footer_text\":{\"type\":\"textarea\",\"label\":\"Footer Text\",\"default\":\"\\u00a9 2026 RJ CMS. All rights reserved.\"},\"footer_bg\":{\"type\":\"color\",\"label\":\"Footer Background\",\"default\":\"#1a1030\"},\"footer_text_color\":{\"type\":\"color\",\"label\":\"Footer Text Color\",\"default\":\"#d1d5db\"}}},\"social\":{\"label\":\"Social Links\",\"icon\":\"link\",\"controls\":{\"facebook\":{\"type\":\"url\",\"label\":\"Facebook URL\",\"default\":\"\"},\"twitter\":{\"type\":\"url\",\"label\":\"Twitter \\/ X URL\",\"default\":\"\"},\"instagram\":{\"type\":\"url\",\"label\":\"Instagram URL\",\"default\":\"\"},\"youtube\":{\"type\":\"url\",\"label\":\"YouTube URL\",\"default\":\"\"},\"linkedin\":{\"type\":\"url\",\"label\":\"LinkedIn URL\",\"default\":\"\"}}}}}}\";s:13:\"error_message\";N;s:12:\"activated_at\";s:19:\"2026-10-24 23:59:57\";s:10:\"created_at\";s:19:\"2026-10-16 22:33:44\";s:10:\"updated_at\";s:19:\"2026-10-24 23:59:57\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:5:{s:8:\"is_child\";s:7:\"boolean\";s:8:\"supports\";s:5:\"array\";s:8:\"settings\";s:5:\"array\";s:8:\"metadata\";s:5:\"array\";s:12:\"activated_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:7:\"version\";i:3;s:11:\"description\";i:4;s:6:\"author\";i:5;s:10:\"author_url\";i:6;s:13:\"preview_image\";i:7;s:6:\"folder\";i:8;s:6:\"status\";i:9;s:8:\"is_child\";i:10;s:11:\"parent_slug\";i:11;s:8:\"supports\";i:12;s:8:\"settings\";i:13;s:8:\"metadata\";i:14;s:13:\"error_message\";i:15;s:12:\"activated_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}',1793150747),('rj-cms-cache-rj_options','a:91:{s:9:\"site_name\";s:6:\"RJ CMS\";s:16:\"site_description\";s:31:\"A modern CMS built with Laravel\";s:8:\"site_url\";s:21:\"http://127.0.0.1:8000\";s:11:\"admin_email\";s:17:\"admin@example.com\";s:8:\"timezone\";s:9:\"Asia/Baku\";s:11:\"date_format\";s:5:\"Y-m-d\";s:11:\"time_format\";s:3:\"H:i\";s:8:\"language\";s:2:\"en\";s:8:\"currency\";s:3:\"USD\";s:14:\"posts_per_page\";s:2:\"10\";s:13:\"homepage_type\";s:6:\"latest\";s:12:\"feed_enabled\";s:1:\"1\";s:16:\"comments_enabled\";s:1:\"1\";s:19:\"comments_moderation\";s:1:\"1\";s:13:\"ai_moderation\";s:1:\"0\";s:19:\"permalink_structure\";s:4:\"name\";s:11:\"admin_theme\";s:5:\"light\";s:11:\"admin_color\";s:7:\"#111827\";s:14:\"frontend_theme\";s:7:\"default\";s:11:\"seo_enabled\";s:1:\"1\";s:14:\"seo_ai_enabled\";s:1:\"0\";s:10:\"ai_enabled\";s:1:\"0\";s:11:\"ai_provider\";s:6:\"openai\";s:8:\"ai_model\";s:11:\"gpt-4o-mini\";s:14:\"ai_temperature\";s:3:\"0.7\";s:13:\"ai_max_tokens\";s:4:\"2000\";s:16:\"ai_monthly_limit\";s:3:\"100\";s:12:\"security_2fa\";s:1:\"0\";s:20:\"security_login_limit\";s:1:\"5\";s:11:\"backup_auto\";s:1:\"0\";s:16:\"backup_frequency\";s:5:\"daily\";s:13:\"cache_enabled\";s:1:\"0\";s:9:\"cache_ttl\";s:4:\"3600\";s:17:\"updates_core_auto\";s:1:\"0\";s:19:\"updates_plugin_auto\";s:1:\"0\";s:18:\"updates_theme_auto\";s:1:\"0\";s:10:\"rj_version\";s:5:\"1.0.0\";s:15:\"rj_installed_at\";s:19:\"2026-10-17 00:08:29\";s:18:\"admin_color_preset\";s:5:\"green\";s:12:\"last_checked\";s:19:\"2026-10-13 15:06:51\";s:12:\"last_release\";s:3975:\"{\"version\":\"1.0.0\",\"name\":\"RJ CMS Lite v1.0.0 \\u2014 Initial Release\",\"body\":\"# RJ CMS Lite v1.0.0\\r\\n\\r\\nFirst public release of RJ CMS Lite, a lightweight Laravel CMS built for print businesses. It manages DTF transfers, custom signage, product catalogs, orders, deliveries and support tickets, with a fully customizable homepage driven by a drag-and-drop widget system.\\r\\n\\r\\n## Highlights\\r\\n\\r\\n- **Widget-based homepage**: 19 predefined sections, drag-to-reorder, per-widget settings editor\\r\\n- **RJFrame Design Studio**: online DTF gang sheet builder (Fabric.js) with text, shapes, image adjustments, auto-arrange, DPI validation and PNG export\\r\\n- **Product catalog**: products, models, categories, attributes, variants, print zones\\r\\n- **Order management**: cart, checkout, receipts, order tracking, design downloads\\r\\n- **Delivery system**: branches, delivery zones, delivery rates\\r\\n- **Payments**: pluggable gateway registry (manual entry, extensible)\\r\\n- **Support tickets**: threads, attachments, priorities, admin replies\\r\\n- **Content**: blog, pages, sliders, menus, gallery, FAQ\\r\\n- **Admin AI Chat**: embed an external AI chat (HF Spaces, DeepAI, Kimi) as an iframe or popup, with a server-side proxy\\r\\n- **2FA authentication**: email-based verification for admin login\\r\\n- **Storage analyzer**: clean up temp, orphaned and order files\\r\\n- **Backup and restore**: manual database backups\\r\\n- **Order API**: external integration endpoint\\r\\n\\r\\n## Tech Stack\\r\\n\\r\\n- Laravel 12.69, PHP 8.2\\r\\n- Tailwind CSS 4, Alpine.js 3, Vite 7\\r\\n- Fabric.js 5.3\\r\\n- MySQL \\/ SQLite\\r\\n- Cloudinary (video only)\\r\\n\\r\\n## Requirements\\r\\n\\r\\n- PHP >= 8.2\\r\\n- Composer >= 2.10\\r\\n- Node.js >= 18\\r\\n- MySQL 8+ or SQLite\\r\\n- PHP extensions: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl`, `fileinfo`\\r\\n\\r\\n## Installation\\r\\n\\r\\n```bash\\r\\ngit clone https:\\/\\/github.com\\/mr-ruhid\\/dtf-website.git\\r\\ncd dtf-website\\r\\n\\r\\ncomposer install\\r\\ncp .env.example .env\\r\\nphp artisan key:generate\\r\\nnpm install && npm run build\\r\\n```\\r\\n\\r\\nSet your database credentials in `.env`, then run:\\r\\n\\r\\n```bash\\r\\nphp artisan migrate --seed\\r\\nphp artisan storage:link\\r\\n```\\r\\n\\r\\n## Default Admin\\r\\n\\r\\n```text\\r\\nURL:      \\/admin\\/login\\r\\nEmail:    admin@rjshop.com\\r\\nPassword: admin123\\r\\n```\\r\\n\\r\\n**Change these immediately after the first login.**\\r\\n\\r\\n## Known Limitations\\r\\n\\r\\n- Multi-language support is not yet implemented\\r\\n- Test suite is not included\\r\\n- Payment gateways: manual entry only (API-ready via `PaymentGatewayRegistry`)\\r\\n- Cloudinary integration covers video uploads only\\r\\n- Logo asset is not bundled (defaults to the \\\"RJ CMS\\\" text)\\r\\n\\r\\n## License\\r\\n\\r\\nRJ CMS Lite is source-available. You may view and modify the code for non-commercial purposes. Commercial use and running it as a live website require prior written permission and a paid license from the author. See [[LICENSE.md](https:\\/\\/claude.ai\\/chat\\/LICENSE.md)](LICENSE.md) for details.\\r\\n\\r\\n## Documentation\\r\\n\\r\\nFull documentation, widget reference and route lists are in the [[README](https:\\/\\/github.com\\/mr-ruhid\\/dtf-website#readme)](https:\\/\\/github.com\\/mr-ruhid\\/dtf-website#readme).\\r\\n\\r\\n## Credits\\r\\n\\r\\n- Author: Ruhid Javadov ([[@mr-ruhid](https:\\/\\/github.com\\/mr-ruhid)](https:\\/\\/github.com\\/mr-ruhid))\\r\\n- Repository: <https:\\/\\/github.com\\/mr-ruhid\\/dtf-website>\\r\\n\\r\\n## Support the Project\\r\\n\\r\\nIf this project is useful to you, you can support its development via [[Kofe.al](https:\\/\\/kofe.al\\/@ruhidjavadoff)](https:\\/\\/kofe.al\\/@ruhidjavadoff), [[\\u00c7ayvoy](https:\\/\\/cayvoy.com\\/donate\\/ruhid4715)](https:\\/\\/cayvoy.com\\/donate\\/ruhid4715) or [[PayPal](https:\\/\\/www.paypal.com\\/paypalme\\/ruhidjavadoff)](https:\\/\\/www.paypal.com\\/paypalme\\/ruhidjavadoff).\",\"url\":\"https:\\/\\/github.com\\/mr-ruhid\\/rj-cms-ai\\/releases\\/tag\\/1.0.0\",\"published_at\":\"2026-10-10T23:04:00Z\",\"has_update\":false}\";s:13:\"global_colors\";s:299:\"[{\"id\":\"primary\",\"name\":\"Primary\",\"color\":\"#7c3aed\"},{\"id\":\"secondary\",\"name\":\"Secondary\",\"color\":\"#ec4899\"},{\"id\":\"text\",\"name\":\"Text\",\"color\":\"#111827\"},{\"id\":\"accent\",\"name\":\"Accent\",\"color\":\"#f59e0b\"},{\"id\":\"light\",\"name\":\"Light\",\"color\":\"#f3f4f6\"},{\"id\":\"dark\",\"name\":\"Dark\",\"color\":\"#1f2937\"}]\";s:12:\"global_fonts\";s:314:\"[{\"id\":\"primary\",\"name\":\"Primary\",\"family\":\"Inter, sans-serif\",\"weight\":\"700\"},{\"id\":\"secondary\",\"name\":\"Secondary\",\"family\":\"Inter, sans-serif\",\"weight\":\"500\"},{\"id\":\"text\",\"name\":\"Body Text\",\"family\":\"Inter, sans-serif\",\"weight\":\"400\"},{\"id\":\"accent\",\"name\":\"Accent\",\"family\":\"Inter, sans-serif\",\"weight\":\"600\"}]\";s:14:\"global_spacing\";s:212:\"[{\"id\":\"xs\",\"name\":\"Extra Small\",\"value\":\"4\"},{\"id\":\"sm\",\"name\":\"Small\",\"value\":\"8\"},{\"id\":\"md\",\"name\":\"Medium\",\"value\":\"16\"},{\"id\":\"lg\",\"name\":\"Large\",\"value\":\"24\"},{\"id\":\"xl\",\"name\":\"Extra Large\",\"value\":\"48\"}]\";s:14:\"rj_breakpoints\";s:166:\"{\"mobile\":{\"label\":\"Mobile\",\"max\":560,\"icon\":\"mobile\"},\"tablet\":{\"label\":\"Tablet\",\"max\":860,\"icon\":\"tablet\"},\"desktop\":{\"label\":\"Desktop\",\"min\":861,\"icon\":\"desktop\"}}\";s:12:\"active_theme\";s:10:\"rj-default\";s:16:\"custom_structure\";N;s:13:\"category_base\";s:8:\"category\";s:8:\"tag_base\";s:3:\"tag\";s:11:\"author_base\";s:6:\"author\";s:14:\"post_slug_case\";s:5:\"lower\";s:17:\"redirect_old_urls\";s:1:\"1\";s:14:\"trailing_slash\";s:3:\"yes\";s:15:\"force_lowercase\";s:1:\"1\";s:16:\"strip_stop_words\";s:1:\"0\";s:8:\"api_keys\";s:2:\"[]\";s:10:\"debug_mode\";s:1:\"0\";s:19:\"maintenance_message\";N;s:17:\"maintenance_retry\";s:4:\"3600\";s:9:\"log_level\";s:5:\"error\";s:18:\"log_retention_days\";s:2:\"14\";s:16:\"custom_head_code\";N;s:18:\"custom_footer_code\";N;s:10:\"custom_css\";N;s:16:\"maintenance_mode\";s:1:\"0\";s:15:\"error_reporting\";s:1:\"0\";s:14:\"track_visitors\";s:1:\"0\";s:18:\"allow_file_editing\";s:1:\"0\";s:19:\"commerce_store_name\";s:6:\"RJ CMS\";s:17:\"commerce_currency\";s:3:\"USD\";s:20:\"commerce_weight_unit\";s:2:\"kg\";s:23:\"commerce_stripe_enabled\";s:1:\"0\";s:18:\"commerce_stripe_pk\";N;s:18:\"commerce_stripe_sk\";N;s:23:\"commerce_paypal_enabled\";s:1:\"0\";s:25:\"commerce_paypal_client_id\";N;s:22:\"commerce_paypal_secret\";N;s:25:\"commerce_checkout_enabled\";s:1:\"0\";s:20:\"commerce_checkout_pk\";N;s:20:\"commerce_checkout_sk\";N;s:25:\"commerce_razorpay_enabled\";s:1:\"0\";s:21:\"commerce_razorpay_key\";N;s:24:\"commerce_razorpay_secret\";N;s:23:\"commerce_crypto_enabled\";s:1:\"0\";s:24:\"commerce_crypto_provider\";s:7:\"binance\";s:23:\"commerce_crypto_api_key\";N;s:20:\"commerce_cod_enabled\";s:1:\"1\";s:18:\"commerce_page_shop\";N;s:18:\"commerce_page_cart\";N;s:22:\"commerce_page_checkout\";N;s:12:\"lang_flag_az\";s:6:\"az.svg\";}',2108507147),('rj-cms-cache-rj_widget_registry','a:64:{i:0;O:43:\"App\\Widgets\\Builtin\\HeaderLoginButtonWidget\":0:{}i:1;O:48:\"App\\Widgets\\Builtin\\HeaderLanguageSwitcherWidget\":0:{}i:2;O:33:\"App\\Widgets\\Builtin\\HeadingWidget\":0:{}i:3;O:30:\"App\\Widgets\\Builtin\\TextWidget\":0:{}i:4;O:31:\"App\\Widgets\\Builtin\\ImageWidget\":0:{}i:5;O:35:\"App\\Widgets\\Builtin\\ContainerWidget\":0:{}i:6;O:32:\"App\\Widgets\\Builtin\\ButtonWidget\":0:{}i:7;O:33:\"App\\Widgets\\Builtin\\DividerWidget\":0:{}i:8;O:36:\"App\\Widgets\\Builtin\\CustomHtmlWidget\":0:{}i:9;O:37:\"App\\Widgets\\Builtin\\ProgressBarWidget\":0:{}i:10;O:31:\"App\\Widgets\\Builtin\\AlertWidget\":0:{}i:11;O:35:\"App\\Widgets\\Builtin\\HeroSlideWidget\":0:{}i:12;O:38:\"App\\Widgets\\Builtin\\AnimatedHeroWidget\":0:{}i:13;O:35:\"App\\Widgets\\Builtin\\VideoHeroWidget\":0:{}i:14;O:31:\"App\\Widgets\\Builtin\\VideoWidget\":0:{}i:15;O:41:\"App\\Widgets\\Builtin\\ImageComparisonWidget\":0:{}i:16;O:40:\"App\\Widgets\\Builtin\\InteractiveMapWidget\":0:{}i:17;O:35:\"App\\Widgets\\Builtin\\Google360Widget\":0:{}i:18;O:38:\"App\\Widgets\\Builtin\\BasicGalleryWidget\":0:{}i:19;O:41:\"App\\Widgets\\Builtin\\GalleryAdvancedWidget\":0:{}i:20;O:32:\"App\\Widgets\\Builtin\\LottieWidget\":0:{}i:21;O:33:\"App\\Widgets\\Builtin\\HotspotWidget\":0:{}i:22;O:39:\"App\\Widgets\\Builtin\\VideoMaskTextWidget\":0:{}i:23;O:34:\"App\\Widgets\\Builtin\\Object3DWidget\":0:{}i:24;O:34:\"App\\Widgets\\Builtin\\LogoGridWidget\":0:{}i:25;O:30:\"App\\Widgets\\Builtin\\LogoWidget\":0:{}i:26;O:37:\"App\\Widgets\\Builtin\\MusicPlayerWidget\":0:{}i:27;O:36:\"App\\Widgets\\Builtin\\SoundCloudWidget\":0:{}i:28;O:31:\"App\\Widgets\\Builtin\\PostsWidget\":0:{}i:29;O:35:\"App\\Widgets\\Builtin\\AccordionWidget\":0:{}i:30;O:30:\"App\\Widgets\\Builtin\\TabsWidget\":0:{}i:31;O:37:\"App\\Widgets\\Builtin\\ToggleCardsWidget\":0:{}i:32;O:33:\"App\\Widgets\\Builtin\\CounterWidget\":0:{}i:33;O:35:\"App\\Widgets\\Builtin\\CountdownWidget\":0:{}i:34;O:30:\"App\\Widgets\\Builtin\\TeamWidget\":0:{}i:35;O:37:\"App\\Widgets\\Builtin\\TestimonialWidget\":0:{}i:36;O:36:\"App\\Widgets\\Builtin\\BlockquoteWidget\":0:{}i:37;O:34:\"App\\Widgets\\Builtin\\StepFlowWidget\":0:{}i:38;O:42:\"App\\Widgets\\Builtin\\AnimatedHeadlineWidget\":0:{}i:39;O:42:\"App\\Widgets\\Builtin\\DualColorHeadingWidget\":0:{}i:40;O:35:\"App\\Widgets\\Builtin\\PriceListWidget\":0:{}i:41;O:36:\"App\\Widgets\\Builtin\\PriceTableWidget\":0:{}i:42;O:38:\"App\\Widgets\\Builtin\\CallToActionWidget\":0:{}i:43;O:33:\"App\\Widgets\\Builtin\\FlipBoxWidget\":0:{}i:44;O:37:\"App\\Widgets\\Builtin\\PromoBannerWidget\":0:{}i:45;O:40:\"App\\Widgets\\Builtin\\WheelOfFortuneWidget\":0:{}i:46;O:38:\"App\\Widgets\\Builtin\\CookieNoticeWidget\":0:{}i:47;O:42:\"App\\Widgets\\Builtin\\NewsletterSignupWidget\":0:{}i:48;O:36:\"App\\Widgets\\Builtin\\SocialFeedWidget\":0:{}i:49;O:37:\"App\\Widgets\\Builtin\\SocialIconsWidget\":0:{}i:50;O:35:\"App\\Widgets\\Builtin\\MultiChatWidget\":0:{}i:51;O:37:\"App\\Widgets\\Builtin\\ContactInfoWidget\":0:{}i:52;O:39:\"App\\Widgets\\Builtin\\BusinessHoursWidget\":0:{}i:53;O:39:\"App\\Widgets\\Builtin\\GoogleReviewsWidget\":0:{}i:54;O:39:\"App\\Widgets\\Builtin\\CurrencyRatesWidget\":0:{}i:55;O:31:\"App\\Widgets\\Builtin\\LoginWidget\":0:{}i:56;O:35:\"App\\Widgets\\Builtin\\PortfolioWidget\":0:{}i:57;O:39:\"App\\Widgets\\Builtin\\CodeHighlightWidget\":0:{}i:58;O:30:\"App\\Widgets\\Builtin\\MenuWidget\":0:{}i:59;O:40:\"RjPlugins\\FormBuilder\\Widgets\\FormWidget\":0:{}i:60;O:36:\"RjCommerce\\Widgets\\ProductGridWidget\":0:{}i:61;O:35:\"RjCommerce\\Widgets\\CategoriesWidget\":0:{}i:62;O:38:\"RjCommerce\\Widgets\\SingleProductWidget\":0:{}i:63;O:29:\"RjCommerce\\Widgets\\CartWidget\":0:{}}',1793151188);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_10_220753_add_role_to_users_table',2),(5,'2026_10_11_221513_yarat_setting_tabili',2),(6,'2026_10_13_152738_yarat_setting_tabili',3),(7,'2026_10_13_155013_yarat_kateqoriya_tabili',4),(8,'2026_10_13_161917_yarat_tags_tabili',5),(9,'2026_10_13_192326_yarat_templates_tabili',6),(10,'2026_10_13_210056_yarat_menus_tabili',7),(11,'2026_10_13_211424_elave_et_translations_menu_items',8),(12,'2026_10_14_203204_pop_up_rj_builder',9),(13,'2026_10_14_204651_form_tabili',9),(14,'2026_10_14_204735_form_tabili_field',9),(15,'2026_10_14_204826_form_tabili_submission',9),(16,'2026_10_14_210804_yarat_global_form_vidceti',9),(17,'2026_10_14_212131_rj_custom_font',9),(18,'2026_10_14_212208_rj_custom_font_tabili',9),(19,'2026_10_14_221646_yarat_yeni_post_tabili',9),(20,'2026_10_14_224222_create_rj_comments_table',9),(21,'2026_10_14_224259_create_rj_revisions_table',9),(22,'2026_10_14_224336_yarat_roll_tabili',9),(23,'2026_10_14_224424_yarat_post_tipi_tabili',9),(24,'2026_10_14_224507_create_rj_taxonomies_table',9),(25,'2026_10_14_224545_create_rj_custom_fields_table',9),(26,'2026_10_14_230046_create_rj_terms_table',9),(27,'2026_10_14_230130_create_rj_notifications_table',9),(28,'2026_10_14_230218_create_rj_activity_log_table',9),(29,'2026_10_14_230306_create_rj_plugins_table',9),(30,'2026_10_14_230353_create_rj_widgets_table',9),(31,'2026_10_14_230449_create_rj_themes_table',9),(32,'2026_10_16_201307_add_blocks_to_rj_posts_table',10),(33,'2026_10_16_231812_add_edit_mode_to_rj_posts_table',11),(34,'2026_10_16_233211_add_seo_fields_to_post_translations_table',12),(35,'2026_10_16_235611_create_category_translations_table',13),(36,'2024_01_01_000001_create_form_builder_tables',14),(37,'2026_10_20_000000_add_missing_columns_to_form_fields',15),(38,'2026_10_20_193922_create_rj_ai_logs_table',16),(39,'2026_10_20_194239_create_rj_ai_prompts_table',16),(40,'2026_10_20_200536_create_rj_knowledge_table',17),(41,'2026_10_20_201738_update_rj_knowledge_for_translations',17),(42,'2026_10_21_213021_add_two_factor_columns_to_users_table',18),(43,'2026_10_22_183704_create_rj_kyc_tables',19),(111,'2026_10_23_055647_create_rj_post_translations_table',20),(112,'2026_10_23_100001_create_rj_product_categories_table',21),(113,'2026_10_23_100002_create_rj_product_tags_tables',21),(114,'2026_10_23_100003_create_rj_product_brands_tables',21),(115,'2026_10_23_100004_create_rj_product_attributes_tables',21),(116,'2026_10_23_100005_create_detailed_products_tables',21),(117,'2026_10_23_100006_create_rj_orders_tables',21),(118,'2026_10_23_100007_create_rj_coupons_table',21),(119,'2026_10_23_100008_create_rj_reviews_and_shipping_tables',21),(120,'2026_10_27_021541_create_rj_newsletter_subscribers_table',22),(121,'2026_10_27_024445_create_rj_newsletter_subscribers_table',23),(122,'2026_10_27_113154_create_rj_newsletter_subscribers_table',24);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_activity_log`
--

DROP TABLE IF EXISTS `rj_activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `event` varchar(255) DEFAULT NULL,
  `batch_uuid` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_activity_log_log_name_index` (`log_name`),
  KEY `rj_activity_log_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  KEY `rj_activity_log_causer_type_causer_id_index` (`causer_type`,`causer_id`),
  KEY `rj_activity_log_event_index` (`event`),
  KEY `rj_activity_log_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_activity_log`
--

LOCK TABLES `rj_activity_log` WRITE;
/*!40000 ALTER TABLE `rj_activity_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_ai_logs`
--

DROP TABLE IF EXISTS `rj_ai_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_ai_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `task` varchar(255) DEFAULT NULL,
  `prompt_tokens` int(11) NOT NULL DEFAULT 0,
  `completion_tokens` int(11) NOT NULL DEFAULT 0,
  `total_tokens` int(11) NOT NULL DEFAULT 0,
  `cost` decimal(10,6) NOT NULL DEFAULT 0.000000,
  `status` varchar(255) NOT NULL DEFAULT 'success',
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_ai_logs_user_id_index` (`user_id`),
  KEY `rj_ai_logs_task_index` (`task`),
  KEY `rj_ai_logs_created_at_index` (`created_at`),
  CONSTRAINT `rj_ai_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_ai_logs`
--

LOCK TABLES `rj_ai_logs` WRITE;
/*!40000 ALTER TABLE `rj_ai_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_ai_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_ai_prompts`
--

DROP TABLE IF EXISTS `rj_ai_prompts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_ai_prompts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'custom',
  `content` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_ai_prompts_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_ai_prompts`
--

LOCK TABLES `rj_ai_prompts` WRITE;
/*!40000 ALTER TABLE `rj_ai_prompts` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_ai_prompts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_categories`
--

DROP TABLE IF EXISTS `rj_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `post_count` int(10) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_categories_slug_unique` (`slug`),
  KEY `rj_categories_parent_id_index` (`parent_id`),
  KEY `rj_categories_is_active_index` (`is_active`),
  KEY `rj_categories_sort_order_index` (`sort_order`),
  CONSTRAINT `rj_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `rj_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_categories`
--

LOCK TABLES `rj_categories` WRITE;
/*!40000 ALTER TABLE `rj_categories` DISABLE KEYS */;
INSERT INTO `rj_categories` VALUES (4,'default-3',NULL,NULL,0,1,1,'2026-10-16 19:56:42','2026-10-16 19:59:30');
/*!40000 ALTER TABLE `rj_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_category_translations`
--

DROP TABLE IF EXISTS `rj_category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_category_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_category_translations_category_id_locale_unique` (`category_id`,`locale`),
  KEY `rj_category_translations_category_id_locale_index` (`category_id`,`locale`),
  CONSTRAINT `rj_category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `rj_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_category_translations`
--

LOCK TABLES `rj_category_translations` WRITE;
/*!40000 ALTER TABLE `rj_category_translations` DISABLE KEYS */;
INSERT INTO `rj_category_translations` VALUES (1,4,'en','Default',NULL,NULL,NULL,NULL,'2026-10-16 19:56:42','2026-10-16 19:56:42');
/*!40000 ALTER TABLE `rj_category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_comments`
--

DROP TABLE IF EXISTS `rj_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(255) NOT NULL,
  `author_url` varchar(255) DEFAULT NULL,
  `author_ip` varchar(45) DEFAULT NULL,
  `content` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `like_count` int(11) NOT NULL DEFAULT 0,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_comments_post_id_index` (`post_id`),
  KEY `rj_comments_parent_id_index` (`parent_id`),
  KEY `rj_comments_status_index` (`status`),
  KEY `rj_comments_user_id_index` (`user_id`),
  CONSTRAINT `rj_comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `rj_comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `rj_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_comments`
--

LOCK TABLES `rj_comments` WRITE;
/*!40000 ALTER TABLE `rj_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_coupons`
--

DROP TABLE IF EXISTS `rj_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'percentage',
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_limit_per_user` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `minimum_amount` decimal(15,2) DEFAULT NULL,
  `maximum_amount` decimal(15,2) DEFAULT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_coupons_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_coupons`
--

LOCK TABLES `rj_coupons` WRITE;
/*!40000 ALTER TABLE `rj_coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_custom_field_values`
--

DROP TABLE IF EXISTS `rj_custom_field_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_custom_field_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` bigint(20) unsigned NOT NULL,
  `valuable_type` varchar(255) NOT NULL,
  `valuable_id` bigint(20) unsigned NOT NULL,
  `value` longtext DEFAULT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_custom_field_values_valuable_type_valuable_id_index` (`valuable_type`,`valuable_id`),
  KEY `rj_custom_field_values_field_id_index` (`field_id`),
  CONSTRAINT `rj_custom_field_values_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `rj_custom_fields` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_custom_field_values`
--

LOCK TABLES `rj_custom_field_values` WRITE;
/*!40000 ALTER TABLE `rj_custom_field_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_custom_field_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_custom_fields`
--

DROP TABLE IF EXISTS `rj_custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_custom_fields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `placeholder` varchar(255) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `validation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`validation`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `post_types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`post_types`)),
  `taxonomies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`taxonomies`)),
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `is_repeatable` tinyint(1) NOT NULL DEFAULT 0,
  `location` varchar(255) NOT NULL DEFAULT 'post',
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_custom_fields_slug_unique` (`slug`),
  KEY `rj_custom_fields_slug_index` (`slug`),
  KEY `rj_custom_fields_key_index` (`key`),
  KEY `rj_custom_fields_type_index` (`type`),
  KEY `rj_custom_fields_location_index` (`location`),
  KEY `rj_custom_fields_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_custom_fields`
--

LOCK TABLES `rj_custom_fields` WRITE;
/*!40000 ALTER TABLE `rj_custom_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_custom_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_custom_fonts`
--

DROP TABLE IF EXISTS `rj_custom_fonts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_custom_fonts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `family` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL DEFAULT 'upload',
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`files`)),
  `variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`variants`)),
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_custom_fonts_status_index` (`status`),
  KEY `rj_custom_fonts_family_index` (`family`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_custom_fonts`
--

LOCK TABLES `rj_custom_fonts` WRITE;
/*!40000 ALTER TABLE `rj_custom_fonts` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_custom_fonts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_custom_icons`
--

DROP TABLE IF EXISTS `rj_custom_icons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_custom_icons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL DEFAULT 'upload',
  `library` varchar(255) DEFAULT NULL,
  `svg` longtext DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_custom_icons_slug_unique` (`slug`),
  KEY `rj_custom_icons_status_index` (`status`),
  KEY `rj_custom_icons_library_index` (`library`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_custom_icons`
--

LOCK TABLES `rj_custom_icons` WRITE;
/*!40000 ALTER TABLE `rj_custom_icons` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_custom_icons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_form_fields`
--

DROP TABLE IF EXISTS `rj_form_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_form_fields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `placeholder` varchar(255) DEFAULT NULL,
  `help_text` text DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `validation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`validation`)),
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_required` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `rj_form_fields_form_id_index` (`form_id`),
  KEY `rj_form_fields_sort_order_index` (`sort_order`),
  CONSTRAINT `rj_form_fields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `rj_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_form_fields`
--

LOCK TABLES `rj_form_fields` WRITE;
/*!40000 ALTER TABLE `rj_form_fields` DISABLE KEYS */;
INSERT INTO `rj_form_fields` VALUES (3,1,'field_ep23s','Name','text','',NULL,NULL,NULL,NULL,NULL,0,0,'2026-10-19 22:57:10','2026-10-19 22:57:10',1),(4,1,'field_9kgmc','Email','email','',NULL,NULL,NULL,NULL,NULL,0,1,'2026-10-19 22:57:10','2026-10-19 22:57:10',1);
/*!40000 ALTER TABLE `rj_form_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_form_submissions`
--

DROP TABLE IF EXISTS `rj_form_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_form_submissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) unsigned NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_form_submissions_form_id_index` (`form_id`),
  KEY `rj_form_submissions_status_index` (`status`),
  KEY `rj_form_submissions_created_at_index` (`created_at`),
  CONSTRAINT `rj_form_submissions_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `rj_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_form_submissions`
--

LOCK TABLES `rj_form_submissions` WRITE;
/*!40000 ALTER TABLE `rj_form_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_form_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_forms`
--

DROP TABLE IF EXISTS `rj_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_forms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `notifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`notifications`)),
  `actions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`actions`)),
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_forms_slug_unique` (`slug`),
  KEY `rj_forms_status_index` (`status`),
  KEY `rj_forms_author_id_index` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_forms`
--

LOCK TABLES `rj_forms` WRITE;
/*!40000 ALTER TABLE `rj_forms` DISABLE KEYS */;
INSERT INTO `rj_forms` VALUES (1,'Default','default',NULL,NULL,NULL,NULL,'active',NULL,'2026-10-18 17:51:15','2026-10-18 17:51:15');
/*!40000 ALTER TABLE `rj_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_global_widgets`
--

DROP TABLE IF EXISTS `rj_global_widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_global_widgets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `children` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`children`)),
  `description` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_global_widgets_slug_unique` (`slug`),
  KEY `rj_global_widgets_type_index` (`type`),
  KEY `rj_global_widgets_status_index` (`status`),
  KEY `rj_global_widgets_author_id_index` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_global_widgets`
--

LOCK TABLES `rj_global_widgets` WRITE;
/*!40000 ALTER TABLE `rj_global_widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_global_widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_knowledge`
--

DROP TABLE IF EXISTS `rj_knowledge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_knowledge` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'general',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_knowledge_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_knowledge`
--

LOCK TABLES `rj_knowledge` WRITE;
/*!40000 ALTER TABLE `rj_knowledge` DISABLE KEYS */;
INSERT INTO `rj_knowledge` VALUES (1,'info','info',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(2,'api','api',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(3,'theme','theme',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(4,'admin','admin',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(5,'plugin','plugin',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(6,'developer','developer',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(7,'hooks','hooks',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(8,'other','other',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(9,'credits','credits',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(10,'license','license',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(11,'user-guide','other',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(12,'faq','other',1,'2026-10-20 16:24:43','2026-10-20 16:24:43'),(13,'troubleshooting','other',1,'2026-10-20 16:24:43','2026-10-20 16:24:43');
/*!40000 ALTER TABLE `rj_knowledge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_knowledge_translations`
--

DROP TABLE IF EXISTS `rj_knowledge_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_knowledge_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `knowledge_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_knowledge_translations_knowledge_id_locale_unique` (`knowledge_id`,`locale`),
  KEY `rj_knowledge_translations_locale_index` (`locale`),
  CONSTRAINT `rj_knowledge_translations_knowledge_id_foreign` FOREIGN KEY (`knowledge_id`) REFERENCES `rj_knowledge` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_knowledge_translations`
--

LOCK TABLES `rj_knowledge_translations` WRITE;
/*!40000 ALTER TABLE `rj_knowledge_translations` DISABLE KEYS */;
INSERT INTO `rj_knowledge_translations` VALUES (1,1,'en','About RJ CMS','<p>RJ CMS is a modern, self-hosted Content Management System built on Laravel 12. It offers a WordPress-like experience but with a cleaner, faster, and more modern architecture.</p><p>Key features include:</p><ul><li>Visual Page Builder (RJBuilder)</li><li>Plugin & Theme Ecosystem</li><li>AI Integration (OpenRouter)</li><li>Multilingual Support</li><li>Advanced Role & Permission System</li></ul>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(2,1,'az','RJ CMS Haqq─▒nda','<p>RJ CMS Laravel 12 ├╝z╔Örind╔Ö qurulmu┼ƒ m├╝asir, self-hosted Kontent ─░dar╔Öetm╔Ö Sistemidir. WordPress b╔Önz╔Öri t╔Öcr├╝b╔Ö t╔Öqdim edir, lakin daha t╔Ömiz, s├╝r╔Ötli v╔Ö m├╝asir arxitekturaya malikdir.</p><p>╞Åsas x├╝susiyy╔Ötl╔Öri:</p><ul><li>Vizual S╔Öhif╔Ö Qurucusu (RJBuilder)</li><li>Plugin v╔Ö Tema Ekosistemi</li><li>AI ─░nteqrasiyas─▒ (OpenRouter)</li><li>├çoxdilli D╔Öst╔Ök</li><li>─░nki┼ƒaf etmi┼ƒ Rol v╔Ö ─░caz╔Ö Sistemi</li></ul>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(3,2,'en','API Documentation','<p>RJ CMS provides a RESTful API to manage your content externally.</p><h3>Authentication</h3><p>To access the API, you need to generate API keys from <strong>Settings > API & Integrations</strong>. You must pass the keys in the headers:</p><pre>X-Public-Key: YOUR_PUBLIC_KEY\\nX-Private-Key: YOUR_PRIVATE_KEY</pre><h3>Endpoints</h3><ul><li><code>GET /api/v1/posts</code> - List all posts</li><li><code>GET /api/v1/posts/{id}</code> - Get a single post</li><li><code>GET /api/v1/pages</code> - List all pages</li><li><code>GET /api/v1/media</code> - List all media</li></ul>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(4,2,'az','API S╔Ön╔Ödl╔Ö┼ƒm╔Ösi','<p>RJ CMS m╔Özmununuzu xarici olaraq idar╔Ö etm╔Ök ├╝├º├╝n RESTful API t╔Öqdim edir.</p><h3>Autentifikasiya</h3><p>API-y╔Ö giri┼ƒ ├╝├º├╝n <strong>Ayarlar > API v╔Ö ─░nteqrasiyalar</strong> b├╢lm╔Ösind╔Ön API a├ºarlar─▒ yaratmal─▒s─▒n─▒z. A├ºarlar─▒ ba┼ƒl─▒qlarda (headers) g├╢nd╔Örm╔Ölisiniz:</p><pre>X-Public-Key: S─░Z─░N_PUBLIC_A├çARINIZ\\nX-Private-Key: S─░Z─░N_PRIVATE_A├çARINIZ</pre><h3>Endpoint-l╔Ör</h3><ul><li><code>GET /api/v1/posts</code> - B├╝t├╝n yaz─▒lar─▒ g├╢st╔Ör</li><li><code>GET /api/v1/posts/{id}</code> - T╔Ök yaz─▒n─▒ g├╢st╔Ör</li><li><code>GET /api/v1/pages</code> - B├╝t├╝n s╔Öhif╔Öl╔Öri g├╢st╔Ör</li><li><code>GET /api/v1/media</code> - B├╝t├╝n median─▒ g├╢st╔Ör</li></ul>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(5,3,'en','Theme Development','<p>Themes in RJ CMS are located in the <code>rj-content/themes</code> directory. Each theme requires a <code>theme.json</code> manifest file.</p><h3>theme.json Structure</h3><p>The manifest defines the theme name, version, author, supports, and customizer settings.</p><h3>Customizer</h3><p>Themes can define a <code>customizer</code> block in <code>theme.json</code> to allow users to change colors, fonts, and layouts from the admin panel.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(6,3,'az','Tema ─░nki┼ƒaf─▒','<p>RJ CMS-d╔Ö temalar <code>rj-content/themes</code> qovlu─ƒunda yerl╔Ö┼ƒir. H╔Ör tema <code>theme.json</code> manifest fayl─▒ t╔Öl╔Öb edir.</p><h3>theme.json Strukturu</h3><p>Manifest tema ad─▒n─▒, versiyas─▒n─▒, m├╝╔Öllifini, d╔Öst╔Ökl╔Ödiyi funksiyalar─▒ v╔Ö customizer ayarlar─▒n─▒ t╔Öyin edir.</p><h3>Customizer</h3><p>Temalar <code>theme.json</code> daxilind╔Ö <code>customizer</code> bloku t╔Öyin ed╔Ör╔Ök istifad╔Ö├ºil╔Ör╔Ö admin paneld╔Ön r╔Öngl╔Öri, ┼ƒriftl╔Öri v╔Ö t╔Örtibat─▒ d╔Öyi┼ƒm╔Öy╔Ö imkan ver╔Ö bil╔Ör.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(7,4,'en','Admin Panel Guide','<p>The RJ CMS admin panel is where you manage all your site content.</p><h3>Posts & Pages</h3><p>You can create, edit, and delete posts and pages. You can also toggle between the Classic Editor and the RJBuilder visual editor.</p><h3>Media</h3><p>Upload images, videos, and documents. You can manage them in the Media Library.</p><h3>Appearance</h3><p>Manage themes, menus, and widgets. The Customizer allows you to tweak your theme settings.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(8,4,'az','Admin Panel B╔Öl╔Öd├ºisi','<p>RJ CMS admin paneli b├╝t├╝n sayt m╔Özmununuzu idar╔Ö etdiyiniz yerdir.</p><h3>Yaz─▒lar v╔Ö S╔Öhif╔Öl╔Ör</h3><p>Yaz─▒lar v╔Ö s╔Öhif╔Öl╔Ör yarada, redakt╔Ö ed╔Ö v╔Ö sil╔Ö bil╔Örsiniz. Klassik Redaktor v╔Ö RJBuilder vizual redaktoru aras─▒nda ke├ºid ed╔Ö bil╔Örsiniz.</p><h3>Media</h3><p>┼₧╔Ökill╔Ör, videolar v╔Ö s╔Ön╔Ödl╔Ör y├╝kl╔Öyin. Onlar─▒ Media Kitabxanas─▒nda idar╔Ö ed╔Ö bil╔Örsiniz.</p><h3>G├╢r├╝n├╝┼ƒ</h3><p>Temalar─▒, menyular─▒ v╔Ö vidcetl╔Öri idar╔Ö edin. Customizer tema ayarlar─▒n─▒z─▒ d╔Öyi┼ƒm╔Öy╔Ö imkan verir.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(9,5,'en','Plugin Development','<p>Plugins extend the functionality of RJ CMS. They are located in <code>rj-content/plugins</code>.</p><h3>plugin.json</h3><p>Each plugin requires a <code>plugin.json</code> manifest file defining its name, version, namespace, and service provider.</p><h3>Hooks</h3><p>Plugins can hook into the core functionality using Actions and Filters.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(10,5,'az','Plugin ─░nki┼ƒaf─▒','<p>Pluginl╔Ör RJ CMS-in funksionall─▒─ƒ─▒n─▒ geni┼ƒl╔Öndirir. Onlar <code>rj-content/plugins</code> qovlu─ƒunda yerl╔Ö┼ƒir.</p><h3>plugin.json</h3><p>H╔Ör plugin ad─▒n─▒, versiyas─▒n─▒, namespace-ni v╔Ö service provider-i t╔Öyin ed╔Ön <code>plugin.json</code> manifest fayl─▒ t╔Öl╔Öb edir.</p><h3>Hooks</h3><p>Pluginl╔Ör Actions v╔Ö Filters istifad╔Ö ed╔Ör╔Ök ╔Ösas funksionall─▒─ƒa qo┼ƒula bil╔Ör.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(11,6,'en','Developer Guide','<p>RJ CMS is built with Laravel 12, Blade, Tailwind CSS, and Alpine.js.</p><h3>Directory Structure</h3><ul><li><code>app/</code> - Core PHP classes</li><li><code>resources/views/</code> - Blade templates</li><li><code>rj-content/</code> - Themes and Plugins</li></ul><h3>Helper Functions</h3><p>RJ CMS provides helper functions like <code>rj_get_option()</code>, <code>rj_set_option()</code>, and <code>rj_render_blocks()</code>.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(12,6,'az','Developer B╔Öl╔Öd├ºisi','<p>RJ CMS Laravel 12, Blade, Tailwind CSS v╔Ö Alpine.js il╔Ö qurulub.</p><h3>Qovluq Strukturu</h3><ul><li><code>app/</code> - ╞Åsas PHP sinifl╔Öri</li><li><code>resources/views/</code> - Blade ┼ƒablonlar─▒</li><li><code>rj-content/</code> - Temalar v╔Ö Pluginl╔Ör</li></ul><h3>K├╢m╔Ök├ºi Funksiyalar</h3><p>RJ CMS <code>rj_get_option()</code>, <code>rj_set_option()</code> v╔Ö <code>rj_render_blocks()</code> kimi k├╢m╔Ök├ºi funksiyalar t╔Öqdim edir.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(13,7,'en','Hooks Reference','<p>RJ CMS uses an event-driven architecture inspired by WordPress.</p><h3>Actions</h3><p>Actions allow you to execute code at specific points:</p><pre>add_action(\"admin.menu\", function() { ... });\\ndo_action(\"admin.menu\");</pre><h3>Filters</h3><p>Filters allow you to modify data before it is used:</p><pre>add_filter(\"builder.widgets\", function($widgets) { return $widgets; });\\napply_filters(\"builder.widgets\", $widgets);</pre>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(14,7,'az','Hooks B╔Öl╔Öd├ºisi','<p>RJ CMS WordPress-d╔Ön ilhamlanan hadis╔Ö y├╢n├╝ml├╝ arxitekturadan istifad╔Ö edir.</p><h3>Actions</h3><p>Actions m├╝╔Öyy╔Ön n├╢qt╔Öl╔Örd╔Ö kod icra etm╔Öy╔Ö imkan verir:</p><pre>add_action(\"admin.menu\", function() { ... });\\ndo_action(\"admin.menu\");</pre><h3>Filters</h3><p>Filters m╔Ölumat istifad╔Ö edilm╔Özd╔Ön ╔Övv╔Öl onu d╔Öyi┼ƒdirm╔Öy╔Ö imkan verir:</p><pre>add_filter(\"builder.widgets\", function($widgets) { return $widgets; });\\napply_filters(\"builder.widgets\", $widgets);</pre>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(15,8,'en','Updates & Maintenance','<p>Keep your RJ CMS installation up to date to ensure security and stability.</p><p>Go to <strong>Updates</strong> in the admin panel to check for core, theme, and plugin updates.</p><p>Always backup your database and files before running updates using the <strong>Tools > Backup</strong> feature.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(16,8,'az','Yenil╔Önm╔Öl╔Ör v╔Ö Texniki Xidm╔Öt','<p>T╔Öhl├╝k╔Ösizlik v╔Ö sabitliyi t╔Ömin etm╔Ök ├╝├º├╝n RJ CMS qura┼ƒd─▒rman─▒z─▒ yenil╔Öyin.</p><p>╞Åsas, tema v╔Ö plugin yenil╔Öm╔Öl╔Örini yoxlamaq ├╝├º├╝n admin panelind╔Ö <strong>Yenil╔Önm╔Öl╔Ör</strong> b├╢lm╔Ösin╔Ö ke├ºin.</p><p>Yenil╔Öm╔Öl╔Öri etm╔Özd╔Ön ╔Övv╔Öl h╔Ömi┼ƒ╔Ö <strong>Al╔Ötl╔Ör > Backup</strong> funksiyas─▒ il╔Ö veril╔Önl╔Ör bazan─▒z─▒ v╔Ö fayllar─▒n─▒z─▒ ehtiyat n├╝sx╔Ösini ├º─▒xar─▒n.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(17,9,'en','Credits','<p><strong>RJ CMS</strong> is developed and maintained by Ruhid Javadov.</p><p>Special thanks to the Laravel, Tailwind CSS, and Alpine.js communities for their incredible open-source tools.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(18,9,'az','T╔Ö┼ƒ╔Ökk├╝rl╔Ör','<p><strong>RJ CMS</strong> Ruhid C╔Öf╔Örov t╔Ör╔Öfind╔Ön haz─▒rlanm─▒┼ƒ v╔Ö idar╔Ö olunur.</p><p>Laravel, Tailwind CSS v╔Ö Alpine.js icmalar─▒na ╔Öv╔Özsiz a├º─▒q m╔Önb╔Ö al╔Ötl╔Öri ├╝├º├╝n x├╝susi t╔Ö┼ƒ╔Ökk├╝rl╔Ör.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(19,10,'en','License','<p>RJ CMS is open-source software licensed under the <strong>MIT license</strong>.</p><p>You are free to use, modify, and distribute this software for personal and commercial projects.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(20,10,'az','Lisenziya','<p>RJ CMS <strong>MIT lisenziyas─▒</strong> alt─▒nda lisenziyala┼ƒd─▒r─▒lm─▒┼ƒ a├º─▒q m╔Önb╔Ö proqram t╔Öminat─▒d─▒r.</p><p>Bu proqram t╔Öminat─▒n─▒ ┼ƒ╔Öxsi v╔Ö kommersiya layih╔Öl╔Öri ├╝├º├╝n istifad╔Ö etm╔Ökd╔Ö, d╔Öyi┼ƒdirm╔Ökd╔Ö v╔Ö yaymaqda s╔Örb╔Östsiniz.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(21,11,'en','User Guide','<h3>How to create a post?</h3><p>Go to <strong>Posts > Add New</strong>. Enter your title, content, and click Publish.</p><h3>How to change the theme?</h3><p>Go to <strong>Appearance > Themes</strong>, browse the available themes, and click Activate.</p><h3>How to add a menu?</h3><p>Go to <strong>Appearance > Menus</strong>, create a new menu, and drag items into it.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(22,11,'az','─░stifad╔Ö├ºi B╔Öl╔Öd├ºisi','<h3>Yaz─▒ nec╔Ö yarad─▒l─▒r?</h3><p><strong>Yaz─▒lar > Yeni ╞Ålav╔Ö Et</strong> b├╢lm╔Ösin╔Ö ke├ºin. Ba┼ƒl─▒─ƒ─▒, m╔Özmunu daxil edin v╔Ö D╔Örc et d├╝ym╔Ösin╔Ö bas─▒n.</p><h3>Teman─▒ nec╔Ö d╔Öyi┼ƒm╔Ök olar?</h3><p><strong>G├╢r├╝n├╝┼ƒ > Temalar</strong> b├╢lm╔Ösin╔Ö ke├ºin, m├╢vcud temalara bax─▒n v╔Ö Aktiv et d├╝ym╔Ösin╔Ö bas─▒n.</p><h3>Menyu nec╔Ö ╔Ölav╔Ö edilir?</h3><p><strong>G├╢r├╝n├╝┼ƒ > Menyular</strong> b├╢lm╔Ösin╔Ö ke├ºin, yeni menyu yarad─▒n v╔Ö elementl╔Öri ora dart─▒b ╔Ölav╔Ö edin.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(23,12,'en','FAQ','<h3>Can I use RJ CMS for commercial projects?</h3><p>Yes, RJ CMS is MIT licensed.</p><h3>Does it support multiple languages?</h3><p>Yes, the core supports AZ, EN, RU, TR, and dynamic languages can be added.</p><h3>How do I update the system?</h3><p>Use the <strong>Updates</strong> section in the admin panel.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(24,12,'az','Tez-tez Veril╔Ön Suallar (FAQ)','<h3>RJ CMS-i kommersiya layih╔Öl╔Örind╔Ö istifad╔Ö ed╔Ö bil╔Ör╔Öm?</h3><p>B╔Öli, RJ CMS MIT lisenziyas─▒na malikdir.</p><h3>├çoxdilli d╔Öst╔Öyi varm─▒?</h3><p>B╔Öli, n├╝v╔Ö AZ, EN, RU, TR dill╔Örini d╔Öst╔Ökl╔Öyir v╔Ö dinamik dill╔Ör ╔Ölav╔Ö edil╔Ö bil╔Ör.</p><h3>Sistemi nec╔Ö yenil╔Öy╔Ö bil╔Ör╔Öm?</h3><p>Admin panelind╔Öki <strong>Yenil╔Önm╔Öl╔Ör</strong> b├╢lm╔Ösind╔Ön istifad╔Ö edin.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(25,13,'en','Troubleshooting','<h3>500 Internal Server Error</h3><p>Check your <code>storage/logs/laravel.log</code> file for the exact error. It might be a missing PHP extension or permission issue.</p><h3>Changes not showing?</h3><p>Clear the cache from <strong>Settings > Cache</strong> or run <code>php artisan optimize:clear</code>.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43'),(26,13,'az','Probleml╔Örin H╔Ölli','<h3>500 Daxili Server X╔Ötas─▒</h3><p>D╔Öqiq x╔Ötan─▒ g├╢rm╔Ök ├╝├º├╝n <code>storage/logs/laravel.log</code> fayl─▒n─▒ yoxlay─▒n. Bu, ├ºat─▒┼ƒmayan PHP geni┼ƒl╔Öndirm╔Ösi v╔Ö ya icaz╔Ö problemi ola bil╔Ör.</p><h3>D╔Öyi┼ƒiklikl╔Ör g├╢r├╝nm├╝r?</h3><p><strong>Ayarlar > Ke┼ƒ</strong> b├╢lm╔Ösind╔Ön ke┼ƒi t╔Ömizl╔Öyin v╔Ö ya <code>php artisan optimize:clear</code> ╔Ömrini icra edin.</p>','2026-10-20 16:24:43','2026-10-20 16:24:43');
/*!40000 ALTER TABLE `rj_knowledge_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_kyc_verifications`
--

DROP TABLE IF EXISTS `rj_kyc_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_kyc_verifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `driver` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `document_type` varchar(255) DEFAULT NULL,
  `document_front` varchar(255) DEFAULT NULL,
  `document_back` varchar(255) DEFAULT NULL,
  `selfie` varchar(255) DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_kyc_verifications_user_id_foreign` (`user_id`),
  CONSTRAINT `rj_kyc_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_kyc_verifications`
--

LOCK TABLES `rj_kyc_verifications` WRITE;
/*!40000 ALTER TABLE `rj_kyc_verifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_kyc_verifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_media`
--

DROP TABLE IF EXISTS `rj_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `uploaded_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_media_mime_type_index` (`mime_type`),
  KEY `rj_media_uploaded_by_index` (`uploaded_by`),
  CONSTRAINT `rj_media_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_media`
--

LOCK TABLES `rj_media` WRITE;
/*!40000 ALTER TABLE `rj_media` DISABLE KEYS */;
INSERT INTO `rj_media` VALUES (1,'whatsapp-image-2026-09-18-at-32858-pm-7tv6J6ua.jpeg','WhatsApp Image 2026-09-18 at 3.28.58 PM.jpeg','uploads/2026/10/whatsapp-image-2026-09-18-at-32858-pm-7tv6J6ua.jpeg','http://127.0.0.1:8000/uploads/2026/10/whatsapp-image-2026-09-18-at-32858-pm-7tv6J6ua.jpeg','image/jpeg',88203,1170,697,NULL,'WhatsApp Image 2026-09-18 at 3.28.58 PM',NULL,NULL,1,'2026-10-13 11:43:44','2026-10-13 11:43:44'),(2,'logo-white-kpO7Lvpj.svg','logo-white.svg','uploads/2026/10/logo-white-kpO7Lvpj.svg','http://127.0.0.1:8000/uploads/2026/10/logo-white-kpO7Lvpj.svg','image/svg+xml',15493,NULL,NULL,NULL,'logo-white',NULL,NULL,1,'2026-10-13 18:31:48','2026-10-13 18:31:48'),(3,'logo-white-zsKN6gOD.svg','logo-white.svg','uploads/2026/10/logo-white-zsKN6gOD.svg','http://127.0.0.1:8000/uploads/2026/10/logo-white-zsKN6gOD.svg','image/svg+xml',15493,NULL,NULL,NULL,'logo-white',NULL,NULL,1,'2026-10-13 18:32:01','2026-10-13 18:32:01'),(4,'logo-MOR9OzoF.svg','logo.svg','uploads/2026/10/logo-MOR9OzoF.svg','http://127.0.0.1:8000/uploads/2026/10/logo-MOR9OzoF.svg','image/svg+xml',84826,NULL,NULL,NULL,'logo',NULL,NULL,1,'2026-10-13 18:32:07','2026-10-13 18:32:07'),(5,'gemini-generated-image-1kg64w1kg64w1kg6-wXr2zYwk.jpg','Gemini_Generated_Image_1kg64w1kg64w1kg6.jpg','uploads/2026/10/gemini-generated-image-1kg64w1kg64w1kg6-wXr2zYwk.jpg','http://127.0.0.1:8000/uploads/2026/10/gemini-generated-image-1kg64w1kg64w1kg6-wXr2zYwk.jpg','image/jpeg',3377232,2752,1536,NULL,'Gemini_Generated_Image_1kg64w1kg64w1kg6',NULL,NULL,1,'2026-10-16 18:38:41','2026-10-16 18:38:41'),(6,'ruhid-javadoff-qKCRmr5W.png','Ruhid javadoff.png','uploads/2026/10/ruhid-javadoff-qKCRmr5W.png','http://127.0.0.1:8000/uploads/2026/10/ruhid-javadoff-qKCRmr5W.png','image/png',6469577,3840,2160,NULL,'Ruhid javadoff',NULL,NULL,1,'2026-10-24 20:13:21','2026-10-24 20:13:21'),(7,'images-Gyd4HbBL.jpg','images.jpg','uploads/2026/10/images-Gyd4HbBL.jpg','http://127.0.0.1:8000/uploads/2026/10/images-Gyd4HbBL.jpg','image/jpeg',13147,320,320,NULL,'images',NULL,NULL,1,'2026-10-25 04:40:06','2026-10-25 04:40:06'),(8,'black-and-white-private-detective-logo-shlDQxye.png','Black and White Private Detective Logo.png','uploads/2026/10/black-and-white-private-detective-logo-shlDQxye.png','http://127.0.0.1:8000/uploads/2026/10/black-and-white-private-detective-logo-shlDQxye.png','image/png',725008,1920,700,NULL,'Black and White Private Detective Logo',NULL,NULL,1,'2026-10-27 02:29:15','2026-10-27 02:29:15');
/*!40000 ALTER TABLE `rj_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_menu_items`
--

DROP TABLE IF EXISTS `rj_menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_menu_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'custom',
  `label` varchar(255) NOT NULL,
  `translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`translations`)),
  `url` varchar(255) DEFAULT NULL,
  `target` varchar(10) NOT NULL DEFAULT '_self',
  `object_id` bigint(20) unsigned DEFAULT NULL,
  `object_type` varchar(50) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `css_class` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_menu_items_menu_id_index` (`menu_id`),
  KEY `rj_menu_items_parent_id_index` (`parent_id`),
  KEY `rj_menu_items_sort_order_index` (`sort_order`),
  KEY `rj_menu_items_object_type_object_id_index` (`object_type`,`object_id`),
  CONSTRAINT `rj_menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `rj_menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `rj_menu_items` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_menu_items`
--

LOCK TABLES `rj_menu_items` WRITE;
/*!40000 ALTER TABLE `rj_menu_items` DISABLE KEYS */;
INSERT INTO `rj_menu_items` VALUES (2,1,NULL,'page','Home',NULL,'/home','_self',2,'page',1,NULL,NULL,1,'2026-10-19 22:47:27','2026-10-19 22:47:27'),(3,1,NULL,'page','About',NULL,'/about','_self',3,'page',2,NULL,NULL,1,'2026-10-19 22:47:35','2026-10-19 22:47:35'),(4,1,NULL,'page','Contact',NULL,'/contact','_self',4,'page',3,NULL,NULL,1,'2026-10-19 22:47:41','2026-10-19 22:47:41');
/*!40000 ALTER TABLE `rj_menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_menus`
--

DROP TABLE IF EXISTS `rj_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `location` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_menus_slug_unique` (`slug`),
  KEY `rj_menus_location_index` (`location`),
  KEY `rj_menus_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_menus`
--

LOCK TABLES `rj_menus` WRITE;
/*!40000 ALTER TABLE `rj_menus` DISABLE KEYS */;
INSERT INTO `rj_menus` VALUES (1,'Main','main','header',NULL,1,'2026-10-13 17:13:09','2026-10-13 17:13:09');
/*!40000 ALTER TABLE `rj_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_newsletter_subscribers`
--

DROP TABLE IF EXISTS `rj_newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_newsletter_subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `source` varchar(50) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_newsletter_subscribers_email_unique` (`email`),
  KEY `rj_newsletter_subscribers_status_index` (`status`),
  KEY `rj_newsletter_subscribers_created_at_index` (`created_at`),
  KEY `rj_newsletter_subscribers_token_index` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_newsletter_subscribers`
--

LOCK TABLES `rj_newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `rj_newsletter_subscribers` DISABLE KEYS */;
INSERT INTO `rj_newsletter_subscribers` VALUES (1,'mahiraybrat@gmail.com',NULL,'active','widget','A3wgua0DuFC9t9QcatKvVbu7eK6Vjn4knU6nDZQwkSuODzQLZ8Cenj8mcXdJHaCt','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','2026-10-27 07:43:25',NULL,'2026-10-27 07:43:25','2026-10-27 07:43:25'),(2,'ruhidjavadoff@gmail.com',NULL,'active','widget','gb12pUFvjHfJM35heAoZvS2pfncGv2Jleb8U1yeoGY6of2A4mmk4w7qOdlZMYEP0','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','2026-10-27 08:00:39',NULL,'2026-10-27 08:00:39','2026-10-27 08:00:39'),(3,'ruhidjavadov@gmail.com',NULL,'active','widget','z4VF96QnMJMmUzDjhlwo2t5N9sCoSIglUfKWWmVu7Vzkp9YuMfFPxXTYIR127Hr1','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','2026-10-27 08:04:26',NULL,'2026-10-27 08:04:26','2026-10-27 08:04:26');
/*!40000 ALTER TABLE `rj_newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_notification_settings`
--

DROP TABLE IF EXISTS `rj_notification_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_notification_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `event` varchar(255) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_notification_settings_user_id_event_channel_unique` (`user_id`,`event`,`channel`),
  KEY `rj_notification_settings_user_id_index` (`user_id`),
  CONSTRAINT `rj_notification_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_notification_settings`
--

LOCK TABLES `rj_notification_settings` WRITE;
/*!40000 ALTER TABLE `rj_notification_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_notification_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_notifications`
--

DROP TABLE IF EXISTS `rj_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `action_label` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `notifiable_type` varchar(255) DEFAULT NULL,
  `notifiable_id` bigint(20) unsigned DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_notifications_user_id_index` (`user_id`),
  KEY `rj_notifications_read_at_index` (`read_at`),
  KEY `rj_notifications_type_index` (`type`),
  KEY `rj_notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_notifications`
--

LOCK TABLES `rj_notifications` WRITE;
/*!40000 ALTER TABLE `rj_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_options`
--

DROP TABLE IF EXISTS `rj_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) NOT NULL,
  `option_value` longtext DEFAULT NULL,
  `option_group` varchar(255) NOT NULL DEFAULT 'general',
  `option_type` varchar(255) NOT NULL DEFAULT 'text',
  `autoload` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_options_option_name_unique` (`option_name`),
  KEY `rj_options_option_group_index` (`option_group`),
  KEY `rj_options_autoload_index` (`autoload`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_options`
--

LOCK TABLES `rj_options` WRITE;
/*!40000 ALTER TABLE `rj_options` DISABLE KEYS */;
INSERT INTO `rj_options` VALUES (1,'site_name','RJ CMS','general','text',1,'2026-10-11 18:22:50','2026-10-11 18:22:50'),(2,'site_description','A modern CMS built with Laravel','general','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(3,'site_url','http://127.0.0.1:8000','general','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(4,'admin_email','admin@example.com','general','email',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(5,'timezone','Asia/Baku','general','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(6,'date_format','Y-m-d','general','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(7,'time_format','H:i','general','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(8,'language','en','general','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(9,'currency','USD','general','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(10,'posts_per_page','10','reading','number',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(11,'homepage_type','latest','reading','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(12,'feed_enabled','1','reading','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(13,'comments_enabled','1','discussion','text',1,'2026-10-11 18:22:51','2026-10-16 20:48:46'),(14,'comments_moderation','1','discussion','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(15,'ai_moderation','0','discussion','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(16,'permalink_structure','name','permalinks','text',1,'2026-10-11 18:22:51','2026-10-16 20:34:51'),(17,'admin_theme','light','colors','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(18,'admin_color','#111827','colors','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(19,'frontend_theme','default','colors','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(20,'seo_enabled','1','seo','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(21,'seo_ai_enabled','0','seo','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(22,'ai_enabled','0','ai','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(23,'ai_provider','openai','ai','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(24,'ai_model','gpt-4o-mini','ai','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(25,'ai_temperature','0.7','ai','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(26,'ai_max_tokens','2000','ai','number',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(27,'ai_monthly_limit','100','ai','number',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(28,'security_2fa','0','security','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(29,'security_login_limit','5','security','number',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(30,'backup_auto','0','backup','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(31,'backup_frequency','daily','backup','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(32,'cache_enabled','0','cache','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(33,'cache_ttl','3600','cache','number',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(34,'updates_core_auto','0','updates','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(35,'updates_plugin_auto','0','updates','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(36,'updates_theme_auto','0','updates','boolean',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(37,'rj_version','1.0.0','system','text',1,'2026-10-11 18:22:51','2026-10-11 18:22:51'),(38,'rj_installed_at','2026-10-17 00:08:29','system','text',1,'2026-10-11 18:22:51','2026-10-16 20:08:29'),(39,'admin_color_preset','green','colors','text',1,'2026-10-12 16:24:43','2026-10-22 14:27:53'),(40,'last_checked','2026-10-13 15:06:51','updates','text',1,'2026-10-13 11:06:51','2026-10-13 11:06:51'),(41,'last_release','{\"version\":\"1.0.0\",\"name\":\"RJ CMS Lite v1.0.0 \\u2014 Initial Release\",\"body\":\"# RJ CMS Lite v1.0.0\\r\\n\\r\\nFirst public release of RJ CMS Lite, a lightweight Laravel CMS built for print businesses. It manages DTF transfers, custom signage, product catalogs, orders, deliveries and support tickets, with a fully customizable homepage driven by a drag-and-drop widget system.\\r\\n\\r\\n## Highlights\\r\\n\\r\\n- **Widget-based homepage**: 19 predefined sections, drag-to-reorder, per-widget settings editor\\r\\n- **RJFrame Design Studio**: online DTF gang sheet builder (Fabric.js) with text, shapes, image adjustments, auto-arrange, DPI validation and PNG export\\r\\n- **Product catalog**: products, models, categories, attributes, variants, print zones\\r\\n- **Order management**: cart, checkout, receipts, order tracking, design downloads\\r\\n- **Delivery system**: branches, delivery zones, delivery rates\\r\\n- **Payments**: pluggable gateway registry (manual entry, extensible)\\r\\n- **Support tickets**: threads, attachments, priorities, admin replies\\r\\n- **Content**: blog, pages, sliders, menus, gallery, FAQ\\r\\n- **Admin AI Chat**: embed an external AI chat (HF Spaces, DeepAI, Kimi) as an iframe or popup, with a server-side proxy\\r\\n- **2FA authentication**: email-based verification for admin login\\r\\n- **Storage analyzer**: clean up temp, orphaned and order files\\r\\n- **Backup and restore**: manual database backups\\r\\n- **Order API**: external integration endpoint\\r\\n\\r\\n## Tech Stack\\r\\n\\r\\n- Laravel 12.69, PHP 8.2\\r\\n- Tailwind CSS 4, Alpine.js 3, Vite 7\\r\\n- Fabric.js 5.3\\r\\n- MySQL \\/ SQLite\\r\\n- Cloudinary (video only)\\r\\n\\r\\n## Requirements\\r\\n\\r\\n- PHP >= 8.2\\r\\n- Composer >= 2.10\\r\\n- Node.js >= 18\\r\\n- MySQL 8+ or SQLite\\r\\n- PHP extensions: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl`, `fileinfo`\\r\\n\\r\\n## Installation\\r\\n\\r\\n```bash\\r\\ngit clone https:\\/\\/github.com\\/mr-ruhid\\/dtf-website.git\\r\\ncd dtf-website\\r\\n\\r\\ncomposer install\\r\\ncp .env.example .env\\r\\nphp artisan key:generate\\r\\nnpm install && npm run build\\r\\n```\\r\\n\\r\\nSet your database credentials in `.env`, then run:\\r\\n\\r\\n```bash\\r\\nphp artisan migrate --seed\\r\\nphp artisan storage:link\\r\\n```\\r\\n\\r\\n## Default Admin\\r\\n\\r\\n```text\\r\\nURL:      \\/admin\\/login\\r\\nEmail:    admin@rjshop.com\\r\\nPassword: admin123\\r\\n```\\r\\n\\r\\n**Change these immediately after the first login.**\\r\\n\\r\\n## Known Limitations\\r\\n\\r\\n- Multi-language support is not yet implemented\\r\\n- Test suite is not included\\r\\n- Payment gateways: manual entry only (API-ready via `PaymentGatewayRegistry`)\\r\\n- Cloudinary integration covers video uploads only\\r\\n- Logo asset is not bundled (defaults to the \\\"RJ CMS\\\" text)\\r\\n\\r\\n## License\\r\\n\\r\\nRJ CMS Lite is source-available. You may view and modify the code for non-commercial purposes. Commercial use and running it as a live website require prior written permission and a paid license from the author. See [[LICENSE.md](https:\\/\\/claude.ai\\/chat\\/LICENSE.md)](LICENSE.md) for details.\\r\\n\\r\\n## Documentation\\r\\n\\r\\nFull documentation, widget reference and route lists are in the [[README](https:\\/\\/github.com\\/mr-ruhid\\/dtf-website#readme)](https:\\/\\/github.com\\/mr-ruhid\\/dtf-website#readme).\\r\\n\\r\\n## Credits\\r\\n\\r\\n- Author: Ruhid Javadov ([[@mr-ruhid](https:\\/\\/github.com\\/mr-ruhid)](https:\\/\\/github.com\\/mr-ruhid))\\r\\n- Repository: <https:\\/\\/github.com\\/mr-ruhid\\/dtf-website>\\r\\n\\r\\n## Support the Project\\r\\n\\r\\nIf this project is useful to you, you can support its development via [[Kofe.al](https:\\/\\/kofe.al\\/@ruhidjavadoff)](https:\\/\\/kofe.al\\/@ruhidjavadoff), [[\\u00c7ayvoy](https:\\/\\/cayvoy.com\\/donate\\/ruhid4715)](https:\\/\\/cayvoy.com\\/donate\\/ruhid4715) or [[PayPal](https:\\/\\/www.paypal.com\\/paypalme\\/ruhidjavadoff)](https:\\/\\/www.paypal.com\\/paypalme\\/ruhidjavadoff).\",\"url\":\"https:\\/\\/github.com\\/mr-ruhid\\/rj-cms-ai\\/releases\\/tag\\/1.0.0\",\"published_at\":\"2026-10-10T23:04:00Z\",\"has_update\":false}','updates','text',1,'2026-10-13 11:06:51','2026-10-13 11:06:51'),(42,'global_colors','[{\"id\":\"primary\",\"name\":\"Primary\",\"color\":\"#7c3aed\"},{\"id\":\"secondary\",\"name\":\"Secondary\",\"color\":\"#ec4899\"},{\"id\":\"text\",\"name\":\"Text\",\"color\":\"#111827\"},{\"id\":\"accent\",\"name\":\"Accent\",\"color\":\"#f59e0b\"},{\"id\":\"light\",\"name\":\"Light\",\"color\":\"#f3f4f6\"},{\"id\":\"dark\",\"name\":\"Dark\",\"color\":\"#1f2937\"}]','design','json',1,'2026-10-14 14:07:57','2026-10-14 14:07:57'),(43,'global_fonts','[{\"id\":\"primary\",\"name\":\"Primary\",\"family\":\"Inter, sans-serif\",\"weight\":\"700\"},{\"id\":\"secondary\",\"name\":\"Secondary\",\"family\":\"Inter, sans-serif\",\"weight\":\"500\"},{\"id\":\"text\",\"name\":\"Body Text\",\"family\":\"Inter, sans-serif\",\"weight\":\"400\"},{\"id\":\"accent\",\"name\":\"Accent\",\"family\":\"Inter, sans-serif\",\"weight\":\"600\"}]','design','json',1,'2026-10-14 14:07:57','2026-10-14 14:07:57'),(44,'global_spacing','[{\"id\":\"xs\",\"name\":\"Extra Small\",\"value\":\"4\"},{\"id\":\"sm\",\"name\":\"Small\",\"value\":\"8\"},{\"id\":\"md\",\"name\":\"Medium\",\"value\":\"16\"},{\"id\":\"lg\",\"name\":\"Large\",\"value\":\"24\"},{\"id\":\"xl\",\"name\":\"Extra Large\",\"value\":\"48\"}]','design','json',1,'2026-10-14 14:07:57','2026-10-14 14:07:57'),(45,'rj_breakpoints','{\"mobile\":{\"label\":\"Mobile\",\"max\":560,\"icon\":\"mobile\"},\"tablet\":{\"label\":\"Tablet\",\"max\":860,\"icon\":\"tablet\"},\"desktop\":{\"label\":\"Desktop\",\"min\":861,\"icon\":\"desktop\"}}','design','json',1,'2026-10-14 14:07:57','2026-10-14 14:07:57'),(46,'active_theme','rj-default','general','text',1,'2026-10-16 18:26:35','2026-10-24 19:59:57'),(47,'custom_structure',NULL,'permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(48,'category_base','category','permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(49,'tag_base','tag','permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(50,'author_base','author','permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(51,'post_slug_case','lower','permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(52,'redirect_old_urls','1','permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(53,'trailing_slash','yes','permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(54,'force_lowercase','1','permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(55,'strip_stop_words','0','permalinks','text',1,'2026-10-16 20:34:51','2026-10-16 20:34:51'),(56,'api_keys','[]','general','text',1,'2026-10-19 21:53:38','2026-10-19 21:58:18'),(57,'debug_mode','0','advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:39'),(58,'maintenance_message',NULL,'advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(59,'maintenance_retry','3600','advanced','number',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(60,'log_level','error','advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(61,'log_retention_days','14','advanced','number',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(62,'custom_head_code',NULL,'advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(63,'custom_footer_code',NULL,'advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(64,'custom_css',NULL,'advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(65,'maintenance_mode','0','advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:54:12'),(66,'error_reporting','0','advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(67,'track_visitors','0','advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(68,'allow_file_editing','0','advanced','text',1,'2026-10-21 18:21:26','2026-10-21 18:21:26'),(69,'commerce_store_name','RJ CMS','general','text',1,'2026-10-23 00:16:45','2026-10-23 00:16:45'),(70,'commerce_currency','USD','general','text',1,'2026-10-23 00:16:45','2026-10-23 00:16:45'),(71,'commerce_weight_unit','kg','general','text',1,'2026-10-23 00:16:45','2026-10-23 00:16:45'),(72,'commerce_stripe_enabled','0','general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(73,'commerce_stripe_pk',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(74,'commerce_stripe_sk',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(75,'commerce_paypal_enabled','0','general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(76,'commerce_paypal_client_id',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(77,'commerce_paypal_secret',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(78,'commerce_checkout_enabled','0','general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(79,'commerce_checkout_pk',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(80,'commerce_checkout_sk',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(81,'commerce_razorpay_enabled','0','general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(82,'commerce_razorpay_key',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(83,'commerce_razorpay_secret',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(84,'commerce_crypto_enabled','0','general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(85,'commerce_crypto_provider','binance','general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(86,'commerce_crypto_api_key',NULL,'general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(87,'commerce_cod_enabled','1','general','text',1,'2026-10-23 01:20:05','2026-10-23 01:20:05'),(88,'commerce_page_shop',NULL,'general','text',1,'2026-10-23 01:59:31','2026-10-23 01:59:31'),(89,'commerce_page_cart',NULL,'general','text',1,'2026-10-23 01:59:31','2026-10-23 01:59:31'),(90,'commerce_page_checkout',NULL,'general','text',1,'2026-10-23 01:59:31','2026-10-23 01:59:31'),(91,'lang_flag_az','az.svg','language','text',1,'2026-10-27 01:11:20','2026-10-27 01:11:20');
/*!40000 ALTER TABLE `rj_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_order_items`
--

DROP TABLE IF EXISTS `rj_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `variation_id` bigint(20) unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `variation_name` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_order_items_order_id_foreign` (`order_id`),
  KEY `rj_order_items_product_id_foreign` (`product_id`),
  KEY `rj_order_items_variation_id_foreign` (`variation_id`),
  CONSTRAINT `rj_order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `rj_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `rj_products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rj_order_items_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `rj_product_variations` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_order_items`
--

LOCK TABLES `rj_order_items` WRITE;
/*!40000 ALTER TABLE `rj_order_items` DISABLE KEYS */;
INSERT INTO `rj_order_items` VALUES (1,1,1,NULL,'test en',NULL,19.00,1,19.00,NULL,'2026-10-23 01:20:15','2026-10-23 01:20:15'),(2,2,1,NULL,'test en',NULL,19.00,7,133.00,NULL,'2026-10-23 02:42:05','2026-10-23 02:42:05');
/*!40000 ALTER TABLE `rj_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_orders`
--

DROP TABLE IF EXISTS `rj_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `payment_method` varchar(255) DEFAULT NULL,
  `shipping_method` varchar(255) DEFAULT NULL,
  `billing_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`billing_address`)),
  `shipping_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`shipping_address`)),
  `customer_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_orders_user_id_foreign` (`user_id`),
  CONSTRAINT `rj_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_orders`
--

LOCK TABLES `rj_orders` WRITE;
/*!40000 ALTER TABLE `rj_orders` DISABLE KEYS */;
INSERT INTO `rj_orders` VALUES (1,1,'processing',19.00,0.00,0.00,0.00,19.00,'USD','cod',NULL,'{\"first_name\":\"Admin\",\"last_name\":\"Javadov\",\"email\":\"admin@admin.com\",\"phone\":\"+994506636031\",\"address_line_1\":\"Baku sahvat mehdiyev 18a\",\"city\":\"Baku\",\"country\":\"Azerbaycan\",\"postal_code\":\"1140\"}','{\"first_name\":\"Admin\",\"last_name\":\"Javadov\",\"address_line_1\":\"Baku sahvat mehdiyev 18a\",\"city\":\"Baku\",\"country\":\"Azerbaycan\",\"postal_code\":\"1140\"}',NULL,'2026-10-23 01:20:15','2026-10-23 01:20:15'),(2,1,'processing',133.00,0.00,0.00,0.00,133.00,'USD','cod',NULL,'{\"first_name\":\"Admin\",\"last_name\":\"Javadov\",\"email\":\"admin@admin.com\",\"phone\":\"+994506636031\",\"address_line_1\":\"Baku sahvat mehdiyev 18a\",\"city\":\"Baku\",\"country\":\"Azerbaycan\",\"postal_code\":\"1140\"}','{\"first_name\":\"Admin\",\"last_name\":\"Javadov\",\"address_line_1\":\"Baku sahvat mehdiyev 18a\",\"city\":\"Baku\",\"country\":\"Azerbaycan\",\"postal_code\":\"1140\"}',NULL,'2026-10-23 02:42:05','2026-10-23 02:42:05');
/*!40000 ALTER TABLE `rj_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_permissions`
--

DROP TABLE IF EXISTS `rj_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `group` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_permissions_slug_unique` (`slug`),
  KEY `rj_permissions_slug_index` (`slug`),
  KEY `rj_permissions_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_permissions`
--

LOCK TABLES `rj_permissions` WRITE;
/*!40000 ALTER TABLE `rj_permissions` DISABLE KEYS */;
INSERT INTO `rj_permissions` VALUES (1,'Access Dashboard','dashboard.view','general',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(2,'Manage Settings','settings.manage','settings',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(3,'Manage Users','users.manage','users',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(4,'Manage Roles','roles.manage','users',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(5,'View Posts','posts.view','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(6,'Create Posts','posts.create','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(7,'Edit Posts','posts.edit','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(8,'Delete Posts','posts.delete','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(9,'Publish Posts','posts.publish','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(10,'View Pages','pages.view','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(11,'Create Pages','pages.create','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(12,'Edit Pages','pages.edit','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(13,'Delete Pages','pages.delete','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(14,'View Categories','categories.view','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(15,'Manage Categories','categories.manage','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(16,'View Tags','tags.view','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(17,'Manage Tags','tags.manage','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(18,'View Comments','comments.view','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(19,'Moderate Comments','comments.moderate','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(20,'Delete Comments','comments.delete','content',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(21,'View Media','media.view','media',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(22,'Upload Media','media.upload','media',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(23,'Delete Media','media.delete','media',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(24,'Use Builder','builder.use','design',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(25,'Manage Templates','templates.manage','design',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(26,'Manage Menus','menus.manage','design',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(27,'Manage Themes','themes.manage','design',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(28,'Manage Fonts','fonts.manage','design',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(29,'Manage Plugins','plugins.manage','plugins',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(30,'Manage Updates','updates.manage','tools',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(31,'Manage Backups','backups.manage','tools',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(32,'View Logs','logs.view','tools',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29');
/*!40000 ALTER TABLE `rj_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_plugins`
--

DROP TABLE IF EXISTS `rj_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_plugins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL DEFAULT '1.0.0',
  `description` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `author_url` varchar(255) DEFAULT NULL,
  `plugin_url` varchar(255) DEFAULT NULL,
  `folder` varchar(255) NOT NULL,
  `main_file` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'inactive',
  `requires` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requires`)),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `error_message` text DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `deactivated_at` timestamp NULL DEFAULT NULL,
  `activated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_plugins_slug_unique` (`slug`),
  KEY `rj_plugins_status_index` (`status`),
  KEY `rj_plugins_slug_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_plugins`
--

LOCK TABLES `rj_plugins` WRITE;
/*!40000 ALTER TABLE `rj_plugins` DISABLE KEYS */;
INSERT INTO `rj_plugins` VALUES (1,'Form Builder','form-builder','1.1.1','Create, manage, and embed forms. Includes RJBuilder widget and admin panel.','RJ CMS','https://github.com/mr-ruhid','https://github.com/mr-ruhid/rj-plugin-form-builder','form-builder','src/Plugin.php','active','{\"rj_cms\":\">=1.0.0\",\"php\":\">=8.2\"}','{\"name\":\"Form Builder\",\"slug\":\"form-builder\",\"version\":\"1.1.1\",\"author\":\"RJ CMS\",\"author_url\":\"https:\\/\\/github.com\\/mr-ruhid\",\"plugin_url\":\"https:\\/\\/github.com\\/mr-ruhid\\/rj-plugin-form-builder\",\"description\":\"Create, manage, and embed forms. Includes RJBuilder widget and admin panel.\",\"license\":\"MIT\",\"main\":\"src\\/Plugin.php\",\"namespace\":\"RjPlugins\\\\FormBuilder\",\"provider\":\"RjPlugins\\\\FormBuilder\\\\FormBuilderServiceProvider\",\"requires\":{\"rj_cms\":\">=1.0.0\",\"php\":\">=8.2\"},\"provides\":{\"admin_menu\":[{\"id\":\"forms\",\"title\":\"Forms\",\"icon\":\"clipboard-list\",\"route\":\"admin.plugin.forms.index\",\"position\":30}],\"widgets\":[\"RjPlugins\\\\FormBuilder\\\\Widgets\\\\FormWidget\"],\"routes\":{\"admin\":\"routes\\/admin.php\",\"frontend\":\"routes\\/frontend.php\"},\"views\":\"views\",\"migrations\":\"src\\/Migrations\",\"assets\":\"assets\"},\"update_url\":\"https:\\/\\/raw.githubusercontent.com\\/mr-ruhid\\/rj-plugin-form-builder\\/main\\/plugin.json\"}',NULL,NULL,'2026-10-22 18:13:28',NULL,1,'2026-10-16 21:07:36','2026-10-22 18:13:28'),(10,'RJ Commerce','rj-commerce','1.0.0','A complete e-commerce solution for RJ CMS. Manage products, orders, and storefronts.','RJ Nexus','https://github.com/rj-nexus','https://github.com/rj-nexus/rj-commerce','plugin_6adb0e6920cb8','src/Plugin.php','active','{\"rj_cms\":\">=1.0.0\",\"php\":\">=8.2\"}','{\"name\":\"RJ Commerce\",\"slug\":\"rj-commerce\",\"version\":\"1.0.0\",\"author\":\"RJ Nexus\",\"author_url\":\"https:\\/\\/github.com\\/rj-nexus\",\"plugin_url\":\"https:\\/\\/github.com\\/rj-nexus\\/rj-commerce\",\"description\":\"A complete e-commerce solution for RJ CMS. Manage products, orders, and storefronts.\",\"license\":\"MIT\",\"main\":\"src\\/Plugin.php\",\"namespace\":\"RjCommerce\",\"provider\":\"RjCommerce\\\\CommerceServiceProvider\",\"requires\":{\"rj_cms\":\">=1.0.0\",\"php\":\">=8.2\"},\"provides\":{\"admin_menu\":[{\"id\":\"commerce\",\"title\":\"Commerce\",\"icon\":\"shopping-cart\",\"route\":\"admin.commerce.products.index\",\"position\":20},{\"id\":\"commerce-products\",\"parent\":\"commerce\",\"title\":\"Products\",\"route\":\"admin.commerce.products.index\",\"position\":21},{\"id\":\"commerce-orders\",\"parent\":\"commerce\",\"title\":\"Orders\",\"route\":\"admin.commerce.orders.index\",\"position\":22},{\"id\":\"commerce-coupons\",\"parent\":\"commerce\",\"title\":\"Coupons\",\"route\":\"admin.commerce.coupons.index\",\"position\":23},{\"id\":\"commerce-categories\",\"parent\":\"commerce\",\"title\":\"Categories\",\"route\":\"admin.commerce.categories.index\",\"position\":24},{\"id\":\"commerce-brands\",\"parent\":\"commerce\",\"title\":\"Brands\",\"route\":\"admin.commerce.brands.index\",\"position\":25},{\"id\":\"commerce-attributes\",\"parent\":\"commerce\",\"title\":\"Attributes\",\"route\":\"admin.commerce.attributes.index\",\"position\":26},{\"id\":\"commerce-settings\",\"parent\":\"commerce\",\"title\":\"Settings\",\"route\":\"admin.commerce.settings.index\",\"position\":27}],\"routes\":{\"admin\":\"routes\\/admin.php\",\"frontend\":\"routes\\/frontend.php\",\"api\":\"routes\\/api.php\"},\"views\":\"views\",\"migrations\":\"src\\/Migrations\",\"widgets\":[\"RjCommerce\\\\Widgets\\\\ProductGridWidget\",\"RjCommerce\\\\Widgets\\\\CategoriesWidget\",\"RjCommerce\\\\Widgets\\\\SingleProductWidget\",\"RjCommerce\\\\Widgets\\\\CartWidget\"]}}',NULL,NULL,'2026-10-23 17:02:07',NULL,1,'2026-10-23 03:54:15','2026-10-23 17:02:07');
/*!40000 ALTER TABLE `rj_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_post_category`
--

DROP TABLE IF EXISTS `rj_post_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_post_category` (
  `post_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`),
  KEY `rj_post_category_category_id_foreign` (`category_id`),
  CONSTRAINT `rj_post_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `rj_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_post_category_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `rj_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_post_category`
--

LOCK TABLES `rj_post_category` WRITE;
/*!40000 ALTER TABLE `rj_post_category` DISABLE KEYS */;
INSERT INTO `rj_post_category` VALUES (1,4);
/*!40000 ALTER TABLE `rj_post_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_post_tag`
--

DROP TABLE IF EXISTS `rj_post_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_post_tag` (
  `post_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `rj_post_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `rj_post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `rj_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `rj_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_post_tag`
--

LOCK TABLES `rj_post_tag` WRITE;
/*!40000 ALTER TABLE `rj_post_tag` DISABLE KEYS */;
INSERT INTO `rj_post_tag` VALUES (7,1);
/*!40000 ALTER TABLE `rj_post_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_post_term`
--

DROP TABLE IF EXISTS `rj_post_term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_post_term` (
  `post_id` bigint(20) unsigned NOT NULL,
  `term_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`term_id`),
  KEY `rj_post_term_term_id_foreign` (`term_id`),
  CONSTRAINT `rj_post_term_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `rj_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_post_term_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `rj_terms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_post_term`
--

LOCK TABLES `rj_post_term` WRITE;
/*!40000 ALTER TABLE `rj_post_term` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_post_term` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_post_translations`
--

DROP TABLE IF EXISTS `rj_post_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_post_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_image` varchar(255) DEFAULT NULL,
  `focus_keyword` varchar(255) DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `twitter_card` varchar(255) DEFAULT NULL,
  `twitter_title` varchar(255) DEFAULT NULL,
  `twitter_description` text DEFAULT NULL,
  `twitter_image` varchar(255) DEFAULT NULL,
  `robots` varchar(255) DEFAULT NULL,
  `schema_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_post_translations_post_id_locale_unique` (`post_id`,`locale`),
  CONSTRAINT `rj_post_translations_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `rj_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_post_translations`
--

LOCK TABLES `rj_post_translations` WRITE;
/*!40000 ALTER TABLE `rj_post_translations` DISABLE KEYS */;
INSERT INTO `rj_post_translations` VALUES (1,2,'az','Home','Welcome to our website.','Welcome to our website.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-10-27 01:10:11','2026-10-27 01:10:11');
/*!40000 ALTER TABLE `rj_post_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_post_types`
--

DROP TABLE IF EXISTS `rj_post_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_post_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `singular_name` varchar(255) NOT NULL,
  `plural_name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `menu_position` varchar(255) NOT NULL DEFAULT '25',
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `has_archive` tinyint(1) NOT NULL DEFAULT 1,
  `is_hierarchical` tinyint(1) NOT NULL DEFAULT 0,
  `supports_comments` tinyint(1) NOT NULL DEFAULT 1,
  `supports_builder` tinyint(1) NOT NULL DEFAULT 1,
  `supports_thumbnail` tinyint(1) NOT NULL DEFAULT 1,
  `supports` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`supports`)),
  `labels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`labels`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_post_types_slug_unique` (`slug`),
  KEY `rj_post_types_slug_index` (`slug`),
  KEY `rj_post_types_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_post_types`
--

LOCK TABLES `rj_post_types` WRITE;
/*!40000 ALTER TABLE `rj_post_types` DISABLE KEYS */;
INSERT INTO `rj_post_types` VALUES (1,'Posts','post','Post','Posts','file','5',1,1,0,1,1,1,'[\"title\",\"editor\",\"excerpt\",\"thumbnail\",\"categories\",\"tags\",\"comments\",\"builder\",\"revisions\"]',NULL,'{\"rewrite_slug\":\"blog\",\"archive_slug\":\"blog\",\"is_core\":true}','active',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(2,'Pages','page','Page','Pages','layers','6',1,0,1,0,1,1,'[\"title\",\"editor\",\"thumbnail\",\"builder\",\"revisions\",\"page_attributes\"]',NULL,'{\"rewrite_slug\":\"\",\"is_core\":true}','active',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29');
/*!40000 ALTER TABLE `rj_post_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_posts`
--

DROP TABLE IF EXISTS `rj_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `blocks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`blocks`)),
  `edit_mode` varchar(20) NOT NULL DEFAULT 'classic',
  `theme_template` varchar(100) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'post',
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `is_sticky` tinyint(1) NOT NULL DEFAULT 0,
  `allow_comments` tinyint(1) NOT NULL DEFAULT 1,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `template_id` bigint(20) unsigned DEFAULT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_posts_slug_unique` (`slug`),
  KEY `rj_posts_type_index` (`type`),
  KEY `rj_posts_status_index` (`status`),
  KEY `rj_posts_published_at_index` (`published_at`),
  KEY `rj_posts_author_id_index` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_posts`
--

LOCK TABLES `rj_posts` WRITE;
/*!40000 ALTER TABLE `rj_posts` DISABLE KEYS */;
INSERT INTO `rj_posts` VALUES (1,'test1','test1','','{\"blocks\":[{\"id\":\"blk_trjah6m7y\",\"type\":\"container\",\"settings\":{\"width\":\"boxed\",\"columns\":\"1\",\"column_widths\":null,\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"stretch\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"padding\":\"md\",\"align\":\"stretch\"},\"children\":[{\"id\":\"blk_ja1owaz27\",\"type\":\"heading\",\"settings\":{\"text\":\"test\",\"level\":\"h1\",\"align\":\"center\",\"color\":\"#111827\",\"font_size\":null,\"font_weight\":\"700\",\"line_height\":null,\"letter_spacing\":null,\"text_transform\":\"none\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]},{\"id\":\"blk_qxwij7prq\",\"type\":\"container\",\"settings\":{\"width\":\"boxed\",\"columns\":\"2\",\"column_widths\":null,\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"stretch\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"padding\":\"md\",\"align\":\"stretch\"},\"children\":[{\"id\":\"blk_9i0ubri4n\",\"type\":\"logo\",\"settings\":{\"url\":\"http:\\/\\/127.0.0.1:8000\\/uploads\\/2026\\/10\\/whatsapp-image-2026-09-18-at-32858-pm-7tv6J6ua.jpeg\",\"alt\":null,\"link\":\"\\/\",\"target\":\"_self\",\"width\":\"full\",\"custom_width\":null,\"height\":\"auto\",\"align\":\"left\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]},{\"id\":\"blk_bgjo882g7\",\"type\":\"text\",\"settings\":{\"text\":\"Write something here.\\nWrite something here.\\nWrite something here.\\nWrite something here.\\nWrite something here.\\nWrite something here.\\nWrite something here.\\nWrite something here.\\nWrite something here.\\nWrite something here.\",\"size\":\"base\",\"align\":\"left\",\"color\":\"#374151\",\"font_size\":null,\"font_weight\":\"400\",\"line_height\":null,\"letter_spacing\":null,\"text_transform\":\"none\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]}]}','builder',NULL,'test1','http://127.0.0.1:8000/uploads/2026/10/gemini-generated-image-1kg64w1kg64w1kg6-wXr2zYwk.jpg','post','trash',0,1,14,1,NULL,'{\"custom_css\":null,\"custom_js\":null}','[]','2026-10-16 16:30:00','2026-10-16 16:30:42','2026-10-16 20:09:51'),(2,'Home','home','Welcome to our website.','{\"blocks\":[{\"id\":\"blk_lyq29ghq6\",\"type\":\"music-player\",\"settings\":{\"title\":\"Now Playing\",\"source\":\"deezer\",\"jamendo_client_id\":null,\"audius_playlist_id\":\"rihanna\",\"deezer_playlist_id\":\"4503899902\",\"visualizer\":\"bars\",\"accent\":\"#8b5cf6\",\"accent2\":\"#ec4899\",\"height\":220,\"radius\":\"xl\",\"show_playlist\":true,\"autoplay\":false,\"padding_y\":60,\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]}','builder',NULL,'Welcome to our website.',NULL,'page','published',0,0,0,1,NULL,'{\"custom_css\":null,\"custom_js\":null}','{\"is_front\":true}','2026-10-11 20:08:00','2026-10-16 20:08:29','2026-10-27 08:51:55'),(3,'About','about','<h2>About Us</h2><p>This is the About page. Edit this content from the admin panel.</p><p>You can also switch to RJBuilder mode to design this page visually.</p>',NULL,'classic',NULL,'Learn more about us.',NULL,'page','published',0,0,4,1,NULL,'[]','[]','2026-10-12 20:08:29','2026-10-16 20:08:29','2026-10-24 19:22:02'),(4,'Contact','contact','','{\"blocks\":[{\"id\":\"blk_945hb351k\",\"type\":\"container\",\"settings\":{\"width\":\"boxed\",\"columns\":\"1\",\"column_widths\":null,\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"stretch\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"padding\":\"md\",\"align\":\"stretch\"},\"children\":[{\"id\":\"blk_n8o430o39\",\"type\":\"form\",\"settings\":{\"form_id\":\"1\",\"layout\":\"stack\",\"design_preset\":\"default\",\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]}]}','builder','contact','Get in touch with us.',NULL,'page','published',0,0,8,1,NULL,'[]','[]','2026-10-13 20:08:29','2026-10-16 20:08:29','2026-10-24 19:22:16'),(5,'Privacy Policy','privacy-policy','<h2>Privacy Policy</h2><p>This is a placeholder for your privacy policy. Replace it with your own content that describes how you collect, use, and protect personal data.</p><h3>Data Collection</h3><p>Explain what data you collect from visitors.</p><h3>Cookies</h3><p>Explain your cookie usage.</p><h3>Third Parties</h3><p>Explain if you share data with third parties.</p>',NULL,'classic',NULL,'Your privacy matters to us.',NULL,'page','draft',0,0,1,1,NULL,'{\"custom_css\":null,\"custom_js\":null}','[]','2026-10-16 20:28:00','2026-10-16 20:08:29','2026-10-16 20:28:51'),(6,'Sample Page','sample-page','<h2>Sample Page</h2><p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes).</p><p>Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p><blockquote>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi├▒a coladas.</blockquote>',NULL,'classic',NULL,'A sample page to get started.',NULL,'page','published',0,0,1,1,NULL,'[]','[]','2026-10-15 20:08:29','2026-10-16 20:08:29','2026-10-16 20:28:56'),(7,'Hello World','hello-world','<p>Welcome to RJ CMS! This is your first blog post. Edit or delete it, then start writing.</p><h2>What is RJ CMS?</h2><p>RJ CMS is a modern self-hosted CMS built on Laravel 12, featuring RJBuilder ΓÇö a drag-and-drop visual page builder.</p><h2>Getting Started</h2><p>Visit the admin panel to create new posts, pages, menus, and more. You can switch any post or page to RJBuilder mode to design it visually.</p><p>Happy building!</p>',NULL,'classic',NULL,'Welcome to RJ CMS. This is your first blog post.',NULL,'post','published',1,1,1,1,NULL,'{\"custom_css\":null,\"custom_js\":null}','[]','2026-10-14 20:08:00','2026-10-16 20:08:29','2026-10-19 16:17:53'),(8,'Getting Started with RJBuilder','getting-started-rjbuilder','<p>RJBuilder is the visual page builder included with RJ CMS. It provides a modern drag-and-drop interface for designing pages, headers, footers, and popups.</p><h2>Key Features</h2><ul><li>Drag-and-drop blocks</li><li>Responsive breakpoints (Desktop / Tablet / Mobile)</li><li>Custom CSS and animations</li><li>Dynamic tags for content</li><li>AI assistant integration</li></ul><h2>How to Use</h2><p>Open any post or page in edit mode, select \"RJBuilder\" as the edit mode, and click \"Open Builder\". You can then start adding blocks and customizing styles.</p>',NULL,'classic',NULL,'Learn how to design beautiful pages with RJBuilder.',NULL,'post','published',0,1,0,1,NULL,'[]','[]','2026-10-15 20:08:29','2026-10-16 20:08:29','2026-10-16 20:08:29'),(9,'Test','test','','{\"blocks\":[{\"id\":\"blk_gjh7dp56s\",\"type\":\"container\",\"settings\":{\"width\":\"boxed\",\"columns\":\"1\",\"column_widths\":null,\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"stretch\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"padding\":\"md\",\"align\":\"stretch\"},\"children\":[{\"id\":\"blk_0u25892ye\",\"type\":\"heading\",\"settings\":{\"text\":\"Test\",\"level\":\"h2\",\"align\":\"left\",\"color\":\"#111827\",\"font_size\":null,\"font_weight\":\"700\",\"line_height\":null,\"letter_spacing\":null,\"text_transform\":\"none\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]}]}','builder',NULL,'Test',NULL,'page','published',0,1,2,1,NULL,'{\"custom_css\":null,\"custom_js\":null}','[]','2026-10-16 20:29:00','2026-10-16 20:29:08','2026-10-16 20:32:48');
/*!40000 ALTER TABLE `rj_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_attribute_translations`
--

DROP TABLE IF EXISTS `rj_product_attribute_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_attribute_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_attribute_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_attr_trans_unique` (`product_attribute_id`,`locale`),
  CONSTRAINT `fk_pat_attr` FOREIGN KEY (`product_attribute_id`) REFERENCES `rj_product_attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_attribute_translations`
--

LOCK TABLES `rj_product_attribute_translations` WRITE;
/*!40000 ALTER TABLE `rj_product_attribute_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_attribute_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_attribute_value_translations`
--

DROP TABLE IF EXISTS `rj_product_attribute_value_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_attribute_value_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_attribute_value_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_attr_val_trans_unique` (`product_attribute_value_id`,`locale`),
  CONSTRAINT `fk_pavt_val` FOREIGN KEY (`product_attribute_value_id`) REFERENCES `rj_product_attribute_values` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_attribute_value_translations`
--

LOCK TABLES `rj_product_attribute_value_translations` WRITE;
/*!40000 ALTER TABLE `rj_product_attribute_value_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_attribute_value_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_attribute_values`
--

DROP TABLE IF EXISTS `rj_product_attribute_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_attribute_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_attribute_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color_code` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_attr_val_unique` (`product_attribute_id`,`slug`),
  CONSTRAINT `fk_pav_attr` FOREIGN KEY (`product_attribute_id`) REFERENCES `rj_product_attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_attribute_values`
--

LOCK TABLES `rj_product_attribute_values` WRITE;
/*!40000 ALTER TABLE `rj_product_attribute_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_attribute_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_attributes`
--

DROP TABLE IF EXISTS `rj_product_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_attributes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'select',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_product_attributes_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_attributes`
--

LOCK TABLES `rj_product_attributes` WRITE;
/*!40000 ALTER TABLE `rj_product_attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_brand_translations`
--

DROP TABLE IF EXISTS `rj_product_brand_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_brand_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_brand_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_product_brand_translations_product_brand_id_locale_unique` (`product_brand_id`,`locale`),
  CONSTRAINT `rj_product_brand_translations_product_brand_id_foreign` FOREIGN KEY (`product_brand_id`) REFERENCES `rj_product_brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_brand_translations`
--

LOCK TABLES `rj_product_brand_translations` WRITE;
/*!40000 ALTER TABLE `rj_product_brand_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_brand_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_brands`
--

DROP TABLE IF EXISTS `rj_product_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_product_brands_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_brands`
--

LOCK TABLES `rj_product_brands` WRITE;
/*!40000 ALTER TABLE `rj_product_brands` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_categories`
--

DROP TABLE IF EXISTS `rj_product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_product_categories_slug_unique` (`slug`),
  KEY `rj_product_categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `rj_product_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `rj_product_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_categories`
--

LOCK TABLES `rj_product_categories` WRITE;
/*!40000 ALTER TABLE `rj_product_categories` DISABLE KEYS */;
INSERT INTO `rj_product_categories` VALUES (1,'test-en','categories/0lSx7pU2yYXPe14rR6K9czOIkoovip4ewHijBRax.png',NULL,0,1,'2026-10-23 17:14:44','2026-10-23 17:14:44');
/*!40000 ALTER TABLE `rj_product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_category_translations`
--

DROP TABLE IF EXISTS `rj_product_category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_category_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_category_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_cat_trans_unique` (`product_category_id`,`locale`),
  CONSTRAINT `rj_product_category_translations_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `rj_product_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_category_translations`
--

LOCK TABLES `rj_product_category_translations` WRITE;
/*!40000 ALTER TABLE `rj_product_category_translations` DISABLE KEYS */;
INSERT INTO `rj_product_category_translations` VALUES (1,1,'az','test az',NULL,NULL,NULL,'2026-10-23 17:14:44','2026-10-23 17:14:44'),(2,1,'de','test de',NULL,NULL,NULL,'2026-10-23 17:14:44','2026-10-23 17:14:44'),(3,1,'en','test en','test en','test en','test en','2026-10-23 17:14:44','2026-10-23 17:14:44'),(4,1,'es','test es',NULL,NULL,NULL,'2026-10-23 17:14:44','2026-10-23 17:14:44'),(5,1,'fr','test fr',NULL,NULL,NULL,'2026-10-23 17:14:44','2026-10-23 17:14:44'),(6,1,'pt','test pt',NULL,NULL,NULL,'2026-10-23 17:14:44','2026-10-23 17:14:44');
/*!40000 ALTER TABLE `rj_product_category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_reviews`
--

DROP TABLE IF EXISTS `rj_product_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_product_reviews_product_id_foreign` (`product_id`),
  KEY `rj_product_reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `rj_product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `rj_products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_reviews`
--

LOCK TABLES `rj_product_reviews` WRITE;
/*!40000 ALTER TABLE `rj_product_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_tag_pivot`
--

DROP TABLE IF EXISTS `rj_product_tag_pivot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_tag_pivot` (
  `product_id` bigint(20) unsigned NOT NULL,
  `product_tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`product_tag_id`),
  KEY `rj_product_tag_pivot_product_tag_id_foreign` (`product_tag_id`),
  CONSTRAINT `rj_product_tag_pivot_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `rj_products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_product_tag_pivot_product_tag_id_foreign` FOREIGN KEY (`product_tag_id`) REFERENCES `rj_product_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_tag_pivot`
--

LOCK TABLES `rj_product_tag_pivot` WRITE;
/*!40000 ALTER TABLE `rj_product_tag_pivot` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_tag_pivot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_tag_translations`
--

DROP TABLE IF EXISTS `rj_product_tag_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_tag_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_tag_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_product_tag_translations_product_tag_id_locale_unique` (`product_tag_id`,`locale`),
  CONSTRAINT `rj_product_tag_translations_product_tag_id_foreign` FOREIGN KEY (`product_tag_id`) REFERENCES `rj_product_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_tag_translations`
--

LOCK TABLES `rj_product_tag_translations` WRITE;
/*!40000 ALTER TABLE `rj_product_tag_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_tag_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_tags`
--

DROP TABLE IF EXISTS `rj_product_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_product_tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_tags`
--

LOCK TABLES `rj_product_tags` WRITE;
/*!40000 ALTER TABLE `rj_product_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_translations`
--

DROP TABLE IF EXISTS `rj_product_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_product_translations_product_id_locale_unique` (`product_id`,`locale`),
  CONSTRAINT `rj_product_translations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `rj_products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_translations`
--

LOCK TABLES `rj_product_translations` WRITE;
/*!40000 ALTER TABLE `rj_product_translations` DISABLE KEYS */;
INSERT INTO `rj_product_translations` VALUES (1,1,'az','test az',NULL,NULL,NULL,NULL,'2026-10-23 00:20:40','2026-10-23 00:20:40'),(2,1,'de','test de',NULL,NULL,NULL,NULL,'2026-10-23 00:20:40','2026-10-23 00:20:40'),(3,1,'en','test en','test','test','test','test','2026-10-23 00:20:40','2026-10-23 00:20:40'),(4,1,'es','test es',NULL,NULL,NULL,NULL,'2026-10-23 00:20:40','2026-10-23 00:20:40'),(5,1,'fr','test fr',NULL,NULL,NULL,NULL,'2026-10-23 00:20:40','2026-10-23 00:20:40'),(6,1,'pt','test pt',NULL,NULL,NULL,NULL,'2026-10-23 00:20:40','2026-10-23 00:20:40');
/*!40000 ALTER TABLE `rj_product_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_product_variations`
--

DROP TABLE IF EXISTS `rj_product_variations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_product_variations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `compare_price` decimal(15,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`attributes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_product_variations_product_id_foreign` (`product_id`),
  CONSTRAINT `rj_product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `rj_products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_product_variations`
--

LOCK TABLES `rj_product_variations` WRITE;
/*!40000 ALTER TABLE `rj_product_variations` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_product_variations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_products`
--

DROP TABLE IF EXISTS `rj_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'physical',
  `sku` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `compare_price` decimal(15,2) DEFAULT NULL,
  `manage_stock` tinyint(1) NOT NULL DEFAULT 1,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `stock_status` varchar(255) NOT NULL DEFAULT 'in_stock',
  `weight` decimal(10,2) DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `downloadable_files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`downloadable_files`)),
  `download_limit` int(11) DEFAULT NULL,
  `download_expiry` int(11) DEFAULT NULL,
  `external_url` varchar(255) DEFAULT NULL,
  `license_keys_pool` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`license_keys_pool`)),
  `auto_generate_license` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_products_slug_unique` (`slug`),
  UNIQUE KEY `rj_products_sku_unique` (`sku`),
  KEY `rj_products_category_id_foreign` (`category_id`),
  KEY `rj_products_brand_id_foreign` (`brand_id`),
  CONSTRAINT `rj_products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `rj_product_brands` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rj_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `rj_product_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_products`
--

LOCK TABLES `rj_products` WRITE;
/*!40000 ALTER TABLE `rj_products` DISABLE KEYS */;
INSERT INTO `rj_products` VALUES (1,'test-en','physical',NULL,NULL,19.00,NULL,1,-8,'in_stock',NULL,NULL,NULL,NULL,'[]',NULL,NULL,NULL,'[]',0,NULL,NULL,'products/XgF7Tz45w1koSuIgEKM6ui9zGw0suT43SlzCL8u1.png','[\"products\\/gallery\\/jXopAqSi4xV3EwqhTEUsH5ZbNEfrc2uESmrQTUcX.png\",\"products\\/gallery\\/O7EPSexbQAeo9sgPSTxYoVEhwH0w2oHQ8gJGoJ6r.png\",\"products\\/gallery\\/ygQCy24yTEFMFsYlb22OoLRc75H1nFGZqKcbZc2J.png\",\"products\\/gallery\\/6SdMOxhuJu42p6rxGYSrhjx9vJOW9o1IstDwIRQB.png\"]',0,'published','2026-10-23 00:20:40','2026-10-23 02:42:05');
/*!40000 ALTER TABLE `rj_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_revisions`
--

DROP TABLE IF EXISTS `rj_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_revisions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `revisionable_type` varchar(255) NOT NULL,
  `revisionable_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`content`)),
  `title` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_revisions_revisionable_type_revisionable_id_index` (`revisionable_type`,`revisionable_id`),
  KEY `rj_revisions_user_id_index` (`user_id`),
  KEY `rj_revisions_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_revisions`
--

LOCK TABLES `rj_revisions` WRITE;
/*!40000 ALTER TABLE `rj_revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_role_permission`
--

DROP TABLE IF EXISTS `rj_role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_role_permission` (
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `rj_role_permission_permission_id_foreign` (`permission_id`),
  CONSTRAINT `rj_role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `rj_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `rj_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_role_permission`
--

LOCK TABLES `rj_role_permission` WRITE;
/*!40000 ALTER TABLE `rj_role_permission` DISABLE KEYS */;
INSERT INTO `rj_role_permission` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(2,1),(2,5),(2,6),(2,7),(2,8),(2,9),(2,10),(2,11),(2,12),(2,13),(2,14),(2,15),(2,16),(2,17),(2,18),(2,19),(2,20),(2,21),(2,22),(2,23),(2,24),(2,25),(2,26),(2,27),(2,28),(2,31),(2,32),(3,1),(3,5),(3,6),(3,7),(3,8),(3,9),(3,10),(3,11),(3,12),(3,13),(3,14),(3,15),(3,16),(3,17),(3,18),(3,19),(3,21),(3,22),(3,24),(3,26),(4,1),(4,5),(4,6),(4,7),(4,9),(4,18),(4,21),(4,22),(4,24),(5,1),(5,5),(5,6),(5,7),(5,21),(5,22),(5,24),(6,1);
/*!40000 ALTER TABLE `rj_role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_roles`
--

DROP TABLE IF EXISTS `rj_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_roles_slug_unique` (`slug`),
  KEY `rj_roles_slug_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_roles`
--

LOCK TABLES `rj_roles` WRITE;
/*!40000 ALTER TABLE `rj_roles` DISABLE KEYS */;
INSERT INTO `rj_roles` VALUES (1,'Super Admin','super-admin','Full system access. Cannot be deleted.',1,100,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(2,'Administrator','admin','Site administrator with most capabilities.',1,80,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(3,'Editor','editor','Can manage content but not users or settings.',1,60,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(4,'Author','author','Can create and manage own posts.',1,40,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(5,'Contributor','contributor','Can create posts but cannot publish.',1,20,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(6,'Subscriber','subscriber','Basic read-only access.',1,10,'2026-10-16 20:08:29','2026-10-16 20:08:29');
/*!40000 ALTER TABLE `rj_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_shipping_methods`
--

DROP TABLE IF EXISTS `rj_shipping_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_shipping_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `shipping_zone_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'flat_rate',
  `cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `min_amount` decimal(15,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rj_shipping_methods_shipping_zone_id_foreign` (`shipping_zone_id`),
  CONSTRAINT `rj_shipping_methods_shipping_zone_id_foreign` FOREIGN KEY (`shipping_zone_id`) REFERENCES `rj_shipping_zones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_shipping_methods`
--

LOCK TABLES `rj_shipping_methods` WRITE;
/*!40000 ALTER TABLE `rj_shipping_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_shipping_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_shipping_zones`
--

DROP TABLE IF EXISTS `rj_shipping_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_shipping_zones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `regions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`regions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_shipping_zones`
--

LOCK TABLES `rj_shipping_zones` WRITE;
/*!40000 ALTER TABLE `rj_shipping_zones` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_shipping_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_tag_translations`
--

DROP TABLE IF EXISTS `rj_tag_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_tag_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_tag_translations_tag_id_locale_unique` (`tag_id`,`locale`),
  KEY `rj_tag_translations_locale_index` (`locale`),
  KEY `rj_tag_translations_name_index` (`name`),
  CONSTRAINT `rj_tag_translations_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `rj_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_tag_translations`
--

LOCK TABLES `rj_tag_translations` WRITE;
/*!40000 ALTER TABLE `rj_tag_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_tag_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_tags`
--

DROP TABLE IF EXISTS `rj_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `post_count` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_tags_slug_unique` (`slug`),
  KEY `rj_tags_post_count_index` (`post_count`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_tags`
--

LOCK TABLES `rj_tags` WRITE;
/*!40000 ALTER TABLE `rj_tags` DISABLE KEYS */;
INSERT INTO `rj_tags` VALUES (1,'test',1,'2026-10-19 16:15:47','2026-10-19 16:17:53');
/*!40000 ALTER TABLE `rj_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_taxonomies`
--

DROP TABLE IF EXISTS `rj_taxonomies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_taxonomies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `singular_name` varchar(255) NOT NULL,
  `plural_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_hierarchical` tinyint(1) NOT NULL DEFAULT 0,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 1,
  `post_types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`post_types`)),
  `labels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`labels`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_taxonomies_slug_unique` (`slug`),
  KEY `rj_taxonomies_slug_index` (`slug`),
  KEY `rj_taxonomies_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_taxonomies`
--

LOCK TABLES `rj_taxonomies` WRITE;
/*!40000 ALTER TABLE `rj_taxonomies` DISABLE KEYS */;
INSERT INTO `rj_taxonomies` VALUES (1,'Categories','category','Category','Categories','Organize posts into hierarchical categories.',1,1,1,'[\"post\"]',NULL,'{\"rewrite_slug\":\"category\",\"hierarchical_urls\":true,\"show_admin_column\":true,\"is_core\":true}','active',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29'),(2,'Tags','tag','Tag','Tags','Flat keywords to describe posts.',0,1,1,'[\"post\"]',NULL,'{\"rewrite_slug\":\"tag\",\"hierarchical_urls\":false,\"show_admin_column\":true,\"is_core\":true}','active',NULL,'2026-10-16 20:08:29','2026-10-16 20:08:29');
/*!40000 ALTER TABLE `rj_taxonomies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_templates`
--

DROP TABLE IF EXISTS `rj_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `content` longtext DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`conditions`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_templates_slug_unique` (`slug`),
  KEY `rj_templates_author_id_foreign` (`author_id`),
  KEY `rj_templates_type_index` (`type`),
  KEY `rj_templates_status_index` (`status`),
  KEY `rj_templates_is_default_index` (`is_default`),
  CONSTRAINT `rj_templates_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_templates`
--

LOCK TABLES `rj_templates` WRITE;
/*!40000 ALTER TABLE `rj_templates` DISABLE KEYS */;
INSERT INTO `rj_templates` VALUES (4,'Default','default','header','{\"blocks\":[{\"id\":\"blk_h18sm8a50\",\"type\":\"container\",\"settings\":{\"width\":\"full\",\"columns\":\"2\",\"column_widths\":\"30\",\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"center\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":\"20\",\"right\":\"20\",\"bottom\":\"20\",\"left\":\"20\",\"unit\":\"px\",\"linked\":true},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#f3f4f6\",\"gradient_color_2\":\"#1f2937\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":\"#ec4899\",\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"padding\":\"md\",\"align\":\"stretch\"},\"children\":[{\"id\":\"blk_hpvbi8c56\",\"type\":\"logo\",\"settings\":{\"image\":\"http:\\/\\/127.0.0.1:8000\\/uploads\\/2026\\/10\\/logo-MOR9OzoF.svg\",\"url\":\"\\/\",\"alt\":null,\"width\":\"100\",\"align\":\"center\",\"hover_opacity\":true,\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"contain\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"sm\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"max_height\":\"60\",\"color_filter\":\"white\"},\"children\":[]},{\"id\":\"blk_lmnsmy7n4\",\"type\":\"container\",\"settings\":{\"width\":\"boxed\",\"columns\":\"1\",\"column_widths\":null,\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"stretch\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[{\"id\":\"blk_6eh3aqo07\",\"type\":\"menu\",\"settings\":{\"menu_id\":\"1\",\"layout\":\"horizontal\",\"align\":\"center\",\"mobile_behavior\":\"hamburger\",\"gap\":\"md\",\"font_size\":\"base\",\"font_weight\":\"500\",\"text_color\":\"#111827\",\"hover_color\":\"#7c3aed\",\"hover_style\":\"underline\",\"active_color\":\"#7c3aed\",\"dropdown_bg\":\"#ffffff\",\"dropdown_border\":\"yes\",\"padding_dim\":{\"top\":\"15\",\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]},{\"id\":\"blk_ooxxmlok2\",\"type\":\"header-language\",\"settings\":{\"style\":\"dropdown\",\"show_flag\":true,\"show_name\":true,\"show_full_name\":false,\"show_arrow\":true,\"dropdown_align\":\"auto\",\"size\":\"md\",\"btn_style\":\"ghost\",\"accent\":\"#8b5cf6\",\"radius\":\"md\",\"show_code_on_compact\":true,\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]}]}]}','published',1,NULL,NULL,1,'2026-10-16 18:53:08','2026-10-27 01:16:47'),(5,'Default','default-1','footer','{\"blocks\":[{\"id\":\"blk_ivcz5ehkm\",\"type\":\"container\",\"settings\":{\"width\":\"full\",\"columns\":\"3\",\"column_widths\":null,\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"stretch\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":\"40\",\"right\":\"40\",\"bottom\":\"40\",\"left\":\"40\",\"unit\":\"px\",\"linked\":true},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":\"#000000\",\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"padding\":\"md\",\"align\":\"stretch\"},\"children\":[{\"id\":\"blk_o0ayf5jtw\",\"type\":\"logo\",\"settings\":{\"url\":\"http:\\/\\/127.0.0.1:8000\\/uploads\\/2026\\/10\\/logo-MOR9OzoF.svg\",\"alt\":null,\"link\":\"\\/\",\"target\":\"_self\",\"width\":\"md\",\"custom_width\":null,\"height\":\"auto\",\"align\":\"left\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]},{\"id\":\"blk_jhjf5cbp5\",\"type\":\"heading\",\"settings\":{\"text\":\"Menu 1\",\"level\":\"h4\",\"align\":\"center\",\"color\":\"#f3f4f6\",\"font_size\":null,\"font_weight\":\"700\",\"line_height\":null,\"letter_spacing\":null,\"text_transform\":\"none\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]},{\"id\":\"blk_sk63fcrhc\",\"type\":\"heading\",\"settings\":{\"text\":\"Menu 2\",\"level\":\"h4\",\"align\":\"center\",\"color\":\"#f3f4f6\",\"font_size\":null,\"font_weight\":\"700\",\"line_height\":null,\"letter_spacing\":null,\"text_transform\":\"none\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]},{\"id\":\"blk_rlu6wtwqa\",\"type\":\"container\",\"settings\":{\"width\":\"full\",\"columns\":\"3\",\"column_widths\":null,\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"stretch\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":\"40\",\"right\":\"40\",\"bottom\":\"40\",\"left\":\"40\",\"unit\":\"px\",\"linked\":true},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":\"#000000\",\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"padding\":\"md\",\"align\":\"stretch\"},\"children\":[{\"id\":\"blk_vl9ok4ia2\",\"type\":\"text\",\"settings\":{\"text\":\"Write something here.\",\"size\":\"base\",\"align\":\"left\",\"color\":\"#f3f4f6\",\"font_size\":null,\"font_weight\":\"400\",\"line_height\":null,\"letter_spacing\":null,\"text_transform\":\"none\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]},{\"id\":\"blk_co23tlba9\",\"type\":\"menu\",\"settings\":{\"menu_id\":\"1\",\"layout\":\"vertical\",\"align\":\"center\",\"mobile_behavior\":\"hamburger\",\"gap\":\"md\",\"font_size\":\"base\",\"font_weight\":\"500\",\"text_color\":\"#ffffff\",\"hover_color\":\"#7c3aed\",\"hover_style\":\"underline\",\"active_color\":\"#7c3aed\",\"dropdown_bg\":\"#ffffff\",\"dropdown_border\":\"yes\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]},{\"id\":\"blk_xlzyl8dtf\",\"type\":\"menu\",\"settings\":{\"menu_id\":\"1\",\"layout\":\"vertical\",\"align\":\"center\",\"mobile_behavior\":\"hamburger\",\"gap\":\"md\",\"font_size\":\"base\",\"font_weight\":\"500\",\"text_color\":\"#ffffff\",\"hover_color\":\"#7c3aed\",\"hover_style\":\"underline\",\"active_color\":\"#7c3aed\",\"dropdown_bg\":\"#ffffff\",\"dropdown_border\":\"yes\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]},{\"id\":\"blk_8g1xtyc5d\",\"type\":\"container\",\"settings\":{\"width\":\"full\",\"columns\":\"1\",\"column_widths\":null,\"keep_tablet\":false,\"keep_mobile\":false,\"flex_direction\":\"row\",\"justify_content\":\"start\",\"align_items\":\"stretch\",\"flex_wrap\":\"wrap\",\"gap\":\"md\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"min_height\":\"auto\",\"min_height_custom\":null,\"border\":\"none\",\"border_radius\":\"md\",\"bg_type\":\"none\",\"bg_color\":\"#000000\",\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"padding\":\"md\",\"align\":\"stretch\"},\"children\":[{\"id\":\"blk_djmimmups\",\"type\":\"text\",\"settings\":{\"text\":\"Copyright RJ NEXUS 2026\",\"size\":\"base\",\"align\":\"center\",\"color\":\"#f3f4f6\",\"font_size\":null,\"font_weight\":\"400\",\"line_height\":null,\"letter_spacing\":null,\"text_transform\":\"none\",\"padding_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"margin_dim\":{\"top\":null,\"right\":null,\"bottom\":null,\"left\":null,\"unit\":\"px\",\"linked\":false},\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null},\"children\":[]}]}]}','published',0,NULL,NULL,1,'2026-10-16 19:06:59','2026-10-23 21:27:46'),(6,'velvet-aura','velvet-aura','header','{\"blocks\":[{\"id\":\"blk_042eek9qi\",\"type\":\"velvet-header\",\"settings\":{\"style\":\"style-1\",\"logo\":null,\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"announcement\":\"Saxta babaa\"},\"children\":[]}]}','published',0,NULL,NULL,1,'2026-10-23 19:01:16','2026-10-24 20:00:47'),(7,'velvet-aura','velvet-aura-1','footer','{\"blocks\":[{\"id\":\"blk_pk5dk5ktm\",\"type\":\"velvet-footer\",\"settings\":{\"style\":\"style-1\",\"logo\":\"http:\\/\\/127.0.0.1:8000\\/uploads\\/2026\\/10\\/logo-MOR9OzoF.svg\",\"bg_type\":\"none\",\"bg_color\":null,\"bg_image\":null,\"bg_position\":\"center\",\"bg_size\":\"cover\",\"bg_repeat\":\"no-repeat\",\"gradient_color_1\":\"#7c3aed\",\"gradient_color_2\":\"#ec4899\",\"gradient_angle\":135,\"box_shadow\":\"none\",\"align_self\":\"auto\",\"order\":0,\"_animation\":\"none\",\"_animation_duration\":\"md\",\"_animation_delay\":\"0\",\"_hover\":\"none\",\"_hover_text_color\":null,\"_hover_bg_color\":null,\"_hover_border_color\":null,\"_css_id\":null,\"_css_class\":null,\"copyright\":\"\\u00a9 2026 Velvet Aura. All rights reserved.\",\"description\":\"Curating exceptional fragrances and premium essentials for the modern individual. Experience the art of fine living.\"},\"children\":[]}]}','published',1,NULL,NULL,1,'2026-10-23 21:27:41','2026-10-23 21:44:59');
/*!40000 ALTER TABLE `rj_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_term_translations`
--

DROP TABLE IF EXISTS `rj_term_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_term_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_term_translations_term_id_locale_unique` (`term_id`,`locale`),
  CONSTRAINT `rj_term_translations_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `rj_terms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_term_translations`
--

LOCK TABLES `rj_term_translations` WRITE;
/*!40000 ALTER TABLE `rj_term_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_term_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_terms`
--

DROP TABLE IF EXISTS `rj_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_terms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `taxonomy` varchar(255) NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `post_count` int(11) NOT NULL DEFAULT 0,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_terms_taxonomy_slug_unique` (`taxonomy`,`slug`),
  KEY `rj_terms_taxonomy_index` (`taxonomy`),
  KEY `rj_terms_parent_id_index` (`parent_id`),
  KEY `rj_terms_is_active_index` (`is_active`),
  KEY `rj_terms_sort_order_index` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_terms`
--

LOCK TABLES `rj_terms` WRITE;
/*!40000 ALTER TABLE `rj_terms` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_theme_customizations`
--

DROP TABLE IF EXISTS `rj_theme_customizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_theme_customizations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `theme_slug` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_theme_customizations_theme_slug_section_key_unique` (`theme_slug`,`section`,`key`),
  KEY `rj_theme_customizations_theme_slug_index` (`theme_slug`),
  KEY `rj_theme_customizations_theme_slug_section_index` (`theme_slug`,`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_theme_customizations`
--

LOCK TABLES `rj_theme_customizations` WRITE;
/*!40000 ALTER TABLE `rj_theme_customizations` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_theme_customizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_themes`
--

DROP TABLE IF EXISTS `rj_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_themes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL DEFAULT '1.0.0',
  `description` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `author_url` varchar(255) DEFAULT NULL,
  `preview_image` varchar(255) DEFAULT NULL,
  `folder` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'inactive',
  `is_child` tinyint(1) NOT NULL DEFAULT 0,
  `parent_slug` varchar(255) DEFAULT NULL,
  `supports` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`supports`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `error_message` text DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_themes_slug_unique` (`slug`),
  KEY `rj_themes_status_index` (`status`),
  KEY `rj_themes_slug_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_themes`
--

LOCK TABLES `rj_themes` WRITE;
/*!40000 ALTER TABLE `rj_themes` DISABLE KEYS */;
INSERT INTO `rj_themes` VALUES (1,'RJ Default','rj-default','0.9.0','The official default theme for RJ CMS. Clean, minimal, builder-first.','RJ CMS','https://github.com/mr-ruhid','screenshot.png','rj-default','active',0,NULL,'{\"builder_header\":true,\"builder_footer\":true,\"builder_page\":true,\"builder_popup\":true,\"custom_logo\":true,\"custom_colors\":true,\"custom_fonts\":true,\"post_thumbnail\":true,\"post_excerpt\":true,\"menus\":[\"header\",\"footer\",\"mobile\"]}',NULL,'{\"name\":\"RJ Default\",\"slug\":\"rj-default\",\"version\":\"0.9.0\",\"author\":\"RJ CMS\",\"author_url\":\"https:\\/\\/github.com\\/mr-ruhid\",\"description\":\"The official default theme for RJ CMS. Clean, minimal, builder-first.\",\"license\":\"MIT\",\"preview\":\"screenshot.png\",\"requires\":{\"rj_cms\":\">=1.0.0\",\"php\":\">=8.2\"},\"supports\":{\"builder_header\":true,\"builder_footer\":true,\"builder_page\":true,\"builder_popup\":true,\"custom_logo\":true,\"custom_colors\":true,\"custom_fonts\":true,\"post_thumbnail\":true,\"post_excerpt\":true,\"menus\":[\"header\",\"footer\",\"mobile\"]},\"views\":{\"layout\":\"views\\/layout.blade.php\",\"single_post\":\"views\\/single-post.blade.php\",\"single_page\":\"views\\/single-page.blade.php\",\"archive\":\"views\\/archive.blade.php\"},\"custom_templates\":[{\"id\":\"contact\",\"label\":\"Contact Page\",\"description\":\"Two-column layout with contact form and info sidebar.\",\"view\":\"views\\/templates\\/contact.blade.php\",\"icon\":\"mail\"},{\"id\":\"landing\",\"label\":\"Landing Page\",\"description\":\"Full-width hero with centered CTA. No sidebar.\",\"view\":\"views\\/templates\\/landing.blade.php\",\"icon\":\"rocket\"},{\"id\":\"full-width\",\"label\":\"Full Width\",\"description\":\"Edge-to-edge content without container padding.\",\"view\":\"views\\/templates\\/full-width.blade.php\",\"icon\":\"expand\"}],\"assets\":{\"css\":[],\"js\":[]},\"customizer\":{\"sections\":{\"colors\":{\"label\":\"Colors\",\"icon\":\"palette\",\"controls\":{\"primary_color\":{\"type\":\"color\",\"label\":\"Primary Color\",\"default\":\"#7c3aed\"},\"secondary_color\":{\"type\":\"color\",\"label\":\"Secondary Color\",\"default\":\"#ec4899\"},\"text_color\":{\"type\":\"color\",\"label\":\"Text Color\",\"default\":\"#111827\"},\"background_color\":{\"type\":\"color\",\"label\":\"Background Color\",\"default\":\"#ffffff\"},\"link_color\":{\"type\":\"color\",\"label\":\"Link Color\",\"default\":\"#7c3aed\"}}},\"typography\":{\"label\":\"Typography\",\"icon\":\"type\",\"controls\":{\"font_body\":{\"type\":\"select\",\"label\":\"Body Font\",\"default\":\"Inter\",\"options\":{\"Inter\":\"Inter\",\"Figtree\":\"Figtree\",\"Roboto\":\"Roboto\",\"Open Sans\":\"Open Sans\",\"Lato\":\"Lato\",\"Poppins\":\"Poppins\",\"system-ui\":\"System Default\"}},\"font_heading\":{\"type\":\"select\",\"label\":\"Heading Font\",\"default\":\"Inter\",\"options\":{\"Inter\":\"Inter\",\"Figtree\":\"Figtree\",\"Roboto\":\"Roboto\",\"Open Sans\":\"Open Sans\",\"Lato\":\"Lato\",\"Poppins\":\"Poppins\",\"system-ui\":\"System Default\"}},\"font_size_base\":{\"type\":\"range\",\"label\":\"Base Font Size\",\"default\":16,\"min\":12,\"max\":24,\"step\":1,\"suffix\":\"px\"},\"line_height\":{\"type\":\"range\",\"label\":\"Line Height\",\"default\":1.6,\"min\":1.2,\"max\":2.2,\"step\":0.1}}},\"layout\":{\"label\":\"Layout\",\"icon\":\"layout\",\"controls\":{\"container_width\":{\"type\":\"range\",\"label\":\"Container Width\",\"default\":1200,\"min\":960,\"max\":1600,\"step\":20,\"suffix\":\"px\"},\"sidebar_position\":{\"type\":\"select\",\"label\":\"Sidebar Position\",\"default\":\"right\",\"options\":{\"right\":\"Right\",\"left\":\"Left\",\"none\":\"No Sidebar\"}},\"sticky_header\":{\"type\":\"toggle\",\"label\":\"Sticky Header\",\"default\":true}}},\"header\":{\"label\":\"Header\",\"icon\":\"header\",\"controls\":{\"logo_text\":{\"type\":\"text\",\"label\":\"Logo Text\",\"default\":\"RJ CMS\"},\"logo_image\":{\"type\":\"text\",\"label\":\"Logo Image URL\",\"default\":\"\"},\"header_bg\":{\"type\":\"color\",\"label\":\"Header Background\",\"default\":\"#ffffff\"},\"header_text_color\":{\"type\":\"color\",\"label\":\"Header Text Color\",\"default\":\"#111827\"}}},\"footer\":{\"label\":\"Footer\",\"icon\":\"footer\",\"controls\":{\"footer_text\":{\"type\":\"textarea\",\"label\":\"Footer Text\",\"default\":\"\\u00a9 2026 RJ CMS. All rights reserved.\"},\"footer_bg\":{\"type\":\"color\",\"label\":\"Footer Background\",\"default\":\"#1a1030\"},\"footer_text_color\":{\"type\":\"color\",\"label\":\"Footer Text Color\",\"default\":\"#d1d5db\"}}},\"social\":{\"label\":\"Social Links\",\"icon\":\"link\",\"controls\":{\"facebook\":{\"type\":\"url\",\"label\":\"Facebook URL\",\"default\":\"\"},\"twitter\":{\"type\":\"url\",\"label\":\"Twitter \\/ X URL\",\"default\":\"\"},\"instagram\":{\"type\":\"url\",\"label\":\"Instagram URL\",\"default\":\"\"},\"youtube\":{\"type\":\"url\",\"label\":\"YouTube URL\",\"default\":\"\"},\"linkedin\":{\"type\":\"url\",\"label\":\"LinkedIn URL\",\"default\":\"\"}}}}}}',NULL,'2026-10-24 19:59:57','2026-10-16 18:33:44','2026-10-24 19:59:57'),(2,'VelvetAura','velvet-aura','0.0.9','A premium, modern e-commerce theme exclusively designed for RJ Commerce.','RJ Nexus','https://github.com/rj-nexus',NULL,'velvet-aura','inactive',0,NULL,'[\"rj-builder\",\"rj-commerce\",\"menus\",\"widgets\"]',NULL,'{\"name\":\"VelvetAura\",\"slug\":\"velvet-aura\",\"version\":\"0.0.9\",\"author\":\"RJ Nexus\",\"author_url\":\"https:\\/\\/github.com\\/rj-nexus\",\"description\":\"A premium, modern e-commerce theme exclusively designed for RJ Commerce.\",\"license\":\"MIT\",\"screenshot\":\"screenshot.jpg\",\"namespace\":\"VelvetAura\",\"provider\":\"VelvetAura\\\\VelvetAuraServiceProvider\",\"requires\":{\"rj_cms\":\">=1.0.0\",\"php\":\">=8.2\"},\"supports\":[\"rj-builder\",\"rj-commerce\",\"menus\",\"widgets\"],\"provides\":{\"views\":\"views\",\"assets\":\"assets\"}}',NULL,'2026-10-23 21:17:52','2026-10-23 17:51:59','2026-10-24 19:59:57');
/*!40000 ALTER TABLE `rj_themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_user_role`
--

DROP TABLE IF EXISTS `rj_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_user_role` (
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `rj_user_role_role_id_foreign` (`role_id`),
  CONSTRAINT `rj_user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `rj_roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rj_user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_user_role`
--

LOCK TABLES `rj_user_role` WRITE;
/*!40000 ALTER TABLE `rj_user_role` DISABLE KEYS */;
INSERT INTO `rj_user_role` VALUES (1,1);
/*!40000 ALTER TABLE `rj_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rj_widgets`
--

DROP TABLE IF EXISTS `rj_widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rj_widgets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL DEFAULT '1.0.0',
  `description` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `author_url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'custom',
  `folder` varchar(255) NOT NULL,
  `main_file` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `schema` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`schema`)),
  `defaults` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`defaults`)),
  `requires` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requires`)),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `error_message` text DEFAULT NULL,
  `uploaded_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rj_widgets_slug_unique` (`slug`),
  KEY `rj_widgets_status_index` (`status`),
  KEY `rj_widgets_category_index` (`category`),
  KEY `rj_widgets_slug_index` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rj_widgets`
--

LOCK TABLES `rj_widgets` WRITE;
/*!40000 ALTER TABLE `rj_widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `rj_widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('94jvcofNxZwUwgwAgHxJRJOi7sdjPopKpuOKJpKv',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaW1yMUlEWHE4SDlrUllJOWJqdURPT002RlRuTWgwQ0RVZlJqbTRWZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yai1mb250cy5jc3MiO3M6NToicm91dGUiO3M6MTg6ImZyb250ZW5kLmZvbnRzLmNzcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1793099684),('bhHXjMdsAxNgkvCOxVZK9hqQ2xUB5ymy53zxTrQO',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiS0hEcmpWQ0lLUnNadHpvTzBWYkdDZUVheUh0Q3JQWWxVa2VsTlZiQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yai1mb250cy5jc3MiO3M6NToicm91dGUiO3M6MTg6ImZyb250ZW5kLmZvbnRzLmNzcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1793099318),('dFf1tFn7ozHRHmdd5ZdlsJMIScGwi5ynsTBZB75y',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoieTBwSWoyc2tIUGlkOG0ydko4TWl4c3hyM0ZQbmFrYURJWG1XdGUxVSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6Ijg2YzFmMWVjMDFiYmRjMjBkMDM0MTViY2I2MjMyY2Y0YWFhZGViZTMyMDIwNWM3MWFmMjQ5ZmUyYTI4NzMwODYiO30=',1793147588),('dGypA3xrTfLWI5SWY9eASqI5FWJ5MYXmh3PQYWgJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGlNblVVeVpvSmJoS0NHV3gzdUxoVDBsSkx5dkZFNXRjcGUwSEtZQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yai1mb250cy5jc3MiO3M6NToicm91dGUiO3M6MTg6ImZyb250ZW5kLmZvbnRzLmNzcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1793101828),('DqZOQwms31QV5u6lyIORt6dgGxbzi29m1wOhFf6p',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOTRQN1U0NU1UVFpRcHhtS2VrR2x2QnpYa1JoTk9jQlQ4ZDZ5eVk2ciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yai1mb250cy5jc3MiO3M6NToicm91dGUiO3M6MTg6ImZyb250ZW5kLmZvbnRzLmNzcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1793099272),('isqFIX6WfjoGpYXjmSGMukVTxWYE1ARbR0uca84i',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU2p4bWZrbzFwdHRsVUIwWW93azJGSDh5QTdpY0V4TjY3Y3Y4ZHBMdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiODZjMWYxZWMwMWJiZGMyMGQwMzQxNWJjYjYyMzJjZjRhYWFkZWJlMzIwMjA1YzcxYWYyNDlmZTJhMjg3MzA4NiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO30=',1793107222),('xXcAElE9AW3R89i3QoLPIXyWTCYYmZwWaYtGCT4X',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibng5UkVIb3Y3SWNxYktyMEhRREREQ0tVRU1Vc0J5Nkc3QWYzZ0ZtVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1793100486);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `kyc_status` varchar(255) NOT NULL DEFAULT 'none',
  `kyc_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@admin.com',NULL,'$2y$12$mWYJPeeU3TT45I.aOHdsV.sEoXWwaaNo0vgNgezYcWTM04qhQKRuq','eyJpdiI6IkV2QjA3NXU3MFpOKzU3ZUJKNDNrblE9PSIsInZhbHVlIjoiaTgyd1BsRExYYzVYcUFGODZ2dFZ3cnBWeU9VcGZSc0pDekhJbFdPQWdML2V6UjJuS1BpTE9ZOG5xRlpNZStOYSIsIm1hYyI6ImI0NTQ2ZTQyYzJhZjFiYmE5MDU5ZmY0ZTY2NTg0MzA2Y2I2MTZiODYwOWUzYmY2OTBmNDM2MDkzY2NlMzdmZDciLCJ0YWciOiIifQ==',NULL,NULL,'super_admin','active','none',NULL,'iLML40e3USeYXBxqT7FCbrjDEp13waUnTebnheIJgBlJ8xzpvIOLk0w1JGuE','2026-10-12 11:51:12','2026-10-21 17:45:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-28  4:53:20
