<?php

declare(strict_types=1);

namespace App\Model\Shared\Domain;

use DomainException as BaseDomainException;

abstract class DomainException extends BaseDomainException
{
    protected string $errorCode;

    public function getErrorCode(): string
    {
        return 'course_not_exist';
    }
}
