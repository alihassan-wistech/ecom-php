<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{

    public function index()
    {
        $pageInfo = ["title" => "Contact"];
        $this->renderView($pageInfo, "client/contact/index", "main");
    }
}
