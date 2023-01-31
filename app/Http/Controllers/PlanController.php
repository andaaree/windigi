<?php

namespace App\Http\Controllers;

use stdClass;
use ZipArchive;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = file_get_contents(storage_path('logs/sn.log'));
        $log = explode("\n",$log);
        $log = array_reverse($log,true);
        return view('plans.index',compact('log'));
    }

    public function data()
    {
        $plans = Plan::all();

        return DataTables::of($plans)
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
        return view('plans.add');
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
            $srord = str_replace(".".$extension, "", $fileName);

            $path = "public/";

            $disk = Storage::disk(config('filesystems.default'));

            $disk->putFileAs($path, $file, $fileName);

            unlink($file->getPathname());

            return [
                'status' => true,
                'path' => Storage::url($path . $fileName),
                'filename' => $fileName,
                'url' => $srord
            ];
        }
        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [

            'done' => $handler->getPercentageDone(),

            'status' => true

        ];
    }

    public function snlog()
    {

    }

    public function proc($plan)
    {
        $res = new stdClass;
        $path = "public/";
        $fileName = $plan.".zip";
        $srord = $plan;
        //extract zip video
        $zipz = new ZipArchive;
        if ($zipz->open(storage_path('app/public/').$fileName) !== TRUE) {
            $res->message = "Error :- Unable to open the Zip File";
        }
        $zipz->extractTo(storage_path("app/".$path));
        $zipz->close();

        $files = Storage::disk('public')->allFiles("$srord/LogSNCasing/");
        foreach ($files as $l => $k) {
            $fn = explode('/', $k);
            $fn = end($fn);
            $fn = str_replace(".txt","",$fn);

            $fl = Storage::get("public/$k");
            // debug
            $a = explode("\r\n", $fl);

            try {
                $pl = new Plan;
                $pl->plan_id = $srord;
                $pl->sn_casing = $fn;
                $pl->p_key_id = trim($a[2], " ");
                $pl->save();

                $res->title = "Success";
                $res->message = "Key consumed";

            } catch (\Throwable $e) {
                
                $log = \Log::channel('snlog');

                $res->title = "Error";
                $res->message = $e;

                $log->info("SN $fn save error");
                $log->info(end($e->errorInfo));
            }
        }

        // return $res;
        Storage::delete("public/".$plan);
        return redirect('plans')->with('success',json_encode($res));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
