Authentication through SSO CAS Server with Symfony2
===================================================

- use the Bundle : BeSimpleSsoAuthBundle (instal with Composer)
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

In security.yml:
	
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

In routing.yml :

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


If necessary, you can disable SSL Certificat Verification
---------------------------------------------------------

Add in parameters.ini : 

    	be_simple.sso_auth.client.option.curlopt_ssl_verifypeer.value: FALSE
