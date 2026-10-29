@php
    $githubUrl  = 'https://github.com/rj-nexus';
    $supportUrl = 'https://github.com/orgs/rj-nexus/discussions';

    $debug = (bool) config('app.debug');
    $http  = $exception instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
    $code  = (int) ($statusCode ?? ($http ? $exception->getStatusCode() : 500));

    $main = $exception;
    if ($http && $exception->getPrevious()) {
        $main = $exception->getPrevious();
    }

    $statusMap = [
        400 => ['Bad Request', 'The server could not understand the request.'],
        401 => ['Unauthorized', 'You need to sign in to access this page.'],
        402 => ['Payment Required', 'Payment is required to continue.'],
        403 => ['Forbidden', 'You do not have permission to access this resource.'],
        404 => ['Page Not Found', 'The page you are looking for does not exist or has been moved.'],
        405 => ['Method Not Allowed', 'This action is not supported for the requested address.'],
        408 => ['Request Timeout', 'The request took too long. Please try again.'],
        419 => ['Page Expired', 'Your session has expired. Please refresh the page and try again.'],
        422 => ['Unprocessable Content', 'The submitted data could not be processed.'],
        429 => ['Too Many Requests', 'Slow down a little and try again shortly.'],
        500 => ['Server Error', 'Something went wrong on our side. We are already looking into it.'],
        502 => ['Bad Gateway', 'The server received an invalid response. Please try again.'],
        503 => ['Service Unavailable', 'We are temporarily down for maintenance. Please check back soon.'],
        504 => ['Gateway Timeout', 'The server took too long to respond. Please try again.'],
    ];
    [$statusTitle, $statusText] = $statusMap[$code] ?? ['Error', 'An unexpected error occurred.'];

    $msg      = trim((string) $main->getMessage());
    $errorId  = strtoupper(substr(md5(get_class($main) . '|' . $main->getFile() . '|' . $main->getLine() . '|' . $msg), 0, 8));
    $now      = now()->format('Y-m-d H:i:s');
    $req      = request();
    $method   = $req->method();

    $frames = [];
    $chain = [];
    $hints = [];
    $sql = null;
    $queries = [];
    $reqRows = $queryRows = $inputRows = $fileRows = $headerRows = $sessionRows = $cookieRows = $envRows = $queryLogRows = [];
    $firstOpen = 0;
    $appCount = 0;
    $vendorCount = 0;
    $traceText = '';
    $report = '';
    $relMain = '';
    $editorUrl = null;
    $google = $so = $ghIssues = '#';
    $userLabel = 'Guest';
    $elapsed = '—';
    $memory = '—';

    if ($debug) {
        $sensitive = '/pass|pwd|secret|token|key|auth|cookie|session|csrf|xsrf|credit|card|cvv|ssn|signature|bearer|otp/i';

        $mask = function ($value, $key = '') use (&$mask, $sensitive) {
            if ((string) $key !== '' && preg_match($sensitive, (string) $key)) {
                return '••••••••';
            }
            if (is_array($value)) {
                $out = [];
                foreach ($value as $k => $v) {
                    $out[$k] = $mask($v, $k);
                }
                return $out;
            }
            if ($value instanceof \Illuminate\Http\UploadedFile) {
                return $value->getClientOriginalName();
            }
            if (is_object($value)) {
                return get_class($value);
            }
            return $value;
        };

        $show = function ($value) {
            if (is_null($value)) {
                return 'null';
            }
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }
            if (is_scalar($value)) {
                return mb_strimwidth((string) $value, 0, 800, '…');
            }
            $json = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_PARTIAL_OUTPUT_ON_ERROR);
            return mb_strimwidth($json === false ? '[unserializable]' : $json, 0, 1200, '…');
        };

        $rows = function ($data) use ($mask, $show) {
            $out = [];
            foreach ((array) $data as $k => $v) {
                $out[] = [(string) $k, $show($mask($v, (string) $k))];
            }
            return $out;
        };

        $s = fn ($v) => ($v === null || $v === '') ? '—' : (string) $v;

        $snippet = function (?string $file, int $line, int $radius) {
            if (!$file || $line < 1 || !is_file($file) || !is_readable($file) || filesize($file) > 1500000) {
                return null;
            }
            try {
                $lines = file($file, FILE_IGNORE_NEW_LINES);
            } catch (\Throwable $e) {
                return null;
            }
            if (!is_array($lines) || !isset($lines[$line - 1])) {
                return null;
            }
            $from = max(1, $line - $radius);
            $to = min(count($lines), $line + $radius);
            $out = [];
            for ($n = $from; $n <= $to; $n++) {
                $out[$n] = mb_strimwidth($lines[$n - 1], 0, 400, '…');
            }
            return $out;
        };

        $base = rtrim(str_replace('\\', '/', base_path()), '/') . '/';
        $trace = $main->getTrace();
        array_unshift($trace, ['file' => $main->getFile(), 'line' => $main->getLine(), '__thrown' => true]);

        foreach (array_slice($trace, 0, 45) as $i => $t) {
            $file = $t['file'] ?? null;
            $line = (int) ($t['line'] ?? 0);
            $norm = $file ? str_replace('\\', '/', $file) : null;
            $isVendor = $norm && str_contains($norm, '/vendor/');
            $rel = $norm ? (str_starts_with($norm, $base) ? substr($norm, strlen($base)) : $norm) : '[internal function]';
            $label = isset($t['__thrown'])
                ? class_basename($main) . ' thrown'
                : (($t['class'] ?? '') . ($t['type'] ?? '') . ($t['function'] ?? '') . '()');
            $frames[] = [
                'i'      => $i,
                'file'   => $file,
                'line'   => $line,
                'rel'    => $rel,
                'vendor' => (bool) $isVendor,
                'label'  => $label,
                'snip'   => $file ? $snippet($file, $line, $i === 0 ? 8 : 5) : null,
            ];
        }

        foreach ($frames as $f) {
            if ($f['vendor']) {
                $vendorCount++;
            } else {
                $appCount++;
            }
        }
        foreach ($frames as $f) {
            if (!$f['vendor'] && $f['file']) {
                $firstOpen = $f['i'];
                break;
            }
        }

        $relMain = $frames[0]['rel'] ?? '';
        $editorUrl = $main->getFile() ? 'vscode://file/' . str_replace('\\', '/', $main->getFile()) . ':' . $main->getLine() : null;

        $prev = $main->getPrevious();
        $guard = 0;
        while ($prev && $guard < 5) {
            $chain[] = [get_class($prev), (string) $prev->getMessage(), $prev->getFile() . ':' . $prev->getLine()];
            $prev = $prev->getPrevious();
            $guard++;
        }

        $traceText = collect($frames)->map(fn ($f) => '#' . $f['i'] . ' ' . $f['rel'] . ($f['line'] ? ':' . $f['line'] : '') . ' ' . $f['label'])->implode("\n");

        $route = null;
        try {
            $route = $req->route();
        } catch (\Throwable $e) {
        }

        $routeName = '—';
        $routeAction = '—';
        $routeMiddleware = '—';
        if ($route instanceof \Illuminate\Routing\Route) {
            try {
                $routeName = $route->getName() ?: '—';
                $routeAction = $route->getActionName();
                $routeMiddleware = implode(', ', array_map(fn ($m) => is_string($m) ? $m : 'Closure', $route->gatherMiddleware())) ?: '—';
            } catch (\Throwable $e) {
            }
        }

        try {
            $u = $req->user();
            if ($u) {
                $userLabel = ($u->name ?? $u->email ?? 'User') . ' (ID: ' . $u->getAuthIdentifier() . ')';
            }
        } catch (\Throwable $e) {
        }

        $reqRows = [
            ['Method', $method],
            ['URL', $req->fullUrl()],
            ['Path', '/' . ltrim($req->path(), '/')],
            ['Route name', $routeName],
            ['Route action', $routeAction],
            ['Middleware', $routeMiddleware],
            ['Client IP', $s($req->ip())],
            ['User agent', $s($req->userAgent())],
            ['Referer', $s($req->headers->get('referer'))],
            ['Content type', $s($req->headers->get('content-type'))],
            ['AJAX / JSON', ($req->ajax() ? 'ajax' : 'no') . ' / ' . ($req->expectsJson() ? 'json' : 'html')],
            ['User', $userLabel],
        ];

        $queryRows = $rows($req->query->all());

        try {
            $inputRows = $rows($req->isJson() ? $req->json()->all() : $req->request->all());
        } catch (\Throwable $e) {
        }

        $fileRows = $rows($req->allFiles());

        $headerData = [];
        foreach ($req->headers->all() as $hk => $hv) {
            $headerData[$hk] = implode(', ', (array) $hv);
        }
        $headerRows = $rows($headerData);

        $sessionData = [];
        try {
            if ($req->hasSession() && $req->session()->isStarted()) {
                $sessionData = $req->session()->all();
            }
        } catch (\Throwable $e) {
        }
        $sessionRows = $rows($sessionData);
        $cookieRows = $rows($req->cookies->all());

        $elapsed = defined('LARAVEL_START') ? round((microtime(true) - LARAVEL_START) * 1000) . ' ms' : '—';
        $memory = round(memory_get_peak_usage(true) / 1048576, 2) . ' MB';

        $envRows = [
            ['Laravel', app()->version()],
            ['PHP', PHP_VERSION],
            ['SAPI', php_sapi_name()],
            ['OS', PHP_OS_FAMILY],
            ['Server', $s($_SERVER['SERVER_SOFTWARE'] ?? null)],
            ['App environment', app()->environment()],
            ['Debug mode', config('app.debug') ? 'TRUE' : 'FALSE'],
            ['App URL', $s(config('app.url'))],
            ['Timezone', $s(config('app.timezone'))],
            ['Locale', app()->getLocale()],
            ['Database', $s(config('database.default'))],
            ['Cache driver', $s(config('cache.default'))],
            ['Session driver', $s(config('session.driver'))],
            ['Queue connection', $s(config('queue.default'))],
            ['Memory peak', $memory . ' / ' . ini_get('memory_limit')],
            ['Execution time', $elapsed],
            ['Extensions loaded', count(get_loaded_extensions())],
        ];

        try {
            $queries = \Illuminate\Support\Facades\DB::getQueryLog();
        } catch (\Throwable $e) {
        }
        foreach ($queries as $qi => $qr) {
            $queryLogRows[] = ['#' . ($qi + 1) . ' · ' . round((float) ($qr['time'] ?? 0), 2) . ' ms', (string) ($qr['query'] ?? '')];
        }

        $sql = $main instanceof \Illuminate\Database\QueryException ? $main->getSql() : null;

        $lower = mb_strtolower($msg);
        $has = fn (string $needle) => str_contains($lower, mb_strtolower($needle));

        if ($main instanceof \Illuminate\Database\QueryException) {
            if ($has('connection refused') || $has('could not find driver') || $has('access denied') || $has('unknown database') || $has('getaddrinfo') || $has('no such host')) {
                $hints[] = ['Database connection problem', 'Check the DB_* values in your .env file and make sure the database server is running and reachable.', 'php artisan config:clear'];
            } elseif ($has('base table or view not found') || $has('no such table') || $has('doesn\'t exist')) {
                $hints[] = ['Table is missing', 'The query uses a table that does not exist yet. Run the pending migrations.', 'php artisan migrate'];
            } elseif ($has('unknown column') || $has('no such column') || $has('has no column') || $has('column not found')) {
                $hints[] = ['Column is missing', 'The query references a column that is not in the table. Compare your migration with the real database schema.', 'php artisan migrate:status'];
            } elseif ($has('duplicate entry') || $has('unique constraint')) {
                $hints[] = ['Duplicate value', 'A unique column already contains this value. Validate uniqueness before saving or use updateOrCreate().', null];
            } else {
                $hints[] = ['Database query failed', 'Inspect the SQL below and check table names, column names and bound values.', null];
            }
        }
        if ($main instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $hints[] = ['Record not found', 'findOrFail() or firstOrFail() did not find a matching row. Check the id or slug used in the URL.', null];
        }
        if ($main instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $hints[] = ['Route not found', 'No route matches this URL. List the registered routes and clear the route cache if you just added one.', 'php artisan route:list'];
        }
        if ($main instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            $hints[] = ['Wrong HTTP method', 'The route exists but not for ' . $method . '. Check the form method, @method override or the route verb.', null];
        }
        if ($main instanceof \Illuminate\Session\TokenMismatchException || $code === 419) {
            $hints[] = ['CSRF token mismatch', 'Add the @csrf directive to the form, or refresh the page because the session expired.', null];
        }
        if ($main instanceof \Illuminate\Auth\AuthenticationException || $code === 401) {
            $hints[] = ['Not authenticated', 'The request requires a signed-in user. Check the auth middleware and the guard used.', null];
        }
        if ($main instanceof \Illuminate\Auth\Access\AuthorizationException || $code === 403) {
            $hints[] = ['Access denied', 'A policy, gate or middleware rejected this request. Check permissions for the current user.', null];
        }
        if ($main instanceof \Illuminate\Validation\ValidationException) {
            $hints[] = ['Validation failed', 'Submitted data did not pass the rules. Check the errors bag and the form request rules.', null];
        }
        if ($has('no application encryption key')) {
            $hints[] = ['Application key is missing', 'Generate the key so encryption and sessions can work.', 'php artisan key:generate'];
        }
        if (preg_match('/class "?[^"]+"? not found/i', $msg) || $has('target class [')) {
            $hints[] = ['Class not found', 'Check the namespace and file name, then rebuild the autoloader.', 'composer dump-autoload'];
        }
        if ($has('view [') && $has('not found')) {
            $hints[] = ['View not found', 'The Blade view name or path is wrong. Check resources/views and the view name used.', 'php artisan view:clear'];
        }
        if ($has('undefined variable') || $has('undefined array key') || $has('undefined property')) {
            $hints[] = ['Undefined value', 'A variable, key or property is used before it exists. Check what the controller passes to the view.', null];
        }
        if ($has('call to a member function') || $has('call to undefined method')) {
            $hints[] = ['Method call problem', 'The object is null or the method does not exist. Check the value before calling the method.', null];
        }
        if ($has('allowed memory size')) {
            $hints[] = ['Memory limit reached', 'The script used more memory than allowed. Process data in chunks or raise memory_limit in php.ini.', null];
        }
        if ($has('permission denied') || $has('failed to open stream')) {
            $hints[] = ['File permission problem', 'The web server cannot read or write a file. Check permissions of storage and bootstrap/cache.', 'chmod -R 775 storage bootstrap/cache'];
        }
        if ($has('too few arguments') || $has('must be of type')) {
            $hints[] = ['Wrong arguments', 'A function received missing or wrongly typed arguments. Compare the call with the method signature.', null];
        }
        if ($main instanceof \Illuminate\Contracts\Container\BindingResolutionException) {
            $hints[] = ['Cannot resolve dependency', 'The container cannot build this class. Check constructor type-hints and service provider bindings.', null];
        }
        if ($main instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException || $code === 429) {
            $hints[] = ['Rate limit hit', 'Too many requests in a short time. Wait a moment or adjust the throttle middleware.', null];
        }
        if (!$hints) {
            $hints[] = ['Where to look next', 'Read storage/logs/laravel.log for the full report, then clear cached files.', 'php artisan optimize:clear'];
        }
        $hints = array_slice($hints, 0, 3);

        $q = get_class($main) . ' ' . mb_strimwidth(preg_replace('/\s+/', ' ', $msg), 0, 140, '');
        $google = 'https://www.google.com/search?q=' . rawurlencode($q . ' laravel');
        $so = 'https://stackoverflow.com/search?q=' . rawurlencode($q);
        $ghIssues = 'https://github.com/laravel/framework/issues?q=' . rawurlencode(mb_strimwidth(preg_replace('/\s+/', ' ', $msg), 0, 100, ''));

        $report = implode("\n", [
            '### ' . get_class($main),
            '',
            '> ' . preg_replace('/\s+/', ' ', $msg !== '' ? $msg : $statusText),
            '',
            '- **Error ID:** ' . $errorId,
            '- **Status:** ' . $code,
            '- **Location:** `' . $relMain . ':' . $main->getLine() . '`',
            '- **Request:** ' . $method . ' ' . $req->url(),
            '- **Laravel:** ' . app()->version() . ' · **PHP:** ' . PHP_VERSION,
            '- **Environment:** ' . app()->environment(),
            '- **Time:** ' . $now,
            '',
            '```',
            collect($frames)->take(12)->map(fn ($f) => '#' . $f['i'] . ' ' . $f['rel'] . ($f['line'] ? ':' . $f['line'] : '') . ' ' . $f['label'])->implode("\n"),
            '```',
        ]);
    }

    $tabs = [
        'trace'   => ['Stack Trace', count($frames)],
        'request' => ['Request', null],
        'headers' => ['Headers', count($headerRows)],
        'session' => ['Session & Cookies', count($sessionRows) + count($cookieRows)],
        'env'     => ['Environment', null],
    ];
    $panels = [
        'request' => [
            ['title' => 'Request', 'rows' => $reqRows],
            ['title' => 'Query Parameters', 'rows' => $queryRows],
            ['title' => 'Input', 'rows' => $inputRows],
            ['title' => 'Uploaded Files', 'rows' => $fileRows],
        ],
        'headers' => [
            ['title' => 'Request Headers', 'rows' => $headerRows],
        ],
        'session' => [
            ['title' => 'Session', 'rows' => $sessionRows],
            ['title' => 'Cookies', 'rows' => $cookieRows],
        ],
        'env' => [
            ['title' => 'Environment', 'rows' => $envRows],
        ],
    ];
    if ($queryLogRows) {
        $tabs['queries'] = ['Queries', count($queryLogRows)];
        $panels['queries'] = [['title' => 'Executed Queries', 'rows' => $queryLogRows]];
    }

    $js = [
        'report'  => $report,
        'trace'   => $traceText,
        'message' => $msg !== '' ? $msg : $statusText,
        'id'      => $errorId,
        'sql'     => (string) $sql,
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $code }} | RJ Nexus — {{ $debug ? 'System Error' : $statusTitle }}</title>
    <script>
        try {
            var t = localStorage.getItem('rj-theme');
            document.documentElement.setAttribute('data-theme', t === 'light' ? 'light' : 'dark');
        } catch (e) {}
    </script>
    <style>
        :root, [data-theme="dark"] {
            --bg: #070a12;
            --card: rgba(15, 21, 36, .78);
            --line: rgba(255, 255, 255, .08);
            --line2: rgba(255, 255, 255, .15);
            --fg: #e5e7eb;
            --mut: #9ca3af;
            --dim: #6b7280;
            --acc: #8b5cf6;
            --acc2: #ec4899;
            --ok: #34d399;
            --bad: #f87171;
            --warn: #fbbf24;
            --code: rgba(2, 6, 16, .62);
            --hover: rgba(255, 255, 255, .05);
            color-scheme: dark;
        }
        [data-theme="light"] {
            --bg: #f4f5fa;
            --card: rgba(255, 255, 255, .9);
            --line: rgba(15, 23, 42, .1);
            --line2: rgba(15, 23, 42, .18);
            --fg: #0f172a;
            --mut: #475569;
            --dim: #64748b;
            --code: #f1f5f9;
            --hover: rgba(15, 23, 42, .05);
            color-scheme: light;
        }

        * { box-sizing: border-box; }
        [hidden] { display: none !important; }
        html { -webkit-text-size-adjust: 100%; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg);
            color: var(--fg);
            font: 14px/1.55 -apple-system, BlinkMacSystemFont, 'Segoe UI', Inter, Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        a { color: inherit; }
        code, pre, .mono { font-family: ui-monospace, SFMono-Regular, 'JetBrains Mono', Menlo, Consolas, monospace; }
        ::selection { background: var(--acc); color: #fff; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--line2); border-radius: 4px; }

        .rj-bg { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .rj-bg::before {
            content: "";
            position: absolute;
            inset: -48px 0 0;
            background-image: linear-gradient(var(--line) 1px, transparent 1px), linear-gradient(90deg, var(--line) 1px, transparent 1px);
            background-size: 48px 48px;
            -webkit-mask-image: radial-gradient(ellipse at 50% 15%, #000, transparent 72%);
            mask-image: radial-gradient(ellipse at 50% 15%, #000, transparent 72%);
            animation: rj-grid 24s linear infinite;
        }
        .rj-bg i { position: absolute; border-radius: 50%; filter: blur(70px); animation: rj-drift 14s ease-in-out infinite alternate; }
        .rj-bg .o1 { top: -140px; left: -100px; width: 420px; height: 420px; background: rgba(139, 92, 246, .22); }
        .rj-bg .o2 { right: -120px; bottom: -140px; width: 460px; height: 460px; background: rgba(236, 72, 153, .16); animation-delay: -6s; }
        .rj-above { position: relative; z-index: 1; }

        .rj-wrap { width: 100%; max-width: 1240px; margin: 0 auto; padding: 0 16px; }
        .rj-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            -webkit-backdrop-filter: blur(14px);
            backdrop-filter: blur(14px);
        }
        .rj-pad { padding: 18px; }

        .rj-banner {
            position: relative;
            z-index: 60;
            background: linear-gradient(90deg, #6d28d9, #db2777, #6d28d9);
            background-size: 200% 100%;
            color: #fff;
            animation: rj-hue 6s linear infinite;
        }
        .rj-banner-in {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px 16px;
            max-width: 1240px;
            margin: 0 auto;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }
        .rj-banner-t { display: inline-flex; align-items: center; gap: 8px; }
        .rj-banner-t svg { width: 16px; height: 16px; fill: #fde047; animation: rj-twinkle 1.8s ease-in-out infinite; }
        .rj-star {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 999px;
            background: #fff;
            color: #111827;
            font-weight: 800;
            text-decoration: none;
            box-shadow: 0 10px 24px -10px rgba(0, 0, 0, .55);
            transition: transform .18s;
        }
        .rj-star:hover { transform: translateY(-2px) scale(1.03); }
        .rj-star::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: -60%;
            width: 40%;
            background: linear-gradient(100deg, transparent, rgba(139, 92, 246, .35), transparent);
            transform: skewX(-20deg);
            animation: rj-shine 3s ease-in-out infinite;
        }
        .rj-star svg { width: 16px; height: 16px; }
        .rj-star .st { fill: #f59e0b; animation: rj-twinkle 1.8s ease-in-out infinite; }

        .rj-head {
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid var(--line);
            background: color-mix(in srgb, var(--bg) 78%, transparent);
            -webkit-backdrop-filter: blur(14px);
            backdrop-filter: blur(14px);
        }
        .rj-head-in { display: flex; align-items: center; gap: 12px; height: 60px; }
        .rj-brand { display: inline-flex; align-items: center; text-decoration: none; }
        .rj-brand img { height: 30px; width: auto; display: block; }
        [data-theme="dark"] .rj-brand img { filter: brightness(0) invert(1); }
        .rj-brand-fb {
            display: none;
            align-items: center;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -.02em;
            background: linear-gradient(135deg, var(--acc), var(--acc2));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .rj-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 3px 10px;
            border: 1px solid rgba(248, 113, 113, .3);
            border-radius: 999px;
            background: rgba(248, 113, 113, .1);
            color: var(--bad);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .rj-badge i { width: 7px; height: 7px; border-radius: 50%; background: var(--bad); animation: rj-ping 1.6s ease-out infinite; }
        .rj-sp { flex: 1; }
        .rj-ver { display: flex; align-items: center; gap: 10px; color: var(--mut); font-size: 13px; font-weight: 500; white-space: nowrap; }
        .rj-ver i { width: 4px; height: 4px; border-radius: 50%; background: var(--dim); }
        .rj-ico {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            padding: 0;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--hover);
            color: var(--fg);
            cursor: pointer;
            transition: border-color .2s, transform .15s;
            -webkit-tap-highlight-color: transparent;
        }
        .rj-ico:hover { border-color: var(--acc); transform: translateY(-1px); }
        .rj-ico svg { width: 18px; height: 18px; }
        .rj-sun { display: none; }
        [data-theme="light"] .rj-sun { display: block; }
        [data-theme="light"] .rj-moon { display: none; }

        .rj-main { flex: 1; width: 100%; max-width: 1240px; margin: 0 auto; padding: 22px 16px 34px; }
        .rj-stack > * + * { margin-top: 18px; }

        .rj-hero {
            position: relative;
            overflow: hidden;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr);
            gap: clamp(18px, 4vw, 44px);
            align-items: center;
            padding: clamp(20px, 4vw, 38px) clamp(18px, 4vw, 38px) clamp(46px, 7vw, 64px);
        }
        .rj-hero::before {
            content: "";
            position: absolute;
            top: -90px;
            right: -90px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(248, 113, 113, .22), transparent 65%);
            pointer-events: none;
        }
        .rj-hero::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: -90px;
            height: 90px;
            background: linear-gradient(180deg, transparent, rgba(139, 92, 246, .14), transparent);
            animation: rj-scan 6s linear infinite;
            pointer-events: none;
        }
        .rj-hero-code { position: relative; z-index: 1; text-align: center; }
        .rj-code {
            position: relative;
            font-size: clamp(72px, 16vw, 150px);
            font-weight: 900;
            line-height: .92;
            letter-spacing: -.04em;
            user-select: none;
        }
        .rj-code span {
            display: block;
            background: linear-gradient(135deg, var(--acc), var(--acc2) 65%, #f97316);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
            animation: rj-float 5s ease-in-out infinite;
        }
        .rj-code::before, .rj-code::after {
            content: attr(data-text);
            position: absolute;
            inset: 0;
            opacity: 0;
            pointer-events: none;
            mix-blend-mode: screen;
        }
        .rj-code::before { color: #22d3ee; animation: rj-g1 5s steps(1, end) infinite; }
        .rj-code::after { color: #f43f5e; animation: rj-g2 5s steps(1, end) infinite; }
        .rj-cap { margin-top: 8px; color: var(--mut); font-size: 12px; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; }

        .rj-hero-body { position: relative; z-index: 1; min-width: 0; }
        .rj-chips { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-bottom: 12px; }
        .rj-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            max-width: 100%;
            padding: 4px 10px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--hover);
            color: var(--mut);
            font-size: 12px;
            font-weight: 600;
        }
        .rj-chip b { color: var(--fg); }
        .rj-chip.is-class { overflow: hidden; color: var(--fg); text-overflow: ellipsis; white-space: nowrap; }
        .rj-chip.m-get { color: var(--ok); }
        .rj-chip.m-post { color: var(--warn); }
        .rj-chip.m-put, .rj-chip.m-patch { color: #60a5fa; }
        .rj-chip.m-delete { color: var(--bad); }
        .rj-msg { margin: 0 0 12px; font-size: clamp(19px, 3vw, 27px); font-weight: 800; line-height: 1.3; letter-spacing: -.01em; overflow-wrap: anywhere; }
        .rj-loc { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; color: var(--mut); font-size: 12.5px; }
        .rj-loc a { color: var(--acc); text-decoration: none; word-break: break-all; }
        .rj-loc a:hover { text-decoration: underline; }
        .rj-row-btns { display: flex; flex-wrap: wrap; gap: 8px; }

        .rj-ekg { position: absolute; left: 0; right: 0; bottom: 0; width: 100%; height: 38px; opacity: .8; pointer-events: none; }
        .rj-ekg path { fill: none; stroke: url(#rj-g); stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; stroke-dasharray: 1800; stroke-dashoffset: 1800; animation: rj-draw 4.5s linear infinite; }

        .rj-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            border: 1px solid var(--line2);
            border-radius: 12px;
            background: var(--hover);
            color: var(--fg);
            font: inherit;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform .15s, border-color .2s, box-shadow .2s;
            -webkit-tap-highlight-color: transparent;
        }
        .rj-btn:hover { border-color: var(--acc); transform: translateY(-1px); }
        .rj-btn:active { transform: scale(.98); }
        .rj-btn svg { width: 16px; height: 16px; flex-shrink: 0; }
        .rj-btn.primary { border-color: transparent; background: linear-gradient(135deg, var(--acc), var(--acc2)); color: #fff; box-shadow: 0 12px 24px -14px var(--acc); }
        .rj-btn.sm { padding: 7px 12px; border-radius: 10px; font-size: 12.5px; }

        .rj-grid { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 18px; align-items: start; }
        .rj-h { display: flex; align-items: center; gap: 8px; margin: 0 0 12px; color: var(--mut); font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .rj-h svg { width: 16px; height: 16px; color: var(--warn); }

        .rj-hint + .rj-hint { margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--line); }
        .rj-hint b { display: block; margin-bottom: 2px; font-size: 14.5px; }
        .rj-hint p { margin: 0 0 8px; color: var(--mut); }
        .rj-cmd {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            max-width: 100%;
            padding: 7px 12px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--code);
            color: var(--ok);
            font-size: 12.5px;
            text-align: left;
            word-break: break-all;
            cursor: pointer;
        }
        .rj-cmd:hover { border-color: var(--acc); }
        .rj-cmd svg { width: 14px; height: 14px; flex-shrink: 0; color: var(--dim); }
        .rj-pre {
            margin: 0;
            padding: 14px;
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--code);
            color: var(--warn);
            font-size: 12.5px;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .rj-chain + .rj-chain { margin-top: 10px; padding-top: 10px; border-top: 1px dashed var(--line); }
        .rj-chain b { display: block; word-break: break-all; }
        .rj-chain p { margin: 2px 0; color: var(--mut); overflow-wrap: anywhere; }
        .rj-chain small { color: var(--dim); word-break: break-all; }

        .rj-tabs { display: flex; gap: 4px; padding: 8px 8px 0; overflow-x: auto; border-bottom: 1px solid var(--line); -webkit-overflow-scrolling: touch; }
        .rj-tab {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 14px;
            border: 0;
            border-bottom: 2px solid transparent;
            background: transparent;
            color: var(--mut);
            font: inherit;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            transition: color .2s, border-color .2s;
            -webkit-tap-highlight-color: transparent;
        }
        .rj-tab:hover { color: var(--fg); }
        .rj-tab.is-active { border-bottom-color: var(--acc); color: var(--acc); }
        .rj-tab em { padding: 0 7px; border-radius: 999px; background: var(--hover); color: var(--dim); font-size: 11px; font-style: normal; font-weight: 700; }
        .rj-panel { padding: 18px; animation: rj-in .35s ease both; }

        .rj-tools { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-bottom: 14px; }
        .rj-search { position: relative; flex: 1 1 200px; min-width: 0; }
        .rj-search svg { position: absolute; top: 50%; left: 11px; width: 15px; height: 15px; transform: translateY(-50%); color: var(--dim); pointer-events: none; }
        .rj-search input {
            width: 100%;
            padding: 9px 12px 9px 34px;
            border: 1px solid var(--line2);
            border-radius: 10px;
            background: var(--code);
            color: var(--fg);
            font: inherit;
            outline: 0;
        }
        .rj-search input:focus { border-color: var(--acc); box-shadow: 0 0 0 3px color-mix(in srgb, var(--acc) 18%, transparent); }
        .rj-check { display: inline-flex; align-items: center; gap: 7px; color: var(--mut); font-size: 12.5px; cursor: pointer; user-select: none; }
        .rj-check input { width: 15px; height: 15px; margin: 0; accent-color: var(--acc); }
        .rj-meta { color: var(--dim); font-size: 12px; }

        .rj-frame { margin-bottom: 8px; overflow: hidden; border: 1px solid var(--line); border-radius: 12px; background: var(--code); transition: border-color .2s; }
        .rj-frame:hover, .rj-frame[open] { border-color: color-mix(in srgb, var(--acc) 42%, transparent); }
        .rj-frame > summary { display: flex; align-items: center; gap: 10px; padding: 10px 12px; list-style: none; cursor: pointer; }
        .rj-frame > summary::-webkit-details-marker { display: none; }
        .rj-frame > summary::after {
            content: "";
            flex-shrink: 0;
            width: 7px;
            height: 7px;
            margin: 0 4px 0 auto;
            border-right: 2px solid var(--dim);
            border-bottom: 2px solid var(--dim);
            transform: rotate(45deg);
            transition: transform .2s;
        }
        .rj-frame[open] > summary::after { transform: rotate(-135deg); }
        .rj-fi { flex-shrink: 0; min-width: 28px; color: var(--acc); font-size: 12px; font-weight: 800; }
        .rj-fm { min-width: 0; }
        .rj-fm b { display: block; font-size: 12.5px; font-weight: 600; overflow-wrap: anywhere; }
        .rj-fm small { display: block; color: var(--dim); font-size: 11.5px; overflow-wrap: anywhere; }
        .is-vendor .rj-fm b { color: var(--mut); font-weight: 500; }
        .rj-tag { flex-shrink: 0; padding: 1px 8px; border-radius: 6px; background: var(--hover); color: var(--dim); font-size: 10px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .is-app .rj-tag { background: color-mix(in srgb, var(--acc) 16%, transparent); color: var(--acc); }
        .rj-fb { border-top: 1px solid var(--line); }
        .rj-snip { overflow-x: auto; padding: 8px 0; font-size: 12.5px; line-height: 1.7; }
        .rj-snip-in { display: inline-block; min-width: 100%; }
        .rj-ln { display: flex; min-width: max-content; }
        .rj-ln .n { flex: 0 0 54px; padding-right: 14px; color: var(--dim); text-align: right; user-select: none; }
        .rj-ln code { min-height: 1.7em; padding-right: 18px; white-space: pre; tab-size: 4; }
        .rj-ln.is-err { background: rgba(248, 113, 113, .14); box-shadow: inset 3px 0 0 var(--bad); }
        .rj-ln.is-err .n { color: var(--bad); font-weight: 700; }
        .rj-fa { display: flex; flex-wrap: wrap; gap: 8px; padding: 10px 12px; border-top: 1px solid var(--line); }
        .rj-nosnip { padding: 12px; color: var(--dim); font-size: 12.5px; }

        .rj-sec + .rj-sec { margin-top: 22px; }
        .rj-sh { display: flex; align-items: center; gap: 8px; margin: 0 0 10px; color: var(--mut); font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .rj-sh span { padding: 0 7px; border-radius: 999px; background: var(--hover); color: var(--dim); font-size: 11px; letter-spacing: 0; }
        .rj-kv { overflow: hidden; border: 1px solid var(--line); border-radius: 12px; }
        .rj-row { display: grid; grid-template-columns: minmax(110px, 210px) minmax(0, 1fr); gap: 14px; padding: 9px 14px; }
        .rj-row + .rj-row { border-top: 1px solid var(--line); }
        .rj-row:nth-child(even) { background: var(--hover); }
        .rj-row .k { color: var(--mut); font-size: 12.5px; word-break: break-all; }
        .rj-row .v { font-size: 12.5px; white-space: pre-wrap; word-break: break-word; }
        .rj-empty { padding: 14px; border: 1px dashed var(--line2); border-radius: 12px; color: var(--dim); text-align: center; }

        .rj-side > * + * { margin-top: 18px; }
        .rj-mini .rj-row { grid-template-columns: 96px minmax(0, 1fr); padding: 8px 0; background: transparent; }
        .rj-mini .rj-row + .rj-row { border-top: 1px solid var(--line); }
        .rj-mini .rj-row:nth-child(even) { background: transparent; }
        .rj-mini .rj-row .k { font-size: 12px; }
        .rj-actions { display: grid; gap: 10px; }
        .rj-links { display: grid; gap: 8px; }
        .rj-links .rj-btn { justify-content: flex-start; }

        .rj-center { position: relative; z-index: 1; flex: 1; display: grid; place-items: center; padding: 28px 16px; }
        .rj-public { position: relative; overflow: hidden; width: 100%; max-width: 560px; padding: 36px 28px 64px; text-align: center; }
        .rj-public .rj-brand { margin-bottom: 18px; }
        .rj-public h1 { margin: 6px 0 8px; font-size: 24px; font-weight: 800; letter-spacing: -.01em; }
        .rj-public p { margin: 0 auto 18px; max-width: 420px; color: var(--mut); }
        .rj-public .rj-chips { justify-content: center; }
        .rj-public .rj-actions { grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); margin-top: 20px; }
        .rj-retry { display: inline-flex; align-items: center; gap: 12px; margin-top: 4px; padding: 8px 14px; border: 1px solid var(--line); border-radius: 12px; background: var(--hover); color: var(--mut); font-size: 13px; }
        .rj-retry b { color: var(--acc); }
        .rj-retry button { padding: 0; border: 0; background: none; color: var(--fg); font: inherit; font-weight: 700; text-decoration: underline; cursor: pointer; }

        .rj-foot { position: relative; z-index: 1; padding: 20px 16px; border-top: 1px solid var(--line); color: var(--dim); font-size: 13px; text-align: center; }

        .rj-toast {
            position: fixed;
            left: 50%;
            bottom: 22px;
            z-index: 100;
            padding: 9px 18px;
            border-radius: 999px;
            background: #111827;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            opacity: 0;
            transform: translate(-50%, 14px);
            pointer-events: none;
            transition: opacity .2s, transform .2s;
            box-shadow: 0 14px 30px -12px rgba(0, 0, 0, .6);
        }
        .rj-toast.is-on { opacity: 1; transform: translate(-50%, 0); }

        @keyframes rj-grid { to { transform: translateY(48px); } }
        @keyframes rj-drift { to { transform: translate(60px, 40px) scale(1.12); } }
        @keyframes rj-hue { to { background-position: 200% 0; } }
        @keyframes rj-twinkle { 50% { transform: scale(1.25) rotate(14deg); } }
        @keyframes rj-shine { 0%, 55% { left: -60%; } 100% { left: 130%; } }
        @keyframes rj-ping { 0% { box-shadow: 0 0 0 0 rgba(248, 113, 113, .6); } 100% { box-shadow: 0 0 0 9px rgba(248, 113, 113, 0); } }
        @keyframes rj-scan { to { transform: translateY(560px); } }
        @keyframes rj-float { 50% { transform: translateY(-6px); } }
        @keyframes rj-draw { to { stroke-dashoffset: 0; } }
        @keyframes rj-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
        @keyframes rj-g1 {
            0%, 85%, 100% { opacity: 0; transform: none; clip-path: inset(0); }
            87% { opacity: .85; transform: translate(-5px, 1px); clip-path: inset(8% 0 62% 0); }
            90% { opacity: .85; transform: translate(4px, -1px); clip-path: inset(56% 0 12% 0); }
            93% { opacity: .85; transform: translate(-3px, 0); clip-path: inset(30% 0 40% 0); }
        }
        @keyframes rj-g2 {
            0%, 86%, 100% { opacity: 0; transform: none; clip-path: inset(0); }
            88% { opacity: .85; transform: translate(5px, -1px); clip-path: inset(46% 0 22% 0); }
            91% { opacity: .85; transform: translate(-4px, 1px); clip-path: inset(10% 0 66% 0); }
            94% { opacity: .85; transform: translate(3px, 0); clip-path: inset(64% 0 8% 0); }
        }

        @media (max-width: 980px) {
            .rj-grid { grid-template-columns: minmax(0, 1fr); }
        }
        @media (max-width: 760px) {
            .rj-hero { grid-template-columns: minmax(0, 1fr); text-align: center; }
            .rj-hero .rj-chips, .rj-hero .rj-loc, .rj-hero .rj-row-btns { justify-content: center; }
            .rj-ver { display: none; }
        }
        @media (max-width: 560px) {
            .rj-main { padding: 14px 10px 26px; }
            .rj-wrap { padding: 0 10px; }
            .rj-banner-in { font-size: 12px; padding: 8px 12px; }
            .rj-badge { font-size: 10px; padding: 3px 8px; }
            .rj-panel { padding: 14px 12px; }
            .rj-row { grid-template-columns: minmax(0, 1fr); gap: 2px; padding: 9px 12px; }
            .rj-mini .rj-row { grid-template-columns: 84px minmax(0, 1fr); gap: 10px; }
            .rj-ln .n { flex-basis: 42px; padding-right: 10px; }
            .rj-public { padding: 28px 18px 60px; }
            .rj-fa .rj-btn { flex: 1 1 auto; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition-duration: .01ms !important; }
            .rj-ekg path { stroke-dashoffset: 0; }
        }
    </style>
</head>
<body class="{{ $debug ? 'is-debug' : 'is-public' }}">

    <div class="rj-bg" aria-hidden="true"><i class="o1"></i><i class="o2"></i></div>

    @if($debug)
        <div class="rj-banner rj-above">
            <div class="rj-banner-in">
                <span class="rj-banner-t">
                    <svg viewBox="0 0 24 24"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/></svg>
                    Enjoying RJ Nexus? Support the project with a star on GitHub.
                </span>
                <a class="rj-star" href="{{ $githubUrl }}" target="_blank" rel="noopener noreferrer">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    Star on GitHub
                    <svg class="st" viewBox="0 0 24 24"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/></svg>
                </a>
            </div>
        </div>

        <header class="rj-head rj-above">
            <div class="rj-wrap rj-head-in">
                <a class="rj-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="RJ Nexus" onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex'">
                    <span class="rj-brand-fb">RJ Nexus</span>
                </a>
                <span class="rj-badge"><i></i>Debug Mode</span>
                <div class="rj-sp"></div>
                <div class="rj-ver"><span>Laravel {{ app()->version() }}</span><i></i><span>PHP {{ PHP_VERSION }}</span></div>
                <a class="rj-ico" href="{{ $githubUrl }}" target="_blank" rel="noopener noreferrer" title="GitHub" aria-label="GitHub">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                </a>
                <button type="button" class="rj-ico" data-action="theme" title="Toggle theme" aria-label="Toggle theme">
                    <svg class="rj-moon" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 12.8A9 9 0 1111.2 3a7 7 0 009.8 9.8z"/></svg>
                    <svg class="rj-sun" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
                </button>
            </div>
        </header>

        <main class="rj-main rj-above">
            <div class="rj-stack">

                <section class="rj-card rj-hero">
                    <div class="rj-hero-code">
                        <div class="rj-code" data-text="{{ $code }}"><span>{{ $code }}</span></div>
                        <div class="rj-cap">{{ $statusTitle }}</div>
                    </div>

                    <div class="rj-hero-body">
                        <div class="rj-chips">
                            <span class="rj-chip is-class mono" title="{{ get_class($main) }}">{{ get_class($main) }}</span>
                            <span class="rj-chip m-{{ strtolower($method) }}">{{ $method }}</span>
                            <span class="rj-chip">ID <b class="mono">{{ $errorId }}</b></span>
                        </div>
                        <h1 class="rj-msg">{{ $msg !== '' ? $msg : $statusText }}</h1>
                        <div class="rj-loc mono">
                            <span>in</span>
                            @if($editorUrl)
                                <a href="{{ $editorUrl }}" title="Open in VS Code">{{ $relMain }}:{{ $main->getLine() }}</a>
                            @else
                                <span>{{ $relMain }}:{{ $main->getLine() }}</span>
                            @endif
                        </div>
                        <div class="rj-row-btns">
                            <button type="button" class="rj-btn sm" data-copy="message">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 012-2h10"/></svg>
                                Copy message
                            </button>
                            <button type="button" class="rj-btn sm" data-copy="report">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg>
                                Copy report
                            </button>
                            <button type="button" class="rj-btn sm" data-copy="trace">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 18l6-6-6-6M8 6l-6 6 6 6"/></svg>
                                Copy trace
                            </button>
                            @if($editorUrl)
                                <a class="rj-btn sm" href="{{ $editorUrl }}">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                                    Open in editor
                                </a>
                            @endif
                        </div>
                    </div>

                    <svg class="rj-ekg" viewBox="0 0 1200 40" preserveAspectRatio="none" aria-hidden="true">
                        <defs>
                            <linearGradient id="rj-g" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0" stop-color="#8b5cf6"/>
                                <stop offset="1" stop-color="#ec4899"/>
                            </linearGradient>
                        </defs>
                        <path vector-effect="non-scaling-stroke" d="M0 20 H260 l12 -16 l14 34 l14 -30 l10 12 H600 l12 -16 l14 34 l14 -30 l10 12 H960 l12 -16 l14 34 l14 -30 l10 12 H1200"/>
                    </svg>
                </section>

                <div class="rj-grid">
                    <div class="rj-stack">

                        <section class="rj-card rj-pad">
                            <h2 class="rj-h">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 18h6M10 22h4M12 2a7 7 0 00-4 12.7c.6.5 1 1.3 1 2.1V17h6v-.2c0-.8.4-1.6 1-2.1A7 7 0 0012 2z"/></svg>
                                Possible fix
                            </h2>
                            @foreach($hints as $h)
                                <div class="rj-hint">
                                    <b>{{ $h[0] }}</b>
                                    <p>{{ $h[1] }}</p>
                                    @if(!empty($h[2]))
                                        <button type="button" class="rj-cmd mono" data-copy-text="{{ $h[2] }}">
                                            <span>$ {{ $h[2] }}</span>
                                            <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 012-2h10"/></svg>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </section>

                        @if($sql)
                            <section class="rj-card rj-pad">
                                <h2 class="rj-h">SQL <button type="button" class="rj-btn sm" data-copy="sql" style="margin-left:auto;text-transform:none;letter-spacing:0">Copy</button></h2>
                                <pre class="rj-pre mono">{{ $sql }}</pre>
                            </section>
                        @endif

                        @if(count($chain))
                            <section class="rj-card rj-pad">
                                <h2 class="rj-h">Caused by</h2>
                                @foreach($chain as $c)
                                    <div class="rj-chain">
                                        <b class="mono">{{ $c[0] }}</b>
                                        <p>{{ $c[1] !== '' ? $c[1] : '—' }}</p>
                                        <small class="mono">{{ $c[2] }}</small>
                                    </div>
                                @endforeach
                            </section>
                        @endif

                        <section class="rj-card">
                            <div class="rj-tabs" role="tablist">
                                @foreach($tabs as $id => $tab)
                                    <button type="button" role="tab" class="rj-tab {{ $loop->first ? 'is-active' : '' }}" data-tab="{{ $id }}">
                                        {{ $tab[0] }}
                                        @if($tab[1] !== null)<em>{{ $tab[1] }}</em>@endif
                                    </button>
                                @endforeach
                            </div>

                            <div class="rj-panel" data-panel="trace">
                                <div class="rj-tools">
                                    <label class="rj-search">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                                        <input type="search" id="rj-q" placeholder="Filter frames  ( / )" autocomplete="off">
                                    </label>
                                    <label class="rj-check"><input type="checkbox" id="rj-hv" {{ $appCount > 0 ? 'checked' : '' }}> Hide vendor</label>
                                    <button type="button" class="rj-btn sm" data-expand="open">Expand</button>
                                    <button type="button" class="rj-btn sm" data-expand="close">Collapse</button>
                                    <span class="rj-meta"><span id="rj-count">{{ count($frames) }}</span> frames · {{ $appCount }} app · {{ $vendorCount }} vendor</span>
                                </div>

                                @foreach($frames as $f)
                                    <details class="rj-frame {{ $f['vendor'] ? 'is-vendor' : 'is-app' }}" {{ $f['i'] === $firstOpen ? 'open' : '' }} data-search="{{ strtolower($f['rel'] . ' ' . $f['label'] . ' ' . $f['line']) }}">
                                        <summary>
                                            <span class="rj-fi mono">#{{ $f['i'] }}</span>
                                            <span class="rj-fm">
                                                <b class="mono">{{ $f['label'] }}</b>
                                                <small class="mono">{{ $f['rel'] }}{{ $f['line'] ? ':' . $f['line'] : '' }}</small>
                                            </span>
                                            <span class="rj-tag">{{ $f['vendor'] ? 'vendor' : 'app' }}</span>
                                        </summary>
                                        <div class="rj-fb">
                                            @if($f['snip'])
                                                <div class="rj-snip mono">
                                                    <div class="rj-snip-in">
                                                        @foreach($f['snip'] as $n => $text)
                                                            <div class="rj-ln {{ $n === $f['line'] ? 'is-err' : '' }}"><span class="n">{{ $n }}</span><code>{{ str_replace("\t", '    ', $text) }}</code></div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="rj-nosnip">Source code is not available for this frame.</div>
                                            @endif
                                            @if($f['file'])
                                                <div class="rj-fa">
                                                    <button type="button" class="rj-btn sm" data-copy-text="{{ $f['file'] }}{{ $f['line'] ? ':' . $f['line'] : '' }}">Copy path</button>
                                                    <a class="rj-btn sm" href="vscode://file/{{ str_replace('\\', '/', $f['file']) }}:{{ $f['line'] }}">Open in editor</a>
                                                </div>
                                            @endif
                                        </div>
                                    </details>
                                @endforeach
                            </div>

                            @foreach($panels as $pid => $sections)
                                <div class="rj-panel" data-panel="{{ $pid }}" hidden>
                                    @foreach($sections as $sec)
                                        <div class="rj-sec">
                                            <h3 class="rj-sh">{{ $sec['title'] }} <span>{{ count($sec['rows']) }}</span></h3>
                                            @if(count($sec['rows']))
                                                <div class="rj-kv">
                                                    @foreach($sec['rows'] as $r)
                                                        <div class="rj-row">
                                                            <div class="k mono">{{ $r[0] }}</div>
                                                            <div class="v mono">{{ $r[1] }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="rj-empty">No data</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </section>
                    </div>

                    <aside class="rj-side">
                        <section class="rj-card rj-pad rj-mini">
                            <h2 class="rj-h">Request</h2>
                            <div class="rj-row"><div class="k">Method</div><div class="v mono">{{ $method }}</div></div>
                            <div class="rj-row"><div class="k">URL</div><div class="v mono">{{ $req->fullUrl() }}</div></div>
                            <div class="rj-row"><div class="k">IP</div><div class="v mono">{{ $req->ip() }}</div></div>
                            <div class="rj-row"><div class="k">User</div><div class="v">{{ $userLabel }}</div></div>
                            <div class="rj-row"><div class="k">Time</div><div class="v mono">{{ $now }}</div></div>
                        </section>

                        <section class="rj-card rj-pad rj-mini">
                            <h2 class="rj-h">Environment</h2>
                            <div class="rj-row"><div class="k">App env</div><div class="v mono">{{ app()->environment() }}</div></div>
                            <div class="rj-row"><div class="k">Debug</div><div class="v mono" style="color:var(--bad)">TRUE</div></div>
                            <div class="rj-row"><div class="k">Timezone</div><div class="v mono">{{ config('app.timezone') }}</div></div>
                            <div class="rj-row"><div class="k">Memory</div><div class="v mono">{{ $memory }}</div></div>
                            <div class="rj-row"><div class="k">Duration</div><div class="v mono">{{ $elapsed }}</div></div>
                        </section>

                        <div class="rj-actions">
                            <a href="{{ url('/') }}" class="rj-btn primary">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                                Return Home
                            </a>
                            <button type="button" class="rj-btn" data-action="back">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                                Go Back
                            </button>
                            <button type="button" class="rj-btn" data-action="reload">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 12a9 9 0 11-3-6.7M21 4v5h-5"/></svg>
                                Reload
                            </button>
                            <a href="{{ $supportUrl }}" target="_blank" rel="noopener noreferrer" class="rj-btn">
                                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                Get Support
                            </a>
                        </div>

                        <section class="rj-card rj-pad">
                            <h2 class="rj-h">Search this error</h2>
                            <div class="rj-links">
                                <a class="rj-btn sm" href="{{ $google }}" target="_blank" rel="noopener noreferrer">Google</a>
                                <a class="rj-btn sm" href="{{ $so }}" target="_blank" rel="noopener noreferrer">Stack Overflow</a>
                                <a class="rj-btn sm" href="{{ $ghIssues }}" target="_blank" rel="noopener noreferrer">Laravel issues</a>
                            </div>
                        </section>
                    </aside>
                </div>
            </div>
        </main>

        <footer class="rj-foot">
            RJ Nexus &copy; {{ date('Y') }} — Built with Laravel. All rights reserved.
        </footer>
    @else
        <main class="rj-center">
            <section class="rj-card rj-public">
                <a class="rj-brand" href="{{ url('/') }}" style="justify-content:center">
                    <img src="{{ asset('images/logo.svg') }}" alt="RJ Nexus" onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex'">
                    <span class="rj-brand-fb">RJ Nexus</span>
                </a>

                <div class="rj-code" data-text="{{ $code }}"><span>{{ $code }}</span></div>
                <h1>{{ $statusTitle }}</h1>
                <p>{{ $statusText }}</p>

                <div class="rj-chips">
                    <span class="rj-chip">Reference <b class="mono">{{ $errorId }}</b></span>
                    <button type="button" class="rj-btn sm" data-copy="id">Copy</button>
                </div>

                @if(in_array($code, [429, 503], true))
                    <div class="rj-retry" data-retry="20">
                        <span>Retrying in <b>20</b>s</span>
                        <button type="button" data-retry-cancel>Cancel</button>
                    </div>
                @endif

                <div class="rj-actions">
                    <a href="{{ url('/') }}" class="rj-btn primary">Return Home</a>
                    <button type="button" class="rj-btn" data-action="back">Go Back</button>
                    <button type="button" class="rj-btn" data-action="reload">Reload</button>
                </div>

                <svg class="rj-ekg" viewBox="0 0 1200 40" preserveAspectRatio="none" aria-hidden="true">
                    <defs>
                        <linearGradient id="rj-g" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0" stop-color="#8b5cf6"/>
                            <stop offset="1" stop-color="#ec4899"/>
                        </linearGradient>
                    </defs>
                    <path vector-effect="non-scaling-stroke" d="M0 20 H260 l12 -16 l14 34 l14 -30 l10 12 H600 l12 -16 l14 34 l14 -30 l10 12 H960 l12 -16 l14 34 l14 -30 l10 12 H1200"/>
                </svg>
            </section>
        </main>

        <footer class="rj-foot">
            RJ Nexus &copy; {{ date('Y') }} — All rights reserved.
        </footer>
    @endif

    <div class="rj-toast" id="rj-toast" role="status" aria-live="polite"></div>

    <script>
    (function () {
        var D = @js($js);
        var root = document.documentElement;
        var toastEl = document.getElementById('rj-toast');
        var toastT = 0;

        function toast(m) {
            if (!toastEl) return;
            toastEl.textContent = m;
            toastEl.classList.add('is-on');
            clearTimeout(toastT);
            toastT = setTimeout(function () { toastEl.classList.remove('is-on'); }, 1600);
        }

        function copy(text) {
            function fallback() {
                var a = document.createElement('textarea');
                a.value = text;
                a.style.cssText = 'position:fixed;top:0;left:0;opacity:0';
                document.body.appendChild(a);
                a.select();
                try { document.execCommand('copy'); toast('Copied'); } catch (e) { toast('Copy failed'); }
                document.body.removeChild(a);
            }
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function () { toast('Copied'); }, fallback);
            } else {
                fallback();
            }
        }

        document.addEventListener('click', function (e) {
            var c = e.target.closest('[data-copy]');
            if (c) { e.preventDefault(); copy(D[c.getAttribute('data-copy')] || ''); return; }

            var t = e.target.closest('[data-copy-text]');
            if (t) { e.preventDefault(); copy(t.getAttribute('data-copy-text')); return; }

            var a = e.target.closest('[data-action]');
            if (!a) return;
            var act = a.getAttribute('data-action');
            if (act === 'back') {
                if (history.length > 1) history.back(); else location.href = '/';
            } else if (act === 'reload') {
                location.reload();
            } else if (act === 'theme') {
                var next = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
                root.setAttribute('data-theme', next);
                try { localStorage.setItem('rj-theme', next); } catch (err) {}
            }
        });

        var tabs = [].slice.call(document.querySelectorAll('.rj-tab'));
        var panels = [].slice.call(document.querySelectorAll('.rj-panel'));

        function show(id) {
            tabs.forEach(function (t) { t.classList.toggle('is-active', t.getAttribute('data-tab') === id); });
            panels.forEach(function (p) { p.hidden = p.getAttribute('data-panel') !== id; });
            try { history.replaceState(null, '', '#' + id); } catch (e) {}
        }
        tabs.forEach(function (t) {
            t.addEventListener('click', function () { show(t.getAttribute('data-tab')); });
        });
        var hash = location.hash.slice(1);
        if (hash && tabs.some(function (t) { return t.getAttribute('data-tab') === hash; })) show(hash);

        var frames = [].slice.call(document.querySelectorAll('.rj-frame'));
        var q = document.getElementById('rj-q');
        var hv = document.getElementById('rj-hv');
        var cnt = document.getElementById('rj-count');

        function filter() {
            var s = q ? q.value.trim().toLowerCase() : '';
            var hide = hv && hv.checked;
            var n = 0;
            frames.forEach(function (f) {
                var ok = (!hide || !f.classList.contains('is-vendor')) && (!s || f.getAttribute('data-search').indexOf(s) > -1);
                f.hidden = !ok;
                if (ok) n++;
            });
            if (cnt) cnt.textContent = n;
        }
        if (q) q.addEventListener('input', filter);
        if (hv) hv.addEventListener('change', filter);
        filter();

        [].slice.call(document.querySelectorAll('[data-expand]')).forEach(function (b) {
            b.addEventListener('click', function () {
                var open = b.getAttribute('data-expand') === 'open';
                frames.forEach(function (f) { if (!f.hidden) f.open = open; });
            });
        });

        document.addEventListener('keydown', function (e) {
            var tag = (document.activeElement && document.activeElement.tagName) || '';
            if (e.key === '/' && q && tag !== 'INPUT' && tag !== 'TEXTAREA') {
                e.preventDefault();
                show('trace');
                q.focus();
                q.select();
            } else if (e.key === 'Escape' && document.activeElement === q) {
                q.blur();
            }
        });

        var retry = document.querySelector('[data-retry]');
        if (retry) {
            var left = parseInt(retry.getAttribute('data-retry'), 10) || 20;
            var num = retry.querySelector('b');
            var timer = setInterval(function () {
                left--;
                if (num) num.textContent = left;
                if (left <= 0) { clearInterval(timer); location.reload(); }
            }, 1000);
            var cancel = retry.querySelector('[data-retry-cancel]');
            if (cancel) cancel.addEventListener('click', function () {
                clearInterval(timer);
                retry.hidden = true;
            });
        }
    })();
    </script>
</body>
</html>
