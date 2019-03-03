<?php

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Given pointer has wrong syntax (file reading pointer that does not read file).
 */
class PointerWrosynException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context     During what operation, what is the nature of the error.
     * @param string         $pointerName Name of the pointer (eg. file reader).
     * @param Exception|null $cause       Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $pointerName, ?Exception $cause=null)
    {

        $this->setCodeName('PointerWrosynException');
        $this->addInfo('context', $context);
        $this->addInfo('pointerName', $pointerName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
