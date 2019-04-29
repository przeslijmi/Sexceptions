<?php

namespace Przeslijmi\Sexceptions;

use Exception;

/**
 * Handling error tool.
 *
 * ## Abilities
 * - Show Sexceptions to screen including causes (exception chains).
 *
 * ## Todo
 * - Showing to HTML - not only to consle (PHP_EOL vs BR)
 * - Logging
 * - Handle other exceptions and errors
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
     * Handles all Exceptions.
     *
     * @param Exception $e Exception to handle.
     *
     * @todo   Does it handle errors?
     * @return void
     * @since  v1.0
     */
    public static function handle(Exception $e) : void
    {

        if (is_a($e, 'Przeslijmi\Sexceptions\Sexception') === true) {
            self::handleSexception($e);
        } else {
            die('unknown to handle');
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
     */
    private static function echoSexception(Sexception $e, bool $deeperCause = false) : string
    {

        // Show code name, file and line.
        $response  = $e->getCodeName();
        $response .= ' [on ' . substr($e->getFile(), ( strlen(ROOT_PATH) + 1 ));
        $response .= ' #' . $e->getLine() . ']' . PHP_EOL;

        // Show all infos.
        foreach ($e->getInfos() as $key => $value) {
            $response .= '    ' . $key . ': ' . $value . PHP_EOL;
        }

        // If this is NOT a deeper cause - show trace also.
        if ($deeperCause === false) {

            // Lvd.
            $trace = $e->getTrace()[0];

            if (empty($trace['file']) === false) {
                $response .= '    called:';
                $response .= ' [on ' . substr($trace['file'], ( strlen(ROOT_PATH) + 1 ));
                $response .= ' #' . $trace['line'];
                $response .= ' by ' . $trace['class'] . '::' . $trace['function'];
                $response .= ']' . PHP_EOL;
            }
        }

        // It there is a deeper cause - call to show it also (recursively).
        if (is_a($e->getPrevious(), 'Przeslijmi\Sexceptions\Sexception') === true) {
            $response .= 'caused by ';
            $response .= self::echoSexception($e->getPrevious(), true);
        }

        return $response;
    }
}
