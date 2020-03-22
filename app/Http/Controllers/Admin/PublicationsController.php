<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitSavingRequest;
use App\Models\Author;
use App\Models\Publication;
use App\Models\Section;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\MediaLibrary\Models\Media;

class PublicationsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $publications = Publication::with('sections')->paginate(20);

        return view('admin.publications.index', compact('publications'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $sections = Section::onlyParents()->where('type', 'publication')->orderBy('title->ru')->get();
        $authors = Author::orderBy('name->ru')->get();

        return view('admin.publications.create', compact('sections', 'authors'));
    }

    /**
     * @param  ExhibitSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(ExhibitSavingRequest $request): RedirectResponse
    {
        $publication = new Publication($request->only('author_id', 'props'));
        $publication->makeTranslation(['title', 'body', 'props']);
        $publication->sections()->attach($request->input('section_id'));

        $this->handleMedia($request, $publication);

        return redirect()->route('admin.publications.edit', $publication);
    }

    /**
     * @param  Publication  $publication
     * @return View
     */
    public function edit(Publication $publication): View
    {
        $sections = Section::onlyParents()->where('type', 'publication')->orderBy('title->ru')->get();
        $authors = Author::orderBy('name->ru')->get();

        return view('admin.publications.edit', compact('publication', 'sections', 'authors'));
    }

    /**
     * @param  ExhibitSavingRequest  $request
     * @param  Publication  $publication
     * @return RedirectResponse
     */
    public function update(ExhibitSavingRequest $request, Publication $publication): RedirectResponse
    {
        $publication->fill($request->only('author_id', 'props'));
        $publication->makeTranslation(['title', 'body', 'props'])->save();
        $publication->sections()->sync($request->input('section_id'));

        $this->handleMedia($request, $publication);

        return redirect()->route('admin.publications.edit', $publication);
    }

    /**
     * @param  Publication  $publication
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Publication $publication): RedirectResponse
    {
        $publication->delete();

        return back();
    }

    /**
     * @param  ExhibitSavingRequest  $request
     * @param  Publication  $publication
     */
    private function handleMedia(ExhibitSavingRequest $request, Publication $publication): void
    {
        if ($request->filled('uploads')) {
            foreach ($request->input('uploads') as $media) {
                Media::find($media)->update([
                    'model_type' => Publication::class,
                    'model_id' => $publication->id
                ]);
            }

            Media::setNewOrder($request->input('uploads'));
        }

        if ($request->filled('deletion')) {
            Media::whereIn('id', $request->input('deletion'))->delete();
        }
    }
}
