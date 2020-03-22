<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Upload;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\Models\Media;
use Str;

class UploadsController extends Controller
{
    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $uploaded = null;

        if ($request->hasFile('image')) {
            if ($request->filled(['model', 'model_id'])) {
                $media = $request->input('model')::find($request->input('model_id'));
            } else {
                $media = Upload::create();
            }

            $uploaded = $media->addMediaFromRequest('image')
                ->usingFileName(makeFileName($request->file('image')))
                ->toMediaCollection('uploads');
        }

        return response()->json($uploaded ? new MediaResource($uploaded) : null);
    }

    /**
     * @param  Media  $media
     * @return ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(Media $media)
    {
        $media->delete();

        return response(null, 204);
    }
}
