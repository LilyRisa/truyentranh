<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class Votebuff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:buff {--link=} {--min=} {--max=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'buff vote';

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
        $link = $this->option('link');
        $max = $this->option('max');
        $min = $this->option('min');
        if(!empty($max)){
            $max = (int) $max;
        }else{
            $max = 100;
        }

        if(!empty($min)){
            $min = (int) $min;
        }else{
            $min = 30;
        }


        if(!empty($link)){
            for($i=0;$i< random_int($min,$max);$i++){
                DB::insert('insert into rate (slug, vote, ip) values (?,?,?)',[$link, random_int(4,5), '127.0.0.1']);
            }
            $this->info("'$link' created vote successfully.");
            return 0;
                
        }

        $post = Post::all();
        foreach($post as $pt){
            $check = DB::table('rate')->where('slug', $pt->slug)->get();
            if(empty($check) || count($check) <= 30){
                for($i=0;$i< random_int($min,$max);$i++){
                    DB::insert('insert into rate (slug, vote, ip) values (?,?,?)',[$pt->slug, random_int(4,5), '127.0.0.1']);
                }
                $this->info("'$pt->slug' created vote successfully.");
            }else{
                $this->warn("'$pt->slug' not empty");
            }
        }
        return 0;

    }
}
