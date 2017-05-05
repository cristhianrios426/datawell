<?php

use Illuminate\Database\Seeder;

class WellSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	
       	
       	foreach (\App\ORM\Well::all() as $key => $well) {
       		$well->delete();
       	}

    	$Operator= \App\ORM\Operator::inRandomOrder()->get();
        $Block= \App\ORM\Block::inRandomOrder()->get();
        $Section= \App\ORM\Section::inRandomOrder()->get();
        $WellType= \App\ORM\WellType::inRandomOrder()->get();
        $CoordinateSys= \App\ORM\CoordinateSys::inRandomOrder()->get();
        $Area= \App\ORM\Area::inRandomOrder()->get();
        $Cuenca= \App\ORM\Cuenca::inRandomOrder()->get();
        $Camp= \App\ORM\Camp::inRandomOrder()->get();
        $Client= \App\ORM\Client::inRandomOrder()->get();
        $Desviation= \App\ORM\Desviation::inRandomOrder()->get();
        $ServiceType= \App\ORM\ServiceType::inRandomOrder()->get();
       
        $latlng = [
        	[5.457058, -76.165937],
        	[5.804213, -70.348762],
        	[9.174765, -75.147285],
        	[2.505330, -76.003871],
        	[-0.277505, -72.372310],
        ];
        //foreach ($entities as $class => $label) {
        	for ($i=0; $i < 5; $i++) { 
        		
        		$entity = new \App\ORM\Well();
        		$entity->name = 'Pozo '.$i;
        		
        		$entity->operator()->associate( $Operator->shuffle()->first() );
        		$entity->block()->associate( $Block->shuffle()->first() );        		
        		$entity->type()->associate( $WellType->shuffle()->first() );
        		$entity->area()->associate( $Area->shuffle()->first() );
        		$entity->cuenca()->associate( $Cuenca->shuffle()->first() );
        		$entity->camp()->associate( $Camp->shuffle()->first() );
        		$entity->coorSys()->associate( $CoordinateSys->shuffle()->first() );
        		$entity->deviation()->associate( $Desviation->shuffle()->first() );
        		$entity->drilled_at = '2017-04-0'.$i;
        		$entity->x = '1230'.$i;
        		$entity->y = '2230'.$i;
        		$entity->z = '3230'.$i;
        		$entity->profundidad_tvd =( $i * 1000) + 1;
        		$entity->profundidad_md = ($i * 1000) + 2;
        		$entity->well_kb_elev = ($i * 1000) + 3;
        		$entity->rotaty_elev = ($i * 1000) + 4;
        		$entity->lat = $latlng[$i][0];
        		$entity->long = $latlng[$i][1];
        		$entity->save();
        	}
        //}
    }
}
