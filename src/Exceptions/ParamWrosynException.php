<?php

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Parameter's given value is in wrong syntax.
 */
class ParamWrosynException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $paramName   Name of the parameter with error.
     * @param string         $actualValue Actually given value.
     * @param Exception|null $cause       Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $paramName, string $actualValue, ?Exception $cause=null)
    {

        $this->setCodeName('ParamWrosynException');
        $this->addInfo('paramName', $paramName);
        $this->addInfo('actualValue', $actualValue);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
