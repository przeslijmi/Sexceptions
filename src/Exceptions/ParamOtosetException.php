<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Parameter's given value is out of set (enum - not out of range [i .... j]).
 */
class ParamOtosetException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $paramName   Name of the parameter with error.
     * @param array          $range       Possible values that can be given.
     * @param string         $actualValue Actually given value.
     * @param Throwable|null $cause       Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(
        string $paramName,
        array $range,
        string $actualValue,
        ?Throwable $cause = null
    ) {

        $this->addInfo('paramName', $paramName);
        if (count($range) > 0) {
            $this->addInfo('range', implode(', ', $range));
        } else {
            $this->addInfo('range', 'EMPTY (NONE POSSIBLE)');
        }
        $this->addInfo('actualValue', $actualValue);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
