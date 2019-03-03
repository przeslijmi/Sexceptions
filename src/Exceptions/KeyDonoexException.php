<?php

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Parameter's given value is out of set (enum - not out of range [i .... j]).
 */
class KeyDonoexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context   During what operation, what is the nature of the error.
     * @param array          $range     Existing keys.
     * @param string         $actualKey Actually given key.
     * @param Exception|null $cause     Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, array $range, string $actualKey, ?Exception $cause=null)
    {

        $this->setCodeName('KeyDonoexException');
        $this->addInfo('context', $context);
        $this->addInfo('range', implode(', ', $range));
        $this->addInfo('actualKey', $actualKey);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
