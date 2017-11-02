Using BeSimpleSsoAuthBundle with FosUserBundle
======================================

In order to use FosUserBundle in conjunction with BeSimpleSsoAuthBundle, you need to add the provider directive in security.yml

```
// other directives

    providers:
        fos_userbundle:
            id: fos_user.user_provider.username

// other directives

    firewalls:
        main:
            ...
            provider: fos_userbundle
            ....
```

Then you can create a user with the same username as your SSO.
