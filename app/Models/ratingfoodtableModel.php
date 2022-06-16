<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class ratingfoodtableModel extends Model
{
    protected $table = 'ratingfoodtable';
 
    protected $allowedFields = ['userid', 'foodtitle','foodpic','location','rating'];
}