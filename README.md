PHP Quiz 🐘
===========

This is the public repository of the [https://phpquiz.xyz][1] website.


Requirements
------------

  * [The Symfony binary][4] using at least 7.4
  * [Docker][5] and [Docker compose][6]
  * [Yarn][7]
  * and the [usual Symfony application requirements][2].


How to install this project
---------------------------

As you can see, there no "full-docker-setup" yet. But feel free to contribute if
you want one, that would be nice.

To install and run the project, run the following commands:

  1. `git clone git@github.com:strangebuzz/phpquiz.git`
  1. `cd phpquiz`
  1. `make install`
  1. `make up`
  1. `make run`
  1. Browse `http://127.0.0.1:8006`

If you have an error regarding the database connection run `make run` a second
time so PostgreSQL is finally available.

That's it, you should be ready to develop.


Dev
---

You can find the dev notes in the [README.txt][8] file.


Coding standards
----------------

Execute this command to run PHPStan:

```bash
$ make cs
```


Tests
-----

Execute this command to run the tests:

```bash
$ make test
```


Contribute
----------

Create [an issue][3] so we can talk about it.

[1]: https://phpquiz.xyz
[2]: https://symfony.com/doc/current/setup.html#technical-requirements
[3]: https://github.com/strangebuzz/phpquiz/issues
[4]: https://symfony.com/download
[5]: https://www.docker.com/get-started
[6]: https://docs.docker.com/compose/
[7]: https://yarnpkg.com/
[8]: README.txt
