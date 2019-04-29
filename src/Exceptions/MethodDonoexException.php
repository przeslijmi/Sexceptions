<?php

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
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
     * @param Exception|null $cause      Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $className, string $methodName, ?Exception $cause = null)
    {

        $this->setCodeName('MethodDonoexException');
        $this->addInfo('context', $context);
        $this->addInfo('className', $className);
        $this->addInfo('methodName', $methodName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}