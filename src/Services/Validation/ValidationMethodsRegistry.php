<?php

namespace Src\Services\Validation;

class ValidationMethodsRegistry
{
    /**
     * @param $value
     * @return bool
     */
    public function validateRequired($value): bool
    {
        return !empty($value);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function validateEmail(string $email): bool
    {
        return $this->validateRequired($email) ? filter_var($email, FILTER_VALIDATE_EMAIL) : false;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validateNumeric($value): bool
    {
        return is_numeric($value);
    }
}