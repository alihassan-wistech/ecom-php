<?php

namespace App\Http\Controllers;

use App\Core\ViewRenderer;
use App\utils\Functions;

abstract class Controller
{
    protected ViewRenderer $viewRenderer;

    public function __construct()
    {
        $this->viewRenderer = ViewRenderer::getInstance();
    }

    protected function renderView(array $pageInfo, string $template, string $layout, array $data = [])
    {
        $data["page-info"] = $pageInfo;
        $template = Functions::getTemplate($template, $data);
        Functions::getLayout($layout, $template, $data);
    }

    protected function renderViewImproved(string $template, array $data = []): string
    {
        extract($data);
        ob_start();
        require_once template_dir($template);
        $content = ob_get_contents();

        if (isset($GLOBALS['__layout']) && !empty($GLOBALS['__layout'])) {
            $layout = $GLOBALS['__layout'];
            ob_start();
            require_once template_dir($layout);
            $layout = ob_get_clean();
            return $layout;
        }

        ob_end_clean();
        return $content;
    }


    protected function response(string $message, bool $status)
    {
        echo json_encode(["message" => $message, "status" => $status]);
    }
}
