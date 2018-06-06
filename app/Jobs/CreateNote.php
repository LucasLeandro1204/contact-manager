<?php

namespace App\Jobs;

use App\Note;
use App\Contact;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateNote
{
    use Dispatchable;

    /**
     * Contact related to the new note.
     *
     * @var Contact
     */
    protected $contact;

    /**
     * The new note description.
     *
     * @var string
     */
    protected $description;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, string $description)
    {
        $this->contact = $contact;
        $this->description = $description;
    }

    /**
     * Execute the job.
     */
    public function handle(): Note
    {
        return $this->contact->notes()->create([
            'description' => $this->description,
        ]);
    }
}
