<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Propoerty of object is empty - and mustn't be.
 */
class PropertyIsEmptyException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $propertyName Name of the property that is empty and should not be.
     * @param Throwable|null $cause        Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $propertyName, ?Throwable $cause = null)
    {

        $this->addInfo('propertyName', $propertyName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
