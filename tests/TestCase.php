<?php namespace Tests;

use App\Application;
use Limoncello\Testing\PhpUnitTestCase;
use Limoncello\Testing\Sapi;
use Mockery;
use Neomerx\JsonApi\Contracts\Http\Headers\MediaTypeInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\EmitterInterface;

/**
 * @package Tests
 */
class TestCase extends PhpUnitTestCase
{
    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    /**
     * @inheritdoc
     */
    protected function createSapi(
        array $server = null,
        array $queryParams = null,
        array $parsedBody = null,
        array $cookies = null,
        array $files = null,
        $messageBody = 'php://input'
    ) {
        /** @var EmitterInterface $sapiEmitter */
        $sapiEmitter = Mockery::mock(EmitterInterface::class);

        $sapi = new Sapi($sapiEmitter, $server, $queryParams, $parsedBody, $cookies, $files, $messageBody);

        return $sapi;
    }

    /**
     * @inheritdoc
     */
    protected function createApplication(Sapi $sapi)
    {
        $app = (new Application())->setSapi($sapi);

        return $app;
    }

    /**
     * @param string $uri
     * @param string $json
     * @param array  $headers
     * @param array  $cookies
     *
     * @return ResponseInterface
     */
    protected function postJson($uri, $json, array $headers = [], array $cookies = [])
    {
        $headers[self::HEADER_CONTENT_TYPE] = MediaTypeInterface::JSON_API_MEDIA_TYPE;
        return parent::call('POST', $uri, [], [], $headers, $cookies, [], [], $this->streamFromString($json));
    }

    /**
     * @param string $uri
     * @param string $json
     * @param array  $headers
     * @param array  $cookies
     *
     * @return ResponseInterface
     */
    protected function putJson($uri, $json, array $headers = [], array $cookies = [])
    {
        $headers[self::HEADER_CONTENT_TYPE] = MediaTypeInterface::JSON_API_MEDIA_TYPE;
        return parent::call('PUT', $uri, [], [], $headers, $cookies, [], [], $this->streamFromString($json));
    }

    /**
     * @param string $uri
     * @param string $json
     * @param array  $headers
     * @param array  $cookies
     *
     * @return ResponseInterface
     */
    protected function patchJson($uri, $json, array $headers = [], array $cookies = [])
    {
        $headers[self::HEADER_CONTENT_TYPE] = MediaTypeInterface::JSON_API_MEDIA_TYPE;
        return parent::call('PATCH', $uri, [], [], $headers, $cookies, [], [], $this->streamFromString($json));
    }
}