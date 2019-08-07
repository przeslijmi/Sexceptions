<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * File already exists - and cannot be overwritten.
 */
class FileAlrexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context  During what operation, what is the nature of the error.
     * @param string         $fileName Name of the file.
     * @param Exception|null $cause    Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $fileName, ?Exception $cause = null)
    {

        $this->setCodeName('FileAlrexException');
        $this->addInfo('context', $context);
        $this->addInfo('fileName', $fileName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
