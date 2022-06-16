<?php namespace App\Database\Seeds;
class Epicureuserseed extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
              
                // Simple Queries
               $this->db->query( " CREATE TABLE IF NOT EXISTS topratingfood (
                        id integer PRIMARY KEY AUTO_INCREMENT
                    ); ");
                //$this->db->query("INSERT INTO users (username, email) VALUES(:username:, :email:)",
                //        $data
                //);

                // Using Query Builder
                //$this->db->table('darth')->insert($data);
        }
}