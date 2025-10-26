<?php

use App\Core\Database;

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

/**
 * Outputs a human-readable representation of a variable wrapped in HTML <pre> tags.
 * 
 * This helper function is useful for debugging during development, as it preserves
 * formatting (indentation, line breaks) when displaying arrays, objects, or other
 * complex data structures in a web browser.
 * 
 * @param mixed $data The variable to display (e.g., array, object, string, etc.)
 * @return void
 * 
 * @example
 * print_format(['name' => 'John', 'age' => 30]);
 * Outputs formatted array inside <pre> tags in the browser
 */
function print_format(mixed $data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * Generate a unique slug for any entity
 *
 * @param string $title The title to slugify
 * @param string $table The database table name (e.g., 'products', 'posts')
 * @param int|null $excludeId ID to exclude (when updating an existing record)
 * @param string $idColumn Name of the ID column (default: 'id')
 * @param string $slugColumn Name of the slug column (default: 'slug')
 * @return string
 */
function generateUniqueSlug(
    string $title,
    string $table,
    ?int $excludeId = null,
    string $idColumn = 'id',
    string $slugColumn = 'slug'
): string {
    if (empty(trim($title))) {
        return '';
    }

    $baseSlug = createSlug($title);
    $slug = $baseSlug;
    $counter = 1;

    while (slugExists($table, $slug, $excludeId, $idColumn, $slugColumn)) {
        $slug = $baseSlug . '-' . $counter;
        $counter++;

        if ($counter > 1000) {
            throw new RuntimeException("Could not generate unique slug after 1000 attempts");
        }
    }

    return $slug;
}

/**
 * Create a clean URL-friendly slug from a string
 */
function createSlug(string $text): string
{
    // Convert to lowercase
    $slug = strtolower($text);

    // Remove special characters, keep only alphanumeric, spaces, and hyphens
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

    // Replace spaces and multiple hyphens with single hyphen
    $slug = preg_replace('/[\s-]+/', '-', $slug);

    // Trim hyphens from start and end
    $slug = trim($slug, '-');

    return $slug ?: 'item';
}

/**
 * Check if a slug already exists in a given table
 */
function slugExists(
    string $table,
    string $slug,
    ?int $excludeId = null,
    string $idColumn = 'id',
    string $slugColumn = 'slug'
): bool {
    $query = "SELECT COUNT(*) as count FROM `{$table}` WHERE `{$slugColumn}` = :slug";
    $params = ['slug' => $slug];

    if ($excludeId !== null) {
        $query .= " AND `{$idColumn}` != :exclude_id";
        $params['exclude_id'] = $excludeId;
    }

    $result = Database::getInstance()->getResultsByQuery($query, $params);
    return (int)($result[0]['count'] ?? 0) > 0;
}

/**
 * Returns the base path of the site (e.g., http://host/app => /app)
 * 
 * @return string The base path of the site
 */
function base_path(): string
{
    $siteUrl = rtrim(env('SITE_URL', ''), '/');
    if (empty($siteUrl)) {
        return '';
    }

    // Parse URL to get path (e.g., http://host/app => /app)
    $parsed = parse_url($siteUrl);
    return $parsed['path'] ?? '';
}

/**
 * Generate a full URL relative to SITE_URL
 *
 * @param string $path Optional path to append (e.g., 'products/123')
 * @return string Full URL (e.g., http://localhost:8000/products/123)
 */
function url(string $path = ''): string
{
    $siteUrl = rtrim(env('SITE_URL', ''), '/');
    if (empty($siteUrl)) {
        // Fallback to current host if SITE_URL not set
        $siteUrl = ($_SERVER['REQUEST_SCHEME'] ?? 'http')
            . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
    }

    if ($path === '') {
        return $siteUrl;
    }

    // Ensure $path starts with /
    $path = ltrim($path, '/');
    return $siteUrl . '/' . $path;
}
