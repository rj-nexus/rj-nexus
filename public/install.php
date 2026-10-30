<?php
if (session_status() === PHP_SESSION_NONE) session_start();
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

define('RJ_ROOT', dirname(__DIR__));
define('RJ_ENV', RJ_ROOT . '/.env');
define('RJ_ENV_EXAMPLE', RJ_ROOT . '/.env.example');
define('RJ_LOCK', RJ_ROOT . '/storage/installed.lock');
define('RJ_LOG', RJ_ROOT . '/storage/logs/install.log');

if (file_exists(RJ_LOCK)) {
    http_response_code(403);
    rj_html_standalone('RJ Nexus', '<h1>Already Installed</h1><p>Remove <code>storage/installed.lock</code> to reinstall.</p><p><a href="/admin" class="btn">Open Admin</a></p>');
    exit;
}

function rj_languages(): array
{
    return ['en'=>'English','az'=>'Azərbaycan','de'=>'Deutsch','es'=>'Español','fr'=>'Français','pt'=>'Português','ru'=>'Русский','tr'=>'Türkçe'];
}

function rj_t(): array
{
    return [
        'en'=>['title'=>'RJ Nexus Installation','sub'=>'Setup Wizard','next'=>'Next','back'=>'Back','retry'=>'Retry','install'=>'Install Now','delete_installer'=>'Delete Installer & Open Admin','lang'=>'Language','step1'=>'Language','step2'=>'Requirements','step3'=>'Database','step4'=>'Administrator','step5'=>'Install','step6'=>'Finish','ok'=>'OK','fail'=>'FAIL','req_php'=>'PHP 8.2+','req_ext'=>'Required PHP extensions','req_dir'=>'Writable directories','req_btn'=>'All requirements met. Continue','db_host'=>'Database Host','db_port'=>'Port','db_name'=>'Database Name','db_user'=>'Username','db_pass'=>'Password','db_test'=>'Test Connection','db_ok'=>'Connection successful','db_fail'=>'Connection failed','db_continue'=>'Continue','site_name'=>'Site Name','site_url'=>'Site URL','adm_name'=>'Full Name','adm_email'=>'Email Address','adm_pass'=>'Password','adm_pass2'=>'Confirm Password','adm_mismatch'=>'Passwords do not match','adm_continue'=>'Create Admin Account','ins_work'=>'Installing, please wait...','ins_done'=>'Installation complete','fin_title'=>'Setup Complete','fin_sub'=>'Your RJ Nexus site is ready to use.','err_req'=>'Not all requirements are met.','err_db'=>'Database connection failed.','err_admin'=>'Please fill all fields correctly.','err_inst'=>'Installation failed.','err_direct'=>'Please complete previous steps first.'],
        'az'=>['title'=>'RJ Nexus Quraşdırma','sub'=>'Quraşdırma Sehrbazı','next'=>'İrəli','back'=>'Geri','retry'=>'Yenidən','install'=>'Quraşdır','delete_installer'=>'İnstallatoru Sil və Admini Aç','lang'=>'Dil','step1'=>'Dil','step2'=>'Tələblər','step3'=>'Baza','step4'=>'Administrator','step5'=>'Quraşdırma','step6'=>'Bitdi','ok'=>'OK','fail'=>'XƏTA','req_php'=>'PHP 8.2+','req_ext'=>'Lazımi PHP genişlənmələri','req_dir'=>'Yazıla bilən qovluqlar','req_btn'=>'Bütün tələblər ödənildi. Davam et','db_host'=>'Baza Host','db_port'=>'Port','db_name'=>'Baza Adı','db_user'=>'İstifadəçi','db_pass'=>'Şifrə','db_test'=>'Bağlantını Yoxla','db_ok'=>'Bağlantı uğurlu','db_fail'=>'Bağlantı uğursuz','db_continue'=>'Davam et','site_name'=>'Sayt Adı','site_url'=>'Sayt URL','adm_name'=>'Ad Soyad','adm_email'=>'Email','adm_pass'=>'Şifrə','adm_pass2'=>'Şifrə Təkrar','adm_mismatch'=>'Şifrələr uyğun deyil','adm_continue'=>'Admin Hesabı Yarat','ins_work'=>'Quraşdırılır, gözləyin...','ins_done'=>'Quraşdırma tamamlandı','fin_title'=>'Quraşdırma Bitdi','fin_sub'=>'RJ Nexus saytınız istifadəyə hazırdır.','err_req'=>'Bütün tələblər ödənmir.','err_db'=>'Baza bağlantısı alınmadı.','err_admin'=>'Bütün xanaları düzgün doldurun.','err_inst'=>'Quraşdırma alınmadı.','err_direct'=>'Əvvəlcə əvvəlki addımları tamamlayın.'],
        'de'=>['title'=>'RJ Nexus Installation','sub'=>'Einrichtungsassistent','next'=>'Weiter','back'=>'Zurück','retry'=>'Erneut versuchen','install'=>'Jetzt installieren','delete_installer'=>'Installer löschen & Admin öffnen','lang'=>'Sprache','step1'=>'Sprache','step2'=>'Anforderungen','step3'=>'Datenbank','step4'=>'Administrator','step5'=>'Installation','step6'=>'Fertig','ok'=>'OK','fail'=>'FEHLER','req_php'=>'PHP 8.2+','req_ext'=>'Erforderliche PHP-Erweiterungen','req_dir'=>'Beschreibbare Verzeichnisse','req_btn'=>'Alle Anforderungen erfüllt. Weiter','db_host'=>'Datenbank-Host','db_port'=>'Port','db_name'=>'Datenbankname','db_user'=>'Benutzername','db_pass'=>'Passwort','db_test'=>'Verbindung testen','db_ok'=>'Verbindung erfolgreich','db_fail'=>'Verbindung fehlgeschlagen','db_continue'=>'Weiter','site_name'=>'Website-Name','site_url'=>'Website-URL','adm_name'=>'Vollständiger Name','adm_email'=>'E-Mail','adm_pass'=>'Passwort','adm_pass2'=>'Passwort bestätigen','adm_mismatch'=>'Passwörter stimmen nicht überein','adm_continue'=>'Admin-Konto erstellen','ins_work'=>'Installation läuft, bitte warten...','ins_done'=>'Installation abgeschlossen','fin_title'=>'Einrichtung abgeschlossen','fin_sub'=>'Ihre RJ Nexus-Seite ist bereit.','err_req'=>'Nicht alle Anforderungen erfüllt.','err_db'=>'Datenbankverbindung fehlgeschlagen.','err_admin'=>'Bitte alle Felder korrekt ausfüllen.','err_inst'=>'Installation fehlgeschlagen.','err_direct'=>'Bitte zuerst vorherige Schritte ausführen.'],
        'es'=>['title'=>'Instalación de RJ Nexus','sub'=>'Asistente de configuración','next'=>'Siguiente','back'=>'Atrás','retry'=>'Reintentar','install'=>'Instalar ahora','delete_installer'=>'Eliminar instalador y abrir admin','lang'=>'Idioma','step1'=>'Idioma','step2'=>'Requisitos','step3'=>'Base de datos','step4'=>'Administrador','step5'=>'Instalación','step6'=>'Finalizar','ok'=>'OK','fail'=>'ERROR','req_php'=>'PHP 8.2+','req_ext'=>'Extensiones PHP requeridas','req_dir'=>'Directorios escribibles','req_btn'=>'Todos los requisitos cumplidos. Continuar','db_host'=>'Host BD','db_port'=>'Puerto','db_name'=>'Nombre BD','db_user'=>'Usuario','db_pass'=>'Contraseña','db_test'=>'Probar conexión','db_ok'=>'Conexión exitosa','db_fail'=>'Conexión fallida','db_continue'=>'Continuar','site_name'=>'Nombre del sitio','site_url'=>'URL del sitio','adm_name'=>'Nombre completo','adm_email'=>'Correo','adm_pass'=>'Contraseña','adm_pass2'=>'Confirmar contraseña','adm_mismatch'=>'Las contraseñas no coinciden','adm_continue'=>'Crear cuenta admin','ins_work'=>'Instalando, por favor espere...','ins_done'=>'Instalación completa','fin_title'=>'Configuración completa','fin_sub'=>'Tu sitio RJ Nexus está listo.','err_req'=>'No se cumplen todos los requisitos.','err_db'=>'Conexión a BD fallida.','err_admin'=>'Complete todos los campos.','err_inst'=>'Instalación fallida.','err_direct'=>'Complete los pasos anteriores primero.'],
        'fr'=>['title'=>'Installation de RJ Nexus','sub'=>'Assistant de configuration','next'=>'Suivant','back'=>'Retour','retry'=>'Réessayer','install'=>'Installer maintenant','delete_installer'=>"Supprimer l'installateur et ouvrir l'admin",'lang'=>'Langue','step1'=>'Langue','step2'=>'Prérequis','step3'=>'Base de données','step4'=>'Administrateur','step5'=>'Installation','step6'=>'Terminé','ok'=>'OK','fail'=>'ÉCHEC','req_php'=>'PHP 8.2+','req_ext'=>'Extensions PHP requises','req_dir'=>'Répertoires inscriptibles','req_btn'=>'Tous les prérequis satisfaits. Continuer','db_host'=>'Hôte BD','db_port'=>'Port','db_name'=>'Nom BD','db_user'=>'Utilisateur','db_pass'=>'Mot de passe','db_test'=>'Tester la connexion','db_ok'=>'Connexion réussie','db_fail'=>'Échec de connexion','db_continue'=>'Continuer','site_name'=>'Nom du site','site_url'=>'URL du site','adm_name'=>'Nom complet','adm_email'=>'E-mail','adm_pass'=>'Mot de passe','adm_pass2'=>'Confirmer le mot de passe','adm_mismatch'=>'Les mots de passe ne correspondent pas','adm_continue'=>'Créer le compte admin','ins_work'=>'Installation en cours...','ins_done'=>'Installation terminée','fin_title'=>'Configuration terminée','fin_sub'=>'Votre site RJ Nexus est prêt.','err_req'=>'Prérequis non satisfaits.','err_db'=>'Échec de connexion BD.','err_admin'=>'Remplissez tous les champs.','err_inst'=>"Échec de l'installation.",'err_direct'=>'Complétez les étapes précédentes.'],
        'pt'=>['title'=>'Instalação do RJ Nexus','sub'=>'Assistente de configuração','next'=>'Próximo','back'=>'Voltar','retry'=>'Tentar novamente','install'=>'Instalar agora','delete_installer'=>'Excluir instalador e abrir admin','lang'=>'Idioma','step1'=>'Idioma','step2'=>'Requisitos','step3'=>'Banco de dados','step4'=>'Administrador','step5'=>'Instalação','step6'=>'Concluído','ok'=>'OK','fail'=>'FALHA','req_php'=>'PHP 8.2+','req_ext'=>'Extensões PHP obrigatórias','req_dir'=>'Diretórios graváveis','req_btn'=>'Todos os requisitos atendidos. Continuar','db_host'=>'Host BD','db_port'=>'Porta','db_name'=>'Nome BD','db_user'=>'Usuário','db_pass'=>'Senha','db_test'=>'Testar conexão','db_ok'=>'Conexão bem-sucedida','db_fail'=>'Falha na conexão','db_continue'=>'Continuar','site_name'=>'Nome do site','site_url'=>'URL do site','adm_name'=>'Nome completo','adm_email'=>'E-mail','adm_pass'=>'Senha','adm_pass2'=>'Confirmar senha','adm_mismatch'=>'As senhas não coincidem','adm_continue'=>'Criar conta admin','ins_work'=>'Instalando, aguarde...','ins_done'=>'Instalação concluída','fin_title'=>'Configuração concluída','fin_sub'=>'Seu site RJ Nexus está pronto.','err_req'=>'Requisitos não atendidos.','err_db'=>'Falha na conexão BD.','err_admin'=>'Preencha todos os campos.','err_inst'=>'Falha na instalação.','err_direct'=>'Conclua as etapas anteriores primeiro.'],
        'ru'=>['title'=>'Установка RJ Nexus','sub'=>'Мастер настройки','next'=>'Далее','back'=>'Назад','retry'=>'Повторить','install'=>'Установить','delete_installer'=>'Удалить установщик и открыть админку','lang'=>'Язык','step1'=>'Язык','step2'=>'Требования','step3'=>'База данных','step4'=>'Администратор','step5'=>'Установка','step6'=>'Готово','ok'=>'ОК','fail'=>'ОШИБКА','req_php'=>'PHP 8.2+','req_ext'=>'Требуемые расширения PHP','req_dir'=>'Записываемые каталоги','req_btn'=>'Все требования выполнены. Продолжить','db_host'=>'Хост БД','db_port'=>'Порт','db_name'=>'Имя БД','db_user'=>'Пользователь','db_pass'=>'Пароль','db_test'=>'Проверить подключение','db_ok'=>'Подключение успешно','db_fail'=>'Ошибка подключения','db_continue'=>'Продолжить','site_name'=>'Название сайта','site_url'=>'URL сайта','adm_name'=>'Полное имя','adm_email'=>'Email','adm_pass'=>'Пароль','adm_pass2'=>'Подтвердите пароль','adm_mismatch'=>'Пароли не совпадают','adm_continue'=>'Создать админа','ins_work'=>'Установка, подождите...','ins_done'=>'Установка завершена','fin_title'=>'Установка завершена','fin_sub'=>'Ваш сайт RJ Nexus готов.','err_req'=>'Не все требования выполнены.','err_db'=>'Ошибка подключения к БД.','err_admin'=>'Заполните все поля.','err_inst'=>'Ошибка установки.','err_direct'=>'Сначала завершите предыдущие шаги.'],
        'tr'=>['title'=>'RJ Nexus Kurulumu','sub'=>'Kurulum Sihirbazı','next'=>'İleri','back'=>'Geri','retry'=>'Tekrar Dene','install'=>'Şimdi Kur','delete_installer'=>"Kurulumu Sil ve Admini Aç",'lang'=>'Dil','step1'=>'Dil','step2'=>'Gereksinimler','step3'=>'Veritabanı','step4'=>'Yönetici','step5'=>'Kurulum','step6'=>'Bitti','ok'=>'TAMAM','fail'=>'HATA','req_php'=>'PHP 8.2+','req_ext'=>'Gerekli PHP eklentileri','req_dir'=>'Yazılabilir dizinler','req_btn'=>'Tüm gereksinimler karşılandı. Devam et','db_host'=>'Veritabanı Sunucusu','db_port'=>'Port','db_name'=>'Veritabanı Adı','db_user'=>'Kullanıcı','db_pass'=>'Şifre','db_test'=>'Bağlantıyı Test Et','db_ok'=>'Bağlantı başarılı','db_fail'=>'Bağlantı başarısız','db_continue'=>'Devam et','site_name'=>'Site Adı','site_url'=>'Site URL','adm_name'=>'Ad Soyad','adm_email'=>'E-posta','adm_pass'=>'Şifre','adm_pass2'=>'Şifreyi Onayla','adm_mismatch'=>'Şifreler eşleşmiyor','adm_continue'=>'Yönetici Hesabı Oluştur','ins_work'=>'Kuruluyor, lütfen bekleyin...','ins_done'=>'Kurulum tamamlandı','fin_title'=>'Kurulum Tamamlandı','fin_sub'=>'RJ Nexus siteniz hazır.','err_req'=>'Tüm gereksinimler karşılanmadı.','err_db'=>'Veritabanı bağlantısı başarısız.','err_admin'=>'Tüm alanları doldurun.','err_inst'=>'Kurulum başarısız.','err_direct'=>'Önce önceki adımları tamamlayın.'],
    ];
}

