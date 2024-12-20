<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0207b0b1ce50d7b524cb3efa27485ed3
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Arifu\\MyRuptar\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Arifu\\MyRuptar\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0207b0b1ce50d7b524cb3efa27485ed3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0207b0b1ce50d7b524cb3efa27485ed3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0207b0b1ce50d7b524cb3efa27485ed3::$classMap;

        }, null, ClassLoader::class);
    }
}
