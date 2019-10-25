<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions\Exceptions;

use Throwable;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Some object that is called is not existing.
 */
class ObjectDonoexException extends Sexception
{

    /**
     * Constructor.
     *
     * @param string         $context What object is missing.
     * @param Throwable|null $cause   Throwable that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $context, ?Throwable $cause = null)
    {

        $this->addInfo('context', $context);

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }
}
