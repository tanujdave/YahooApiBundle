A Symfony2 Wrapper for the Yahoo API.

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
composer require agupta/yahoo-api-bundle:dev-master
```

Register bundle in `app/AppKernel.php`

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

Add this to your `routing.yml`:

```yaml
yahoo_api:
    resource: "@YahooApiBundle/Resources/config/routing.yml"
    prefix:   /
```

Usage
-----

**STEP1:**

Call this url for authorization and getting code from the Yahoo api:

```link
http://YOUR_DOMAIN/yahoo_authorization
```

Above url will auto redirect to your callback_url with additional parameter '**code**'

```link
http://CALLBACK_URL?code=[CODE]
```

**STEP2:**

Add following code in your callback_url action to get yahoo contacts:
 
```php
public function CallbackUrlAction(Request $request)
{
    // ...
    $code = $request->get('code',null);	
    if($code) {
        $yahooService = $this->get('AG.Yahoo.OAuth2.Service');	
        $contacts = $yahooService->getContacts($code);
        var_dump($contacts);
    }
    // ...
}
```