<?php

namespace App\Jobs;

use App\Repositories\CounterRepository;

class CounterIncJob extends Job
{
    protected $country;
    protected $event;
    protected $step;

    public function __construct($country, $event, $step = 1)
    {
        $this->country = $country;
        $this->event = $event;
        $this->step = $step;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new CounterRepository)
            ->inc($this->country, $this->event, $this->step);
    }
}
