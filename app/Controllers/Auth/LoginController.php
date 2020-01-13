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
     * @var string
     */
    protected $redirectIfFailed = '/login';

    /**
     * @var string
     */
    protected $redirectIfAuthAsAdmin = '/admin';

    /**
     * @var string
     */
    protected $redirectIfAuthAsUser = '/dashboard';

    public function __construct()
    {
        parent::__construct();

        if ($this->auth->isAuthorized()) {
            Router::redirect('/admin');
        }
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        echo $this->twig->render('auth/login.twig');
    }

    /**
     * @throws Exception
     */
    public function login(): void
    {
        list($email, $password) = $this->validateLoginInput();

        /** @var User $user */
        $user = User::where('email', $email)->first();

        if (empty($user) || !password_verify($password, $user->password)) {
            Router::redirectWithFlash('error', [
                'message' => 'Invalid email or password',
                'class' => 'alert-danger',
            ], $this->redirectIfFailed);
        }

        $user->refreshHash();
        $this->auth->authorize($user->hash);

        if ($user->isAdmin()) {
            Router::redirectWithFlash('success', [
                'message' => 'You are successfully authorized as ' . $user->full_name . '. Role: Admin',
                'class' => 'alert-success',
            ], $this->redirectIfAuthAsAdmin);
        }

        Router::redirectWithFlash('success', [
            'message' => 'You are successfully authorized as ' . $user->full_name,
            'class' => 'alert-success',
        ], $this->redirectIfAuthAsUser);
    }

    public function logout()
    {

    }

    /**
     * @return array
     */
    private function validateLoginInput(): array
    {
        $email = isset($_POST['login_email']) ? trim($_POST['login_email']) : null;
        $password = isset($_POST['login_password']) ? htmlspecialchars(trim($_POST['login_password'])) : null;

        if (empty($email) || empty($password)) {
            Router::redirectWithFlash('error', [
                'message' => 'Invalid email format',
                'class' => 'alert-danger',
            ], $this->redirectIfFailed);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Router::redirectWithFlash('error', [
                'message' => 'Invalid email format',
                'class' => 'alert-danger',
            ], $this->redirectIfFailed);
        }

        return [$email, $password];
    }
}