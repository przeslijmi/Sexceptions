<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Needed constant is empty.
 */
class ConstIsEmptyException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $constName Name of the property that is empty and should not be.
     * @param Throwable|null $cause     Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $constName, ?Throwable $cause = null)
    {

        $this->addInfo('constName', $constName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
