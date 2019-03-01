<?php
namespace Zero1\CustomLogging\Logger;

use Monolog\Handler\HandlerInterface;

class HandlersFactory
{
    protected $objectManager;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager
    ){
        $this->objectManager = $objectManager;
    }

    public function create($config)
    {
        $handlers = [];
        if(isset($config['handlers'])){
            foreach($config['handlers'] as $classAlias => $classConfig){
                /** @var HandlerInterface $handler */
                $handler = $this->objectManager->get($classAlias);
                if(isset($classConfig['formatter'])){
                    $handler->setFormatter($this->objectManager->get($classConfig['formatter']));
                }

                if(isset($classConfig['processors'])){
                    foreach($classConfig['processors'] as $processorAlias){
                        $handler->pushProcessor($this->objectManager->get($processorAlias));
                    }
                }
                $handlers[] = $handler;
            }

            if(isset($config['common_formatter'])){
                $formatter = $this->objectManager->get($config['common_formatter']);
                foreach($handlers as $handler){
                    if(!$handler->getFormatter()){
                        $handler->setFormatter($formatter);
                    }
                }
            }

            if(isset($config['common_processors'])){
                foreach($config['common_processors'] as $processorAlias){
                    $processor = $this->objectManager->get($processorAlias);
                    foreach($handlers as $handler){
                        $handler->pushProcessor($processor);
                    }
                }
            }
        }
        return $handlers;
    }
}