<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Illuminate\Http\UploadedFile;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $media = Media::where('is_projector', 0)->get();
        return view('media.index', compact('media'));
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
        return view('media.create', compact('rooms'));
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
        if (!$request->lang) {
            return back()->with('error', 'Select Language');
        }

        if ($request->file_names) {
            foreach ($request->file_names as $index => $fileName) {
                // $media = Media::whereName($fileName)->first();
                $media = Media::create([
                    'lang' => $request->lang,
                    'name' => $fileName,
                    'room_id' => $request->room_id,
                    'phase_id' => $request->phase_id ?? null,
                    'zone_id' => $request->zone_id ?? null,
                    'scene_id' => $request->scene_id ?? null,
                    'is_projector' => 0,
                    'duration' => $request->durations[$index],
                    'is_image' => $request->is_images[$index]
                ]);
            }
            return redirect()->route('media.index');
        } else {
            return back()->with('error', 'Upload Media File');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id='0')
    {
       $item = Media::where('id', $id)->first();  //where('is_projector', 0)
       return view('media.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // return $id;
        try {
            $media = Media::find($id);
            $mediaPath = $media->getMediaPath();
            Storage::delete(['/' . $mediaPath . '/' . $media->name]);
            $deleted = $media->delete();
            if ($deleted) {
                return back()->with('deleted', 'Media Deleted');
            } else {
                return back()->with('warning', 'Media could not be deleted');
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
        $type = explode('-', $mime)[0];
        // Group files by the date (week
        $dateFolder = date("Y-m-W");

        // Build the file path 
        $media = new Media();
        $filePath = $media->getMediaPath();
        // $filePath = "upload/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/" . $filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        // Media::create([
        //     'name' => $fileName
        // ]);
        $duration_seconds = 0;
        $is_image = 0;
        Log::info($finalPath . $fileName);
        if($type != 'image') {
            $getID3 = new \getID3;
           $video_file = $getID3->analyze($finalPath.$fileName);
            $duration_seconds = $video_file['playtime_seconds'];
            Log::info($duration_seconds);
        }
        if($type == 'image') {
            $is_image = 1;
        }
        $response = [
            'path' => $filePath,
            'name' => $fileName,
            'duration' => $duration_seconds,
            'is_image' => $is_image,
            'mime_type' => $mime
        ];

        return response()->json($response);
    }

    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        // $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension
        $filename = 'media';

        // Add timestamp hash to name of the file
       // $filename .= "_" . md5(time()) . "." . $extension;
       $filename .= "_" . date('YmdHis') . "." . $extension;
       
        return $filename;
    }
}
