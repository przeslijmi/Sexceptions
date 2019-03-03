<?php

namespace Przeslijmi\Sexceptions\Exceptions;

use Exception;
use Przeslijmi\Sexceptions\Sexception;

/**
 * Type hinting test failed - tested value is in different type that it should be.
 */
class TypeHintingFailException extends Sexception
{

    /**
     * What type should be used.
     *
     * @var   string
     * @since v1.0
     */
    private $shouldBe = '';

    /**
     * What is the real type of the value.
     *
     * @var   string
     * @since v1.0
     */
    private $isInFact = '';

    /**
     * Constructor.
     *
     * @param string         $shouldBe What type should be used.
     * @param string         $isInFact What is the real type of the value.
     * @param Exception|null $cause    Exception that caused the problem.
     *
     * @since v1.0
     */
    public function __construct(string $shouldBe, string $isInFact, ?Exception $cause=null)
    {

        $this->setCodeName('TypeHintingFailException');
        $this->addInfo('shouldBe', $shouldBe);
        $this->addInfo('isInFact', $isInFact);

        $this->shouldBe = $shouldBe;
        $this->isInFact = $isInFact;

        if (is_null($cause) === false) {
            parent::__construct($this->getCodeName(), 0, $cause);
        }
    }

    /**
     * Getter for "should be".
     *
     * @return string
     * @since  v1.0
     */
    public function getShouldBe() : string
    {

        return $this->shouldBe;
    }

    /**
     * Getter for "is in fact".
     *
     * @return string
     * @since  v1.0
     */
    public function getIsInFact() : string
    {

        return $this->isInFact;
    }
}
