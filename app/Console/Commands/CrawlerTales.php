<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerTales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:nettruyen {--category_site=} {--category_local=} {--page=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $category_link = $this->option('category_site');
        $category_id = (int)$this->option('category_local');
        if(empty($category_link) || empty($category_id)) throw new \Exception('Khong co du lieu!');
        $data = Http::get($category_link);
        $html = $data->body();
        $crawler = new Crawler($html);
        // $link_page = [];
        $link_page = $crawler->filter('.pagination li')->each(function(Crawler $node, $i){
            print_r($node);
            return $node->link();
        });
        print_r($crawler);
        return 0;
    }
}
