<?php

namespace App\Core;

use App\Traits\Singleton;

class Router
{
  use Singleton;

  private array $handlers;
  private const METHOD_POST = "POST";
  private const METHOD_GET = "GET";
  private $notFoundCallback;

  private array $routeParams = [];

  public function run()
  {
    // Parse request URI safely
    $parsedURI = parse_url($_SERVER['REQUEST_URI'] ?? '/');
    $requestPath = $parsedURI['path'] ?? '/';
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    // Apply base path stripping (only on the PATH string)
    $basePath = base_path(); // e.g., "/my-app"
    if ($basePath !== '' && $basePath !== '/') {
      // Ensure basePath starts and ends without double slashes
      $basePath = '/' . trim($basePath, '/');
      if (strpos($requestPath, $basePath) === 0) {
        $requestPath = substr($requestPath, strlen($basePath)) ?: '/';
      }
    }

    // Normalize trailing slash: redirect if needed (only for non-root)
    if ($requestPath !== '/' && str_ends_with($requestPath, '/')) {
      $requestPath = rtrim($requestPath, '/');
      // Use full URL for redirect to respect base path
      $redirectUrl = url($requestPath);
      header("Location: " . $redirectUrl, true, 301);
      exit;
    }

    // Route matching
    $callback = null;

    // Exact match
    foreach ($this->handlers as $handler) {
      if ($requestPath === $handler["path"] && $requestMethod === $handler["method"]) {
        $callback = $handler["handler"];
        break;
      }
    }

    // Parameterized match (if no exact match)
    if (!$callback) {
      $callback = $this->getCallbackWithPathParams($requestPath, $requestMethod); // ← pass method!
      if (!$callback) {
        $callback = $this->notFoundCallback;
      }
    }

    // Resolve controller
    if (is_array($callback) && is_string($callback[0])) {
      $controller = new $callback[0];
      $method = $callback[1];
      $callback = [$controller, $method];
    }

    // Call with merged input (note: consider changing this design long-term)
    $params = array_merge($_GET, $_POST, $this->routeParams);
    call_user_func_array($callback, [$params]);
  }

  public function getCallbackWithPathParams(string $url, string $method = self::METHOD_GET)
  {
    $url = trim($url, '/');
    $routeParams = false;

    foreach ($this->handlers as $route) {
      // ✅ Match by method too!
      if ($route['method'] !== $method) {
        continue;
      }

      $routePath = trim($route['path'], '/');
      if ($routePath === '') continue;

      $routeNames = [];
      if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $routePath, $matches)) {
        $routeNames = $matches[1];
      }

      // Build regex
      $routeRegex = preg_quote($routePath, '@');
      $routeRegex = preg_replace_callback(
        '/\\\{(\w+)(:([^}]+))?\\\}/',
        function ($m) {
          $pattern = $m[3] ?? '[^/]+';
          return "({$pattern})";
        },
        $routeRegex
      );
      $routeRegex = "@^{$routeRegex}$@";

      if (preg_match($routeRegex, $url, $valueMatches)) {
        array_shift($valueMatches); // remove full match
        if (count($routeNames) !== count($valueMatches)) {
          continue; // mismatch
        }
        $this->routeParams = array_combine($routeNames, $valueMatches);
        return $route['handler'];
      }
    }

    return false;
  }

  public function addNotFoundCallback($handler)
  {
    $this->notFoundCallback = $handler;
  }

  private function addHandler(string $method, string $path, $handler)
  {
    $key = strtolower($method . $path);
    $this->handlers[$key] = [
      "path" => $path,
      "method" => $method,
      "handler" => $handler
    ];
  }

  public function post(string $path, $handler)
  {
    $this->addHandler(self::METHOD_POST, $path, $handler);
  }

  public function get(string $path, $handler)
  {
    $this->addHandler(self::METHOD_GET, $path, $handler);
  }
}
