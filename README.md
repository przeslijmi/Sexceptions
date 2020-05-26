# Przeslijmi Sexceptions

[![Run Status](https://api.shippable.com/projects/5e4da2352d50ee0007e90b8e/badge?branch=master)]()

[![Coverage Badge](https://api.shippable.com/projects/5e4da2352d50ee0007e90b8e/coverageBadge?branch=master)]()

## Table of contents

  1. [Using this app](#using-this-app)
     1. [Step 1 - define your Exception in your code](#step-1---define-your-exception-in-your-code)
     1. [Step 2 - throwing exception](#step-2---throwing-exception)
     1. [Step 3 - rethrowing exceptions](#step-3---rethrowing-exceptions)
     1. [Step 4 - get nice info out of an exception](#step-5---get-nice-info-out-of-an-exception)
     1. [Step 5 - final commandline handler](#step-5---final-commandline-handler)


## Using this app

### Step 1 - define your Exception in your code

```php
class YourSexception extends Sexception
{

    /**
     * Hint.
     *
     * @var string
     */
    protected $hint = 'This is a very usefull hint on how to work with this exception.';

    /**
     * Keys for extra data array.
     *
     * @var array
     */
    protected $keys = [ 'pieceOfInormationOne', 'pieceOfInormationTwo' ];
}
```

You can give as long hint as you want - it will be used to prepare final error message.

In `keys` you define what `keys of infos` that will be send along with throwing exception (for eg. record ID from database, used value, etc.).

#### Add warning

Some Exceptions can be used to serve warnings. If you want to have warning message included as information inside your exception add next method to `Sexception`.

```php
/**
 * To add warning.
 *
 * @var boolean
 */
protected $addWarning = true;
```

### Step 2 - throwing exception

```php
throw new YourSexception($infos, $intCode);
```

You can send as `infos` ar `array` of:
  - **scalars** and see them intact in exception message,
  - **recursive arrays** and see them as `var_export()` value in exception message,
  - **non-recursive arrays** and see them as comma separated value in exception message,
  - **nulls** and see them as `! info not given !` string in exception message,
  - **objects with toString() method** and see resulting string in exception message.

You can ignore to send all keys - missing will be filled with nulls.

### Step 3 - rethrowing exceptions

If you want you can rethrow an exception to show cause chain.

```php
try {
    // something
} catch (AnyThrowableAsCause $exc) {
    throw new YourSexception($infos, $intCode, $exc);
}
```

### Step 4 - get nice info out of an exception

```php
$exc->getCode(); // with 100
$exc->getCodeName(); // with YourSexception
$exc->getMessage(); // with nicely formmatted all given infos
$exc->getInfos(); // with array of infos given to exception
$exc->getCause(); // with AnyThrowableAsCause
$exc->hasInCauses(AnyThrowableAsCause::class); // with true
```

Use it on also during unit testing to have better feedback on real situation.

### Step 5 - final commandline handler

When use on commandline there is a handler that will printout in formatted way all details about exception and all its causes as well as will handle any Errors or Throwables from PHP itself.

```php
{
    // your app
} catch (Throwable $thr) {

    // Handle throwable by Sexception class.
    \Przeslijmi\Sexceptions\Handler::handle($thr);
}
```
