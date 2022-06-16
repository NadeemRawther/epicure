<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class foodsserchModel extends Model
{
    protected $table = 'foodstable';
 
    protected $allowedFields = ['id','title','imageurl','videourl','ingredients','description','rating','totalrating','TypeVegorNon','userid','foodid'];
} 