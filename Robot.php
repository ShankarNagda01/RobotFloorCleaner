<?php 
	$parameters = $argv;
	
	if( 4 != count( $parameters ) ) {
		echo "Mismatch parameters";
		exit;
	}
	
	$parameters[2] = explode( "=", $parameters[2] );
	$parameters[3] = explode( "=", $parameters[3] );
	
	$parameters = [ 
					"action" 		  => $parameters[1],
					$parameters[2][0] => $parameters[2][1],
					$parameters[3][0] => $parameters[3][1]
				  ];
	

	if( "clean" != $parameters["action"] || is_null( $parameters["--floor"] ) || is_null( $parameters["--area"] ) ) {
		echo "Inavalid Parameters";
		exit;
	}
	
	$objRobot = new Robot( $parameters );
	$objRobot->cleanFloor();
	
	class Robot {
		protected const BATTERY_LIFETIME				= 60;
		protected const BATTERY_CHARGE_TIME				= 30;
		protected const HARD_FLOOR_1M2_CLEAN_TIME		= 1;
		protected const CARPETED_FLOOR_1M2_CLEAN_TIME	= 2;
		
		protected $action;
		protected $floorType;
		protected $floorArea;

		function __construct( $parameters ) {
			$this->action 	 = $parameters["action"];
			$this->floorType = $parameters["--floor"];
			$this->floorArea = $parameters["--area"];
		}
		
		public function cleanFloor() {
			$floorCleanTime	= ( 'hard' == $this->floorType ) ? self::HARD_FLOOR_1M2_CLEAN_TIME : self::CARPETED_FLOOR_1M2_CLEAN_TIME;
			$cleanRemaining = $this->floorArea;
			$seconds		= 0;
			
			while( 0 < $cleanRemaining ) {
				sleep($floorCleanTime);
				
				$seconds += $floorCleanTime;
				$cleanRemaining -= $floorCleanTime;
				
				echo "\rCleaning Completed: " . round( ( (  $this->floorArea - $cleanRemaining ) / $this->floorArea ) * 100 ) . "%";
				
				if( self::BATTERY_LIFETIME == $seconds ) {
					$this->rechargeBattery();
					echo "\n";
				}
			}
		}
		
		protected function rechargeBattery() {
			$batterChargeTime = self::BATTERY_CHARGE_TIME;
			
			echo "\n";
			
			while( 0 < $batterChargeTime ) {
				sleep(1);
				
				echo "\rBattery Charging: " . round( ( self::BATTERY_CHARGE_TIME - $batterChargeTime ) / self::BATTERY_CHARGE_TIME * 100 ) . "%";
				$batterChargeTime--;
			}
			
			echo "\rBattery Charging: 100%";
		}
	}
?>