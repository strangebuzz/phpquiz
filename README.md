PHP Quiz 🐘
===========

This is the public repository of the [https://phpquiz.xyz][1] website. It's a
Symfony 5.1 application trying to respect [best practices][12].

Badges 🏅
--------

<p align="center">
  <a href="#all-contributors">
    <img src="https://img.shields.io/badge/all_contributors-2-orange.svg" alt="All Contributors" />
  </a>
  <a href="/LICENSE">
    <img src="https://img.shields.io/github/license/strangebuzz/phpquiz.svg" alt="MIT License" />
  </a>
</p>

[![SymfonyInsight](https://insight.symfony.com/projects/26fa7619-c350-4c47-a676-3791304d5f32/big.svg)](https://insight.symfony.com/projects/26fa7619-c350-4c47-a676-3791304d5f32)


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

To install and start the project, run the following commands:

  1. `git clone git@github.com:strangebuzz/phpquiz.git`
  1. `cd phpquiz`
  1. `make install`
  1. `make start`
  1. Browse `http://127.0.0.1:8006`

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


Troubleshooting 🐛
-----------------

  * Verify that you have at least PHP **7.4** (`php -v`).
  * In other cases, verify your versions and eventually submit a [bug report][3].


All Contributors
----------------

Thanks goes out to all these wonderful people:

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://github.com/COil"><img src="https://avatars1.githubusercontent.com/u/177844?s=460&u=740a02df5028ae640ad1d158ec04b94939cccfe8&v=4" width="100px;" alt=""/><br /><sub><b>COil</b></sub></a>
    <td align="center"><a href="https://github.com/f2r"><img src="https://pbs.twimg.com/profile_images/1126758661043265543/DPBOnFra_400x400.png" width="100px;" alt=""/><br /><sub><b>Fred</b></sub></a>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

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
[12]: https://www.strangebuzz.com/en/blog/what-are-your-symfony-best-practices
