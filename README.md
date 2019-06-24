# Custom Logging
Allows configurable logging, on a per environment basis. Whilst still keeping the logging configuration in source control.

100% compatible with [Mdoq](https://www.mdoq.io)  
  
To setup you will need to add the following snippets to the appropriate files.  
On you production sites make sure you change the `stack` value to `production`.  
In addition to this if you are running multiple webheads you can the `hardware_instance` value to identify each web head. eg `admin-01`, `web-asg-01` this will then be added to the logs.

## env.php Config Example
```php
'logging' => [
        'hardware_instance' => 'server1-blahblah',
        'stack' => 'non_production'
    ],
```

## config.php Config Example
```php
'logging' => [
        'stacks' => [
            'production' => [
                'handlers' => [
                    'productionDefaultLogger' => [],
                ],
                'common_formatter' => \Monolog\Formatter\JsonFormatter::class,
                'common_processors' => [
                    \Monolog\Processor\GitProcessor::class,
                    \Monolog\Processor\IntrospectionProcessor::class,
                    \Monolog\Processor\WebProcessor::class,
                    \Zero1\CustomLogging\Logger\Processor\HardwareInstance::class,
                ]
            ],
            'non_production' => [
                'handlers' => [
                    'nonProductionDefaultLogger' => [],
                    'nonProductionDebugLogger' => [],
                ],
                'common_formatter' => 'loggingLineFormatter',
                'common_processors' => [
                    \Monolog\Processor\GitProcessor::class,
                    \Monolog\Processor\IntrospectionProcessor::class,
                    \Monolog\Processor\WebProcessor::class,
                    \Zero1\CustomLogging\Logger\Processor\HardwareInstance::class,
                ]
            ]
        ]
    ]
```

## Additional Information
The changes you make in `app/etc/env.php` are meant to be environment specific. In here you can configure the logging 'stack' you want to use. This value will be out of source control. The 'stack' is purely a nice name to a set of logging configuration defined in `app/etc/config.php`. In `app/etc/config.php` you can configure as many different stacks as you want e.g 'production', 'staging', 'local'. Each of these stacks is stored in source control allowing the stacks to be used by anyone on your code base.

In addition to be able to change the 'stack' with a single environment value, we can also add additional things to all loggers, so that all messages get this info. The default example adds four 'processors' that add extra info.
```php
'common_processors' => [
    \Monolog\Processor\GitProcessor::class,
    \Monolog\Processor\IntrospectionProcessor::class,
    \Monolog\Processor\WebProcessor::class,
    \Zero1\CustomLogging\Logger\Processor\HardwareInstance::class,
]
```
These will be added to all handlers:
```php
'handlers' => [
    'nonProductionDefaultLogger' => [],
    'nonProductionDebugLogger' => [],
 ]
 ```
These link to the loggers that are defined in `etc/di.xml`

How this is different from Magento core:
- In magento core, you would have to make changes in source controlled files to change the logging verbosity. (Not ideal as production should have the same source files as staging, yet they should have different logging verbosity / settings)
- In magento core there is no way to configure different stacks of loggers.