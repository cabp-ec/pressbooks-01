<?php

/**
 * Defines application features from the API context.
 */
class WelcomeContext extends TestContext
{
    const URI_NOT_FUND = 'URI_NOT_FUND';
    const URI_SEARCH = 'URI_SEARCH';
    const URI_TERMS_MOST_USED = 'URI_TERMS_MOST_USED';

    private $uriNotFound;
    private $httpResponse;

    /**
     * WelcomeContext constructor.
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
     * @When Consumer performs a GET request to :apiUrl
     * @param string $apiUri
     */
    public function consumerPerformsGetRequest(string $apiUri)
    {
        try {
            $this->httpResponse = $this->get($apiUri)->response;
        } catch (\Exception $exception) {
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
        } catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        } finally {
            $message = "\nAssertion Error:\n" . json_encode($content);
            $this->assertTrue($output, $message);
        }
    }
}
