<?php

namespace App\Observers;

use App\Models\Crawler;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver as BaseCrawlObserver;

class CrawlObserver extends BaseCrawlObserver
{
    protected string $name;

    public function __construct(protected array $configAry = [])
    {
        $this->name = $configAry['name'];
        $this->domain = $configAry['domain'];
    }

    /*
     * Called when the crawler has crawled the given url successfully.
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        if (!Str::endsWith(parse_url($url)['host'], $this->domain)) return;
        $crawl = Crawler::updateOrCreate([
            'name' => $this->name, 'url' => $url
        ], [
            'status' => $response->getStatusCode()
        ]);
    }

    /*
     * Called when the crawler had a problem crawling the given url.
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        Log::error(__('Crawl URL :url failed with the reason with the reason :exception_message.', ['url' => $url, 'exception_message' => $requestException->getMessage()]));
    }
}
