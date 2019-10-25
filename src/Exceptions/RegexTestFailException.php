<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Regular expression test failed.
 */
class RegexTestFailException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $value Value that has been checked against regular expression.
     * @param string         $regex Contents of the regular expression.
     * @param Throwable|null $cause Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $value, string $regex, ?Throwable $cause = null)
    {

        $this->addInfo('value', $value);
        $this->addInfo('regex', $regex);
        $this->addHint('See RegEx above!');

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
