<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class cookstableModle extends Model
{
    protected $table = 'cookstable';
 
    protected $allowedFields = ['username', 'emailid','profilepic','location','contact','rating'];
}