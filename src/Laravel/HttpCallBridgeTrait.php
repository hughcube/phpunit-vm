<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugh.li
 * Date: 2020/4/2
 * Time: 11:28
 */

namespace HughCube\PHPUnit\VM\Laravel;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Http\Request as LumenRequest;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Trait HttpCallBridgeTrait
 * @package HughCube\PHPUnitVM\Laravel
 * @property \Laravel\Lumen\Application $app
 * @property string $baseUrl
 */
trait HttpCallBridgeTrait
{
    /**
     * @inheritDoc
     */
    public function call(
        $method,
        $uri,
        $parameters = [],
        $cookies = [],
        $files = [],
        $server = [],
        $content = null
    ) {
        $this->currentUri = $uri = $this->prepareHttpUrl($uri);

        $symfonyRequest = SymfonyRequest::create(
            $uri,
            $method,
            $parameters,
            $cookies,
            $files,
            $server,
            $content
        );
        $this->app['request'] = LumenRequest::createFromBase($symfonyRequest);
        $this->app->instance(Request::class, $this->app['request']);

        $client = new Client();
        $response = $client->request($method, $uri, [
            RequestOptions::FORM_PARAMS => ((empty($parameters) && !empty($content)) ? null : $parameters),
            RequestOptions::COOKIES => $cookies,
            RequestOptions::BODY => $content,
            RequestOptions::HEADERS => $this->transformServerToHeadersVars($server),
            RequestOptions::DEBUG => isset($this->httpProxy) && $this->httpDebug,
            RequestOptions::PROXY => isset($this->httpProxy) ? $this->httpProxy : null,
            RequestOptions::TIMEOUT => isset($this->httpTimeout) ? $this->httpTimeout : null,
        ]);
        return $this->response = TestResponse::fromBaseResponse(
            $this->app->prepareResponse($response)
        );
    }

    /**
     * Transform HTTP_* array to array of headers vars with $_SERVER format.
     *
     * @param array $server
     * @return array
     */
    protected function transformServerToHeadersVars(array $server)
    {
        $prefix = 'Http-';

        $headers = [];
        foreach ($server as $name => $value) {
            $name = ucwords(str_replace(['-', '_'], ' ', strtolower($name)));
            $name = str_replace([' '], '-', $name);

            if (Str::startsWith($name, $prefix)) {
                $name = substr($name, strlen($prefix));
            }

            $headers[$name] = 'Content-Length' === $name ? 0 : $value;
        }

        return $headers;
    }

    /**
     * Turn the given URI into a fully qualified URL.
     *
     * @param string $uri
     * @return string
     */
    protected function prepareHttpUrl($uri)
    {
        if (Str::startsWith($uri, '/')) {
            $uri = substr($uri, 1);
        }

        if (!Str::startsWith($uri, 'http')) {
            $uri = $this->baseUrl . '/' . $uri;
        }

        return trim($uri, '/');
    }
}
