SSO authentication for Symfony2
===============================


**Warning:**

-   Currently under development, unusable for now.
-   No test written.
-   Currently implemented: CAS only.


**Summary:**

-   Get started: install & enable bundle & dependencies
-   Trusted SSO: force user to authenticate with a trusted server
-   Open SSO: let user authenticate with any SSO server


Get started:
------------


**Install bundle dependencies:**

If already using GIT for your project:

    # add bundle submodule
    git submodule add https://jfsimon@github.com/jfsimon/SsoAuthBundle.git vendor/bundles/BeSimple/SsoAuthBundle

    # add Buzz library submodule
    git submodule add https://github.com/kriswallsmith/Buzz.git vendor/buzz

Else:

    # clone bundle
    git clone https://jfsimon@github.com/jfsimon/SsoAuthBundle.git vendor/bundles/BeSimple/SsoAuthBundle

    # clone Buzz library
    git clone https://github.com/kriswallsmith/Buzz.git vendor/buzz


**Enable bundle & dependencies:**

Add bundle to your kernel class:

    // app/AppKernel.php
    $bundles = array(
        // ...
        new BeSimple\DeploymentBundle\BeSimpleDeploymentBundle(),
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

    // app/config/security.yml
    security:
        // ...
        factories:
            - "%kernel.root_dir%/../vendor/bundles/BeSimple/SsoAuthBundle/Resources/config/security_factories.xml"
        // ...



Trusted SSO:
------------


**How to configure:**

An example for cas:

    // security.yml
    security:
        // ...
        firewalls:
            my_firewall:
                pattern: ^/secured-area/.*$
                trusted_sso:
                    protocol:   cas
                    version:    2
                    base_url:   my.cas_server.com
                    check_path: /sso/login
        //...

List of configuration parameters:

-   protocol: the protocol key (cas, kerberos ...)
-   version: the protocol version (1 or 2 for cas)
-   base_url: SSO server base URL
-   chack_path: as usual ...

Other settings are used by other security components and have no action on this bundle.


Open SSO:
---------


**To be implemented ...**