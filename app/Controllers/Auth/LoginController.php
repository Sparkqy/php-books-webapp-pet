<?php

namespace App\Controllers\Auth;

use App\Controllers\AbstractController;
use App\Models\User;
use Exception;
use Src\Helpers\Router;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LoginController extends AbstractController
{
    /**
     * @var array
     */
    private $validationRules = [
        'login_email' => 'email',
        'login_password' => 'required',
    ];

    /**
     * @var string
     */
    protected $redirectIfFailed = '/login';

    /**
     * @var string
     */
    protected $redirectIfSuccess = '/admin';

    public function __construct()
    {
        parent::__construct();

        if ($this->user !== null) {
            Router::redirect($this->redirectIfSuccess);
        }
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(): void
    {
        echo $this->twig->render('auth/login.twig');
    }

    /**
     * @throws Exception
     */
    public function login(): void
    {
        $validated = $this->validator->validate($_POST, $this->validationRules)->get();

        if (!$validated) {
            Router::redirectWithFlash('error', [
                'message' => $this->validator->echoErrors(),
                'class' => 'alert-danger',
            ], $this->redirectIfFailed);
        }

        /** @var User $user */
        $user = User::where('email', $validated['login_email'])->first();

        if (empty($user) || !password_verify($validated['login_password'], $user->password) || !$user->isAdmin()) {
            Router::redirectWithFlash('error', [
                'message' => 'Invalid email or password',
                'class' => 'alert-danger',
            ], $this->redirectIfFailed);
        }

        $user->refreshHash();
        $this->auth->authorize($user, $user->auth_token);

        Router::redirectWithFlash('success', [
            'message' => 'You are successfully authorized as ' . $user->full_name . '. Role: Admin',
            'class' => 'alert-success',
        ], $this->redirectIfSuccess);
    }
}