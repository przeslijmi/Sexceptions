<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Loop was stopped because range security setting was reached.
 */
class LoopOtoranException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context  During what operation, what is the nature of the error.
     * @param integer        $maxRange Range that was reached.
     * @param Throwable|null $cause    Throwable that caused the problem.
     *
     * @since v1.2
     */
    public function __construct(string $context, int $maxRange, ?Throwable $cause = null)
    {

        $this->addInfo('context', $context);
        $this->addInfo('maxRange', (string) $maxRange);
        $this->addHint('Loop reached its top value of ' . $maxRange . '.');

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
