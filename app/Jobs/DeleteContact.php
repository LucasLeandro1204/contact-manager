<?php

namespace App\Jobs;

use App\Contact;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteContact
{
    use Dispatchable;

    /**
     * The contact to be deleted.
     *
     * @var Contact
     */
    protected $contact;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->contact->delete();
    }
}
