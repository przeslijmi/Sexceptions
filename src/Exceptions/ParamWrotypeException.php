<?php

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Parameter's given value is in wrong type (eg. int expected but string was given).
 */
class ParamWrotypeException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $paramName    Name of the parameter with error.
     * @param string         $typeExpected Name of the expected type (eg. string, string[]).
     * @param string         $actualType   Actually given type.
     * @param Exception|null $cause        Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $paramName, string $typeExpected, string $actualType, ?Exception $cause = null)
    {

        $this->setCodeName('ParamWrotypeException');
        $this->addInfo('paramName', $paramName);
        $this->addInfo('typeExpected', $typeExpected);
        $this->addInfo('actualType', $actualType);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}