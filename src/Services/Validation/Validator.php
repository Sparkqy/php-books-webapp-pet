<?php

namespace Src\Services\Validation;

class Validator
{
    /**
     * @var ValidationMethodsRegistry
     */
    protected $validationMethodRegistry;

    /**
     * @var array
     */
    protected $ruleMethodLinksRegistry = [
        'required' => 'validateRequired',
        'email' => 'validateEmail',
        'numeric' => 'validateNumeric',
    ];

    /**
     * @var array
     */
    protected $ruleErrorMessages = [
        'required' => 'cannot be empty',
        'email' => 'must be in valid email format',
        'numeric' => 'field must be numeric',
    ];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array
     */
    protected $validated = [];
    
    public function __construct()
    {
        $this->validationMethodRegistry = new ValidationMethodsRegistry();
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