<?php

namespace Controller;

use Service\UserService;
use View\LatteViewRenderer;
use Service\PaginationService;


class UserController
{
    protected ?UserService $userService;
    protected ?LatteViewRenderer $frontendViewhelper;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->frontendViewhelper = new LatteViewRenderer();
    }

    public function loginAction(array $params): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userService->loginUser($params);
            $error = '';
            var_dump($user);

            if ($user) {
                session_regenerate_id(true); // Verhindert Session-Fixation
                $_SESSION['user'] = $user;    // Speichere Benutzerdaten
                header('Location: /');
                exit;
            } else {
                $error = 'Ungültige Anmeldedaten.';
            }
        }

        $templateParams = [
            'msg' => $error,
            'user' => $_SESSION['user'] ?? null,
            'action' => __FUNCTION__
        ];

        $this->frontendViewhelper->renderLogin($templateParams);
    }

    public function registerAction(array $params): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userService->registerUser($params);
            $error = '';

            if ($user) {
                session_regenerate_id(true); // Verhindert Session-Fixation
                $_SESSION['user'] = $user;    // Speichere Benutzerdaten
                header('Location: /');
                exit;
            } else {
                $error = 'Registrierung fehlgeschlagen oder Daten ungültig.';
            }
        }

        $templateParams = [
            'msg' => $error,
            'user' => $_SESSION['user'] ?? null,
            'action' => __FUNCTION__
        ];

        $this->frontendViewhelper->renderRegister($templateParams);
    }
    public function logoutAction(array $params): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}
