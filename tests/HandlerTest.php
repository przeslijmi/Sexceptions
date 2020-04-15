<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions;

use Error;
use Exception;
use Throwable;
use PHPUnit\Framework\TestCase;
use Przeslijmi\Sexceptions\Exceptions\TemporaryException;
use Przeslijmi\Sexceptions\Exceptions\ClassDonoexException;
use Przeslijmi\Sexceptions\Exceptions\TemporaryDeepException;
use Przeslijmi\Sexceptions\Handler;

/**
 * Methods for testing File class.
 */
final class HandlerTest extends TestCase
{

    /**
     * Test if handling Sexceptions works.
     *
     * @return void
     */
    public function testIfHandlingSexceptionsWorks() : void
    {

        // Lvd.
        $line      = 'TemporaryDeepException \[on ';
        $cause1    = new Exception('cause');
        $cause2    = new ClassDonoexException('context', 'class', $cause1);
        $exception = new TemporaryDeepException('anonymous', '', $cause2);
        $exception->addHint('This is a hint!');

        // Prepare.
        $showRegex = '/^(\R){2}(=){90}(\R)(' . $line . ')((.)+(\R))+(=){90}(\R){2}/';
        $this->expectOutputRegex($showRegex);

        // Test.
        $handler = new Handler();
        $handler->handle($exception);
    }

    /**
     * Test if handling Exceptions works.
     *
     * @return void
     */
    public function testIfHandlingExceptionsWorks() : void
    {

        // Lvd.
        $line      = 'Exception \[on ';
        $exception = new Exception('message', 0, new Exception('message'));

        // Prepare.
        $showRegex = '/^(\R){2}(=){90}(\R)(' . $line . ')((.)+(\R))+(=){90}(\R){2}/';
        $this->expectOutputRegex($showRegex);

        // Test.
        $handler = new Handler();
        $handler->handle($exception);
    }

    /**
     * Test if handling Errors works.
     *
     * @return void
     */
    public function testIfHandlingErrorsWorks() : void
    {

        // Lvd.
        $error = new Error('message, called from ', 0, new Error('deepMessage passed by '));

        // Prepare.
        $showRegex = '/^(\R){2}(=){90}(\R)(Error)(\R)((.)+(\R))+(=){90}(\R){2}/';
        $this->expectOutputRegex($showRegex);

        // Test.
        $handler = new Handler();
        $handler->handle($error);
    }
}
