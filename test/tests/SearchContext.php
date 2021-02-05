<?php

/**
 * Defines application features from the API context.
 */
class SearchContext extends TestContext
{
    const URI_NOT_FUND = 'URI_NOT_FUND';
    const URI_SEARCH = 'URI_SEARCH';

    private $uriNotFound;
    private $httpResponse;
    private $page = 1;
    private $per_page = 5;

    /**
     * SearchContext constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->uriNotFound = env(self::URI_NOT_FUND, '/not-found');
        $this->httpResponse = new \Illuminate\Http\Response();
    }

    /**
     * @return array
     */
    private function getContentData()
    {
        $output = [];

        try {
            $content = json_decode($this->httpResponse->content(), true);
            $output = $content['data'];
        }
        catch (\Exception $exception) {
        }
        finally {
            return $output;
        }
    }

    /**
     * @Given /^Requested page is (\d+)$/
     * @param int $page
     */
    public function setPage(int $page)
    {
        try {
            $this->page = $page;
        }
        catch (\Exception $exception) {}
    }

    /**
     * @Given /^Page limit is (\d+)$/
     * @param int $limit
     */
    public function setPageLimit(int $limit)
    {
        try {
            $this->per_page = $limit;
        }
        catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @Then Consumer gets a :expectedHttpCode response
     * @param $expectedHttpCode
     */
    public function consumerGetsHttpResponse(int $expectedHttpCode)
    {
        $output = false;
        $content = [];

        try {
            $status = $this->httpResponse->status();
            $content = json_decode($this->httpResponse->content(), true);
            $output = $status === $expectedHttpCode;
        }
        catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        }
        finally {
            $message = "\nAssertion Error:\n" . json_encode($content);
            $this->assertTrue($output, $message);
        }
    }

    /**
     * @When Consumer requests all books
     */
    public function getAllBooks()
    {
        try {
            $apiUri = env(self::URI_SEARCH, $this->uriNotFound);

            $this->httpResponse = $this
                ->json('GET', $apiUri, [
                    'page' => $this->page,
                    'per_page' => $this->per_page,
                ])
                ->response;
        }
        catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @Given /^There should be (\d+) total results$/
     * @param int $totalResults
     */
    public function totalResultsShouldBe(int $totalResults)
    {
        $output = false;
        $data = [];

        try {
            $data = $this->getContentData();
            $output = $data['totalResults'] === $totalResults;
        }
        catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        }
        finally {
            $message = "\nAssertion Error:\n" . json_encode($data);
            $this->assertTrue($output, $message);
        }
    }

    /**
     * @Given /^There should be (\d+) pages$/
     * @param int $expectedPages
     */
    public function totalPagesShouldBe(int $expectedPages)
    {
        $output = false;
        $data = [];

        try {
            $data = $this->getContentData();
            $output = $data['totalPages'] === $expectedPages;
        }
        catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        }
        finally {
            $message = "\nAssertion Error:\n" . json_encode($data);
            $this->assertTrue($output, $message);
        }
    }

    /**
     * @Given /^Page (\d+) should have (\d+) results$/
     * @param int $page
     * @param int $expectedResults
     * @internal param int $expectedPages
     */
    public function pageContainsResults(int $page, int $expectedResults)
    {
        $output = false;
        $data = [];

        try {
            $data = $this->getContentData();
            $output = $data['currentPage'] === $page && count($data['results']) === $expectedResults;
        }
        catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        }
        finally {
            $message = "\nAssertion Error:\n" . json_encode($data);
            $this->assertTrue($output, $message);
        }
    }
}
