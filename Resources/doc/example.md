Authentication through SSO CAS Server with Symfony2
===================================================

- use the Bundle : BeSimpleSsoAuthBundle (install with Composer)
- be careful on dependences : Buzz needs a recent version of libcurl (7.19 ??)


Configure SSO
-------------

In config.yml:

        be_simple_sso_auth:
            admin_sso:
                protocol:
                    id: cas
                    version: 2
                server:
                    id: cas
                    login_url: https://cas.server.tld/login
                    logout_url: https://cas.server.tld/logout
                    validation_url: https://cas.server.tld/serviceValidate



Create a firewall
-----------------

    # app/config/security.yml
    my_firewall:
        pattern: ^/
        anonymous: ~
        trusted_sso:
            manager: admin_sso
            login_action: false 		# BeSimpleSsoAuthBundle:TrustedSso:login
            logout_action: false 		# BeSimpleSsoAuthBundle:TrustedSso:logout
            create_users: true
            created_users_roles: [ROLE_USER ]
            check_path: /


Create all routes (mandatory even if there is no controller)
------------------------------------------------------------

    # app/config/routing.yml
    login:
        pattern: /login
    logout:
        pattern: /logout
      

Providers 
---------

Example with Propel:

    providers:
        administrators:
            propel:
                class: Altern\CdtBundle\Model\User
                property: username

The propel User Class must implement \Symfony\Component\Security\Core\User\UserInterface

Customize the "Username does not exist" error page
--------------------------------------------------

When a user successfully authenticates, but is not in the user provider's data store (or a user provider is not configured at all),
then a generic error page is shown indicating that the user was not found. You can customize this error page by overriding the Twig error template,
as described here: http://symfony.com/doc/current/cookbook/controller/error_pages.html

If necessary, you can disable SSL Certificate Verification
----------------------------------------------------------

This is handy when using a development server that does not have a valid certificate, but it should not be done in production.

    # app/config/parameters.yml
    be_simple.sso_auth.client.option.curlopt_ssl_verifypeer.value: FALSE
