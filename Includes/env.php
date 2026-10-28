<?php
/** Load project .env values for PHP requests without requiring a dotenv package. */
function load_project_env(): void
{
    static $loaded = false;
    if ($loaded) return;
    $loaded = true;
    $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
    if (!is_file($path) || !is_readable($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES);
    if (!is_array($lines)) return;
    foreach ($lines as $line) {
        if (!preg_match('/^\s*([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.*?)\s*$/', $line, $match)) continue;
        $name = $match[1];
        $raw = $match[2];
        if ($raw !== '' && $raw[0] === '"') {
            $decoded = json_decode($raw, true);
            $value = is_string($decoded) ? $decoded : trim($raw, '"');
        } elseif ($raw !== '' && $raw[0] === "'") {
            $value = trim($raw, "'");
        } else {
            $value = $raw;
        }
        putenv($name . '=' . $value);
        $_ENV[$name] = $value;
    }
}

load_project_env();
