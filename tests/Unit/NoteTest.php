<?php

namespace Tests\Unit;

use App\Note;
use App\Contact;
use Tests\TestCase;
use App\Jobs\CreateNote as Create;
use App\Jobs\UpdateNote as Update;
use App\Jobs\DeleteNote as Delete;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function we_can_create_a_note(): void
    {
        $this->assertNull(Note::first());

        $response = Create::dispatchNow($contact = factory(Contact::class)->create(), 'Foo');

        $this->assertInstanceOf(Note::class, $response);

        $this->assertNotNull($note = Note::first());

        $this->assertEquals('Foo', $note->description);
        $this->assertEquals($contact->id, $note->contact_id);
    }

    /**
     * @test
     */
    public function we_can_update_a_note(): void
    {
        $old = factory(Note::class)->create();

        $this->assertNotEquals('Foo', $old->description);

        $note = Update::dispatchNow($old, [
            'description' => 'Foo',
        ]);

        $this->assertEquals('Foo', $note->description);
    }

    /**
     * @test
     */
    public function we_can_delete_a_note(): void
    {
        $note = factory(Note::class)->create();

        Delete::dispatchNow($note);

        $this->assertNull($note->fresh());
    }
}
