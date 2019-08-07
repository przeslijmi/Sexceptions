<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Key in collection is already taken - can not be used again.
 */
class KeyAlrexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context   During what operation, what is the nature of the error.
     * @param string         $actualKey Actually given key.
     * @param Exception|null $cause     Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $actualKey, ?Exception $cause = null)
    {

        $this->setCodeName('KeyDonoexException');
        $this->addInfo('context', $context);
        $this->addInfo('actualKey', $actualKey);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
