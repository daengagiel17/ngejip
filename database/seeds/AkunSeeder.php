<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Driver;
use App\Models\Admin;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Admin
        $admin = new Admin;
    	$admin->admin_nama = "ngejip";
    	$admin->admin_nohp = "+6285819910714";
    	// $admin->status = "admin";
    	$admin->email = "ngejip@gmail.com";
     	$admin->password = bcrypt("+6285819910714");
    	$admin->api_token = str_random(100);
    	$admin->save();

		// Customer
        $user = new User;
    	$user->name = "Indra";
    	$user->nohp = "+6289660600419";
    	$user->email = "seism.ml@gmail.com";
     	$user->password = bcrypt("indra");
    	$user->api_token = str_random(100);
    	$user->save();

        $user = new User;
    	$user->name = "Bayu";
    	$user->nohp = "+6288234108105";
    	$user->email = "agielnara17@gmail.com";
     	$user->password = bcrypt("bayu");
    	$user->api_token = str_random(100);
    	$user->save();

        $user = new User;
    	$user->name = "Oky";
    	$user->nohp = "+6282230914422";
    	$user->email = "kyky733@gmail.com";
     	$user->password = bcrypt("bayu");
    	$user->api_token = str_random(100);
    	$user->save();
		
		// Driver
        $driver = new Driver;
    	$driver->driver_username = "Oky";
    	$driver->driver_nama = "Oky";
    	$driver->driver_nohp = "+6282230914422";
    	$driver->email = "agielnara17@gmail.com";
     	$driver->password = bcrypt("+6282230914422");
    	$driver->api_token = str_random(100);
        $driver->driver_jmlh_orderan = 0;
        $driver->save();

        $driver = new Driver;
    	$driver->driver_username = "Indra";
    	$driver->driver_nama = "Indra";
    	$driver->driver_nohp = "+89660600419";
    	$driver->email = "seism.ml@gmail.com";
     	$driver->password = bcrypt("+89660600419");
    	$driver->api_token = str_random(100);
        $driver->driver_jmlh_orderan = 0;
        $driver->save();

        $driver = new Driver;
    	$driver->driver_username = "cadangan";
    	$driver->driver_nama = "Agiel";
    	$driver->driver_nohp = "+6285819910714";
    	$driver->email = "ngejip@gmail.com";
     	$driver->password = bcrypt("+6285819910714");
    	$driver->api_token = str_random(100);
        $driver->driver_jmlh_orderan = 0;
        $driver->save();
    }
}
