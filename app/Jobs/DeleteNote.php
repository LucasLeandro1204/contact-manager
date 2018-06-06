<?php

namespace App\Jobs;

use App\Note;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteNote
{
    use Dispatchable;

    /**
     * The note to be deleted.
     *
     * @var Note
     */
    protected $note;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->note->delete();
    }
}
