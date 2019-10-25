<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Method failed it's operation - nothing more will be done in this class.
 */
class MethodFopException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context During what operation, what is the nature of the error.
     * @param Throwable|null $cause   Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, ?Throwable $cause = null)
    {

        $this->addInfo('context', $context);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
