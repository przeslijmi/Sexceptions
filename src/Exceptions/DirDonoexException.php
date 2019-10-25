<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
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
     * @param Throwable|null $cause   Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, string $dirName, ?Throwable $cause = null)
    {

        $this->addInfo('context', $context);
        $this->addInfo('dirName', $dirName);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
