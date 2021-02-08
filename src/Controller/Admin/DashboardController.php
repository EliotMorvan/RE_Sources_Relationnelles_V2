<?php

namespace Controller\Admin;

use Controller\AbstractController;
use Http\Response;

class DashboardController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}
