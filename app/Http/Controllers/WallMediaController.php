<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\WallMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class WallMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $media = WallMedia::all();
        return view('wallmedia.index', compact('media'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $rooms = Room::get(['name', 'id']);
        return view('wallmedia.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return $request;
        if ($request->file_names) {
            foreach ($request->file_names as $index => $fileName) {
                // $media = Media::whereName($fileName)->first();
                $media = WallMedia::create([
                    'name' => $fileName,
                    'room_id' => $request->room_id,
                    'title_en' => $request->title_en,
                    'title_ar' => $request->title_ar,
                ]);
            }
            return redirect()->route('wallmedia.index');
        } else {
            return back()->with('error', 'Upload Media File');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WallMedia  $wallMedia
     * @return \Illuminate\Http\Response
     */
    public function show(WallMedia $wallMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WallMedia  $wallMedia
     * @return \Illuminate\Http\Response
     */
    public function edit(WallMedia $wallMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WallMedia  $wallMedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WallMedia $wallMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WallMedia  $wallMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $wallMedia = WallMedia::find($id);
            $mediaPath = $wallMedia->getMediaPath();
            Storage::delete(['/' . $mediaPath . '/' . $wallMedia->name]);
            $deleted = $wallMedia->delete();
            if ($deleted) {
                return back()->with('deleted', 'Wall Media Deleted');
            } else {
                return back()->with('warning', 'Wall Media could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function upload_media_dropzone(Request $request)
    {
        // create the file receiver
        $receiver = new FileReceiver("media", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());

        // Build the file path 
        $media = new WallMedia();
        $filePath = $media->getMediaPath();
        // $filePath = "upload/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/" . $filePath);

        // move the file name
        $file->move($finalPath, $fileName);
        Log::info($finalPath . $fileName);

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
}
