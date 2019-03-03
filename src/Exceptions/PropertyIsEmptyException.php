<?php

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Parameter's given value is out of set (enum - not out of range [i .... j]).
 */
class PropertyIsEmptyException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $propertyName Name of the property that is empty and should not be.
     * @param Exception|null $cause        Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $propertyName, ?Exception $cause=null)
    {

        $this->setCodeName('PropertyIsEmptyException');
        $this->addInfo('propertyName', $propertyName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
