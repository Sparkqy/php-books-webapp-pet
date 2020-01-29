<?php

namespace Src\Services\Validation;

use Src\Exceptions\FileNotFoundException;
use Src\Helpers\Config;

class Validator
{
    /**
     * @var ValidationMethodsRegistry
     */
    protected ValidationMethodsRegistry $validationMethodRegistry;

    /**
     * @var array
     */
    protected array $ruleMethodLinksRegistry = [];

    /**
     * @var array
     */
    protected array $ruleErrorMessages = [];

    /**
     * @var array
     */
    protected array $errors = [];

    /**
     * @var array
     */
    protected array $validated = [];

    /**
     * Validator constructor.
     * @throws FileNotFoundException
     */
    public function __construct()
    {
        $this->validationMethodRegistry = new ValidationMethodsRegistry();
        $this->ruleMethodLinksRegistry = Config::get('rule_method_links_registry');
        $this->ruleErrorMessages = Config::get('rule_error_messages');
    }

    /**
     * @param string $rule
     * @param $value
     * @return mixed
     */
    private function callRuleValidator(string $rule, $value)
    {
        if (!array_key_exists($rule, $this->ruleMethodLinksRegistry)) {
            throw new \InvalidArgumentException('Provided rule does not exist in Rules registry');
        }

        $validationMethod = $this->ruleMethodLinksRegistry[$rule];

        if (!method_exists($this->validationMethodRegistry, $validationMethod) || !is_callable([$this->validationMethodRegistry, $validationMethod])) {
            throw new \InvalidArgumentException('Validation method does not exist or not callable');
        }

        return $this->validationMethodRegistry->$validationMethod($value);
    }

    /**
     * @param array $input
     * @param array $rules
     * @return Validator
     */
    public function validate(array $input, array $rules): self
    {
        foreach ($input as $inputName => $inputValue) {
            if (array_key_exists($inputName, $rules)) {
                $rule = $rules[$inputName];
                $isValid = $this->callRuleValidator($rule, $inputValue);

                if ($isValid) {
                    $this->validated[$inputName] = $inputValue;
                } else {
                    $this->errors[] = [
                        'input_name' => $inputName,
                        'message' => $this->setErrorMessage($inputName, $this->ruleErrorMessages[$rule])
                    ];
                }
            } else {
                $this->validated[$inputName] = $inputValue;
            }
        }

        return $this;
    }

    /**
     * @param string $inputName
     * @param string $error
     * @return string
     */
    private function setErrorMessage(string $inputName, string $error): string
    {
        return ucfirst($inputName) . ' ' . $error . '. ';
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors) ? true : false;
    }

    /**
     * @return string
     */
    public function echoErrors(): string
    {
        $string = '';

        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                $string .= $error['message'];
            }
        }

        return $string;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->validated;
    }
}