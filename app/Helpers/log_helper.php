<?php

if (!function_exists('log_activity')) {
    function log_activity($action, $description = null)
    {
        $db = \Config\Database::connect();
        $request = \Config\Services::request();
        $session = \Config\Services::session();

        $data = [
            'user_id'     => $session->get('id'),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => $request->getIPAddress(),
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $db->table('activity_logs')->insert($data);
    }
}
