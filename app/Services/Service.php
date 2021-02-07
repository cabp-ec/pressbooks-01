<?php

namespace App\Services;

class Service
{
    const LOGGER_INTERFACE = 'LOGGER_INTERFACE';
    const KEY_SUCCESS = 'success';
    const KEY_MESSAGE = 'message';
    const KEY_DATA = 'data';
    const STANDARD_OUTPUT = [
        self::KEY_SUCCESS => false,
        self::KEY_MESSAGE => '',
        self::KEY_DATA => [],
    ];

    protected $logger;

    function __construct()
    {
        $this->logger = app(env(self::LOGGER_INTERFACE));
    }

    protected function catchException(\Exception $exception, bool $exit = true)
    {
        try {
            if (app()->environment('local')) {
                echo $exception->getFile() . '<br>';
                echo $exception->getLine() . '<br>';
                echo $exception->getMessage();

                if ($exit === true) {
                    exit;
                }
            }
            else {
                $this->logger->error($exception, ['exception' => $exception]);
            }
        }
        catch (\Exception $e) {
            throw $exception;
        }
    }
}