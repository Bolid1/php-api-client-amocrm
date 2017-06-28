PHP client for API amoCRM
=========================

Simple in usage PHP client for [amoCRM](https://amocrm.com/)

### Status
[![Build Status](https://travis-ci.org/Bolid1/php-api-client-amocrm.svg?branch=master)](https://travis-ci.org/Bolid1/php-api-client-amocrm)
[![Coverage Status](https://coveralls.io/repos/github/Bolid1/php-api-client-amocrm/badge.svg?branch=master)](https://coveralls.io/github/Bolid1/php-api-client-amocrm?branch=master)

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require "bolid1/php-api-client-amocrm"
```

## Usage

Create lead with *\amoCRM\Entities\Elements\Lead* class:
```php
$lead = new \amoCRM\Entities\Elements\Lead;
$lead->setName('My new lead');
```

Init requester via *\amoCRM\RequesterFactory*::__make__ method:
```php
$requester = \amoCRM\RequesterFactory::make('subdoma', 'email@example.com', 'secret_key');
```

Create *\amoCRM\Entities\LeadsRequester* object and send lead info to amoCRM
```php
$leads_requester = new \amoCRM\Entities\LeadsRequester($requester);
$created_leads = $leads_requester->add([$lead->toAmo()]);
if (!empty($created_leads[0]['id'])) {
    $lead->setId($created_leads[0]['id']);
}
```

### License
PHP client for API amoCRM is MIT license
