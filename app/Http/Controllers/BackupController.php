<?php

namespace App\Http\Controllers;
use App\Models\Backup;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
class BackupController extends Controller
{
    /**
     * صفحة النسخ الاحتياطي
     */
public function index()
{
    $backupFolder = storage_path('app/backups');

    // إنشاء مجلد backups إذا ما كانش موجود
    File::ensureDirectoryExists($backupFolder);

    /*
    =====================================
    Détecter les sauvegardes موجودة في Disk
    =====================================
    */

    $folders = File::directories($backupFolder);

    foreach ($folders as $folder) {

        $name = basename($folder);

        // نتأكد أن المجلد يحتوي على database.sql
        // باش ما نسجلوش أي folder عشوائي
        $sqlFile = $folder . '/database.sql';

        if (!File::exists($sqlFile)) {
            continue;
        }

        // نشوف هل هذا Backup مسجل في قاعدة البيانات
$exists = Backup::where('name', $name)->exists();

if (!$exists) {
    Backup::create([
        'name'   => $name,
        'folder' => $folder,
    ]);
}
    }

    /*
    =====================================
    جلب جميع النسخ
    =====================================
    */

    $backups = Backup::latest()->get();

    /*
    =====================================
    حساب حجم كل Backup
    =====================================
    */

    $backups->each(function ($backup) {

        $size = 0;

        if (File::exists($backup->folder)) {

            foreach (File::allFiles($backup->folder) as $file) {

                $size += $file->getSize();
            }
        }

        if ($size >= 1073741824) {

            $backup->size =
                round($size / 1073741824, 2) . ' GB';

        } elseif ($size >= 1048576) {

            $backup->size =
                round($size / 1048576, 2) . ' MB';

        } elseif ($size >= 1024) {

            $backup->size =
                round($size / 1024, 2) . ' KB';

        } else {

            $backup->size =
                $size . ' B';
        }
    });

    return view(
        'backups.index',
        compact('backups')
    );
}
public function create()
{
    $name = 'backup_' . now()->format('Y_m_d_H_i_s');

    $folder = storage_path('app/backups/' . $name);

    File::ensureDirectoryExists($folder);

    /*
    ======================
    Sauvegarde Storage
    ======================
    */

    File::copyDirectory(
        storage_path('app/public'),
        $folder . '/storage'
    );

    /*
    ======================
    Sauvegarde Database
    ======================
    */

    $db = Config::get('database.connections.mysql.database');
    $user = Config::get('database.connections.mysql.username');
    $pass = Config::get('database.connections.mysql.password');
    $host = Config::get('database.connections.mysql.host');

    $sql = $folder . '/database.sql';

    $command =
        "\"C:\\xampp\\mysql\\bin\\mysqldump.exe\" " .
        "--user={$user} " .
        "--password={$pass} " .
        "--host={$host} " .
        "{$db} > \"{$sql}\"";

    exec($command);

    Backup::create([
        'name' => $name,
        'folder' => $folder,
    ]);

    return back()->with('success', 'Sauvegarde créée avec succès.');
}
public function restore(Backup $backup)
{
    /*
    ===========================
    Restaurer Storage
    ===========================
    */

    $storageBackup = $backup->folder . '/storage';

    if (File::exists($storageBackup)) {

        File::deleteDirectory(storage_path('app/public'));

        File::copyDirectory(
            $storageBackup,
            storage_path('app/public')
        );
    }

    /*
    ===========================
    Restaurer Base de données
    ===========================
    */

    $sql = $backup->folder . '/database.sql';

    if (File::exists($sql)) {

        $db = Config::get('database.connections.mysql.database');
        $user = Config::get('database.connections.mysql.username');
        $pass = Config::get('database.connections.mysql.password');
        $host = Config::get('database.connections.mysql.host');

        $command =
            "\"C:\\xampp\\mysql\\bin\\mysql.exe\" " .
            "--user={$user} " .
            "--password={$pass} " .
            "--host={$host} " .
            "{$db} < \"{$sql}\"";

        exec($command);
    }

    return back()->with('success', 'Sauvegarde restaurée avec succès.');
}
public function copyToExternal(Request $request, Backup $backup)
{
    $request->validate([
        'destination' => 'required|string',
    ]);

    $destination = $request->destination;

    // نتأكد أن القرص/المجلد موجود
    if (!File::exists($destination)) {
        return back()->with('error', 'Le disque ou dossier sélectionné n’existe pas.');
    }

    // اسم النسخة
    $backupName = basename($backup->folder);

    // المكان النهائي في القرص الخارجي
    $destinationFolder = rtrim($destination, '\\/') . '\\' . $backupName;

    // إذا كانت النسخة موجودة من قبل
    if (File::exists($destinationFolder)) {
        File::deleteDirectory($destinationFolder);
    }

    // نسخ الـ Backup كامل
    File::copyDirectory(
        $backup->folder,
        $destinationFolder
    );

    return back()->with(
        'success',
        'Sauvegarde copiée vers le disque externe avec succès.'
    );
}
public function destroy(Backup $backup)
{
    if (File::exists($backup->folder)) {
        File::deleteDirectory($backup->folder);
    }

    $backup->delete();

    return back()->with('success', 'Sauvegarde supprimée.');
}

}