<?php

// Adjust the path according to your project structure
$source = __DIR__ . '/../config/telemetry_logging.yml';
// Adjust the path according to your project structure
$destination =  './config/telemetry_logging.yml';

// Check if the source file exists
if (!file_exists($source)) {
	echo "Source file for configuration of telemetry logging does not exists.\n";
	exit(1);
}

// Check if the destination file already exists
if (file_exists($destination)) {
	echo "Configuration file `telemetry_logging.yml` already exists. No action taken.\n";
	// Exit without error
	exit(0);
}

if (!copy($source, $destination)) {
	echo "Failed to copy telemetry logging configuration file from $source to $destination.\n";
	exit(1);
}

echo "Configuration file for telemetry logging was successfully copied from $source to $destination.\n";