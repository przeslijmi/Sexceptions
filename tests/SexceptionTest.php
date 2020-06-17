<?php declare(strict_types=1);

namespace Przeslijmi\Sexceptions;

use Exception;
use PHPUnit\Framework\TestCase;
use Przeslijmi\Sexceptions\Exceptions\ClassDonoexException;
use Przeslijmi\Sexceptions\Exceptions\TemporaryException;
use Przeslijmi\Sexceptions\Sexception;
use stdClass;

/**
 * Methods for testing File class.
 */
final class SexceptionTest extends TestCase
{

    /**
     * LIst of all exceptions and default params provider.
     *
     * @return array[]
     */
    public function classesDataProvider() : array
    {

        return [
            [ 'ClassDonoexException', [ 'context', 'class' ] ],
            [ 'ClassFopException', [ 'context' ] ],
            [ 'ClassWrotypeException', [ 'context', 'class', 'parentClass' ] ],
            [ 'ConstDonoexException', [ 'context', 'name' ] ],
            [ 'ConstIsEmptyException', [ 'context' ] ],
            [ 'ConstWrotypeException', [ 'name', 'typeExpected', 'typeActual' ] ],
            [ 'DirDonoexException', [ 'context', 'name' ] ],
            [ 'DirIsEmptyException', [ 'context', 'name' ] ],
            [ 'FileAlrexException', [ 'context', 'name' ] ],
            [ 'FileDonoexException', [ 'context', 'name' ] ],
            [ 'FopException', [ 'context' ] ],
            [ 'KeyAlrexException', [ 'context', 'key' ] ],
            [ 'KeyDonoexException', [ 'context', [ 'key1', 'key2', 'key3' ], 'key4' ] ],
            [ 'KeyDonoexException', [ 'context', [ ], 'key4' ] ],
            [ 'LoopOtoranException', [ 'context', 5 ] ],
            [ 'MethodDonoexException', [ 'context', 'class', 'method' ] ],
            [ 'MethodFopException', [ 'context' ] ],
            [ 'ObjectDonoexException', [ 'context' ] ],
            [ 'ParamOtoranException', [ 'paramName', '2-20', '1' ] ],
            [ 'ParamOtosetException', [ 'paramName', [ 'val1', 'val2', 'val3' ], 'val4' ] ],
            [ 'ParamOtosetException', [ 'paramName', [], 'value' ] ],
            [ 'ParamWrosynException', [ 'paramName', 'value' ] ],
            [ 'ParamWrotypeException', [ 'name', 'typeExpected', 'typeActual' ] ],
            [ 'PointerWrosynException', [ 'context' ] ],
            [ 'PropertyIsEmptyException', [ 'name' ] ],
            [ 'RegexTestFailException', [ 'value', 'regex' ] ],
            [ 'TemporaryException', [ 'context', 'codeNameToTest' ] ],
            [ 'TypeHintingFailException', [ 'shouldBe', 'isInFact' ] ],
            [ 'ValueOtosetException', [ 'name', [ 'val1', 'val2', 'val3' ], 'val4' ] ],
            [ 'ValueOtosetException', [ 'name', [], 'val4' ] ],
            [ 'ValueWrosynException', [ 'context', 'value' ] ],
            [ 'ValueWrotypeException', [ 'context', 'typeExpected', 'typeActual' ] ],
        ];
    }

    /**
     * Test if throwing all exceptions works.
     *
     * @param string   $exceptionName Name of exception.
     * @param string[] $parameters    Array of parameters for exception.
     *
     * @throws Exception To test.
     * @return void
     *
     * @dataProvider classesDataProvider
     */
    public function testAll(string $exceptionName, array $parameters) : void
    {

        // Lvd.
        $causeDeeper       = new Exception('testCauseException');
        $cause             = new TemporaryException('test', '', $causeDeeper);
        $fullExceptionName = 'Przeslijmi\Sexceptions\Exceptions\\' . $exceptionName;

        // Add $cause to every call.
        $parameters[] = $cause;

        // Expect.
        $this->expectException($fullExceptionName);

        // This is an nonexisting file - reading is impossible.
        $exception = new $fullExceptionName(...$parameters);

        // Extra tests for some exceptions.
        if ($exceptionName === 'TypeHintingFailException') {
            $this->assertEquals($parameters[0], $exception->getShouldBe());
            $this->assertEquals($parameters[1], $exception->getIsInFact());
        }

        // Extra test for TemporaryException.
        if ($exceptionName === 'TemporaryException') {
            $this->assertEquals($parameters[1], $exception->getCodeName());
        }

        // Test causes.
        $this->assertEquals($cause, $exception->getCause());
        $this->assertEquals($causeDeeper, $exception->findInCauses(Exception::class));
        $this->assertEquals(null, $exception->findInCauses(ClassDonoexException::class));
        $this->assertTrue($exception->hasInCauses(Exception::class));
        $this->assertFalse($exception->hasInCauses(ClassDonoexException::class));

        throw $exception;
    }

