<?php

namespace Delta\Components\Http\Validators;

use Delta\Components\Http\Interfaces\RequestValidator as IRequestValidator;
use Validator\Validator;


abstract class RequestValidator implements IRequestValidator
{
    private Validator $validator;


    public function __construct(private array &$data, private object $entity)
    {
        $this->validator = new Validator;
    }

    private function setEntityProps(): void
    {
        foreach ($this->data as $prop => $value) {
            $this->entity->{$prop} = $value;
        }
    }

    final public function validate(): bool
    {
        $this->setEntityProps();

        $isValid = $this->validator->validate($this->entity);

        $this->data = $this->entity->toArray();

        return $isValid;
    }

    final public function getValidationErrors(): array
    {
        return $this->validator->getErrors();
    }
}
