Installation
------------

Add this to your `composer.json` file:

```json
"require": {
	"agupta/yahoo-api-bundle": "dev-master",
}
```

or install using composer

```composer
composer require agupta/yahoo-api-bundle
```

Add the bundle to `app/AppKernel.php`

```php
$bundles = array(
	// ...
	new Yahoo\ApiBundle\YahooApiBundle(),
);
```

Configuration
-------------

Add this to your `config.yml`:

```yaml
imports:
    # ...
    - { resource: "@YahooApiBundle/Resources/config/services.yml" }
```

```yaml
yahoo_api:
    application_id: 'app-id'
    consumer_key: 'consumer-key'
    consumer_secret: 'consumer-secret'
    callback_url: 'callback-url'
```

Usage
-----