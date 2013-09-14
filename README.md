![CodeIgniter](http://www.elreplicante.com.ar/wp-content/uploads/2012/05/codeigniter-logo.png)
### meets
![Segment.io](http://nathaniel.talbott.ws/images/posts/segmentio_homepage.png)


<div style="margin-top: 50px;">
This library keeps Segment.io integration away from the meat of your app (i.e. the controllers/models/views). It wraps the identify and track methods from Segment.io's own PHP bindings for ease of use.
</div>

## Installation
Either download and unpack the archive into application/libraries/Loggly or use git submodules. Use sudo if you're in a restricted directory.

#### Add Segment.io API key + secret
Add your Segment.io API key and secret to your default config file (values below are non-working) and any custom environment config files you've created

application/config/config.php  
application/config/(development|staging|whatever)/config.php  

```php
/* Segment.io config data */
$config['segment']['API_key'] = 'xxxxxxx';
$config['segment']['secret'] = 'yyyyyyyyyyyyyyyyyyyy';
```

## Usage
Haven't figured that part out yet

## Acknowledgements
PHP API taken from [Segment.io](https://github.com/segmentio/analytics-php)
