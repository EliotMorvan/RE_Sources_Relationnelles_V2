<?php

namespace Controller;

use Http\Response;

class AppController extends AbstractController
{
    public function index(): Response
    {
        if (isset($_POST['reg'])) {
            $reg = $_POST['reg'];
            return $this->redirectToRoute('liste_ressources_reg', [
                'reg' => $reg,
            ]);
        }
        return $this->render('app/index.html.twig');
    }
}
