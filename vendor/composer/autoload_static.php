<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb30354356d0d28baa926a92d11a0efde
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Raven\\' => 6,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Raven\\' => 
        array (
            0 => __DIR__ . '/..' . '/raven/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb30354356d0d28baa926a92d11a0efde::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb30354356d0d28baa926a92d11a0efde::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb30354356d0d28baa926a92d11a0efde::$classMap;

        }, null, ClassLoader::class);
    }
}