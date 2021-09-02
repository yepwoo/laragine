<?php

namespace Core\Base\Logging;

use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class CustomizeFormatter
{
    /**
     * The request
     *
     * @var Request
     */
    protected $request;

    /**
     * Init
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke(Logger $logger)
    {
        if ($this->request) {
            foreach ($logger->getHandlers() as $handler) {
                $handler->pushProcessor([$this, 'processLogRecord']);
            }
        }
    }

    /**
     * Process Log Record
     *
     * @param array $record
     * @return array
     */
    public function processLogRecord(array $record): array
    {
        $record['extra'] += [
            'route'   => $this->request->route() ? $this->request->route()->getName() : '',
            'url'     => $this->request->url(),
            'ip'      => $this->request->getClientIp(),
            'time'    => now(),
            'user'    => $this->request->user() ?? 'guest',
            'request' => $this->request
        ];

        return $record;
    }
}
