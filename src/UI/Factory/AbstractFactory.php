<?php

namespace App\UI\Factory;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Repository\Interfaces\Manageable;
use App\UI\Errors\ApiProblem;
use App\UI\Errors\ApiProblemException;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\FormInterface;

/**
 * @todo externalize getErrorsFromForm() and throwValidationErrorException(). Remove AbstractFactory.
 * Class AbstractFactory
 * @author ereshkidal
 */
abstract class AbstractFactory
{
    protected const CREATE_ACTION = 'create';
    protected const UPDATE_ACTION = 'update';
    protected const DELETE_ACTION = 'delete';

    /**
     * @todo externalize logic in service
     * @param FormInterface $form
     * @return array
     */
    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }

    /**
     * @param FormInterface $form
     */
    protected function throwValidationErrorException(FormInterface $form): void
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
     * @todo seems like a bit much over-engineered ?
     * @param string $action
     * @param ObjectRepository $repository
     * @param EntityInterface|null $entity
     * @param string|null $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function checkThenUseRepository(
        string $action,
        ObjectRepository $repository,
        ?EntityInterface $entity = null,
        ?string $id = null
    ): void {
        if (!$repository instanceof Manageable) {
            throw new \InvalidArgumentException(
                'The repository given by the Model does not implement Manageable'
            );
        }

        switch ($action) {
            case $action === self::CREATE_ACTION:
                $repository->save($entity);
                break;
            case $action === self::UPDATE_ACTION:
                $repository->update($entity);
                break;
            case $action === self::DELETE_ACTION:
                $repository->remove($id);
                break;
        }
    }
}
