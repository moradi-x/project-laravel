<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;
use function Termwind\ask;

class GetNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:news {site}';


    protected $description = ' get top news from tasnim website ';


    public function handle()
    {

        //  اگر بخوایم سوالیش کنیم کامنئ مون رو 

        // $resp = $this->ask("are your shure take news Y|N") ;

        // if (Str::lower($resp) == 'y' ) {
        //   $site = $this->input->getArgument('site');
        // if ($site == 'tasnim') {
        //     $this->tasnim();
        // } else {
        //     $this->mehr();
        // }
        // }else{
        //     $this->error("good for your");
        // }

        $site = $this->input->getArgument('site');
        if ($site == 'tasnim') {
            $this->tasnim();
        } else {
            $this->mehr();
        }
    }

    public function tasnim()
    {
        $response = Http::get('https://www.tasnimnews.ir/fa/rss/feed/0/0/8/1/TopStories');
        if ($response->getStatusCode() == 200) {
            $name = now()->format('y-m-d-h-i');
            Storage::disk('public')->put('files/tasnimNews_' . $name . '.xml', $response->getBody()->getContents());
            $this->alert("tasnim news was taked");
        } else {
            $this->error('can not take news');
        }
    }

    public function mehr()
    {
        $response = Http::get('https://www.mehrnews.com/rss');
        if ($response->getStatusCode() == 200) {
            $name = now()->format('y-m-d-h-i');
            Storage::disk('public')->put('files/mehrNews_' . $name . '.xml', $response->getBody()->getContents());
            $this->alert(" mehr news was taked");
        } else {
            $this->error('can not take news');
        }
    }
}
