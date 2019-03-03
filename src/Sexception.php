<?php

namespace Przeslijmi\Sexceptions;

use Exception;

/**
 * Parent of all Sexceptions.
 */
abstract class Sexception extends Exception
{

    /**
     * Name of the child class that called exception.
     *
     * @var   string
     * @since v1.0
     */
    private $codeName = '';

    /**
     * Pairs of (string)key <=> (string)value extra informations about the nature of exception.
     *
     * @var   array
     * @since v1.0
     */
    private $infos = [];

    /**
     * Setter for code name.
     *
     * @param string $codeName Code name.
     *
     * @return void
     * @since  v1.0
     */
    protected function setCodeName(string $codeName) : void
    {

        $this->codeName = $codeName;
    }

    /**
     * Getter for code name.
     *
     * @return string
     * @since  v1.0
     */
    public function getCodeName() : string
    {

        return $this->codeName;
    }

    /**
     * Adds one info (one pair) to infos array.
     *
     * @param string      $infoKey   Name of the information (key).
     * @param string|null $infoValue Content of the information.
     *
     * @return self
     * @since  v1.0
     */
    public function addInfo(string $infoKey, ?string $infoValue=null) : self
    {

        // ignore if there is no value
        if (is_null($infoValue) === true) {
            return $this;
        }

        $this->infos[$infoKey] = $infoValue;

        return $this;
    }

    /**
     * Adds many infos with possible prefix.
     *
     * @param array|null  $infos  Contents of infos to be added (array of key-info pairs).
     * @param string|null $prefix (opt.) If given all info keys will be prefixed with this prefix and a dot.
     *
     * @return self
     * @since  v1.0
     */
    public function addInfos(?array $infos=null, ?string $prefix=null) : Sexception
    {

        // ignore if there is no value
        if (is_null($infos) === true) {
            return $this;
        }

        if (is_null($prefix) === false) {
            $prefix = $prefix . '.';
        }

        foreach ($infos as $infoKey => $infoValue) {

            $showValue = '';

            switch ($infoValueType = gettype($infoValue)) {
            case 'resource':
            case 'NULL':
            case 'array':
            case 'unknown type':
            case 'resource (closed)':
                $showValue = $infoValueType;
                break;

            case 'boolean':
                $showValue = [ 'false', 'true' ][$infoValue];
                break;

            case 'integer':
            case 'double':
            case 'string':
                $showValue = (string) $infoValue;
                break;

            case 'object':
                if (method_exists($infoValue, 'toString') === true) {
                    $showValue = $infoValue->toString();
                } else {
                    $showValue = 'object (no toString method)';
                }
                break;
            }//end switch

            $this->infos[( $prefix . $infoKey )] = $showValue;
        }//end foreach

        return $this;
    }

    /**
     * Getter for all infos.
     *
     * @return array
     * @since  v1.0
     */
    public function getInfos() : array
    {
        return $this->infos;
    }
}
