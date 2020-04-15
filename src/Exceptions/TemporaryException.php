<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Temporary exception for development purposes.
 */
class TemporaryException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $content  Contents of the exception.
     * @param string         $codeName Optional, class name. Code name if given to use.
     * @param Throwable|null $cause    Throwable that caused the problem.
     */
    public function __construct(string $content, string $codeName = '', ?Throwable $cause = null)
    {

        $this->addHint($content . ' This is development temporary exception and has to be reingd.');

        if (empty($codeName) === false) {
            $this->setCodeName($codeName);
        }

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
