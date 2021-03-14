# Changelog

## v1.8.0.rs1 - 2021-03-14


## v1.7.0 - 2020-06-17

- Change: Superflous infos are now accepted but warning is fired.
- Change: You can construct exception without any infos from now.

## v1.6.2 - 2020-06-03

- New: Added default (empty) values for `hint` and `keys` in `Sexception`.
- Change: Deleted snippets.

## v1.6.1 - 2020-05-26

- Fix: Restored `addWarning` functionality for `short exceptions`.

## v1.6.0 - 2020-05-24

- **Important!** All specific Exeptions are depreciated and will be deleted with `v2.0.0` (ie. the next major update).
- New: Added `README.md`.
- New: Added functionality for `short sexceptions` (see README.md).
- New: Added hint for Given value has failed to meet given regex.

## v1.5.1 - 2020-04-15

- New: Added `shippable.yml`.
- New: Added badges.
- Change: Updated `composer.json`.
- Change: Deleted `build.sh` and `build.sh.dist`.

## v1.5.0 - 2019-12-23

- New: Added `ValueWrosynException`.
- Change: Added more tests (66.00%).

## v1.4.1 - 2019-11-10

- New: Added `build.sh.dist`.
- New: Added `phpcs.xml`.
- New: Added `phpunit.xml` to be more complete.
- Change: Changed `composer.json`.

## v1.4.0 - 2019-10-23

- Change: Changed all exceptions to accept Throwables instead of just Exception.

## v1.3.0 - 2019-10-21

- New: Added `LoopOtoranException`.
- New: Added `ValueWrotypeException`.
- Change: Changed in `ClassFopException` to accept Throwables instead of just Exception. TBC.

## v1.2.0 - 2019-09-10

- New: Added handling for errors and `Throwables`.
- New: Added `TemporarySexception`.
- New: Added snippets for Sublime Text Editor.
- Change: started change from catching `Exception` into catching `Throwables`.

## v1.1.0 - 2019-08-19

- Change: `getCodeName()` will return real class of Sexception if no `codeName` is given.

## v1.0.0 - 2019-08-19

- New: Added all.
