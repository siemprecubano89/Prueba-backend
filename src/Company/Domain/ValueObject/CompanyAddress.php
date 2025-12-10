<?php

namespace OptimaCultura\Company\Domain\ValueObject;

final class CompanyAddress
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('Address cannot be empty');
        }

        if (strlen($value) > 500) {
            throw new \InvalidArgumentException('Address is too long');
        }
    }

    public function get(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
