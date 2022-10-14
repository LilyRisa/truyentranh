<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Story;
use App\Models\Chapter;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

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
        
        $data = Story::all();

        foreach($data as $d){
            try{
                $one = Chapter::where('story_id', $d->id)->get();
                foreach($one as $k){
                    $k->slug = $d->slug;
                    $k->save();
                    $this->info('Update success: '.$k->title);
                }
                
            }catch(\Exception $e){
                $this->error('Lỗi!');
            }
            

        }
        return 0;
    }
}
