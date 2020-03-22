<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionSavingRequest;
use App\Models\Section;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SectionsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $sections = Section::onlyParents()->withCount(['exhibits', 'publications'])->paginate(20);

        return view('admin.sections.index', compact('sections'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $sections = Section::onlyParents()->orderBy('title->ru')->get();

        return view('admin.sections.create', compact('sections'));
    }

    /**
     * @param  SectionSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(SectionSavingRequest $request): RedirectResponse
    {
        $section = new Section($request->only('parent_id', 'type'));
        $section->makeTranslation(['title', 'description', 'body'])->save();

        if ($request->hasFile('cover')) {
            $section->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }
        if($request->has('meta')){
            foreach ($request->get('meta') as $key => $meta) {
                $section->meta()->updateOrCreate([
                    'metable_id' => $section->id
                ], [
                    $key => $meta
                ]);
            }
        }

        return redirect()->route('admin.sections.edit', $section)->with('message', 'Секция успешно создана.');;
    }

    /**
     * @param  Section  $section
     * @return View
     */
    public function edit(Section $section): View
    {
        $sections = Section::onlyParents()->where('id', '!=', $section->id)->orderBy('title->ru')->get();

        return view('admin.sections.edit', compact('section', 'sections'));
    }

    /**
     * @param  SectionSavingRequest  $request
     * @param  Section  $section
     * @return RedirectResponse
     */
    public function update(SectionSavingRequest $request, Section $section): RedirectResponse
    {
        $section->fill($request->only('parent_id', 'type'));
        $section->makeTranslation(['title', 'description', 'body'])->save();

        if ($request->hasFile('cover')) {
            $section->clearMediaCollection('cover');
            $section->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }
        if($request->has('meta')){
            foreach ($request->get('meta') as $key => $meta) {
                $section->meta()->updateOrCreate([
                    'metable_id' => $section->id
                ], [
                    $key => $meta
                ]);
            }
        }
        return redirect()->route('admin.sections.edit', $section)->with('message', 'Секция успешно обновлена.');
    }

    /**
     * @param  Section  $section
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Section $section)
    {
        if ($section->exhibits()->count() || $section->publications()->count()) {
            return back()->withErrors('Нельзя удалить секцию, которая содержит записи.');
        }

        $section->delete();

        return back()->with('message', 'Секция удалена успешно.');
    }

    /**
     * @param  Section  $item
     * @return RedirectResponse
     */
    public function up(Section $item)
    {
        $item->moveOrderUp();

        return back();
    }

    /**
     * @param  Section  $item
     * @return RedirectResponse
     */
    public function down(Section $item)
    {
        $item->moveOrderDown();

        return back();
    }
}
