## [v1.9.10] - 2026-11-20

### 🚀 Added
- **Amharic Language Support:** Added Amharic (`am`) as a fully supported language across the system, including the core translation files (`lang/am.json`), installer translations (`installer/lang/am.php`), and the Ethiopian flag.

### 🐛 Fixed
- **AI Center Status Detection:** The AI Center was looking for a non-existent option key (`ai_api_key`) to determine the connection status, resulting in a false "API Disconnected" state even when OpenRouter was configured. It now correctly relies on `OpenRouterService::isConfigured()`.
- **AI Center Cache Overflow:** Fetching the OpenRouter models list caused a `MySQL max_allowed_packet` error because the entire model metadata array was being stored in the database cache. The cached data is now stripped down to only the essential fields (`id`, `name`, `pricing`), preventing database connection drops.
- **AI Model Selection Ignored:** The SEO, Code Reviewer, Translator, and Builder services were always using the default model, ignoring the specific models assigned in AI Center → Models. All services now correctly read their respective options (`ai_seo_model`, `ai_code_model`, `ai_translate_model`, `ai_builder_model`) and fall back to the default model only when necessary.
- **AI Builder Connection:** `AiBuilderService` was using its own redundant HTTP logic and had an outdated default model. It now delegates directly to `OpenRouterService`, ensuring consistency and correctly using the selected Builder model.
- **AI Tools Request Signature:** `AiToolController` was passing the model options array into the wrong argument of the `chat()` method, causing OpenRouter API to return a 400 error. The method signature and fallback logic have been corrected.
- **Auto SEO Invalid JSON:** `AiSeoService` was prone to returning truncated or malformed JSON responses (especially in non-English languages), leading to "AI returned invalid JSON" errors. It now enforces `json_object` response formatting, increases `max_tokens` to 2000, and features a more tolerant JSON parser.
- **Auto SEO with RJBuilder:** Generating SEO for a page designed with RJBuilder failed because the textarea content was empty. The system now passes the `post_id` to the backend, allowing it to extract text directly from the RJBuilder blocks before sending the request to the AI.
- **AI SEO Routing:** The "Auto SEO" button in the Post/Page editor was incorrectly routing through the free AI agent (RAG). It now correctly uses `AiSeoService` and your OpenRouter API key for high-quality results.