<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class AddTestCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:add {name} {lang}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Category -name -lang';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name=$this->argument('name');
        $lang=$this->argument('lang');
        Category::create([
            'name'=>$name,
            'lang'=>$lang
        ]);
        $this->info('Successeffuly added Category!');
    }
}
