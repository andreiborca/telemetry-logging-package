# Telemetry Logging Package

Telemetry and logging are data collection approaches used in monitoring and troubleshooting software systems. Telemetry 
focuses on real-time performance metrics, offering insights into a system's current health and behavior, aiding in 
proactive issue detection.


## Supported logging drivers

This package currently supports the following drivers for logging:
- console
- file

From the logging perspective the package provides support for:
- simple logging using methods like `log`, `debug`, `info`, `warning`, `error`, `critical`
- transactional logging using methods `startTransactionLogging`, `updateTransactionLogging`, `endTransactionLogging`

**Note:**: The transactional logging is implemented that every time the `updateTransactionLogging` method is called to 
create a log entry using the unique identifier generated when method `startTransactionLogging` was called. Also, take in
consideration that the provided metadata through call of method `startTransactionLogging` will be appended to the 
metadata provided through calls of method `updateTransactionLogging` or `endTransactionLogging`. Also, a `TraceId` 
property will be added to the metadata.

## Required Configuration

The package requires to have the configuration file `\config\telemetry_logging.yml` with following configuration:
```
default: file

drivers:
  console:
    format: text

  file:
    path: logs/logs.log
    format: json
```

**Note:** The used/active driver is mentioned through `default` option.

The supported values for option `format` of **console** and **file** driver are `text` and `json`.


## Example for using the package

The usage of package was envisioned as entry point through the `TransactionalLoggerFacade`.
For the next examples, it will be assumed that the used driver is `file`.

### Simple logging
```
use App\Facades\TransactionalLoggerFacade;

# Log with out any metadata information
TransactionalLoggerFacade::info('Info message log');

# Log with metadata information
TransactionalLoggerFacade::error('Error message log', [
    "errMsg": "Unexpected error occured",
]);
```

### Transactional logging
```
use App\Facades\TransactionalLoggerFacade;

$traceId = TransactionalLoggerFacade::startTransactionLogging('Starting the transactional logging', [
    "status": "update starting",
]);

TransactionalLoggerFacade::updateTransactionLogging('Updating the transactional logging', [
    "status": "updating",
]);

TransactionalLoggerFacade::endTransactionLogging('Ending the transactional logging', [
    "status": "successfully updated",
]);
```

**Note:** Currently if you wish to start another logging transaction, it is required to end the active logging 
transaction and then to start. For moment is not supported to pass an `TraceId` to the `update` and `end` methods to be 
able to reference specific transactions.


## Extending the package

Depending on the desired extension of functionalities the focus need to be in the following places:
- App\Facades\TransactionalLoggerFacade@initLogger for the initialization of the `LoggerDriverFactory`
- App\Factories\LoggerDriverFactory. Here based of what is required:
1. Add new method to handle the initialization of custom driver and extend to `initDriver` to support the call for new method
2. It is desired to change the behaviour of an existing driver you need to switch the driver reference for the factory

**Note:** Any driver must implement the `LoggerInterface` and `TransactionalLoggerInterface`.
