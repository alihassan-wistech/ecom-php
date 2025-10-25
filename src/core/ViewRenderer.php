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

    public function __construct(string $templateDir)
    {
        $this->templateDir = rtrim($templateDir, '/') . '/';
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
        // Clear previous state
        $this->sections = [];
        $this->currentSection = null;

        // Extract data into local scope
        extract($data);

        // Render the child view (which may define sections)
        ob_start();
        include $this->resolvePath($template);
        ob_end_clean(); // Discard direct output; we only want sections

        // If no layout, just return captured main output (optional fallback)
        if (empty($this->layout)) {
            // Alternative: you could capture main body as a special section
            return ob_get_clean() ?: ''; // but we already cleaned it
            // Better: require that views only define sections when using layout
        }

        // Render the layout, which will call yieldSection()
        ob_start();
        include $this->resolvePath($this->layout);
        $output = ob_get_clean();

        // Reset layout after render (optional, for reuse)
        $this->layout = '';

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
