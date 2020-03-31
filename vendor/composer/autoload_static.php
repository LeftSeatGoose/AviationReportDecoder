<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1bfebe9a80492d1078ea1a5f7f096823
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'ReportDecoder\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ReportDecoder\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1bfebe9a80492d1078ea1a5f7f096823::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1bfebe9a80492d1078ea1a5f7f096823::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}