<?php
namespace Zero1\CustomLogging\Logger\Processor;

use Monolog\Processor\ProcessorInterface;

class HardwareInstance implements ProcessorInterface
{
    protected $hardwareInstance;

    public function __construct(
        \Magento\Framework\App\DeploymentConfig $deploymentConfig
    ){
        $this->hardwareInstance = $deploymentConfig->get('logging/hardware_instance', '');
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $record['extra']['hardware_instance'] = $this->hardwareInstance;
        return $record;
    }
}