function rj_t_current(): array
{
    $lang = $_SESSION['rj_install']['lang'] ?? 'en';
    $all = rj_t();
    return $all[$lang] ?? $all['en'];
}

function rj_esc(?string $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

function rj_log(string $msg): void
{
    $dir = dirname(RJ_LOG);
    if (!is_dir($dir)) @mkdir($dir, 0755, true);
    @file_put_contents(RJ_LOG, '[' . date('c') . '] ' . $msg . PHP_EOL, FILE_APPEND);
}

function rj_requirements(): array
{
    $root = RJ_ROOT;
    return [
        'php'    => ['ok' => version_compare(PHP_VERSION, '8.2.0', '>='), 'val' => PHP_VERSION],
        'pdo'    => ['ok' => extension_loaded('pdo_mysql'), 'val' => extension_loaded('pdo_mysql') ? 'yes' : 'no'],
        'mb'     => ['ok' => extension_loaded('mbstring'), 'val' => extension_loaded('mbstring') ? 'yes' : 'no'],
        'ssl'    => ['ok' => extension_loaded('openssl'), 'val' => extension_loaded('openssl') ? 'yes' : 'no'],
        'file'   => ['ok' => extension_loaded('fileinfo'), 'val' => extension_loaded('fileinfo') ? 'yes' : 'no'],
        'gd'     => ['ok' => extension_loaded('gd'), 'val' => extension_loaded('gd') ? 'yes' : 'no'],
        'zip'    => ['ok' => extension_loaded('zip'), 'val' => extension_loaded('zip') ? 'yes' : 'no'],
        'curl'   => ['ok' => extension_loaded('curl'), 'val' => extension_loaded('curl') ? 'yes' : 'no'],
        'json'   => ['ok' => extension_loaded('json'), 'val' => extension_loaded('json') ? 'yes' : 'no'],
        'tok'    => ['ok' => extension_loaded('tokenizer'), 'val' => extension_loaded('tokenizer') ? 'yes' : 'no'],
        'xml'    => ['ok' => extension_loaded('xml'), 'val' => extension_loaded('xml') ? 'yes' : 'no'],
        'ctype'  => ['ok' => extension_loaded('ctype'), 'val' => extension_loaded('ctype') ? 'yes' : 'no'],
        'storage'=> ['ok' => is_dir($root.'/storage') && is_writable($root.'/storage'), 'val' => $root.'/storage'],
        'cache'  => ['ok' => is_dir($root.'/bootstrap/cache') && is_writable($root.'/bootstrap/cache'), 'val' => $root.'/bootstrap/cache'],
        'env'    => ['ok' => is_writable($root), 'val' => $root],
        'example'=> ['ok' => file_exists(RJ_ENV_EXAMPLE), 'val' => '.env.example'],
    ];
}

function rj_requirements_ok(): bool
{
    foreach (rj_requirements() as $r) if (!$r['ok']) return false;
    return true;
}

function rj_db_test(array $cfg): array
{
    try {
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $cfg['host'], (int)$cfg['port'], $cfg['name']);
        $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 5]);
        return ['ok' => true, 'msg' => 'OK', 'pdo' => $pdo];
    } catch (Throwable $e) {
        return ['ok' => false, 'msg' => $e->getMessage()];
    }
}

