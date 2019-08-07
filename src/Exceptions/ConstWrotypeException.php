<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Needed constant value has wrong type.
 */
class ConstWrotypeException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $constName    Name of the constant with error.
     * @param string         $typeExpected Name of the expected type (eg. string, string[]).
     * @param string         $actualType   Actually given type.
     * @param Exception|null $cause        Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $constName, string $typeExpected, string $actualType, ?Exception $cause = null)
    {

        $this->setCodeName('ConstWrotypeException');
        $this->addInfo('constName', $constName);
        $this->addInfo('typeExpected', $typeExpected);
        $this->addInfo('actualType', $actualType);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
