<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Looking for class of other type that has been found.
 */
class ClassWrotypeException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context                 During what operation, what is the nature of the error.
     * @param string         $className               Full name of the class.
     * @param string         $parentClassNameExpected Full name of the class that className should be a parent of.
     * @param Exception|null $cause                   Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(
        string $context,
        string $className,
        string $parentClassNameExpected,
        ?Exception $cause = null
    ) {

        $this->setCodeName('ClassWrotypeException');
        $this->addInfo('context', $context);
        $this->addInfo('className', $className);
        $this->addInfo('parentClassNameExpected', $parentClassNameExpected);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
