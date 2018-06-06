<?php

namespace App\Jobs;

use App\Contact;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateContact
{
    use Dispatchable;

    /**
     * The new contact first name.
     *
     * @var string
     */
    protected $first_name;

    /**
     * The new contact last name.
     *
     * @var string
     */
    protected $last_name;

    /**
     * The new contact email.
     *
     * @var string
     */
    protected $email;

    /**
     * The new contact phone.
     *
     * @var string
     */
    protected $phone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $first_name, string $last_name, string $email, string $phone)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     */
    public function handle(): Contact
    {
        return Contact::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
    }
}
