<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Directory does not exists.
 */
class DirDonoexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context During what operation, what is the nature of the error.
     * @param string         $dirName Name of the file.
     * @param Exception|null $cause   Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $dirName, ?Exception $cause = null)
    {

        $this->setCodeName('DirDonoexException');
        $this->addInfo('context', $context);
        $this->addInfo('dirName', $dirName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
