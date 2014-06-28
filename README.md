Certificationy Web Platform
============================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ProPheT777/certificationy-web-platform/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ProPheT777/certificationy-web-platform/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/fcf9e36d-0eb4-40c9-a1de-2d3fc13d27a9/mini.png)](https://insight.sensiolabs.com/projects/fcf9e36d-0eb4-40c9-a1de-2d3fc13d27a9)

Provide web web platform of [eko/certificationy](https://github.com/eko/certificationy) project.
The goal is to tain about the symfony certification [http://sensiolabs.com/en/symfony/certification.html](http://sensiolabs.com/en/symfony/certification.html)

Installation
-------------

### Requirements ###
* PHP 5.3.3 at least
* Curl extension
* Composer
* MySQL

Go to the root of project and

```shell
git clone https://github.com/ProPheT777/certificationy-web-platform.git
cd certificationy-web-platform
composer install -o
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console assets:install
php app/console assetic:dump --env="prod" #assets prod are versionned so it's not required
```

Development
-----------

```shell
php app/console assetic:dump --watch
```

Setup github connect if you dev on it else use the heavy way. Then feed `github_client_id` and `github_client_secret` in `app/config/parameters.yml` with your dev application keys.

Test
----

No test yet, but it's plan to integrate BDD test with Behat.

Roadmap
-------
* Integrate Q/A system based on YML from [eko/certificationy](https://github.com/eko/certificationy)
* Use Redis for session and cache in production env
* Add Scrutinizer / SensioLabsInsight tracking for CI
* Add BDD test with Behat
* Analitics on train session
* Provide informations about the certification from Symfony
* Add SensioLabs connect to login (Bind certification to register newer certified developper who we help with this app and display / count on the web platform ?)
* Add httpCache and use ESI.
* Add caspitrano 3 config to easy deploy.
* If some people wants mobile (web) app, why not provide an API.
* Improve responsive template.
* Add contribution system to provide Q/A ??
* Fix typo :D
* Launch hamsters on Mars

Contribution
-------------

All contribution are welcome ! So please feel free to submit PRs.

We follow coding standard [PSR-2](http://www.php-fig.org/psr/psr-2).