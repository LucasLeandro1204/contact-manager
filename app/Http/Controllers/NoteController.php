<?php

namespace App\Http\Controllers;

use App\Note;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Jobs\CreateNote as Create;
use App\Jobs\UpdateNote as Update;
use App\Jobs\DeleteNote as Delete;

class NoteController extends Controller
{
    /**
     * Store a new note.
     */
    public function store(Request $request): JsonResponse
    {
        $contact = Contact::findOrFail($request->contact_id);

        $data = array_values($request->validate([
            'description' => 'required|min:3|max:180',
        ]));

        return JsonResponse::create(Create::dispatchNow($contact, ...$data), JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a note.
     */
    public function update(Note $note, Request $request): void
    {
        $data = $request->validate([
            'description' => 'min:3|max:180',
        ]);

        Update::dispatchNow($note, $data);
    }

    /**
     * Delete a note.
     */
    public function destroy(Note $note): void
    {
        Delete::dispatchNow($note);
    }
}
