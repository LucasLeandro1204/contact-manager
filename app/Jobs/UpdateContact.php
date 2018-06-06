<?php

namespace App\Jobs;

use App\Contact;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateContact
{
    use Dispatchable;

    /**
     * The contact.
     *
     * @var Contact
     */
    protected $contact;

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
    public function __construct(Contact $contact, array $attributes)
    {
        $this->contact = $contact;
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     */
    public function handle(): Contact
    {
        $this->contact->fill($this->attributes);

        return tap($this->contact)->save();
    }
}
