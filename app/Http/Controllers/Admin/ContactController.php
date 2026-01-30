<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    public function updateStatus(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,resolved',
            'admin_notes' => 'nullable|string'
        ]);

        $contact->update($validated);

        return redirect()->back()->with('success', 'Contact status updated successfully!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted successfully!');
    }
}
