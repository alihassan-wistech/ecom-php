<?php

/**
 * Get the base directory.
 *
 * @param string $path
 * @return string
 */
function base_dir(string $path = ""): string
{
    $path = trim($path, "/\\");
    return $path === ''
        ? BASE_DIR
        : BASE_DIR . DIRECTORY_SEPARATOR . $path;
}

/**
 * Get the templates directory.
 *
 * @param string $path
 * @return string
 */
function template_dir(string $path = ''): string
{
    $path = trim($path, "/\\");
    $templatePath = 'templates';
    if ($path !== '') {
        $templatePath .= DIRECTORY_SEPARATOR . $path;
    }
    return base_dir($templatePath);
}

/**
 * Get the full filesystem path to a file in the public directory.
 *
 * @param string $path Optional sub-path or filename (e.g., 'assets/css/app.css')
 * @return string Full path to the public asset
 */
function public_dir(string $path = ''): string
{
    $path = trim($path, "/\\");
    $publicPath = 'public_html'; // or 'public_html' if that's your actual folder name

    if ($path === '') {
        return base_dir($publicPath);
    }

    return base_dir($publicPath . DIRECTORY_SEPARATOR . $path);
}

/**
 * Get an environment variable or return a default value.
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 * @throws RuntimeException if required env var is missing and no default provided
 */
function env(string $key, $default = null)
{
    // Check if the key exists in $_ENV
    if (array_key_exists($key, $_ENV)) {
        $value = $_ENV[$key];

        // Convert common string values to booleans/numbers
        if ($value === 'true')  return true;
        if ($value === 'false') return false;
        if ($value === 'null')  return null;
        if (is_numeric($value) && !isset($value[0]) === false) {
            // Only cast if it's purely numeric (e.g., "123", "3.14")
            return $value + 0; // converts to int or float
        }

        return $value;
    }

    // If no default is provided, treat as required
    if ($default === null) {
        throw new RuntimeException("Environment variable [{$key}] is not set and no default provided.");
    }

    return $default;
}

/**
 * Generate a URL to an asset (CSS, JS, image, etc.) using SITE_URL from .env
 *
 * @param string $path Relative path to the asset (e.g., 'css/app.css')
 * @return string Full URL to the asset
 */
function asset(string $path = ''): string
{
    // Get and clean SITE_URL: trim whitespace and trailing slashes
    $baseUrl = rtrim(trim(env('SITE_URL', '/')), "/\\");

    if (empty($path)) {
        return $baseUrl;
    }

    // Clean the path: remove leading slashes to avoid double slashes
    $cleanPath = ltrim(trim($path), "/\\");

    return $baseUrl . '/' . $cleanPath;
}

function using_layout(string $layout)
{
    $GLOBALS['__layout'] = $layout;
}

function yield_section(string $name)
{
    echo $GLOBALS['__sections'][$name] ?? '';
}

function start_section(string $name)
{
    $GLOBALS['__current_section'] = $name;
    ob_start();
}

function end_section(string|null $name = null)
{
    $section = $name ?? $GLOBALS['__current_section'];
    if (empty($section)) {
        return;
    }
    $content = ob_get_clean();
    $GLOBALS['__sections'][$section] = $content;
}
