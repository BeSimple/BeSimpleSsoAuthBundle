Get started with BeSimpleSsoAuthBundle
======================================


Get the sources, enable bundle & run the tests.


Install bundle & dependency
---------------------------

Add the requirement in your `composer.json` file:

    {
        "require": {
            "besimple/sso-auth-bundle": "*"
        }
    }

Then run `composer update besimple/sso-auth-bundle`.

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

    # app/config/config.yml
    be_simple_sso_auth: ~
