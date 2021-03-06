<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Looking for class that does not exist.
 */
class ClassDonoexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context   During what operation, what is the nature of the error.
     * @param string         $className Full name of the class.
     * @param Throwable|null $cause     Throwable that caused the problem.
     */
    public function __construct(string $context, string $className, ?Throwable $cause = null)
    {

        $this->addInfo('context', $context);
        $this->addInfo('className', $className);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
