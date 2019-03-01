# magento2-CustomLogging
Allows configurable logging


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