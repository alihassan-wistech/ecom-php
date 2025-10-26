<?php

namespace App\Core;

use App\Traits\Singleton;
use RuntimeException;

class ViewRenderer
{
    use Singleton;

    protected string $layout = '';
    protected array $sections = [];
    protected ?string $currentSection = null;

    // Path to template directory (adjust as needed)
    protected string $templateDir;

    public function __construct()
    {
        $this->templateDir = rtrim(template_dir(), '/') . '/';
    }

    // Set the layout to wrap the view
    public function usesLayout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }

    // Start capturing a section
    public function startSection(string $name): void
    {
        $this->currentSection = $name;
        ob_start();
    }

    // End capturing and store the section content
    public function endSection(): void
    {
        if ($this->currentSection === null) {
            throw new RuntimeException('No active section to end.');
        }

        $content = ob_get_clean();
        $this->sections[$this->currentSection] = $content;
        $this->currentSection = null;
    }

    // Get section content (used in layout)
    public function yieldSection(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    // Render a view file (with optional data)
    public function render(string $template, array $data = []): string
    {
        // Reset state
        $this->sections = [];
        $this->currentSection = null;

        extract($data);

        // Render the child view — this populates $this->sections
        include $this->resolvePath($template);

        // If no layout, optionally return a default body (not needed if always using layout)
        if (empty($this->layout)) {
            return ''; // or throw, or handle differently
        }

        // Now render the layout, which pulls in sections
        ob_start();
        include $this->resolvePath($this->layout);
        $output = ob_get_clean();

        $this->layout = ''; // reset for next use
        return $output;
    }

    protected function resolvePath(string $template): string
    {
        $path = $this->templateDir . ltrim($template, '/');
        if (!file_exists($path)) {
            throw new RuntimeException("Template not found: {$path}");
        }
        return $path;
    }
}
