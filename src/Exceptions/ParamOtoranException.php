<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Parameter's given value is out of range [i .... j] (not out of set).
 */
class ParamOtoranException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $paramName   Name of the parameter with error.
     * @param string         $range       Possible values that can be given, eg. `5 - 12`.
     * @param string         $actualValue Actually given value.
     * @param Exception|null $cause       Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(
        string $paramName,
        string $range,
        string $actualValue,
        ?Exception $cause = null
    ) {

        $this->setCodeName('ParamOtoranException');
        $this->addInfo('paramName', $paramName);
        $this->addInfo('range', $range);
        $this->addInfo('actualValue', $actualValue);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}