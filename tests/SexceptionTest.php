<?php declare(strict_types=1);

namespace Przeslijmi\SiHDD;

use stdClass;
use Exception;
use RuntimeException;
use PHPUnit\Framework\TestCase;
use Przeslijmi\Sexceptions\Exceptions\ClassDonoexException;
use Przeslijmi\Sexceptions\Handler;

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
            [ 'TemporaryException', [ 'context' ] ],
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
        $cause             = new Exception('testCauseException');
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
                 * @since  v1.0
                 * @return array
                 */
                public function getExceptionInfos()
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
}
