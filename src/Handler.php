<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions;

use Exception;

/**
 * Handling error tool.
 *
 * ## Abilities
 * - Show Sexceptions to CLI screen including causes (exception chains).
 *
 * ## Usage
 *
 * ### Only for Sexceptions
 * ```
 * try {
 *     // some code
 * } catch (\Przeslijmi\Sexceptions\Sexception $e) {
 *     \Przeslijmi\Sexceptions\self::handle($e);
 * }
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
    public static function handle(Exception $e) : void
    {

        if (is_a($e, 'Przeslijmi\Sexceptions\Sexception') === true) {
            self::handleSexception($e);
        } else {
            var_dump($e);
            die('unknown to handle ... ' . get_class($e));
        }
    }

    /**
     * Handles (show to the screen) exceptions.
     *
     * @param Sexception $e Exception to be handled.
     *
     * @return void
     * @since  v1.0
     */
    private static function handleSexception(Sexception $e) : void
    {

        // Lvd.
        $response = '';

        if (CALL_TYPE === 'client') {

            // Get response.
            $response .= self::echoSexception($e);
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
            $response .= self::echoSexception($e);
            $response .= str_pad('', 90, '=');
            $response .= PHP_EOL . PHP_EOL;

            echo $response;
        }//end if

        // End of service.
        die;
    }

    /**
     * Show information about exception to the screen.
     *
     * @param Sexception $e           Exception to be showed.
     * @param boolean    $deeperCause Opt., false. If set to true - it means that this Exception is a cause
     *                                to a previous one.
     *
     * @return string
     * @since  v1.0
     *
     * @phpcs:disable Generic.Metrics.CyclomaticComplexity
     */
    private static function echoSexception(Sexception $e, bool $deeperCause = false) : string
    {

        // Show code name, file and line.
        $response  = $e->getCodeName();
        $response .= ' [on ' . substr($e->getFile(), ( strlen(ROOT_PATH) + 1 ));
        $response .= ' #' . $e->getLine() . ']' . PHP_EOL;

        // Show parents.
        $parents = class_parents($e);
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

        // Show all infos.
        foreach ($e->getInfos() as $key => $value) {

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

        // If this is NOT a deeper cause - show trace also.
        if ($deeperCause === false) {

            // Lvd.
            $headerGiven = false;

            // Draw traces.
            foreach ($e->getTrace() as $trace) {

                if (empty($trace['file']) === true) {
                    continue;
                }

                if ($headerGiven === false) {
                    $headerGiven = true;
                    $response   .= '    called: ';
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
        }//end if

        // It there is a deeper cause - call to show it also (recursively).
        if (is_a($e->getPrevious(), 'Przeslijmi\Sexceptions\Sexception') === true) {
            $response .= 'caused by ';
            $response .= self::echoSexception($e->getPrevious(), true);
        }

        return $response;
    }
}
