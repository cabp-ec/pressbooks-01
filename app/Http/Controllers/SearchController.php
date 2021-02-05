<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\LoggerInterface;

final class SearchController extends Controller
{
    /**
     * SearchController constructor.
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
            'data' => [
                'totalResults' => 0,
                'totalPages' => 0,
            ],
        ];

        try {
            $input = json_decode($request->getContent(), true);
            $perPage = $input['per_page'] ?? 10;
            $page = $input['page'] ?? 1;
            $search = $input['search'] ?? false;
            $original = $input['is_original'] ?? false;
            $subject = $input['subject'] ?? false;

            // TODO: reduce the amount of if statements and 'move' through pages
            $query = DB::table('book');

            if ($search !== false && !empty($search)) {
                $query->where('title', 'like', "%$search%");
            }

            if ($original !== false && (0 === $original || 1 === $original)) {
                $query->where('is_original', $original);
            }

            if ($subject !== false && is_numeric($subject)) {
                $query->where('identifier', $subject);
            }

            $results = $query->paginate($perPage);
            $jsonResults = json_decode($results->toJson(), true);
            $data = $jsonResults['data'];

            $status = 200;
            $output = [
                'success' => true,
                'data' => [
                    'totalResults' => $results->total(),
                    'totalPages' => $results->lastPage(),
                    'currentPage' => $results->currentPage(),
                    'results' => $data,
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
