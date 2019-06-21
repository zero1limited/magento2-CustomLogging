# magento2-CustomLogging
Allows configurable logging
  
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