    /**
     * Test if every way of adding infos to exception works.
     *
     * @throws Exception To test.
     * @return void
     *
     * @phpcs:disable Generic.PHP.NoSilencedErrors
     * @phpcs:disable Squiz.Commenting.PostStatementComment
     */
    public function testAddingInfos() : void
    {

        // Expect.
        $this->expectException(ClassDonoexException::class);

        // Make silenced error.
        $nothing = @( 5 / 0 );

        // Make cause.
        $cause = new Exception('cause');

        // Throw.
        $exception = ( new ClassDonoexException('context', 'class') )
            ->addInfo('keyOfInfo1', 'valueOfInfo')
            ->addInfo('keyOfInfo2')
            ->addInfos()
            ->addInfos([
                'keyOfInfo3' => new stdClass(),
                'keyOfInfo4' => null,
                'keyOfInfo5' => (bool) false,
                'keyOfInfo6' => (int) 5,
                'keyOfInfo7' => ( new class {

                    /**
                     * Convert this Sexception to string.
                     *
                     * @return string
                     */
                    public function toString() : string
                    {

                        return 'test';
                    }
                } ),
            ], 'prefix')
            ->addObjectInfos(new class {

                /**
                 * Used by Sexceptions to introduce this object when it causes exceptions.
                 *
                 * @return array
                 */
                public function getExceptionInfos() : array
                {
                    return [
                        'subInfo1' => '1',
                        'subInfo2' => '2',
                    ];
                }
            })
            ->addWarning()
            ->setCause($cause);

        // Infos expected.
        $infosExpected = [
            'context' => 'context',
            'className' => 'class',
            'keyOfInfo1' => 'valueOfInfo',
            'prefix.keyOfInfo3' => 'object (no toString method)',
            'prefix.keyOfInfo4' => 'nonScalarNonObject',
            'prefix.keyOfInfo5' => 'false',
            'prefix.keyOfInfo6' => '5',
            'prefix.keyOfInfo7' => 'test',
            'subInfo1' => '1',
            'subInfo2' => '2',
            'warning' => 'Division by zero', // @see "Make silenced error" comment above.
        ];

        // Assert infos.
        $this->assertEquals($infosExpected, $exception->getInfos());

        throw $exception;
    }

    /**
     * Test if using shortest exception without array or hint works.
     *
     * @throws Sexception To test.
     * @return void
     */
    public function testIfShortExceptionWithStringWorks() : void
    {

        // Lvd.
        $contents = 'contents';
        $errorId  = 100;

        // Try.
        try {

            throw new class($contents, $errorId) extends Sexception
            {

                /**
                 * Keys for extra data array.
                 *
                 * @var array
                 */
                protected $keys = [ 'info' ];
            };

        } catch (Sexception $exc) {

            // Test.
            $this->assertEquals($errorId, $exc->getCode());
            $this->assertEquals($contents, $exc->getMessage());
        }//end try
    }

    /**
     * Test if using short exception with array as contents works.
     *
     * @throws Sexception To test.
     * @return void
     */
    public function testIfShortExceptionWithArrayWorks() : void
    {

        // Lvd.
        $contents = [
            'contentsA',
            [ 'contentsB1', 'contentsB2' ],
            [ 'contentsC1', 'contentsC2', [ 'contentsC3A', 'contentsC3B' ] ],
        ];
        $errorId  = 100;

        // Try.
        try {

            // Create anonymous class.
            throw new class($contents, $errorId) extends Sexception
            {

                /**
                 * Hint.
                 *
                 * @var string
                 */
                protected $hint = 'Test hint.';

                /**
                 * Keys for extra data array.
                 *
                 * @var array
                 */
                protected $keys = [ 'infoA', 'infoB', 'infoC', 'infoD' ];

                /**
                 * To add warning.
                 *
                 * @var boolean
                 */
                protected $addWarning = true;
            };

        } catch (Sexception $sexc) {

            // Test.
            $this->assertEquals($errorId, $sexc->getCode());
            $this->assertIsInt(strpos($sexc->getMessage(), 'Test hint.'));
            $this->assertIsInt(strpos($sexc->getMessage(), $contents[0]));
            $this->assertIsInt(strpos($sexc->getMessage(), $contents[1][0]));
            $this->assertIsInt(strpos($sexc->getMessage(), '! info not given !'));
            $this->assertIsInt(strpos($sexc->getMessage(), 'warning'));
            $this->assertTrue(isset($sexc->getInfos()['warning']));
        }//end try
    }

    /**
     * Test if using superflous infos works.
     *
     * @throws Sexception To test.
     * @return void
     */
    public function testIfUsingSuperflousInfosWorks() : void
    {

        // Lvd.
        $contents = [
            'superflous info 1',
            'superflous info 2',
        ];

        // Try.
        try {

            // Create anonymous class.
            throw new class($contents) extends Sexception
            {

                /**
                 * Hint.
                 *
                 * @var string
                 */
                protected $hint = 'Test hint.';
            };

        } catch (Sexception $sexc) {

            // Test.
            $this->assertEquals($contents[0], $sexc->getInfos()['! superflous key 1 !']);
            $this->assertEquals($contents[1], $sexc->getInfos()['! superflous key 2 !']);
        }//end try
    }
}
