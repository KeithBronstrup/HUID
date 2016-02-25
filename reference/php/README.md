# Documentation
## HUID PHP Class

Using the Host-Unique Identifier PHP Class in your project is simple. Follow the
installation and usage instructions below, and you'll be using HUID in your
application in no time!

### Installation

#### Manual Installation

All that is required to use HUID in your application is the file
`/bin/php/huid.php`. Simply copy this file into your application and load it
like any other class. If using an autoloader, be sure to install the file to the
correct location and configure your autoloader to load the HUID class from this
file.

#### Installing via Composer

If your application utilizes Composer, you can use the PHP-specific branch of
this repository as a dependency, like so:
```
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/KeMBro2012/HUID.git"
        }
    ],
    "require": {
        "KeMBro2012/HUID": "dev-php"
    }
}
```

This will fetch the most recent release from the `php` branch.

If you require a specific version, replace `dev-php` with the version you need.

### Usage

The most basic usage of the HUID class is to simply instantiate it (after
`require()`ing it if not utilizing an autoloader), passing in your primary and
secondary namespace, then call the `get()` method, like so:
```
$HUID = new HUID('aaaa', 'bbb');
$HUIDValue = $HUID->get();
```

In the above example, the value of `$HUIDValue` will be something similar to
`00000056ceb810-4151c70-aaaa-bbb-bbf0`. Calling `get()` a second time will yield
the same result; to get a new HUID value, call the `generate()` method.

If you wish to instantiate the HUID class without generating a HUID value,
omit the namespace parameters, like so:
```
$HUID = new HUID();
$HUIDValue = $HUID->get();
```

In this example, the value of `$HUIDValue` will be `false`.

### Additional Documentation

For additional documentation, refer to the comments in `/bin/php/huid.php`.

-----
##### Copyright (c) 2016 Keith Bronstrup and Contributors