function rj_env_write(array $values): void
{
    if (!file_exists(RJ_ENV)) {
        if (!file_exists(RJ_ENV_EXAMPLE)) throw new RuntimeException('.env.example missing');
        copy(RJ_ENV_EXAMPLE, RJ_ENV);
    }
    $content = (string) file_get_contents(RJ_ENV);
    foreach ($values as $k => $v) {
        $v = (string) $v;
        $quoted = ($v === '' || str_contains($v, ' ') || str_contains($v, '#') || str_contains($v, '"')) ? '"' . addcslashes($v, '"\\') . '"' : $v;
        $pattern = '/^' . preg_quote($k, '/') . '=.*$/m';
        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $k . '=' . $quoted, $content, 1);
        } else {
            $content = rtrim($content) . "\n{$k}={$quoted}\n";
        }
    }
    if (file_put_contents(RJ_ENV, $content) === false) throw new RuntimeException('.env write failed');
    @chmod(RJ_ENV, 0644);
}

function rj_artisan(array $args): array
{
    if (!function_exists('exec')) return ['code'=>-1, 'out'=>'exec() disabled'];
    $cmd = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(RJ_ROOT . '/artisan') . ' ' . implode(' ', array_map('escapeshellarg', $args)) . ' 2>&1';
    $out = [];
    $code = 0;
    @exec($cmd, $out, $code);
    return ['code' => $code, 'out' => implode("\n", $out)];
}

