PHP Quiz 🐘
===========

This is the public repository of the [https://phpquiz.xyz][1] website.


Requirements ⚙
--------------

  * [The Symfony binary][4] using at least PHP 7.4
  * [Docker][5] and [Docker compose][6]
  * [Yarn][7]
  * And the [usual Symfony application requirements][2].

Here are the versions I currently use:

  * Symfony CLI **v4.18.4**
  * Docker **19.03.12**
  * Docker-compose **1.26.2**
  * Yarn **1.22.4**

How to install this project 📚
------------------------------

As you can see, there no "full-docker-setup" yet. But feel free to contribute if
you want one, it would be nice.

To install and run the project, run the following commands:

  1. `git clone git@github.com:strangebuzz/phpquiz.git`
  1. `cd phpquiz`
  1. `make install`
  1. `make up`
  1. `make run`
  1. Browse `http://127.0.0.1:8006`

If you have an error regarding the database connection, run `make run` a second
time, so PostgreSQL is finally available.

That's it; you should be ready to develop.


Dev 📔
------

You can find the dev notes in the [README.txt][8] file.

To see the changes you do to the assets (Js, CSS), you must run yarn watch with the
following command:

```bash
$ make watch
```


Coding standards ✨
-------------------

Execute this command to run [PHPStan][9]:

```bash
$ make cs
```


Tests ✅
--------

Execute this command to run the [PHPUnit][11] tests:

```bash
$ make test
```

Deploy 🚀
--------

There is a [deploy file][10] sample. To be able to deploy, copy it to `config/prod/deploy.php`
and modify the settings it contains. Then you can deploy in production with:

```bash
$ make deploy
```


Contribute 🤝
-------------

Please create an [an issue][3] so we can talk about it.

[1]: https://phpquiz.xyz
[2]: https://symfony.com/doc/current/setup.html#technical-requirements
[3]: https://github.com/strangebuzz/phpquiz/issues
[4]: https://symfony.com/download
[5]: https://www.docker.com/get-started
[6]: https://docs.docker.com/compose/
[7]: https://yarnpkg.com/
[8]: README.txt
[9]: https://github.com/phpstan/phpstan
[10]: config/prod/deploy_sample.php
[11]: https://phpunit.de/
