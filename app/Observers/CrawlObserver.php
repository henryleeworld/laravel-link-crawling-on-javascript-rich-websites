<?php

namespace App\Observers;

use App\Models\Crawler;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver as BaseCrawlObserver;
use Spatie\Crawler\CrawlProgress;
use Spatie\Crawler\CrawlResponse;
use Spatie\Crawler\Enums\FinishReason;
use Spatie\Crawler\Enums\ResourceType;
use Spatie\Crawler\TransferStatistics;

class CrawlObserver extends BaseCrawlObserver
{
    protected string $name;

    public function __construct(protected array $configAry = [])
    {
        $this->name = $configAry['name'];
        $this->domain = $configAry['domain'];
    }

    /*
    public function willCrawl(string $url, ?string $linkText, ?ResourceType $resourceType = null): void
    {
    }
    */

    /*
     * Called when the crawler has crawled the given url successfully.
     */
    public function crawled(
        string $url,
        CrawlResponse $response,
        CrawlProgress $progress,
    ): void {
        if (!Str::endsWith(parse_url($url)['host'], $this->domain)) return;
        $crawl = Crawler::updateOrCreate([
            'name' => $this->name, 'url' => $url
        ], [
            'status' => $response->status()
        ]);
    }

    /*
     * Called when the crawler had a problem crawling the given url.
     */
    public function crawlFailed(
        string $url,
        RequestException $requestException,
        CrawlProgress $progress,
        ?string $foundOnUrl = null,
        ?string $linkText = null,
        ?ResourceType $resourceType = null,
        ?TransferStatistics $transferStats = null,
    ): void {
        Log::error(__('Crawl URL :url failed with the reason with the reason :exception_message.', ['url' => $url, 'exception_message' => $requestException->getMessage()]));
    }

    /*
    public function finishedCrawling(FinishReason $reason, CrawlProgress $progress): void
    {
    }
    */
}
