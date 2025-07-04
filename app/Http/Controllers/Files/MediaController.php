<?php

namespace App\Http\Controllers\Files;

use App\Facades\Media;
use App\Http\Requests\DeleteMediaRequest;
use App\Http\Requests\StoreMultipleMediaRequest;
use App\Http\Requests\StoreSingleMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use Illuminate\Routing\Controller;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a single media file.
     *
     * @param \App\Http\Requests\StoreSingleMediaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSingle(StoreSingleMediaRequest $request)
    {
        $model = $this->resolveModel($request->model_type, $request->model_id);
        Media::storeSingle(
            $request->file('file'),
            $model,
            $request->type,
            $request->path ?? 'media'
        );

        return redirect()->back()->with('message', [
                    'type' => 'success',
                    'content' => 'Operation completed successfully!']);
    }

    /**
     * Store multiple media files.
     *
     * @param \App\Http\Requests\StoreMultipleMediaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMultiple(StoreMultipleMediaRequest $request)
    {
        $model = $this->resolveModel($request->model_type, $request->model_id);
        Media::storeMultiple(
            $request->file('files'),
            $model,
            $request->type,
            $request->path ?? 'media'
        );

        return redirect()->back()->with('message', [
                    'type' => 'success',
                    'content' => 'Operation completed successfully!']);
    }

    /**
     * Update a specific media file.
     *
     * @param \App\Http\Requests\UpdateMediaRequest $request
     * @param int $mediaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMediaRequest $request, int $mediaId)
    {
        Media::updateMedia(
            $request->file('file'),
            $mediaId,
            $request->path ?? 'media'
        );

        return redirect()->back()->with('message', [
                    'type' => 'success',
                    'content' => 'Operation completed successfully!']);
    }

    /**
     * Delete a specific media file.
     *
     * @param \App\Http\Requests\DeleteMediaRequest $request
     * @param int $mediaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteMediaRequest $request, int $mediaId)
    {
        Media::deleteSingle($mediaId);

        return redirect()->back()->with('message', [
                    'type' => 'success',
                    'content' => 'Operation completed successfully!']
                );
    }

    /**
     * Resolve the model instance from type and ID.
     *
     * @param string $modelType
     * @param int $modelId
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    protected function resolveModel(string $modelType, int $modelId)
    {
        return $modelType::findOrFail($modelId);
    }
}