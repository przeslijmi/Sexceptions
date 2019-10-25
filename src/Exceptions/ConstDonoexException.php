<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Looking for constant that does not exist.
 */
class ConstDonoexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context   During what operation, what is the nature of the error.
     * @param string         $constName Full name of the class.
     * @param Throwable|null $cause     Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $constName, ?Throwable $cause = null)
    {

        $this->addInfo('context', $context);
        $this->addInfo('constName', $constName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
