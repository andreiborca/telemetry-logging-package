# Coding Challenge
## Telemetry package

### Description

This package should offer a variety of features for meaningful logging. The goal is to remove
the need to run, operate and maintain multiple agents/collectors in order to support telemetry
data, like logs or transactions. This means that the code that uses this package never needs
to be adjusted when the logging technology changes.

Your task is to create a Telemetry Logging Package that simplifies and unifies the process of
logging telemetry data. In modern software systems, logging is crucial for monitoring,
debugging, and maintaining applications. However, managing multiple logging agents can be
complex and inefficient. This package aims to provide a seamless and consistent logging,
allowing developers to focus on the application logic without worrying about the specifics of
log handling.

The core objective of this challenge is to design and implement a versatile logging package
that supports multiple logging mechanisms (“drivers”) while ensuring that the codebase
remains stable and unaffected by changes in logging technologies. The package should
handle logs with various levels of severity, support transaction-styled logs, and include
metadata attributes to enrich log entries with additional context.

**Requirements:**
- Timestamping: Every log entry must include a timestamp to record when the event
occurred.
- Log Levels: Implement several levels of logging to categorize the severity and
importance of log entries:
    - Debug: Detailed information typically of interest only when diagnosing
problems.
    - Error: Due to a more serious problem, the software has not been able to
perform some function.
    - (Optional) Add other appropriate log levels.
- Logs should be able to include metadata in the form of attributes. These attributes
provide additional context to the log entries and can be used for filtering and querying
logs. Example attributes could be:
    - CustomerId: An identifier for the customer associated with the log entry.
    - Environment: The environment where the log was generated (e.g.,
'development', 'staging', 'production').
- The package should support multiple log processing methods (drivers) to cater to
different storage and output needs. These should include:
    - CLI Output: Directly output logs to the Command Line Interface for real-time
monitoring.
    - Simple text or JSON file: Store logs in a plain append-only text file.
    - (Optional) Add other drivers of your desire.
- Transaction-styled logs(1*), consisting of:
    - TraceID: A unique identifier for each transaction to correlate related log
entries.
    - Attributes: Additional metadata associated with the transaction, such as user
information, request parameters, etc.

### Boundary conditions
- Usability: Supports different drivers and runs out of the box.
- Configurable: Customizable by a configuration file without touching the core code or
the code which uses this package.
- Extensible: Without touching core code the package should be extensible by new
drivers.
- Programming language have to be PHP or Go.
- The code has to be unit tested.
- How you design and implement this is up to you. Because of that this project is
openly described on purpose.

### Deliverables
Develop the logging package that meets all the requirements outlined above. The package
should be modular, allowing for the easy addition of new drivers and log levels. Ensure the
package is easy to integrate into existing projects, with a simple and intuitive API. Please
also develop a simple showcase in a small go or php file on how to use your telemetry
package. Alternatively some automated tests would also be fine to see how your package is
used.
- GitHub repository with the source code
- (Optional) UML diagram(s) of your software design

(1*) A transaction is basically the processing of a task by the application. Example: Request arrives,
service processes something, saves something to the DB, email sent, end. A transaction is therefore
a kind of grouping element of several logs which are all written in this process to handle this
task/request.