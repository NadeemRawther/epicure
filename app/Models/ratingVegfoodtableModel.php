<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class ratingVegfoodtableModel extends Model
{
    protected $table = 'ratingVegfoodtable';
 
    protected $allowedFields = ['userid', 'foodtitle','foodpic','location','rating'];
}