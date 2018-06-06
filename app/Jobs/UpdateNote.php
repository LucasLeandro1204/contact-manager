<?php

namespace App\Jobs;

use App\Note;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateNote
{
    use Dispatchable;

    /**
     * The note.
     *
     * @var Note
     */
    protected $note;

    /**
     * The attributes to update.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Note $note, array $attributes)
    {
        $this->note = $note;
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     */
    public function handle(): Note
    {
        $this->note->fill($this->attributes);

        return tap($this->note)->save();
    }
}
