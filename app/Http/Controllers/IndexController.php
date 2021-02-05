<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

final class IndexController extends Controller
{
    /**
     * IndexController constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }

    /**
     * Default index action
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $status = 400;
        $output = [
            'success' => false,
            'details' => [],
        ];

        try {
            $status = 200;
            $output = [
                'success' => true,
                'details' => "Hello...",
            ];
        }
        catch (\Exception $exception) {
            $this->catchException($exception, $status, $output);
        }
        finally {
            return $this->respond($output, $status);
        }
    }
}
