<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use ZipArchive;

use App\Http\Requests\ProblemRequest;
use App\Models\Problem;
use App\Models\Testcase;


class ProblemController extends Controller
{
    public function create() { return view('problem.create'); }

    public function store(ProblemRequest $req)
    {
        DB::transaction(function () use ($req, &$problem) {

            $problem = Problem::create([
                'user_id'  => $req->user()->id,
                'slug'     => Str::slug($req->title).'-'.Str::random(6),
                'title'    => $req->title,
                'statement'=> $req->statement,
                'time_limit'   => $req->time_limit ?? 1000,
                'memory_limit' => ($req->memory_limit ?? 256)*1024,
                'judge_type'   => $req->judge_type,
                'judge_lang'   => $req->judge_type==='SPECIAL'
                                  ? $req->judge_lang : null,
                'status'       => $req->listed ? 'CREATED'
                                               : 'CREATED_NOT_LISTED',
            ]);

            if ($req->hasFile('cases_zip')) {
                $this->importZip($problem, $req->file('cases_zip'));
            }
        });

        return redirect()->route('problems.show', $problem->slug);
    }

    public function show(Problem $problem)
    { return view('problem.show', compact('problem')); }

    /* ZIP → storage/testcases/{problem_id}/ */
    private function importZip(Problem $p, UploadedFile $zipFile)
    {
        $zip=new ZipArchive; $zip->open($zipFile->getRealPath());
        for($i=0;$i<$zip->numFiles;$i++){
            $entry=$zip->getNameIndex($i);
            if(!preg_match('/^(.+)\\.in$/',$entry,$m)) continue;
            $name=$m[1]; $outE="$name.out";
            if($zip->locateName($outE)===false) continue;

            $dir="testcases/{$p->id}";
            $inPath="$dir/$entry"; $outPath="$dir/$outE";
            $in=$zip->getFromIndex($i);
            $out=$zip->getFromName($outE);
            Storage::put($inPath,$in); Storage::put($outPath,$out);

            Testcase::create([
              'problem_id'=>$p->id,'name'=>$name,
              'in_path'=>$inPath,'out_path'=>$outPath,
              'is_sample'=>Str::startsWith($name,'sample'),
              'size_in'=>strlen($in),'size_out'=>strlen($out),
              'md5_in'=>md5($in),'md5_out'=>md5($out),
            ]);
        }
        $zip->close();
    }
}
