<?php
require 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class RobotTest extends TestCase {

	public function testRobot($data) {
		$this->assertTrue($data);
	}
	
	public function provider()
    {
        return [
            'action'  => 'clean',
			'--floor' => 'hard',
			'--area'  => 70
        ];
    }
}

?>