<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions;

use Exception;
use Throwable;

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
     * @since  v1.1 When no code name defined - class name (without namespace) is returned as default.
     * @since  v1.0
     */
    public function getCodeName() : string
    {

        // When no code name defined - class name (without namespace) is returned as default.
        if (empty($this->codeName) === true) {
            return substr(get_class($this), ( strrpos(get_class($this), '\\') + 1 ));
        }

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
    public function addInfo(string $infoKey, ?string $infoValue = null) : self
    {

        // Ignore if there is no value.
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
     * @param string|null $prefix Optional. If given all info keys will be prefixed with this prefix and a dot.
     *
     * @return self
     * @since  v1.0
     */
    public function addInfos(?array $infos = null, ?string $prefix = null) : self
    {

        // Ignore if there is no value.
        if (is_null($infos) === true) {
            return $this;
        }

        if (is_null($prefix) === false) {
            $prefix = $prefix . '.';
        }

        foreach ($infos as $infoKey => $infoValue) {

            // Lvd.
            $showValue     = 'unknown variable type';
            $infoValueDict = [
                'resource' => 'nonScalarNonObject',
                'NULL' => 'nonScalarNonObject',
                'array' => 'nonScalarNonObject',
                'unknown type' => 'unknown',
                'resource (closed)' => 'nonScalarNonObject',
                'boolean' => 'boolean',
                'integer' => 'scalar',
                'double' => 'scalar',
                'string' => 'scalar',
                'object' => 'object',
            ];
            $infoValueType = ( $infoValueDict[gettype($infoValue)] ?? 'unknown' );

            switch ($infoValueType) {

                case 'nonScalarNonObject':
                    $showValue = $infoValueType;
                break;

                case 'boolean':
                    $showValue = [ 'false', 'true' ][$infoValue];
                break;

                case 'scalar':
                    $showValue = (string) $infoValue;
                break;

                case 'object':
                    if (method_exists($infoValue, 'toString') === true) {
                        $showValue = $infoValue->toString();
                    } else {
                        $showValue = 'object (no toString method)';
                    }
                break;

                default:
                    $showValue = 'unknown value type';
                break;
            }//end switch

            $this->infos[( $prefix . $infoKey )] = $showValue;
        }//end foreach

        return $this;
    }

    /**
     * Add object that serves public method `getExceptionInfos` to transfer infos faster.
     *
     * @param object $object Any object that serves `getExceptionInfos` public method.
     *
     * @return self
     * @since  v1.0
     */
    public function addObjectInfos(object $object) : self
    {

        // Transfer each info.
        foreach ($object->getExceptionInfos() as $infoKey => $infoValue) {
            $this->addInfo($infoKey, $infoValue);
        }

        return $this;
    }

    /**
     * Adds hint.
     *
     * @param string $hint Hint for exception.
     *
     * @return self
     * @since  v1.0
     */
    public function addHint(string $hint) : self
    {

        // Save.
        $this->infos['hint'] = $hint;

        return $this;
    }

    /**
     * Showing warning when it was silenced.
     *
     * Warning has been silnced and now exception is thrown - so it is needed to
     * show detailes of this silenced warning.
     *
     * @return self
     * @since  v1.0
     */
    public function addWarning() : self
    {

        // Lvd.
        $last = error_get_last();

        // Add info about warning.
        $this->addInfo('warning', ( $last['message'] ?? '' ));

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

    /**
     * Setter for cause of Throwabel (to create chain of causes).
     *
     * @param Throwable $throwable Throwable that caused current Throwabel.
     *
     * @return self
     * @since  v1.0
     */
    public function setCause(Throwable $throwable) : self
    {

        parent::__construct($this->getCodeName(), 0, $throwable);

        return $this;
    }

    /**
     * Getter for cause of this Throwable (if present);
     *
     * @since  v1.0
     * @return null|Throwable
     */
    public function getCause() : ?Throwable
    {

        return $this->getPrevious();
    }

    /**
     * Return exception from causes of this Sexception that has given cause class.
     *
     * @param string         $className What Sexception class to look in causes.
     * @param Exception|null $deeper    Ignore. Just to loop in.
     *
     * @since  v1.0
     * @return null|Sexception Sexception of given class or null.
     */
    public function hasInCauses(string $className, ?Exception $deeper = null) : ?Sexception
    {

        // Lvd.
        if (func_num_args() === 2) {
            $analize = $deeper->getPrevious();
        } else {
            $analize = $this->getPrevious();
        }

        // Short way - if this is null or not an Sexception.
        if ($analize === null || is_a($analize, 'Przeslijmi\Sexceptions\Sexception') === false) {
            return null;
        }

        // There is!
        if (get_class($analize) === $className) {
            return $analize;
        }

        return $this->hasInCauses($className, $analize);
    }
}
