<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb0a37d9d199926d276a438c0677cfe9b
{
    public static $prefixesPsr0 = array (
        'D' => 
        array (
            'Doctrine_' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/doctrine1/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitb0a37d9d199926d276a438c0677cfe9b::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}