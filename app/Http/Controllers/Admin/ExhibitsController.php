<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitSavingRequest;
use App\Models\Author;
use App\Models\Exhibit;
use App\Models\Section;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\MediaLibrary\Models\Media;

class ExhibitsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $exhibits = Exhibit::query();
        if (request()->filled('q')) {
            $q = request()->input('q');
            $exhibits->where('title', 'like', "%{$q}%")->orWhere('body', 'like', "%{$q}%")->orWhere('props' , 'like', "%{$q}%");
        }

        return view('admin.exhibits.index', ['exhibits' => $exhibits->with('sections')->paginate(20)]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $sections = Section::onlyParents()->where('type', 'exhibit')->orderBy('title->ru')->get();
        $authors = Author::orderBy('name->ru')->get();

        return view('admin.exhibits.create', compact('sections', 'authors'));
    }

    /**
     * @param  ExhibitSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(ExhibitSavingRequest $request): RedirectResponse
    {
        $exhibit = new Exhibit($request->only('author_id', 'props'));
        $exhibit->makeTranslation(['title', 'body', 'props'])->save();
        $exhibit->sections()->attach($request->input('section_id'));

        $this->handleMedia($request, $exhibit);
        if($request->has('meta')){
            foreach ($request->get('meta') as $key => $meta) {
                $exhibit->meta()->updateOrCreate([
                    'metable_id' => $exhibit->id
                ], [
                    $key => $meta
                ]);
            }
        }
        return redirect()->route('admin.exhibits.edit', $exhibit);
    }

    /**
     * @param  Exhibit  $exhibit
     * @return View
     */
    public function edit(Exhibit $exhibit): View
    {
        $sections = Section::onlyParents()->where('type', 'exhibit')->orderBy('title->ru')->get();
        $authors = Author::orderBy('name->ru')->get();

        return view('admin.exhibits.edit', compact('exhibit', 'sections', 'authors'));
    }

    /**
     * @param  ExhibitSavingRequest  $request
     * @param  Exhibit  $exhibit
     * @return RedirectResponse
     */
    public function update(ExhibitSavingRequest $request, Exhibit $exhibit): RedirectResponse
    {
        $exhibit->fill($request->only('author_id', 'props'));
        $exhibit->makeTranslation(['title', 'body', 'props'])->save();
        $exhibit->sections()->sync($request->input('section_id'));

        $this->handleMedia($request, $exhibit);
        if($request->has('meta')){
            foreach ($request->get('meta') as $key => $meta) {
                $exhibit->meta()->updateOrCreate([
                    'metable_id' => $exhibit->id
                ], [
                    $key => $meta
                ]);
            }
        }
        return redirect()->route('admin.exhibits.edit', $exhibit);
    }

    /**
     * @param  Exhibit  $exhibit
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Exhibit $exhibit): RedirectResponse
    {
        $exhibit->delete();

        return back();
    }

    /**
     * @param  Exhibit  $item
     * @return RedirectResponse
     */
    public function up(Exhibit $item)
    {
        $item->moveOrderUp();

        return back();
    }

    /**
     * @param  Exhibit  $item
     * @return RedirectResponse
     */
    public function down(Exhibit $item)
    {
        $item->moveOrderDown();

        return back();
    }

    /**
     * @param  ExhibitSavingRequest  $request
     * @param  Exhibit  $exhibit
     */
    private function handleMedia(ExhibitSavingRequest $request, Exhibit $exhibit): void
    {
        if ($request->filled('uploads')) {
            foreach ($request->input('uploads') as $media) {
                Media::find($media)->update([
                    'model_type' => Exhibit::class,
                    'model_id' => $exhibit->id
                ]);
            }

            Media::setNewOrder($request->input('uploads'));
        }

        if ($request->filled('deletion')) {
            Media::whereIn('id', $request->input('deletion'))->delete();
        }
    }
}
