<?php

namespace App\Console\Commands;

use App\Observers\CrawlObserver;
use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Crawler::create()->setBrowsershot(new Browsershot)
                         ->executeJavaScript()
                         ->ignoreRobots()
                         ->setCrawlObserver(new CrawlObserver(['name' => 'books']))
                         ->startCrawling('https://www.books.com.tw');
        return Command::SUCCESS;
    }
}
