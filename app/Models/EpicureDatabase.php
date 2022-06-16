<?php namespace App\Models;

use CodeIgniter\Model;

class EpicureDatabase extends Model
{
    protected $table = 'epicuretable';
    
    public function getNews($slug = false)
    {
        if ($slug === false)
        {
            return $this->findAll();
        }
    
        return $this->asArray()
                    ->where(['slug' => $slug])
                    ->first();
    }
    



}