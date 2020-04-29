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

This library package requires PHP >= 7.2

Composer [composer](http://getcomposer.org)

Setup
-----

- Enter project directory in CMD

- Run command ```composer install```

Usage
-----

Instantiate the decoder and launch it on a report string.
The returned object is a DecodedReport object from which you can retrieve all the weather properties that have been decoded.

Example:

- Initiate decoder instance

```$decoder = new ReportDecoder();```

- Get the decoded report object

```$decoded_metar = $decoder->getDecodedReport($metar_raw_text);```

- Output the wind speed for the given metar

```echo $decoded_metar->getSurfaceWind()->getWind();```
