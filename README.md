Aviation Report Decoder
=================

A PHP library to decode aviation report strings

Introduction
------------

This piece of software is a library package that provides a parser to decode raw aviation reports.

Currently Supported:

- Metar
- Taf

Requirements
------------

This library package requires PHP >= 5.3

Composer [composer](http://getcomposer.org)

Setup
-----

- Run the command ```composer require tipsy-aviator/aviation-report-decoder:"dev-master"``` in your project root

- Be sure to include the autoloader: ``` require_once '/path/to/your-project/vendor/autoload.php';```

- Add the line ```use ReportDecoder\ReportDecoder;``` to the file you want to use the library in

Usage
-----

Instantiate the decoder and launch it on a report string.
The returned object is a DecodedReport object from which you can retrieve all the weather properties that have been decoded.

Example:

- Initiate decoder instance

`$decoder = new ReportDecoder();`

- Get the decoded report object

`$decoded = $decoder->getDecodedMetar($metar_raw_text);`

*OR*

`$decoded = $decoder->getDecodedTaf($taf_raw_text);`

- Example: Getting the wind speed from the decoded object.

`echo $decoded->getSurfaceWind()->getSpeed();`