function rj_install_run(): array
{
    $cfg = $_SESSION['rj_install'];
    $log = [];

    try {
        rj_env_write([
            'APP_NAME' => $cfg['site_name'],
            'APP_URL' => rtrim($cfg['site_url'], '/'),
            'APP_ENV' => 'production',
            'APP_DEBUG' => 'false',
            'APP_LOCALE' => $cfg['lang'] ?? 'en',
            'APP_KEY' => '',
            'DB_HOST' => $cfg['db']['host'],
            'DB_PORT' => $cfg['db']['port'],
            'DB_DATABASE' => $cfg['db']['name'],
            'DB_USERNAME' => $cfg['db']['user'],
            'DB_PASSWORD' => $cfg['db']['pass'],
        ]);
        $log[] = '.env written';

        $kg = rj_artisan(['key:generate', '--force']);
        if ($kg['code'] !== 0) throw new RuntimeException('key:generate failed: ' . $kg['out']);
        $log[] = 'app key generated';

        rj_artisan(['config:clear']);
        rj_artisan(['cache:clear']);

        $mg = rj_artisan(['migrate', '--force', '--no-interaction']);
        if ($mg['code'] !== 0) throw new RuntimeException('migrate failed: ' . $mg['out']);
        $log[] = 'migrations run';

        $sd = rj_artisan(['db:seed', '--class=DatabaseSeeder', '--force', '--no-interaction']);
        if ($sd['code'] !== 0) $log[] = 'seeder warning: ' . substr($sd['out'], 0, 500);
        else $log[] = 'base seeders run';

        if (is_dir(database_path_dummy()) || file_exists(RJ_ROOT . '/database/seeders/data/demo/manifest.json')) {
            $dm = rj_artisan(['db:seed', '--class=DemoSeeder', '--force', '--no-interaction']);
            $log[] = ($dm['code'] === 0 ? 'demo imported' : 'demo warning: ' . substr($dm['out'], 0, 300));
        }

        $pdo = new PDO(
            sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $cfg['db']['host'], (int)$cfg['db']['port'], $cfg['db']['name']),
            $cfg['db']['user'], $cfg['db']['pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $hash = password_hash($cfg['admin']['pass'], PASSWORD_BCRYPT, ['cost' => 12]);
        $existing = (int) $pdo->query("SELECT id FROM users ORDER BY id LIMIT 1")->fetchColumn();
        if ($existing > 0) {
            $pdo->prepare("UPDATE users SET name=?, email=?, password=?, email_verified_at=NOW(), updated_at=NOW() WHERE id=?")
                ->execute([$cfg['admin']['name'], $cfg['admin']['email'], $hash, $existing]);
            $log[] = 'admin user updated';
        } else {
            $hasRole = $pdo->query("SHOW COLUMNS FROM users LIKE 'role'")->fetch();
            if ($hasRole) {
                $pdo->prepare("INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) VALUES (?,?,?,?,NOW(),NOW(),NOW())")
                    ->execute([$cfg['admin']['name'], $cfg['admin']['email'], $hash, 'admin']);
            } else {
                $pdo->prepare("INSERT INTO users (name, email, password, email_verified_at, created_at, updated_at) VALUES (?,?,?,NOW(),NOW(),NOW())")
                    ->execute([$cfg['admin']['name'], $cfg['admin']['email'], $hash]);
            }
            $log[] = 'admin user created';
        }

        $sl = rj_artisan(['storage:link']);
        $log[] = ($sl['code'] === 0 ? 'storage linked' : 'storage link warning: ' . substr($sl['out'], 0, 200));

        $lockDir = dirname(RJ_LOCK);
        if (!is_dir($lockDir)) @mkdir($lockDir, 0755, true);
        file_put_contents(RJ_LOCK, json_encode(['installed_at' => date('c'), 'version' => '1.5.0'], JSON_PRETTY_PRINT));

        rj_log(implode(' | ', $log));
        return ['ok' => true, 'log' => $log];
    } catch (Throwable $e) {
        rj_log('INSTALL FAIL: ' . $e->getMessage());
        return ['ok' => false, 'error' => $e->getMessage(), 'log' => $log];
    }
}

function database_path_dummy(): string { return ''; }

function rj_state(): array
{
    return $_SESSION['rj_install'] ?? [];
}

function rj_set_state(array $data): void
{
    $_SESSION['rj_install'] = $data;
}

function rj_render(string $step, string $body, string $extra = ''): void
{
    $t = rj_t_current();
    $lang = $_SESSION['rj_install']['lang'] ?? 'en';
    $steps = ['step1','step2','step3','step4','step5'];
    $stepIdx = ['language'=>1,'requirements'=>2,'database'=>3,'admin'=>4,'install'=>5,'finish'=>6][$step] ?? 1;
    $nav = '';
    foreach ($steps as $i => $k) {
        $n = $i + 1;
        $cls = $n === $stepIdx ? 'active' : ($n < $stepIdx ? 'done' : '');
        $nav .= '<span class="dot ' . $cls . '">' . $n . '</span>';
        if ($n < 5) $nav .= '<span class="line ' . ($n < $stepIdx ? 'done' : '') . '"></span>';
    }
    $html = '<!DOCTYPE html><html lang="' . rj_esc($lang) . '"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>' . rj_esc($t['title']) . '</title><style>'
        . '*{box-sizing:border-box;margin:0;padding:0}body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",system-ui,sans-serif;background:#0a0a0b;color:#e5e7eb;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}'
        . '.card{width:100%;max-width:560px;background:#131315;border:1px solid #26262a;border-radius:16px;padding:32px}'
        . '.brand{font-size:13px;letter-spacing:.3em;text-transform:uppercase;color:#d4af37;font-weight:700;margin-bottom:6px}'
        . 'h1{font-size:24px;font-weight:700;margin-bottom:4px}p.sub{color:#8a8a92;font-size:14px;margin-bottom:24px}'
        . '.steps{display:flex;align-items:center;margin:20px 0 28px}.dot{width:28px;height:28px;border-radius:50%;border:1px solid #2c2c31;color:#555;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:600}'
        . '.dot.active{border-color:#d4af37;color:#d4af37;background:rgba(212,175,55,.08)}.dot.done{border-color:#2e7d32;color:#2e7d32;background:rgba(46,125,50,.1)}'
        . '.line{flex:1;height:1px;background:#2c2c31;margin:0 8px}.line.done{background:#2e7d32}'
        . 'label{display:block;font-size:12px;color:#8a8a92;margin:12px 0 6px;letter-spacing:.02em}'
        . 'input,select{width:100%;background:#0a0a0b;border:1px solid #26262a;color:#e5e7eb;border-radius:8px;padding:10px 12px;font-size:14px;font-family:inherit}'
        . 'input:focus,select:focus{outline:none;border-color:#d4af37}'
        . '.btn{display:inline-block;background:#d4af37;color:#0a0a0b;border:none;padding:11px 22px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;transition:opacity .15s}'
        . '.btn:hover{opacity:.9}.btn.ghost{background:transparent;color:#d4af37;border:1px solid #d4af37}.btn:disabled{opacity:.5;cursor:not-allowed}'
        . '.row{display:flex;gap:12px;margin-top:24px;justify-content:space-between;align-items:center}'
        . '.req{list-style:none;margin-top:8px}.req li{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #1e1e22;font-size:13px}'
        . '.req li:last-child{border-bottom:none}.ok{color:#2e7d32}.fail{color:#dc2626}'
        . '.langs{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:16px}'
        . '.lang-btn{background:#0a0a0b;border:1px solid #26262a;color:#e5e7eb;padding:12px;border-radius:8px;cursor:pointer;font-size:14px;transition:.15s;text-align:left}'
        . '.lang-btn:hover{border-color:#d4af37}.lang-btn.active{border-color:#d4af37;background:rgba(212,175,55,.08)}'
        . '.alert{background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.4);color:#fca5a5;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px}'
        . '.alert-ok{background:rgba(46,125,50,.1);border:1px solid rgba(46,125,50,.4);color:#86efac}'
        . '.spinner{width:32px;height:32px;border:3px solid #26262a;border-top-color:#d4af37;border-radius:50%;animation:spin 1s linear infinite;margin:20px auto}'
        . '@keyframes spin{to{transform:rotate(360deg)}}'
        . '.log{background:#0a0a0b;border:1px solid #1e1e22;border-radius:8px;padding:14px;font-family:ui-monospace,monospace;font-size:12px;color:#a1a1aa;max-height:200px;overflow:auto;margin-top:12px}'
        . 'code{background:#1f1f23;padding:2px 6px;border-radius:4px;font-size:.9em}'
        . '</style>' . $extra . '</head><body><div class="card"><div class="brand">RJ NEXUS</div><h1>' . rj_esc($t['title']) . '</h1><p class="sub">' . rj_esc($t['sub']) . '</p><div class="steps">' . $nav . '</div>' . $body . '</div></body></html>';
    echo $html;
}

function rj_html_standalone(string $title, string $body): void
{
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>' . rj_esc($title) . '</title><style>body{font-family:system-ui;background:#0a0a0b;color:#e5e7eb;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:24px;text-align:center}.card{max-width:480px;background:#131315;border:1px solid #26262a;border-radius:16px;padding:40px}h1{font-size:22px;margin-bottom:12px}p{color:#8a8a92;margin-bottom:12px;line-height:1.5}code{background:#1f1f23;padding:2px 8px;border-radius:4px}a.btn,.btn{display:inline-block;background:#d4af37;color:#0a0a0b;padding:10px 22px;border-radius:8px;font-weight:600;text-decoration:none;margin-top:16px;border:none;cursor:pointer}</style></head><body><div class="card">' . $body . '</div></body></html>';
}

if (isset($_POST['rj_lang']) && isset(rj_languages()[$_POST['rj_lang']])) {
    rj_set_state(array_merge(rj_state(), ['lang' => $_POST['rj_lang']]));
    header('Location: ?step=requirements');
    exit;
}

$step = $_GET['step'] ?? 'language';
$t = rj_t_current();
$state = rj_state();

if ($step === 'requirements') {
    if (empty($state['lang'])) { header('Location: ?step=language'); exit; }
    $reqs = rj_requirements();
    $allOk = rj_requirements_ok();
    $body = '<ul class="req">';
    foreach ($reqs as $k => $r) {
        $label = $k === 'php' ? $t['req_php'] : ($k === 'example' ? '.env.example' : $k);
        $body .= '<li><span>' . rj_esc($label) . '</span><span class="' . ($r['ok'] ? 'ok' : 'fail') . '">' . ($r['ok'] ? 'OK' : $t['fail']) . '</span></li>';
    }
    $body .= '</ul>';
    if (!$allOk) $body .= '<div class="alert" style="margin-top:16px">' . rj_esc($t['err_req']) . '</div>';
    $body .= '<div class="row"><a href="?step=language" class="btn ghost">' . rj_esc($t['back']) . '</a>';
    if ($allOk) $body .= '<a href="?step=database" class="btn">' . rj_esc($t['req_btn']) . '</a>';
    $body .= '</div>';
    rj_render('requirements', $body);
    exit;
}

if ($step === 'database') {
    if (empty($state['lang']) || !rj_requirements_ok()) { header('Location: ?step=requirements'); exit; }
    $err = '';
    $dbTest = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db_host'])) {
        $cfg = [
            'host' => trim($_POST['db_host'] ?? '127.0.0.1'),
            'port' => (int)($_POST['db_port'] ?? 3306),
            'name' => trim($_POST['db_name'] ?? ''),
            'user' => trim($_POST['db_user'] ?? ''),
            'pass' => (string)($_POST['db_pass'] ?? ''),
            'site_name' => trim($_POST['site_name'] ?? ''),
            'site_url' => trim($_POST['site_url'] ?? ''),
        ];
        if ($cfg['name'] === '' || $cfg['user'] === '' || $cfg['site_name'] === '' || $cfg['site_url'] === '') {
            $err = $t['err_db'];
        } else {
            $dbTest = rj_db_test($cfg);
            if ($dbTest['ok']) {
                $state['db'] = ['host'=>$cfg['host'],'port'=>$cfg['port'],'name'=>$cfg['name'],'user'=>$cfg['user'],'pass'=>$cfg['pass']];
                $state['site_name'] = $cfg['site_name'];
                $state['site_url'] = $cfg['site_url'];
                rj_set_state($state);
                header('Location: ?step=admin');
                exit;
            }
            $err = $t['err_db'] . ': ' . $dbTest['msg'];
        }
    }
    $db = $state['db'] ?? ['host'=>'127.0.0.1','port'=>'3306','name'=>'','user'=>'','pass'=>''];
    $body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';
    $body .= '<form method="post"><label>' . rj_esc($t['db_host']) . '</label><input name="db_host" value="' . rj_esc($db['host']) . '" required>';
    $body .= '<label>' . rj_esc($t['db_port']) . '</label><input name="db_port" type="number" value="' . rj_esc((string)$db['port']) . '" required>';
    $body .= '<label>' . rj_esc($t['db_name']) . '</label><input name="db_name" value="' . rj_esc($db['name']) . '" required>';
    $body .= '<label>' . rj_esc($t['db_user']) . '</label><input name="db_user" value="' . rj_esc($db['user']) . '" required>';
    $body .= '<label>' . rj_esc($t['db_pass']) . '</label><input name="db_pass" type="password" value="">';
    $body .= '<label>' . rj_esc($t['site_name']) . '</label><input name="site_name" value="' . rj_esc($state['site_name'] ?? 'RJ Nexus') . '" required>';
    $body .= '<label>' . rj_esc($t['site_url']) . '</label><input name="site_url" value="' . rj_esc($state['site_url'] ?? ('http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'))) . '" required>';
    $body .= '<div class="row"><a href="?step=requirements" class="btn ghost">' . rj_esc($t['back']) . '</a><button class="btn" type="submit">' . rj_esc($t['db_test']) . '</button></div></form>';
    rj_render('database', $body);
    exit;
}

