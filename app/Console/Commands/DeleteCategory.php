<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class DeleteCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:delete {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Category delete -name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name=$this->argument('name');
        Category::where('name',$name)->delete();
        $this->info('Successfully deleted');
    }
}
