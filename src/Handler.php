<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions;

use Throwable;
use Error;
use Exception;
use RuntimeException;
use Przeslijmi\Silogger\Log;

/**
 * Handling error tool.
 *
 * ## Abilities
 * - Show Throwable to CLI or JSON response.
 * - Send 500 header.
 */
class Handler
{

    /**
     * Handles Sexceptions.
     *
     * @param Exception $e Exception to handle.
     *
     * @return void
     * @since  v1.0
     *
     * @phpcs:disable Squiz.PHP.DiscouragedFunctions
     */
    public static function handle(Throwable $thr) : void
    {

        // Lvd.
        $response = '';

        if (CALL_TYPE === 'client') {

            // Get response.
            $response .= self::toString($thr);
            $json      = json_encode(
                [
                    'errorReport' => explode(PHP_EOL, $response),
                ]
            );

            // Set headers.
            http_response_code(500);
            header('Content-type: application/json; charset=utf-8');

            // Call echo.
            echo $json;

        } else {

            // Get response.
            $response .= PHP_EOL . PHP_EOL;
            $response .= str_pad('', 90, '=');
            $response .= PHP_EOL;
            $response .= self::toString($thr);
            $response .= str_pad('', 90, '=');
            $response .= PHP_EOL . PHP_EOL;

            echo $response;
        }//end if

        // Log.
        $log = Log::get();
        $log->emergency(get_class($thr), [ 'response' => $response ]);
    }

    /**
     * Convert Sexception, Exception or Error to string.
     *
     * @param Throwable $thr         Throwable to be showed.
     * @param boolean   $deeperCause Opt., false. If set to true - it means that this Throwable is a cause
     *                               to a previous one.
     *
     * @return string
     * @since  v2.0
     */
    private static function toString(Throwable $thr, bool $deeperCause = false) : string
    {

        // It there is a deeper cause - call to show it also (recursively).
        if (is_a($thr, 'Przeslijmi\Sexceptions\Sexception') === true) {
            return self::sexceptionToString($thr, $deeperCause);
        } elseif (is_a($thr, 'Exception') === true) {
            return self::exceptionToString($thr, $deeperCause);
        }

        return self::errorToString($thr, $deeperCause);
    }

    /**
     * Convert Sexception to string.
     *
     * @param Sexception $sexc        Sexception to be showed.
     * @param boolean    $deeperCause Opt., false. If set to true - it means that this Sexception is a cause
     *                                to a previous one.
     *
     * @return string
     * @since  v1.0
     */
    private static function sexceptionToString(Sexception $sexc, bool $deeperCause = false) : string
    {

        // Show code name, file and line.
        $response  = $sexc->getCodeName();
        $response .= ' [on ' . substr($sexc->getFile(), ( strlen(ROOT_PATH) + 1 ));
        $response .= ' #' . $sexc->getLine() . ']' . PHP_EOL;

        // Show parents.
        $parents = class_parents($sexc);
        if (count($parents) >= 3) {

            // Ignore Exception and Sexception classes.
            $parents = array_slice($parents, 0, -2);

            // Now `$parent` is string with class name.
            foreach ($parents as $parent) {

                if (substr($parent, 0, 34) === 'Przeslijmi\Sexceptions\Exceptions\\') {
                    $parent = substr($parent, 34);
                }
                $response .= '    extends: >>> ' . $parent . PHP_EOL;
            }
        }

        $response .= self::infosToString($sexc->getInfos());

        // If this is NOT a deeper cause - show trace also.
        // if ($deeperCause === false) {
            $response .= self::tracesToString($sexc->getTrace());
        // }

        // Show previous.
        if (is_null($sexc->getPrevious()) === false) {
            $response .= 'caused by ';
            $response .= self::toString($sexc->getPrevious(), true);
        }

        return $response;
    }

    /**
     * Convert Exception to string.
     *
     * @param Exception $exc         Exception to be showed.
     * @param boolean   $deeperCause Opt., false. If set to true - it means that this Exception is a cause
     *                               to a previous one.
     *
     * @since  v2.0
     * @return string
     */
    private static function exceptionToString(Exception $exc, bool $deeperCause = false) : string
    {

        $respons = 'hiii';

        // Show previous.
        if (is_null($exc->getPrevious()) === false) {
            $response .= 'caused by ';
            $response .= self::toString($exc->getPrevious(), true);
        }

        return $response;
    }

    /**
     * Convert Error to string.
     *
     * @param Error   $err         Error to be showed.
     * @param boolean $deeperCause Opt., false. If set to true - it means that this Error is a cause
     *                             to a previous one.
     *
     * @since  v2.0
     * @return string
     */
    private static function errorToString(Error $err, bool $deeperCause = false) : string
    {

        // Format message.
        $message = $err->getMessage();

        // Cut unneeded.
        if (($cut = strrpos($message, ', called ')) !== false) {
            $message = substr($message, 0, $cut) . '.';
        } elseif (($cut = strrpos($message, ' passed ')) !== false) {
            $message = substr($message, 0, $cut) . '.';
        }

        // Format file.
        $file = substr($err->getFile(), ( strlen(ROOT_PATH) + 1 ));

        // Create response.
        $response = get_class($err) . PHP_EOL;
        $response .= self::infosToString([
            'code'    => $err->getCode(),
            'message' => $message,
            'called'  => '[on: ' . $file . ' #' . $err->getLine() . ']',
        ]);

        // If this is NOT a deeper cause - show trace also.
        // if ($deeperCause === false) {
            $response .= self::tracesToString($err->getTrace());
        // }

        // Show previous.
        if (is_null($err->getPrevious()) === false) {
            $response .= 'caused by ';
            $response .= self::toString($err->getPrevious(), true);
        }

        return $response;
    }

    /**
     * Converts infos to string.
     *
     * @param array $infos Array with key (info name) and value (info contents).
     *
     * @since  v2.0
     * @return string
     */
    private static function infosToString(array $infos) : string
    {

        // Lvd.
        $response = '';

        foreach ($infos as $key => $value) {

            $response .= '    ';

            // If this is hint add yellow background with black letters.
            if ($key === 'hint') {
                $response .= "\e[0;30;43m";
            }

            $response .= $key . ': ' . $value;

            // If this was hint turn off colloring.
            if ($key === 'hint') {
                $response .= "\e[0m";
            }

            $response .= PHP_EOL;
        }

        return $response;
    }

    /**
     * Converts traces to string.
     *
     * @param array $traces Traces of Throwable.
     *
     * @since  v2.0
     * @return string
     */
    private static function tracesToString(array $traces) : string
    {

        // Lvd.
        $response    = '';
        $headerGiven = false;

        // Draw traces.
        foreach ($traces as $trace) {

            if (empty($trace['file']) === true) {
                continue;
            }

            if ($headerGiven === false) {
                $headerGiven = true;
                $response   .= '    traces: ';
            } else {
                $response .= '            ';
            }

            $response .= '[on ' . substr($trace['file'], ( strlen(ROOT_PATH) + 1 ));
            $response .= ' #' . $trace['line'];

            if (isset($trace['class']) === true) {
                $response .= ' by ' . $trace['class'] . '::' . $trace['function'];
            }
            $response .= ']' . PHP_EOL;
        }//end foreach

        return $response;
    }
}
