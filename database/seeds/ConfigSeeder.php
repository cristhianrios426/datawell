<?php

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entities = [
        	'Operator'=>'operador',
	        'Block'=>'operador',
	        'Section'=>'sección',
	        'WellType'=>'tipo de pozo',
	        'CoordinateSys'=>'sistema de coordenadas',
	        'Area'=>'area',
	        'Cuenca'=>'cuenca',
	        'Camp'=>'campo',
	        'Client'=>'campo',
	        'Desviation'=>'desviación',
	        'ServiceType'=>'tipo de servicio'
        ];

        foreach ($entities as $class => $label) {
        	for ($i=0; $i < 5; $i++) { 
        		$className = "\\App\\ORM\\".$class;
        		$entity = new $className();
        		$entity->name = ucfirst($label).' '.($i+ 1);
        		$entity->save();
        	}
        }
    }
}
