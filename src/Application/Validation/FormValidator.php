<?php

namespace App\Application\Validation;

use App\UI\Errors\ApiProblem;
use App\UI\Errors\ApiProblemException;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormValidator
 * @author ereshkidal
 */
final class FormValidator
{
    /**
     * @param FormInterface $form
     */
    public function throwValidationErrorException(FormInterface $form): void
    {
        $errors = $this->getErrorsFromForm($form);
        $apiProblem = new ApiProblem(
            400,
            ApiProblem::TYPE_VALIDATION_ERROR
        );
        $apiProblem->setExtraData('errors', $errors);

        throw new ApiProblemException($apiProblem);
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface && $childErrors = $this->getErrorsFromForm($childForm)) {
                $errors[$childForm->getName()] = $childErrors;
            }
        }

        return $errors;
    }
}
