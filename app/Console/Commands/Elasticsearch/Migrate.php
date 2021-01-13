<?php

namespace App\Console\Commands\Elasticsearch;

use Illuminate\Console\Command;

class Migrate extends Command
{
    use Operate;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate index of elasticsearch';

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
        $this->es = app('es');

        foreach ($this->getAllIndices() as $index) {
            $this->handleIndex($index::getAliasName(), $index);
        }
    }

    public function handleIndex($alias_name, $index){
        if (!$this->es->indices()->exists(['index' => $alias_name])) {

            $this->createIndex($alias_name, $index);

            $index::rebuild($alias_name);
        }
        else{
            // if the index exists, try to update it
            try{
                $this->updateIndex($alias_name, $index);
            }catch (\Exception $e){
                $this->recreateIndex($alias_name, $index);
            }
        }
    }
}
