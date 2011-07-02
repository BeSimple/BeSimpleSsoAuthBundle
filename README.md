SSO authentication for Symfony2
===============================


**Warning:**

-   Currently under development, unusable for now.
-   Only unit tests, missing functional.
-   Currently implemented: CAS only.


**Summary:**

-   Get started: install & enable bundle & dependencies
-   Trusted SSO: force user to authenticate with a trusted server
-   Open SSO: let user authenticate with any SSO server


Get started:
------------


###Install bundle & dependency:

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


###Enable bundle & dependency:

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

    # app/config/security.yml
    security:
        # ...
        factories:
            - "%kernel.root_dir%/../vendor/bundles/BeSimple/SsoAuthBundle/Resources/config/security_factories.xml"
        # ...


###Run the tests:

    phpunit -c app vendor/bundles/BeSimple/SsoAuthBundle


Trusted SSO:
------------


###Configure your firewall:

An example in the YAML format:

    # security.yml
    security:
        # ...
        firewalls:
            my_firewall:
                pattern: ^/secured-area/.*$
                trusted_sso:
                    server: my_server
                    # ...
        #...

The full list of settings:

-   `server`: the SSO server name (this server is configured under the `be_simple_sso_auth` section.
-   `check_url`:


###Configure your server:

    # config.yml
    be_simple_sso_auth:
        my_server:
            protocol: cas                           # required
            version: 2
            base_url: http://cas.domain.tls/path    # required
            validation_request:
                client: Curl                        # or FileGetContents
                method: get
                timeout: 5                          # in seconds
                max_redirects: 5
        # ...

Note that you can define a `default` section to store your default values.


Open SSO:
---------


*To be implemented ...*


Create custom SSO provider:
---------------------------


*To be continued ...*