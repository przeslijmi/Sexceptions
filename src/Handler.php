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
 *     \Przeslijmi\Sexceptions\Handler::handle($e);
 * }
 *
 * @version v1.0
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
            Handler::handleSexception($e);
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

        // lvd
        $response = '';

        if (CALL_TYPE === 'client') {

            // get response
            $response .= Handler::echoSexception($e);
            $json = json_encode([
                'errorReport' => explode(PHP_EOL, $response),
            ]);

            // set headers
            http_response_code(500);
            header("Content-type: application/json; charset=utf-8");

            // call echo
            echo $json;

        } else {

            // get response
            $response .= PHP_EOL . PHP_EOL;
            $response .= str_pad('', 90, '=');
            $response .= PHP_EOL;
            $response .= Handler::echoSexception($e);
            $response .= str_pad('', 90, '=');
            $response .= PHP_EOL . PHP_EOL;

            echo $response;
        }

        // end of service
        die;
    }

    /**
     * Show information about exception to the screen.
     *
     * @param Sexception $e           Exception to be showed.
     * @param bool       $deeperCause (opt., false) If set to true - it means that this Exception is a cause to a previous one.
     *
     * @return void
     * @since  v1.0
     */
    private static function echoSexception(Sexception $e, bool $deeperCause=false) : string
    {

        // show code name, file and line
        $response = $e->getCodeName();
        $response .= ' [on ' . substr($e->getFile(), (strlen(ROOT_PATH) + 1));
        $response .= ' #' . $e->getLine() . ']' . PHP_EOL;

        // show all infos
        foreach ($e->getInfos() as $key => $value) {
            $response .= '    ' . $key . ': ' . $value . PHP_EOL;
        }

        // if this is NOT a deeper cause - show trace also
        if ($deeperCause === false) {

            // lvd
            $trace = $e->getTrace()[0];

            if (empty($trace['file']) === false) {
                $response .= '    called:';
                $response .= ' [on ' . substr($trace['file'], (strlen(ROOT_PATH) + 1));
                $response .= ' #' . $trace['line'];
                $response .= ' by ' . $trace['class'] . '::' . $trace['function'];
                $response .= ']' . PHP_EOL;
            }
        }

        // it there is a deeper cause - call to show it also (recursively)
        if (is_a($e->getPrevious(), 'Przeslijmi\Sexceptions\Sexception') === true) {
            $response .= 'caused by ';
            $response .= Handler::echoSexception($e->getPrevious(), true);
        }

        return $response;
    }
}
