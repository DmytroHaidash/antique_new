<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactCreationRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $contacts = Contact::withTrashed()->ordered()->get();

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.contacts.create');
    }

    /**
     * @param  ContactCreationRequest  $request
     * @return RedirectResponse
     */
    public function store(ContactCreationRequest $request): RedirectResponse
    {
        /** @var Contact $contact */
        $contact = new Contact($request->only('contacts'));
        $contact->makeTranslation(['name', 'position'])->save();

        if ($request->hasFile('cover')) {
            $contact->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.contacts.edit', $contact)
            ->with('message', 'Контакт успешно добавлен.');
    }

    /**
     * @param  Contact  $contact
     * @return View
     */
    public function edit(Contact $contact): View
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * @param  ContactCreationRequest  $request
     * @param  Contact  $contact
     * @return RedirectResponse
     */
    public function update(ContactCreationRequest $request, Contact $contact): RedirectResponse
    {
        $contact->fill($request->only('contacts'));
        $contact->makeTranslation(['name', 'position'])->save();

        if ($request->hasFile('cover')) {
            $contact->clearMediaCollection('cover');
            $contact->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.contacts.edit', $contact)
            ->with('message', 'Контакт успешно обновлен.');
    }

    /**
     * @param  Contact  $contact
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return back()->with('message', 'Контакт успешно удален.');;
    }

    /**
     * @param  $contact
     * @return RedirectResponse
     */
    public function restore($contact): RedirectResponse
    {
        $contact = Contact::withTrashed()->find($contact);
        $contact->restore();

        return back()->with('message', 'Контакт успешно восстановлен.');;
    }

    /**
     * @param  Contact  $item
     * @return RedirectResponse
     */
    public function up(Contact $item)
    {
        $item->moveOrderUp();

        return back();
    }

    /**
     * @param  Contact  $item
     * @return RedirectResponse
     */
    public function down(Contact $item)
    {
        $item->moveOrderDown();

        return back();
    }
}
