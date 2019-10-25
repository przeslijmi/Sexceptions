<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Given value is out of set (enum - not out of range [i .... j]).
 */
class ValueOtosetException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $name        Name of the value with error.
     * @param array          $range       Possible values that can be given.
     * @param string         $actualValue Actually given value.
     * @param Throwable|null $cause       Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $name, array $range, string $actualValue, ?Throwable $cause = null)
    {

        $this->addInfo('name', $name);
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
