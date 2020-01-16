<?php

namespace Src\Services\Auth;

use App\Models\User;
use Src\Helpers\Cookie;

class Auth implements AuthInterface
{
    /**
     * @return User|null
     */
    public static function getUserByAuthToken(): ?User
    {
        $authToken = Cookie::get('auth_token');

        if ($authToken === null) {
            return null;
        }

        list($id, $token) = explode(':', $authToken, 2);
        $user = User::find($id);

        if ($user === null) {
            return null;
        }

        if ($user->auth_token !== $token) {
            return null;
        }

        return $user;
    }

    /**
     * @param User $user
     * @param string $authToken
     * @return bool
     */
    public function authorize(User $user, string $authToken): bool
    {
        if (empty($authToken)) {
            Cookie::set('auth_token', null);
            Cookie::set('is_authorized', false);

            return false;
        }

        $this->setAuthToken($user->id, $authToken);
        Cookie::set('is_authorized', true);

        return true;
    }

    public function unAuthorize(): void
    {
        Cookie::unset('auth_token');
        Cookie::unset('is_authorized');
    }

    /**
     * @param string $password
     * @return string
     */
    public static function encryptPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return bool|null
     */
    public static function isAuthorized(): ?bool
    {
        if (!Cookie::has('is_authorized')) {
            return false;
        }

        return ((bool)Cookie::get('is_authorized') === true) ? true : false;
    }

    /**
     * @param int $userId
     * @param string $authToken
     * @return $this
     */
    private function setAuthToken(int $userId, string $authToken): self
    {
        $token = $userId . ':' . $authToken;
        Cookie::set('auth_token', $token);

        return $this;
    }
}