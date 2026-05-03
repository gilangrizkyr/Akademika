<?php

if (! function_exists('generate_slug')) {
    function generate_slug($string, $table, $id = null)
    {
        $db = \Config\Database::connect();
        $slug = mb_url_title($string, '-', true);
        
        $builder = $db->table($table);
        $builder->like('slug', $slug, 'after');
        if ($id) {
            $builder->where('id !=', $id);
        }
        $count = $builder->countAllResults();

        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        return $slug;
    }
}
