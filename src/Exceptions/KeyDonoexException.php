<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Parameter's given value is out of set (enum - not out of range [i .... j]).
 */
class KeyDonoexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context   During what operation, what is the nature of the error.
     * @param array          $range     Existing keys.
     * @param string         $actualKey Actually given key.
     * @param Throwable|null $cause     Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, array $range, string $actualKey, ?Throwable $cause = null)
    {

        $this->addInfo('context', $context);
        if (count($range) > 0) {
            $this->addInfo('range', implode(', ', $range));
        } else {
            $this->addInfo('range', 'EMPTY (NONE POSSIBLE)');
        }
        $this->addInfo('actualKey', $actualKey);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
