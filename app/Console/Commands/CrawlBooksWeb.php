<?php

namespace App\Console\Commands;

use App\Observers\CrawlObserver;
use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\JavaScriptRenderers\BrowsershotRenderer;

class CrawlBooksWeb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Books Web';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $browsershot = (new Browsershot())
            ->setNodeModulePath(base_path('node_modules'));
        Crawler::create('https://www.books.com.tw')
            ->executeJavaScript(new BrowsershotRenderer($browsershot))
            ->ignoreRobots()
            ->retry(2, 500)
            ->withoutVerifying()
            ->addObserver(new CrawlObserver(['name' => 'books', 'domain' => 'books.com.tw']))
            ->start();
        return Command::SUCCESS;
    }
}
