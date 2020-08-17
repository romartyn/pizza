<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Parse2B extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:2b';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the dummy data from https://2-berega.ru/pizza';

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
        ini_set('pcre.backtrack_limit', '104857600');
        $html = file_get_contents('storage/app/public/2b.html');
        preg_match_all("#<script.*REDUX_STATE=(.*)</script>#Uis", $html, $matches);
        $REDUX_STATE = json_decode($matches[1][0]);
        foreach ($REDUX_STATE->products as $key => $product) {
            if(preg_match("#пицца#Uis",mb_strtolower($product->title))){
                print_r($product);

                $this->line($product->title);
                break;
            }
        }

        return 0;
    }
}
