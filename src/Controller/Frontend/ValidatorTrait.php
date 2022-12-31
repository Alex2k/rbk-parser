<?php

namespace App\Controller\Frontend;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidatorTrait
{
    protected ValidatorInterface $validator;
    protected Assert\Collection $constraints;

    protected function contentValidation(array $context = []): ConstraintViolationListInterface
    {
        return $this->validator->validate($context, $this->constraints);
    }
}
