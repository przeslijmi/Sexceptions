<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
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
     * @param Exception|null $cause        Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $valueName, string $typeExpected, string $actualType, ?Exception $cause = null)
    {

        $this->addInfo('valueName', $valueName);
        $this->addInfo('typeExpected', $typeExpected);
        $this->addInfo('actualType', $actualType);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