if ($step === 'admin') {
    if (empty($state['db'])) { header('Location: ?step=database'); exit; }
    $err = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adm_email'])) {
        $name = trim($_POST['adm_name'] ?? '');
        $email = trim($_POST['adm_email'] ?? '');
        $pass = (string)($_POST['adm_pass'] ?? '');
        $pass2 = (string)($_POST['adm_pass2'] ?? '');
        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 8) {
            $err = $t['err_admin'];
        } elseif ($pass !== $pass2) {
            $err = $t['adm_mismatch'];
        } else {
            $state['admin'] = ['name'=>$name, 'email'=>$email, 'pass'=>$pass];
            rj_set_state($state);
            header('Location: ?step=install');
            exit;
        }
    }
    $body = $err ? '<div class="alert">' . rj_esc($err) . '</div>' : '';
    $body .= '<form method="post"><label>' . rj_esc($t['adm_name']) . '</label><input name="adm_name" value="' . rj_esc($_POST['adm_name'] ?? '') . '" required>';
    $body .= '<label>' . rj_esc($t['adm_email']) . '</label><input name="adm_email" type="email" value="' . rj_esc($_POST['adm_email'] ?? '') . '" required>';
    $body .= '<label>' . rj_esc($t['adm_pass']) . '</label><input name="adm_pass" type="password" minlength="8" required>';
    $body .= '<label>' . rj_esc($t['adm_pass2']) . '</label><input name="adm_pass2" type="password" minlength="8" required>';
    $body .= '<div class="row"><a href="?step=database" class="btn ghost">' . rj_esc($t['back']) . '</a><button class="btn" type="submit">' . rj_esc($t['adm_continue']) . '</button></div></form>';
    rj_render('admin', $body);
    exit;
}

