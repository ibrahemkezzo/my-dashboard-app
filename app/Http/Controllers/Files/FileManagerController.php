<?php

namespace App\Http\Controllers\Files;


use App\Http\Requests\DeleteMediaRequest;
use App\Models\Media;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super-admin', 'permission:manage-files']);
    }

    /**
     * Display the file manager.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $media = Media::with('mediable')->orderBy('created_at', 'desc')->paginate(20);
        $directories = collect(Storage::disk('public')->directories())->map(function ($dir) {
            return ['path' => $dir, 'files' => Storage::disk('public')->files($dir)];
        });

        return view('file-manager.index', compact('media', 'directories'));
    }

    /**
     * Delete a media file.
     *
     * @param \App\Http\Requests\DeleteMediaRequest $request
     * @param int $mediaId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeleteMediaRequest $request, int $mediaId)
    {
        Media::deleteSingle($mediaId);

        return redirect()->route('file-manager.index')->with('success', __('File deleted successfully.'));
    }
}