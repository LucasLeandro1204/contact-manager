<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Support\Collection;

class ContactNoteController extends Controller
{
    /**
     * Return all contact notes.
     */
    public function index(Contact $contact): Collection
    {
        return $contact->notes;
    }
}
