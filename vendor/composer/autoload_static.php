<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7d8e59127c8db5c46d1b71101ecdaa02
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Slim\\Views\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Slim\\Views\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/views',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7d8e59127c8db5c46d1b71101ecdaa02::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7d8e59127c8db5c46d1b71101ecdaa02::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit7d8e59127c8db5c46d1b71101ecdaa02::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
