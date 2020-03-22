<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Resources\MediaResource;
use App\Models\Upload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $media = Media::where('collection_name', 'uploads')->latest()->get();

        return response()->json(ImageResource::collection($media));
    }

    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $media = null;

        if ($request->hasFile('image')) {
            $media = (Upload::create())->addMediaFromRequest('image')
                ->usingFileName(makeFileName($request->file('image')))
                ->toMediaCollection('uploads');
        }

        return response()->json($media ? new ImageResource($media) : null);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function wysiwyg(Request $request)
    {
        $media = null;
        if ($request->hasFile('img')) {
            /** @var Upload $media */
            $media = Upload::create();
            $media->addMediaFromRequest('img')
                ->usingFileName(makeFileName($request->file('img')))
                ->toMediaCollection('uploads');
        }
        return response()->json(['image' => $media ? new MediaResource($media->getFirstMedia('uploads')) : null,]);
    }
}
