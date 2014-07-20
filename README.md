Certificationy Web Platform
============================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ProPheT777/certificationy-web-platform/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ProPheT777/certificationy-web-platform/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/fcf9e36d-0eb4-40c9-a1de-2d3fc13d27a9/mini.png)](https://insight.sensiolabs.com/projects/fcf9e36d-0eb4-40c9-a1de-2d3fc13d27a9)

This project is originally inspired of [eko/certificationy](https://github.com/eko/certificationy).
The goal is to train about the symfony certification [http://sensiolabs.com/en/symfony/certification.html](http://sensiolabs.com/en/symfony/certification.html) and may be other ?

Installation
-------------

### Requirements ###
* PHP 5.3.3 at least
* PHP extension : cURL, mongo, amqp (optional)
* Composer
* MySQL
* MongoDB
* RabbitMQ (optional)

**I'm interesting for vagrant / docker solution**

Installation
-------------

Go to the root of project and

```shell
git clone https://github.com/ProPheT777/certificationy-web-platform.git
cd certificationy-web-platform
composer install -o
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console assets:install
php app/console doctrine:mongodb:schema:create
php app/console assetic:dump --env="prod" #assets prod are versionned so it's not required
```

Development
-----------

```shell
php app/console assetic:dump --watch
```

Setup github connect if you dev on it else use the heavy way. Then feed `github_client_id` and `github_client_secret` in `app/config/parameters.yml` with your dev application keys.

Documentation
--------------

Coming ASAP

Test
----

No test yet, but it's plan to integrate BDD test with Behat for the web platform.
Certy also not test.

Roadmap
-------

**Soon as possible :**
* Write test for Certy component (phpunit)
* Write test for Certy bundle (phpunit)
* Write test for the web platform (behat)
* Redesigned homepage
* Add contribution page for the web plateform
* Add httpCache / ESI for Certification part.
* Add redis cache for production (session, doctrine, form)
* i18n training support (Need to review data structure)
* Level training support (Need to review data structure)
* Improve metrics, add timer.
* Add new context ability : limit number of questions per category

**Long time :**
* Add interesting dumper (I think to pdf & SQL)
* Add interesting loader (SQL)
* Add new training (Currently we have only Symfony2 because they provide a certification, but why not add other techs / libs) ?
* Add ability to create custom training online, and share / rate with other users ? (need SQL loader / dumper before)
* Add new certy component to provide reward / achievement system.
* Add ability to make training program who group several libs & techs. (Only if we have active community).
* Get a real design instead of boostrap.



Contribution
-------------

All contribution are welcome ! So please feel free to submit PRs.

We follow coding standard [PSR-2](http://www.php-fig.org/psr/psr-2).