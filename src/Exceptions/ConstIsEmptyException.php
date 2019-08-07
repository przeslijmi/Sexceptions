<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Needed constant is empty.
 */
class ConstIsEmptyException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $constName Name of the property that is empty and should not be.
     * @param Exception|null $cause     Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $constName, ?Exception $cause = null)
    {

        $this->setCodeName('ConstantIsEmptyException');
        $this->addInfo('constName', $constName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
