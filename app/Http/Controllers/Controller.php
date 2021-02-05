<?php

namespace App\Http\Controllers;

use Psr\Log\LoggerInterface;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Response;
use App\Exceptions\Handler;

class Controller extends BaseController
{
    // Response Headers
    const HTTP_RESPONSE_HEADER_KEY = 'HTTP_RESPONSE_HEADER_KEY';
    const HTTP_RESPONSE_HEADER_VALUE = 'HTTP_RESPONSE_HEADER_VALUE';

    // Response Status
    const HTTP_STATUS_OK = 'HTTP_STATUS_OK';
    const HTTP_STATUS_SERVER_ERROR = 'HTTP_STATUS_SERVER_ERROR';
    const HTTP_STATUS_BAD_REQUEST = 'HTTP_STATUS_BAD_REQUEST';
    const HTTP_STATUS_CONFLICT = 'HTTP_STATUS_CONFLICT';

    // Response Message
    const HTTP_MESSAGE_SERVER_ERROR = 'HTTP_MESSAGE_SERVER_ERROR';
    const HTTP_MESSAGE_CONFLICT = 'HTTP_MESSAGE_CONFLICT';

    // Default Output
    const DEFAULT_HTTP_RESPONSE_OUTPUT = [
        'success' => false,
        'status' => 400,
        'message' => '',
        'data' => [],
    ];

    protected $logger;
    protected $httpStatusCode;
    protected $exceptionHandler;

    /**
     * Controller constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->exceptionHandler = new Handler();

        $this->httpStatusCode = [
            self::HTTP_STATUS_OK => env(self::HTTP_STATUS_OK, 200),
            self::HTTP_STATUS_SERVER_ERROR => env(self::HTTP_STATUS_SERVER_ERROR, 500),
            self::HTTP_STATUS_BAD_REQUEST => env(self::HTTP_STATUS_BAD_REQUEST, 400),
            self::HTTP_STATUS_CONFLICT => env(self::HTTP_STATUS_CONFLICT, 409),
        ];
    }

    /**
     * Catch an exception and send it to the default handler
     * @param \Exception $exception
     * @param $status
     * @param $output
     * @throws \Exception
     */
    protected function catchException(\Exception $exception, &$status, &$output)
    {
        $status = $this->httpStatusCode[self::HTTP_STATUS_SERVER_ERROR];

        $output['status'] = $status;
        $output['message'] = env(self::HTTP_MESSAGE_SERVER_ERROR, 'Ups...');
        $output['data'] = [
            'exception' => $exception->getMessage(),
        ];

        $this->exceptionHandler->report($exception);
    }

    /**
     * Respond as JSON
     * @param array $output
     * @param int $status
     * @return Response
     */
    protected function respond(array $output, int $status)
    {
        $headerKey = env(self::HTTP_RESPONSE_HEADER_KEY);
        $headerValue = env(self::HTTP_RESPONSE_HEADER_VALUE);

        return (new Response($output, $status))
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'OPTIONS, POST, GET')
            ->header('Access-Control-Allow-Headers', 'Content-Type')
            ->header($headerKey, $headerValue);
    }
}
