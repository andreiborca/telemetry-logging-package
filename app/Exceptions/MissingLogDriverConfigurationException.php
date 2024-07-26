<?php

namespace App\Exceptions;

use PHPUnit\Framework\Exception;

class MissingLogDriverConfigurationException extends Exception
{
	public function __construct($missingConfiguration = "", $code = 0, \Throwable $previous = null)
	{
		$message = sprintf(
			"Missing driver `%s` configuration for telemetry logging",
			$missingConfiguration,
		);

		parent::__construct($message, $code, $previous);
	}
}