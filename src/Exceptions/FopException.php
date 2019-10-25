<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Operation outside class or method failed - nothing more will be done.
 */
class FopException extends Sexception
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
