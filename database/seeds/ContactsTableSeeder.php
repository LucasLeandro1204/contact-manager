<?php

use App\Note;
use App\Contact;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Contact::class, 15)->create()
            ->each(function (Contact $contact) {
                $contact->notes()->saveMany(factory(Note::class, rand(0, 3))->make());
            });
    }
}
