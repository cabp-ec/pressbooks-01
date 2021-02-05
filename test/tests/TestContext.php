<?php

use Behat\Behat\Context\Context;

abstract class TestContext extends Laravel\Lumen\Testing\TestCase implements Context
{
    const APP_URL_KEY = 'APP_URL';

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->app = $this->createApplication();
        $this->baseUrl = env(self::APP_URL_KEY);
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../../bootstrap/app.php';
    }
}
