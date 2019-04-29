<?php

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
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
     * @param Exception|null $cause Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $value, string $regex, ?Exception $cause = null)
    {

        $this->setCodeName('RegexTestFailException');
        $this->addInfo('value', $value);
        $this->addInfo('regex', $regex);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
