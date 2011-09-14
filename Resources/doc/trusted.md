BeSimpleSsoAuthBundle trusted SSO configuration
===============================================


Firewall configuration
----------------------


**Config entries:**

BeSimpleSsoAuthBundle adds 3 configuration entries to standard (form_login) firewall wich are:

-   `server`: name of the server configured under `be_simple_sso_auth` config section (see below).
-   `login_action`: when login required, user is forwarded to this action (wich by default tell him to
    follow given link to authenticate). Set to `false` to auto-redirect user to SSO login form.
-   `logout_action`: same as `login_action`, but for logout.

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


Server configuration
--------------------


**Required entries:**

-   `protocol`: protocol alias as defined in services.
-   `base_url`: server base url.


**Optional entries:**

-   `version` (default 1): protocol version.
-   `username` (default '{username}@{server_id}'): username format (see below).
-   `validation_request`:
    -   `client` (default 'FileGetContents'): Buzz library client implementation.
    -   `method` (default 'get'): HTTP method.
    -   `timeout` (default 5): HTTP timeout in seconds.
    -   `max_redirects` (default 5): maximum allowed redirects.


**Username formatting:**

If you use many authentication systems, you may get many users with same username.
To avoid collision, you can format usernames (with the `username` configuration entry)
with SSO specific variables. Valid placeholders are:

-   `username`: the username.
-   `server_id`: SSO server ID.


**An example in YAML format:**

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
