<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc5ea18c3e0eaf1c853429a732ff056b4
{
    public static $files = array (
        '3f8bdd3b35094c73a26f0106e3c0f8b2' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/SendGrid.php',
        '9dda55337a76a24e949fbcc5d905a2c7' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/helpers/mail/Mail.php',
        '5d7e2090c9a3b69b2ff2fceddeadca94' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/helpers/contacts/Recipients.php',
        '04a9a7b26fb79fbd712347cc9bc9d9be' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/helpers/stats/Stats.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SendGrid\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SendGrid\\' => 
        array (
            0 => __DIR__ . '/..' . '/sendgrid/php-http-client/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc5ea18c3e0eaf1c853429a732ff056b4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc5ea18c3e0eaf1c853429a732ff056b4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
