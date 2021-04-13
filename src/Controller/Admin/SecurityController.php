<?php

namespace Controller\Admin;

use Controller\AbstractController;
use Entity\User;
use Http\Response;
use Manager\UserManager;
use Security\Security;

class SecurityController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;
    private $userManager;

    public function __construct(Security $security, UserManager $userManager)
    {
        $this->security = $security;
        $this->userManager = $userManager;
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
        if (isset($_POST['create_compte'])) {
            if (empty($prenom = $_POST['prenom'])) {
                $error = "Veuillez saisir votre prénom.";
            } 
            elseif (empty($nom = $_POST['nom'])) {
                $error = "Veuillez saisir votre nom.";
            }
            elseif (empty($pseudo = $_POST['pseudo'])) {
                $error = "Veuillez saisir votre pseudo.";
            }
            elseif (empty($password = $_POST['password'])) {
                $error = "Veuillez saisir votre mot de passe.";
            } 
            elseif ($this->security->pseudoDisponible($pseudo)) {
                $user = new User();
                $user->setEmail($pseudo);
                $user->setPrenom($prenom);
                $user->setNom($nom);
                $user->setPlainPassword($password);
                $user->setDroit(0);
                $this->userManager->insert($user);
                $this->security->login($pseudo, $password);
                return $this->redirectToRoute('/');
            } 
            else {
                $error = "Ce pseudo est déja utilisé.";
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