if ($step === 'install') {
    if (empty($state['admin'])) { header('Location: ?step=admin'); exit; }
    @set_time_limit(300);
    @ini_set('memory_limit', '256M');
    $result = rj_install_run();
    if ($result['ok']) {
        header('Location: ?step=finish');
        exit;
    }
    $body = '<div class="alert">' . rj_esc($t['err_inst']) . '</div>';
    $body .= '<div class="log">' . rj_esc($result['error'] ?? '') . '</div>';
    $body .= '<div class="row"><a href="?step=admin" class="btn ghost">' . rj_esc($t['back']) . '</a><a href="?step=install" class="btn">' . rj_esc($t['retry']) . '</a></div>';
    rj_render('install', $body);
    exit;
}

if ($step === 'finish') {
    if (!file_exists(RJ_LOCK)) { header('Location: ?step=install'); exit; }
    if (isset($_POST['delete_installer'])) {
        @unlink(__FILE__);
        header('Location: /admin');
        exit;
    }
    $body = '<div class="alert alert-ok">' . rj_esc($t['ins_done']) . '</div>';
    $body .= '<p style="color:#8a8a92;margin-top:16px;font-size:14px;line-height:1.6">' . rj_esc($t['fin_sub']) . '</p>';
    $body .= '<p style="color:#8a8a92;margin-top:12px;font-size:13px"><strong style="color:#d4af37">Security:</strong> For your protection, delete <code>install.php</code> from your server after setup.</p>';
    $body .= '<form method="post" style="margin-top:24px"><button type="submit" name="delete_installer" class="btn">' . rj_esc($t['delete_installer']) . '</button></form>';
    rj_render('finish', $body);
    exit;
}

$selectedLang = $state['lang'] ?? 'en';
$body = '<p style="font-size:14px;color:#8a8a92;margin-bottom:8px">' . rj_esc($t['lang']) . '</p><form method="post" class="langs">';
foreach (rj_languages() as $code => $label) {
    $active = $code === $selectedLang ? ' active' : '';
    $body .= '<button type="submit" name="rj_lang" value="' . rj_esc($code) . '" class="lang-btn' . $active . '">' . rj_esc($label) . '</button>';
}
$body .= '</form>';
rj_render('language', $body);
