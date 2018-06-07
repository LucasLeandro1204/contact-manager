<?php

namespace Tests\Feature;

use App\Note;
use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactNoteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_a_contact_notes(): void
    {
        $contact = factory(Contact::class)->create();
        $contact->notes()->saveMany(factory(Note::class, 5)->make());

        $response = $this->getJson(route('contact.note', 999));
        $response->assertStatus(404);

        $response = $this->getJson(route('contact.note', $contact));
        $response->assertStatus(200);

        $this->assertcount(5, $response->decodeResponseJson());
    }
}
