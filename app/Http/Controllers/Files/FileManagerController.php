<?php

namespace App\Http\Controllers\Files;

use App\Facades\Media as FacadesMedia;
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

        return view('dashboard.file-manager.media', compact('media', 'directories'));
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
        FacadesMedia::deleteSingle($mediaId);

        return redirect()->route('dashboard.file-manager.media')->with('message', [
            'type' => 'error',
            'content' =>  __('File deleted successfully.')]);
    }

    public function showFolder($folder)
    {
        $folder = str_replace(['..', '/'], '', $folder); // basic sanitization
        $files = collect(\Storage::disk('public')->files($folder));
        $directories = collect(\Storage::disk('public')->directories($folder));
        return view('dashboard.file-manager.folder', compact('folder', 'files', 'directories'));
    }
}