<?php

namespace Controller;

use Http\Response;

class AppController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('app/index.html.twig');
    }
}
