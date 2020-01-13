<?php

namespace Src\Services\Auth;

use Src\Helpers\Cookie;

class Auth implements AuthInterface
{
    /**
     * @param string $authHash
     * @return bool
     */
    public function authorize(string $authHash): bool
    {
        if (empty($authHash)) {
            Cookie::set('auth_hash', null);

            return false;
        }

        Cookie::set('is_authorized', true);
        Cookie::set('auth_hash', $authHash);

        return true;
    }

    public function unAuthorize(): void
    {
        Cookie::unset('auth_hash');
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
    public function isAuthorized(): ?bool
    {
        if (!Cookie::has('is_authorized')) {
            return false;
        }

        return Cookie::get('is_authorized');
    }

    /**
     * @return string|null
     */
    public function getAuthHash(): ?string
    {
        return Cookie::get('auth_hash');
    }
}