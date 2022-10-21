<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Story;

class service extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:story {--method=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is command use run task afflatus table story';

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
        $method = $this->option('method');
        if($method == 'keyword'){
            $data = Story::whereNull('main_keyword')->get();
            foreach($data as $item){
                $find = Story::find($item->id);
                $find->main_keyword = $find->title;
                $find->meta_keyword = $find->title;
                $find->save();
                $this->info($find->slug.' created successfully!');
            }
            return 0;
        }
        if($method == 'view'){
            $data = Story::where('view_count', 0)->get();
            foreach($data as $item){
                $find = Story::find($item->id);
                $find->view_count = random_int(1234, 10234);
                $find->save();
                $this->info($find->slug.' gen view count '.$find->view_count.' successfully!');
            }
        }
        if($method == 'chapter'){
            $data = Story::where('view_count', 0)->get();
            foreach($data as $item){
                $find = Story::find($item->id);
                $find->view_count = random_int(1234, 10234);
                $find->save();
                $this->info($find->slug.' gen view count '.$find->view_count.' successfully!');
            }
        }
        return 0;
    }
}
