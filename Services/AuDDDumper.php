<?php

declare(strict_types=1);

namespace Skwi\AuDDBundle\Services;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\DataCollector\DumpDataCollector;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\VarDumper;

class AuDDDumper
{
    private $eventDispatcher;
    private $cloner;
    private $kernelDebug;
    private $dataCollectorDumper;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        bool $kernelDebug,
        VarCloner $cloner,
        DumpDataCollector $dataCollectorDumper
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->kernelDebug = $kernelDebug;
        $this->cloner = $cloner;
        $this->dataCollectorDumper = $dataCollectorDumper;
    }

    public function handleInit()
    {
        if (!$this->kernelDebug) {
            return;
        }

        VarDumper::setHandler(function ($var) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 6);
            $filteredBacktrace = array_filter($backtrace, function ($trace) {
                return 'dd' === $trace['function'];
            });
            if (!empty($filteredBacktrace)) {
                echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/BtyHYIpykN0?controls=0&amp;autoplay=1&amp;showinfo=0&amp;rel=0&amp;vq=medium&amp;start=123" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }

            $data = $this->cloner->cloneVar($var);
            $handler = function ($var) use ($data) {
                $this->dataCollectorDumper->dump($data);
            };
            VarDumper::setHandler($handler);
            $handler($var);
        });
    }
}
