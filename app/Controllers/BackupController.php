<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BackupController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access.');
        }

        $db = \Config\Database::connect();
        $dbname = $db->getDatabase();
        $filename = 'backup_' . $dbname . '_' . date('Y-m-d_H-i-s') . '.sql';
        
        // We will attempt to use mysqldump via exec
        $host = $db->hostname;
        $user = $db->username;
        $pass = $db->password;

        $command = "mysqldump --user=$user --password=$pass --host=$host $dbname";
        
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        passthru($command);
        exit;
    }
}
