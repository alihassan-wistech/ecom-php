<?php

namespace App\controllers;

use App\utils\Functions;

abstract class Controller
{
    protected function renderView(array $pageInfo, string $template, string $layout, array $data = [])
    {
        $data["page-info"] = $pageInfo;
        $template = Functions::getTemplate($template, $data);
        Functions::getLayout($layout, $template, $data);
    }

    protected function response(string $message, bool $status)
    {
        echo json_encode(["message" => $message, "status" => $status]);
    }
}
