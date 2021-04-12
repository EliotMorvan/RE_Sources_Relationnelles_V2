<?php

namespace Controller\Admin;

use Controller\AbstractController;
use Http\Response;
use Security\Security;

class SecurityController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function login(): Response
    {
        $error = null;
        if (isset($_POST['login'])) {
            if (empty($email = $_POST['email'])) {
                $error = "Veuillez saisir votre adresse email.";
            } elseif (empty($password = $_POST['password'])) {
                $error = "Veuillez saisir votre mot de passe.";
            } elseif ($this->security->login($email, $password)) {
                return $this->redirectToRoute('/');
            } else {
                $error = $this->security->getError();
            }
        }

        return $this->render('admin/security/login.html.twig', [
            'error' => $error,
        ]);
    }

    public function create(): Response
    {
        $error = null;
        if (isset($_POST['create'])) {
            if (empty($email = $_POST['email'])) {
                $error = "Veuillez saisir un pseudo.";
            } elseif (empty($password = $_POST['password'])) {
                $error = "Veuillez saisir un mot de passe.";
            } elseif ($this->security->isTaken($email, $password)) {
                return $this->redirectToRoute('/');
            } else {
                $error = $this->security->getError();
            }
        }

        return $this->render('admin/security/create.html.twig', [
            'error' => $error,
        ]);
    }

    public function logout()
    {
        $this->security->logout();

        return $this->redirectToRoute('admin_login');
    }
}
