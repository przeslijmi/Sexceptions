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
     * @param string $content Contents of the exception.
     *
     * @since v1.0
     */
    public function __construct(string $content)
    {

        $this->addHint($content . ' This is development temporary exception and has to be reingd.');
    }
}
