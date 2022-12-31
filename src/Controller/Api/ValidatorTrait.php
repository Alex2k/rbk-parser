<?php

namespace App\Controller\Api;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function count;

trait ValidatorTrait
{
    protected ValidatorInterface $validator;
    protected Assert\Collection $constraints;

    protected function contentValidation(array $context = []): array
    {
        $violations = $this->validator->validate($context, $this->constraints);

        $errorMessages = [];
        if (count($violations) > 0) {
            $accessor = PropertyAccess::createPropertyAccessor();

            foreach ($violations as $violation) {
                $accessor->setValue(
                    $errorMessages,
                    $violation->getPropertyPath(),
                    $violation->getMessage()
                );
            }
        }

        return $errorMessages;
    }
}
