<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Phase;
use App\Models\Room;
use App\Models\Scene;
use App\Models\Zone;
use Exception;
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
        $media = Media::all();
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
        $scenes = Scene::get(['name', 'id']);
        $phases = Phase::get(['name', 'id']);
        $zones = Zone::get(['name', 'id']);
        return view('media.create', compact('rooms', 'scenes', 'phases', 'zones'));
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
        foreach($request->file_names as $fileName) {
            $media = Media::whereName($fileName)->first();
            $updated = $media->update([
                'room_id' => $request->room_id ?? null,
                'phase_id' => $request->phase_id ?? null,
                'zone_id' => $request->zone_id ?? null,
                'scene_id' => $request->scene_id ?? null,
            ]);
        }
        return redirect()->route('media.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            if($deleted) {
                return back()->with('deleted', 'Media Deleted');
            } else {
                return back()->with('warning', 'Media could not be deleted');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function upload_media_dropzone(Request $request) {
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
        // Group files by the date (week
        $dateFolder = date("Y-m-W");

        // Build the file path 
        $media = new Media();
        $filePath = $media->getMediaPath();
        // $filePath = "upload/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/".$filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        Media::create([
            'name' => $fileName
        ]);

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }

    public function upload_media()
    {
        return 'meow';
        // $targetDir = $items_config['images_path'];
        // $images_url = $items_config['images_url'];
        $media = new Media();
        $targetDir = $media->getMediaPath();

        $outData = $this->upload($targetDir, $media); // a function to upload the bootstrap-fileinput files
        echo json_encode($outData); // return json data
    }

    public function upload($targetDir, $media)
    {
        $preview = $config = $errors = [];
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }
        // return $_POST;
        $fileBlob = 'fileBlob';                      // the parameter name that stores the file blob
        if (isset($_FILES[$fileBlob])) {
            $file = $_FILES[$fileBlob]['tmp_name'];  // the path for the uploaded file chunk 
            $fileName = $_POST['fileName'];          // you receive the file name as a separate post data
            // $image = basename($_FILES['file']['name']);
            // $fileName = str_replace(' ','|',$fileName);
            $fileSize = $_POST['fileSize'];          // you receive the file size as a separate post data
            $fileId = $_POST['fileId'];              // you receive the file identifier as a separate post data
            $index =  $_POST['chunkIndex'];          // the current file chunk index
            $totalChunks = $_POST['chunkCount'];     // the total number of chunks for this file
            $targetFile = $targetDir . $fileName;  // your target file path
            $combined = true;
            if ($totalChunks > 1) {                  // create chunk files only if chunks are greater than 1
                $targetFile .= '_' . str_pad($index, 4, '0', STR_PAD_LEFT);
                $combined = false;
            }


            // $thumbnail = 'unknown.jpg';
            if (move_uploaded_file($file, Storage::path($targetFile))) {
                // get list of all chunks uploaded so far to server
                $chunks = glob(Storage::path($targetFile)."_*");
                // check uploaded chunks so far (do not combine files if only one chunk received)
                Log::info(count($chunks));
                $allChunksUploaded = $totalChunks > 1 && count($chunks) == $totalChunks;
                // Log::info(json_encode($allChunksUploaded));
                if ($allChunksUploaded) {           // all chunks were uploaded
                    $outFile = $targetDir . '/' . $fileName;
                    // combines all file chunks to one file
                    $combined = $this->combineChunks($chunks, $outFile);
                }
                $targetUrl =  asset($targetFile);
                $ext = pathinfo($targetUrl, PATHINFO_EXTENSION);
                if ($ext == 'avi' || $ext == 'mp4' || $ext == 'wmv' || $ext == 'mkv' || $ext == 'webm' || $ext == 'mp4' || $ext == 'flv' || $ext == 'mp4' || $ext == 'amv' || $ext == 'm4p' || $ext == 'm4v' || $ext == 'mpg' || $ext == 'mpeg') {
                    $type = 'video';
                } else {
                    $type = 'image';
                }
                if ($combined) {
                    $data = [
                        'name' => $fileName,
                        'file_key' => $fileId,
                        'size' => $fileSize,
                        'file_type' => $type . '/' . $ext,
                    ];
                    $media = Media::create($data);
                }
                // if you wish to generate a thumbnail image for the file
                // $targetUrl = getThumbnailUrl($path, $fileName);

                // separate link for the full blown image file
                // $zoomUrl = 'http://localhost/uploads/' . $fileName;
                // if()
                return [
                    'chunkIndex' => $index,         // the chunk index processed
                    'initialPreview' => $targetUrl, // the thumbnail preview data (e.g. image)
                    'initialPreviewConfig' => [
                        [
                            'type' => $type,      // check previewTypes (set it to 'other' if you want no content preview)
                            'caption' => $fileName, // caption
                            'key' => $fileId,       // keys for deleting/reorganizing preview
                            'fileId' => $fileId,    // file identifier
                            'size' => $fileSize,    // file size
                            // 'zoomData' => $zoomUrl, // separate larger zoom data
                        ]
                    ],
                    'append' => true,
                ];
            } else {
                return [
                    'error' => 'Error uploading chunk ' . $_POST['chunkIndex']
                ];
            }
        }
        return [
            'error' => 'No file found'
        ];
    }


    public function combineChunks($chunks, $targetFile)
    {
        // open target file handle
        try {
            $handle = fopen(Storage::path($targetFile), 'a+');

            Log::info(json_encode($handle));
            
            foreach ($chunks as $file) {
                Log::info(json_encode($file));
                fwrite($handle, file_get_contents($file));
            }
    
            // you may need to do some checks to see if file 
            // is matching the original (e.g. by comparing file size)
    
            // after all are done delete the chunks
            foreach ($chunks as $file) {
                @unlink($file);
            }
    
            // close the file handle
            fclose($handle);
            return true;
        } catch (Exception $e) {
            Log::info($e->getMessage);
            return false;
        }
    }


    // public function upload_media(Request $request)
    // {
    //     // return $request;
    //     // $images_url = $items_config['images_url'];
    //     $media = new Media();
    //     $targetDir = $media->getMediaPath();

    //     $outData = $this->upload($request, $targetDir); // a function to upload the bootstrap-fileinput files
    //     echo json_encode($outData); // return json data
    // }

    // public function upload($request, $targetDir)
    // {
    //     $preview = $config = $errors = [];
    //     if (!file_exists(Storage::path($targetDir))) {
    //         mkdir(Storage::path($targetDir), 755, true);
    //     }
    //     // return $request;
    //     // return $_FILES;
    //     $fileBlob = 'fileBlob';                      // the parameter name that stores the file blob
    //     if ($file = $request->file($fileBlob)) {
    //         // $file = $_FILES[$fileBlob]['tmp_name'];  // the path for the uploaded file chunk 
    //         $file_name = $file->getClientOriginalName();  // the path for the uploaded file chunk 
    //         $fileName = $request->fileName;          // you receive the file name as a separate post data
    //         $fileSize = $request->fileSize;          // you receive the file size as a separate post data
    //         $fileId = $request->fileId;              // you receive the file identifier as a separate post data
    //         $index =  $request->chunkIndex;          // the current file chunk index
    //         $totalChunks = $request->chunkCount;     // the total number of chunks for this file
    //         $targetFile = $targetDir . '/' . $fileName;  // your target file path
    //         $combined = true;
    //         if ($totalChunks > 1) {                  // create chunk files only if chunks are greater than 1
    //             $targetFile .= '_' . str_pad($index, 4, '0', STR_PAD_LEFT);
    //             $combined = false;
    //         }


    //         // $thumbnail = 'unknown.jpg';
    //         // if (move_uploaded_file($file, $targetFile)) {
    //         if ($file->storeAs($targetDir, $file_name)) {
    //             // get list of all chunks uploaded so far to server
    //             $chunks = glob("{$targetDir}/{$fileName}_*");
    //             // check uploaded chunks so far (do not combine files if only one chunk received)
    //             $allChunksUploaded = $totalChunks > 1 && count($chunks) == $totalChunks;
    //             if ($allChunksUploaded) {           // all chunks were uploaded
    //                 $outFile = $targetDir . '/' . $fileName;
    //                 // combines all file chunks to one file
    //                 $combined = $this->combineChunks($chunks, $outFile);
    //             }
    //             $targetUrl = asset($targetFile);
    //             // $ext = pathinfo($targetUrl, PATHINFO_EXTENSION);
    //             $ext = $request->file->getClientOriginalExtension();
    //             if ($ext == 'avi' || $ext == 'mp4' || $ext == 'wmv' || $ext == 'mkv' || $ext == 'webm' || $ext == 'mp4' || $ext == 'flv' || $ext == 'mp4' || $ext == 'amv' || $ext == 'm4p' || $ext == 'm4v' || $ext == 'mpg' || $ext == 'mpeg') {
    //                 $type = 'video';
    //             } else {
    //                 $type = 'image';
    //             }
    //             if ($combined) {
    //                 $data = [
    //                     'name' => $fileName,
    //                     'file_key' => $fileId,
    //                     'size' => $fileSize,
    //                     'file_type' => $type . '/' . $ext,
    //                 ];
    //                 $media = Media::create($data);
    //             }
    //             // if you wish to generate a thumbnail image for the file
    //             // $targetUrl = getThumbnailUrl($path, $fileName);

    //             // separate link for the full blown image file
    //             // $zoomUrl = 'http://localhost/uploads/' . $fileName;
    //             // if()
    //             return [
    //                 'chunkIndex' => $index,         // the chunk index processed
    //                 'initialPreview' => $targetUrl, // the thumbnail preview data (e.g. image)
    //                 'initialPreviewConfig' => [
    //                     [
    //                         'type' => $type,      // check previewTypes (set it to 'other' if you want no content preview)
    //                         'caption' => $fileName, // caption
    //                         'key' => $fileId,       // keys for deleting/reorganizing preview
    //                         'fileId' => $fileId,    // file identifier
    //                         'size' => $fileSize,    // file size
    //                         // 'zoomData' => $zoomUrl, // separate larger zoom data
    //                     ]
    //                 ],
    //                 'append' => true,
    //             ];
    //         } else {
    //             return [
    //                 'error' => 'Error uploading chunk ' . $_POST['chunkIndex']
    //             ];
    //         }
    //     }
    //     return [
    //         'error' => 'No file found'
    //     ];
    // }
}
