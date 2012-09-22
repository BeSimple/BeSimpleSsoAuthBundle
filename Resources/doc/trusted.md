BeSimpleSsoAuthBundle trusted SSO configuration
===============================================


Firewall configuration
----------------------


**Config entries:**

BeSimpleSsoAuthBundle adds 5 configuration entries to standard (form_login) firewall which are:

-   `manager`: name of the manager configured under `be_simple_sso_auth` config section (see below).
-   `login_action`: when login required, user is forwarded to this action (which by default tell him to
    follow given link to authenticate). Set to `false` to auto-redirect user to SSO login form.
-   `logout_action`: same as `login_action`, but for logout.
-   `create_users`: authorize user provider to create not found users if implementing UserFactoryInterface.
-   `created_users_roles`: an array of roles to assign to users created by user provider.

Other required configuration entries are:

-   `login_path`: path to redirect to when login needed.
-   `check_path`: path to redirect to when checking login informations.

Other optional configuration entries are:

-   `always_use_default_target_path` (default false): if true, always redirect to default target path when logged in.
-   `default_target_path` (default '/'): target path to redirect to when `always_use_default_target_path` is true.
-   `target_path_parameter` (default '_target_path'):
-   `use_referer` (default false):
-   `failure_path` (default null): go to this path on failure.
-   `failure_forward` (default false): forward (true) or redirect (false) to failure path.


**An example in YAML format:**

    # security.yml

    security:
        firewalls:
            my_firewall:
                pattern: ^/admin/.*$
                trusted_sso:
                    manager: admin_sso
                    login_action: BeSimpleSsoAuthBundle:TrustedSso:login
                    logout_action: BeSimpleSsoAuthBundle:TrustedSso:logout
                    create_users: true
                    created_users_roles: [ROLE_USER, ROLE_ADMIN]


Manager configuration
---------------------


Now you must configure your `my_manager` manager.


**An example in YAML format:**

    # config.yml

    be_simple_sso_auth:
        admin_sso:
            protocol:
                id: cas
                version: 2
            server:
                id: cas
                login_url: http://cas.server.tld/login
                logout_url: http://cas.server.tld/logout
                validation_url: http://cas.server.tld/serviceValidate
