<?php

namespace App\Http\Controllers;

use stdClass;
use ZipArchive;
use App\Models\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class KeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = file_get_contents(storage_path('logs/sp.log'));
        $log = explode("\n",$log);
        $log = array_reverse($log,true);
        return view('keys.index',compact('log'));
    }

    public function coba()
    {
        $spord = "SSORDIMV-22100240";
        $ar = [];
        $files = Storage::disk('public')->allFiles("$spord/LogSNCasing/");
        foreach ($files as $k) {
            $fl = Storage::get("public/$k");
            $a = explode("\r\n", $fl);
            // debug 
            $fn = explode('/', $k);
            $fn = end($fn);
            $fn = str_replace(".txt","",$fn);
            array_push($ar,$fn);
            // $key = new Key;
            // $key->bundle_id = $spord;
            // $key->p_key = $a['ProductKey'];
            // $key->p_key_id = $a['ProductKeyID'];
            // if ($key->save()) {
            //     $res->message = "success";
            // }
        }
        dd($ar);
    }

    public function data()
    {
        $keys = Key::all();

        return DataTables::of($keys)
            ->addIndexColumn()
            ->setRowId('id')
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keys.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        $res = new stdClass;
        if (!$receiver->isUploaded()) {

            // file not uploaded

            throw new UploadMissingFileException();
        }

        $fileReceived = $receiver->receive(); // receive file

        // return json_encode($fileReceived);

        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded

            $file = $fileReceived->getFile(); // get file

            $extension = $file->getClientOriginalExtension();
            $fileName = $file->getClientOriginalName();
            $spord = str_replace(".".$extension, "", $fileName);

            $path = "public/";

            $disk = Storage::disk(config('filesystems.default'));

            $disk->putFileAs($path, $file, $fileName);

            unlink($file->getPathname());

            return [
                'status' => true,
                'path' => Storage::url($path . $fileName),
                'filename' => $fileName,
                'url' => $spord
            ];
        }
        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [

            'done' => $handler->getPercentageDone(),

            'status' => true

        ];
    }

    public function proc($key)
    {
        $res = new stdClass;
        $path = "public/";
        $fileName = $key.".zip";
        $spord = $key;
        //extract zip video
        $zipz = new ZipArchive;
        if ($zipz->open(storage_path('app/public/').$fileName) !== TRUE) {
            $res->message = "Error :- Unable to open the Zip File";
        }
        $zipz->extractTo(storage_path("app/".$path));
        $zipz->close();

        $files = Storage::disk('public')->allFiles("$spord/");
        foreach ($files as $k) {
            $fl = Storage::get("public/$k");
            // debug 
            $xml = simplexml_load_string($fl);
            $json = json_encode($xml);
            $a = json_decode($json, TRUE);

            $ky = new Key;
            $ky->bundle_id = $spord;
            $ky->p_key = $a['ProductKey'];
            $ky->p_key_id = $a['ProductKeyID'];

            try {
                $ky->save();
                $res->status = "success";
                $res->message = "Key saved";
            } catch (\Throwable $e) {
                \Log::channel('snlog')
                ->info("SPO $spord save error")
                ->info(end($e->errorInfo));
                $res->status = "error";
                $res->message = end($e->errorInfo);
            }
        }
        
        Storage::delete($path.$key);
        return redirect('keys')->with($res->status,json_encode($res));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function show(Key $key)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function edit(Key $key)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Key $key)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Http\Response
     */
    public function destroy(Key $key)
    {
        $res = new stdClass;
        try {
            $key->delete();

            $res->status = "success";
            $res->message = "$key->bundle_id deleted!";
        } catch (\Throwable $th) {
            $res->status = "success";
            $res->message = end($th->errorInfo);
        }

        return response()->json($res);
    }
}
