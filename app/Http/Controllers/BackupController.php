<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function manual(Request $request)
    {
        try {
           
            return Storage::disk('manual')->download('manual.pdf'); 

        } catch (\Throwable $th) {
            
            $request->session()->flash('error', $th->getMessage());
            return redirect()->route('d_help');
        }
    }


    public function create(Request $request)
    {
        try {

            $this->authorize('viewAny', Audit::class);

            // Conection
            $host         = env('DB_HOST');
            $databaseName = env('DB_DATABASE');
            $userName     = env('DB_USERNAME');
            $password     = env('DB_PASSWORD');

            $today = Carbon::now();
            $dumpName = "dump_clinica_". $today->format('d-m-Y')."_".$today->format('H-i-s')."_"."export.sql";

            MySql::create()
                ->setDbName($databaseName)
                ->setUserName($userName)
                ->setPassword($password)
                ->setHost($host)
                //->doNotUseColumnStatistics() // FIX SO Windows
                ->dumpToFile('../storage/backup/'.$dumpName);
    
            
            return Storage::disk('backup')->download($dumpName);
        
        } catch (\Throwable $th) {
            
            $request->session()->flash('error', $th->getMessage());
            return redirect()->route('d_help');
        }
    }


    public function form_upload(Request $request)
    {
        $this->authorize('viewAny', Audit::class);

        return Inertia::render('Backup/Index', [
            'return_url' => route('d_help')
        ]);
    }


    public function store_backup(Request $request)
    {
        $this->authorize('viewAny', Audit::class);

        $validated = $request->validate([
            'database_file' => 'required|file',
        ]);

        $sqlFile = $request->file('database_file');

        if (pathinfo($sqlFile->getClientOriginalName(), PATHINFO_EXTENSION) !== 'sql') {
            $request->session()->flash('error', 'Debe cargar un archivo .sql');
            return redirect()->route('backup.upload');
        }

        try {
            $sql = file_get_contents($sqlFile);
            DB::unprepared($sql);
        } catch (\Throwable $th) {
            $request->session()->flash('error', $th->getMessage());
            return redirect()->route('backup.upload');
        }

        $request->session()->flash('success', 'Base de datos cargada correctamente');
        return redirect()->route('d_help');
    }

}
