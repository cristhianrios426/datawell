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
	        'Block'=>'bloque',
	        'Section'=>'sección',
	        'WellType'=>'tipo de pozo',
	        'CoordinateSys'=>'sistema de coordenadas',
	        'Area'=>'area',
	        'Cuenca'=>'cuenca',
	        'Camp'=>'campo',
	        'Client'=>'cliente',
	        'Desviation'=>'desviación',
	        'ServiceType'=>'tipo de servicio'
        ];

        $locables = [
            'Block',
            'Area',
            'Cuenca',
            'Camp',
        ];
        $location = \App\ORM\Location::first();
        
        foreach ($entities as $class => $label) {
        	for ($i=0; $i < 5; $i++) { 
        		$className = "\\App\\ORM\\".$class;
        		$entity = new $className();
        		$entity->name = ucfirst($label).' '.($i+ 1);
                if(in_array($class, $locables)){
                    $entity->location()->associate($location);
                }
        		$entity->save();
        	}
        }
    }
}
