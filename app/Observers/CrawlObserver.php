<?php

namespace App\Observers;

use App\Models\Crawler;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver as BaseCrawlObserver;

class CrawlObserver extends BaseCrawlObserver
{
    protected string $name;

    public function __construct(protected array $configAry = [])
    {
        $this->name = $configAry['name'];
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    ): void {
        // Create records
        $crawl = Crawler::updateOrCreate([
            // 'host' => parse_url($url, PHP_URL_HOST), 'url' => $url
            'name' => $this->name, 'url' => $url
        ], [
            'status' => $response->getStatusCode()
        ]);
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ): void {
        Log::error('crawlFailed: ' . $url);
    }
}
