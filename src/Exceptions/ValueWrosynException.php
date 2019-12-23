<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Value is in wrong syntax.
 */
class ValueWrosynException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context What value has wrong syntax.
     * @param string         $value   Actually given value.
     * @param Throwable|null $cause   Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $value, ?Throwable $cause = null)
    {

        // Define.
        $this->addInfo('context', $context);
        $this->addInfo('value', $value);

        // Call parent.
        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
