<?php


namespace App\UI\Factory\Traits;

use App\UI\Errors\ApiProblem;
use App\UI\Errors\ApiProblemException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trait ProcessFormTrait
 * @author ereshkidal
 */
trait ProcessFormTrait
{
    /**
     * @param Request $request
     * @param FormInterface $form
     */
    protected function processForm(Request $request, FormInterface $form): void
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            $apiProblem = new ApiProblem(422, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            throw new ApiProblemException($apiProblem);
        }
        $clearMissing = $request->getMethod() !== 'PATCH';
        $form->submit($data, $clearMissing);
    }
}
