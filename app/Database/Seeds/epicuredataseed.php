<?php namespace App\Database\Seeds;

class Epicuredataseed extends \CodeIgniter\Database\Seeder
{
        public function run()
        {
                $data = [
                        'emailid' => 'darth3',
                        'pass'    => 'po7853',
                        'username' => 'darthname3',
                        'profilepic'    => '',
                        'locations' => '',
                        'favoritefoods'    => '',
                        'favoritecooks' => '',
                        'rating'    => ''
                        ];

                // Simple Queries
               $this->db->query( " CREATE TABLE IF NOT EXISTS epicureuser (
                        id integer PRIMARY KEY AUTO_INCREMENT,
                        emailid text NOT NULL,
                        pass text NOT NULL,
                        username text NOT NULL ,
                        profilepic text,
                        locations text ,
                        favoritefoods text ,
                        favoritecooks text ,
                        rating text 
                    ); ");
                //$this->db->query("INSERT INTO users (username, email) VALUES(:username:, :email:)",
                //        $data
                //);

                // Using Query Builder
                $this->db->table('epicureuser')->insert($data);
        }
}