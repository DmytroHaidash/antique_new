<?php

namespace App\Http\Controllers\Client;

use App\Models\Exhibit;
use App\Models\Post;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionsController extends Controller
{
    /**
     * @param  Section  $section
     * @param  Section|null  $child_section
     * @return View
     */
    public function index(Section $section, Section $child_section = null): View
    {
        if ($child_section) {
            $section = $child_section;
        }

        $exhibits = $section->exhibits()->paginate(12);

        return view('client.collection.section', compact('exhibits', 'section'));
    }

    /**
     * @param  Exhibit  $exhibit
     * @return View
     */
    public function show(Exhibit $exhibit): View
    {
        $props = array_merge(array_flip(array_keys(trans('exhibits.props'))), $exhibit->props);

        return view('client.collection.show', compact('exhibit', 'props'));
    }
}
