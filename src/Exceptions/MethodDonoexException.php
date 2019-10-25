<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Looking for method inside class that does not exist.
 */
class MethodDonoexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context    During what operation, what is the nature of the error.
     * @param string         $className  Full name of the class.
     * @param string         $methodName Full name of the method that should be existing.
     * @param Throwable|null $cause      Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $className, string $methodName, ?Throwable $cause = null)
    {

        $this->addInfo('context', $context);
        $this->addInfo('className', $className);
        $this->addInfo('methodName', $methodName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
