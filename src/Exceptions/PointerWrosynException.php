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
     * @param string         $context During what operation, what is the nature of the error.
     * @param Exception|null $cause   Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, ?Exception $cause = null)
    {

        $this->setCodeName('PointerWrosynException');
        $this->addInfo('context', $context);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}