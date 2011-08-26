SSO authentication for Symfony2
===============================


*Tests fail since this commit : 9e038c005cdcb349eb1de2c9e44e53ccc4f7db43 ... cant see why, maybe a session issue?*


-   Only CAS is implemented for now.
-   Unit & functional tests OK!


**SSO systems:**

-   Currently implemented:
    -   CAS: http://www.jasig.org/cas
-   Planed implementations:
    -   CoSign: http://cosign.sourceforge.net/
    -   WebAuth: http://webauth.stanford.edu/
    -   OpenID: http://openid.net/
-   Other systems:
    -   OAuth: http://oauth.net/
    -   LDAP: http://en.wikipedia.org/wiki/LDAP
    -   JOSSO: http://www.josso.org/confluence/display/JOSSO1/JOSSO+-+Java+Open+Single+Sign-On+Project+Home
    -   OpenAM: http://www.forgerock.com/openam.html
    -   PubCookie: http://www.pubcookie.org/


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
                    login_action: BeSimpleSsoAuthBundle:TrustedSso:login
                    logout_action: BeSimpleSsoAuthBundle:TrustedSso:logout
                    # ...
        #...

Specific configuration:

-   `server`: the SSO server name (this server is configured under the `be_simple_sso_auth` section).
-   `login_action`: when login required, user is forwarded to this action (wich by default tell him to
    follow given link to authenticate). Set to `false` to auto-redirect user to SSO login form.
-   `logout_action`: same as `login_action`, but for logout


###Configure your server:

    # config.yml
    be_simple_sso_auth:
        my_server:
            protocol: cas                           # required
            version: 2
            base_url: http://cas.domain.tls/path    # required
            username: {username}@{server_id}
            validation_request:
                client: Curl                        # or FileGetContents
                method: get
                timeout: 5                          # in seconds
                max_redirects: 5
        # ...

Username formatting:

If you use many authentication systems, you may get many users with same username.
To avoid collision, you can format usernames (with the `username` configuration entry)
with SSO specific variables. Valid placeholders are:

-   `username`: the username,
-   `server_id`: SSO server ID,


Open SSO:
---------


*To be implemented ...*


Create custom SSO provider:
---------------------------


*To be continued ...*
