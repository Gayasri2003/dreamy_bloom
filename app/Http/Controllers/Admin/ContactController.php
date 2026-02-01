<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Livewire will load/paginate/filter the table.
        // Controller only sends summary stats for the dashboard cards.
        return view('admin.contacts.index', [
            'totalCount' => Contact::count(),
            'newCount' => Contact::where('status', Contact::STATUS_NEW)->count(),
            'inProgressCount' => Contact::where('status', Contact::STATUS_IN_PROGRESS)->count(),
            'resolvedCount' => Contact::where('status', Contact::STATUS_RESOLVED)->count(),
        ]);
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    // Optional: keep this if your SHOW page has a form to update status/admin_notes
    public function updateStatus(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:' . Contact::STATUS_NEW . ',' . Contact::STATUS_IN_PROGRESS . ',' . Contact::STATUS_RESOLVED,
            'admin_notes' => 'nullable|string'
        ]);

        $contact->update($validated);

        return redirect()->back()->with('success', 'Contact status updated successfully!');
    }

    // Optional: keep this for non-Livewire delete (e.g., on show page)
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted successfully!');
    }
}
