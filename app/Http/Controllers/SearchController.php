<?php

namespace App\Http\Controllers;

use App\Services\InputValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\LoggerInterface;

final class SearchController extends Controller
{
    /**
     * @var InputValidationService
     */
    private $inputValidation;

    /**
     * SearchController constructor.
     * @param LoggerInterface $logger
     * @param InputValidationService $inputValidation
     */
    public function __construct(LoggerInterface $logger, InputValidationService $inputValidation)
    {
        $this->inputValidation = $inputValidation;
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
            'data' => [
                'totalResults' => 0,
                'totalPages' => 0,
            ],
        ];

        try {
            $input = json_decode($request->getContent(), true);
            $perPage = $input['per_page'] ?? 10;
            $query = DB::table('book');

            $whereParams = $this->inputValidation->validate([
                'search' => [
                    'column' => 'title',
                    'value' => $input['search'] ?? false,
                ],
                'original' => [
                    'column' => 'is_original',
                    'value' => $input['is_original'] ?? false,
                ],
                'subject' => [
                    'column' => 'identifier',
                    'value' => $input['subject'] ?? false,
                ],
            ]);

            foreach ($whereParams as $param) {
                $query->where($param['column'], $param['operator'], $param['value']);
            }

            $results = $query->paginate($perPage);

            $status = 200;
            $output = [
                'success' => true,
                'data' => [
                    'totalResults' => $results->total(),
                    'totalPages' => $results->lastPage(),
                    'currentPage' => $results->currentPage(),
                    'nextPageUrl' => $results->nextPageUrl(),
                    'results' => $results->items(),
                ],
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
