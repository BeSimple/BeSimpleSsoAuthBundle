Get started with BeSimpleSsoAuthBundle
======================================


Get the sources, enable bundle & run the tests.


Install bundle & dependency
---------------------------


If already using GIT for your project:

    # add bundle submodule
    git submodule add https://jfsimon@github.com/jfsimon/SsoAuthBundle.git vendor/bundles/BeSimple/SsoAuthBundle

    # add Buzz library submodule
    git submodule add https://github.com/kriswallsmith/Buzz.git vendor/buzz


Else (maybe you should):

    # clone bundle
    git clone https://jfsimon@github.com/jfsimon/SsoAuthBundle.git vendor/bundles/BeSimple/SsoAuthBundle

    # clone Buzz library
    git clone https://github.com/kriswallsmith/Buzz.git vendor/buzz


Enable bundle & dependency
--------------------------


Add bundle to your kernel class:

    // app/AppKernel.php
    $bundles = array(
        // ...
        new BeSimple\SsoAuthBundle\BeSimpleSsoAuthBundle(),
        // ...
    );


Add bundle to your config file:

    # app/config.yml
    be_simple_sso_auth: ~


Add bundle & Buzz library to your autoload file:

    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'BeSimple' => __DIR__.'/../vendor/bundles',
        'Buzz'     => __DIR__.'/../vendor/buzz/lib',
        // ...
    ));


Add the factories to your secutity config:

    # app/config/security.yml
    security:
        # ...
        factories:
            - "%kernel.root_dir%/../vendor/bundles/BeSimple/SsoAuthBundle/Resources/config/security_factories.xml"
        # ...


Run the tests
-------------


From your project root dicrectory:

    phpunit -c app vendor/bundles/BeSimple/SsoAuthBundle


Navigation
----------


-   Next: [Configure trusted SSO](trusted.md)
-   [Index](index.md)
