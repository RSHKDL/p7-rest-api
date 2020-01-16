<?php

namespace App\Application\Validation\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * Class NoDuplicateClientEmail
 * @author ereshkidal
 */
class NoDuplicateClientEmail extends Constraint
{
    public $message = 'A client already exist for this email address.';

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return get_class($this).'Validator';
    }
}
