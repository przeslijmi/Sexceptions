<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Given value is in wrong type.
 */
class ValueWrotypeException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $valueName    Name of the value with error.
     * @param string         $typeExpected Name of the expected type (eg. string, string[]).
     * @param string         $actualType   Actually given type.
     * @param Throwable|null $cause        Throwable that caused the problem.
     *
     * @since v1.2
     */
    public function __construct(string $valueName, string $typeExpected, string $actualType, ?Throwable $cause = null)
    {

        $this->addInfo('valueName', $valueName);
        $this->addInfo('typeExpected', $typeExpected);
        $this->addInfo('actualType', $actualType);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
