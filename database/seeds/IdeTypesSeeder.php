<?php

use Illuminate\Database\Seeder;
use App\ORM\IdeType;
class IdeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['CC -Cédula de ciudadanía', 'CC -Cédula de extrangería'];
        foreach ($types as $key => $type) {
        	$model = new IdeType;
        	$model->name = $type;
        	$model->save();
        }

    }
}
