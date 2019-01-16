<?php

abstract class BeesFactory
{
	private static $_beesNameArray = array(
		"QueenBee" => array("Queen Bee"),
		"WorkerBees" => array("Thorin", "Kili", "Fili", "Balin", "Dwalin", "Gloin", "Oin", "Dori", "Nori", "Ori", "Bofur", "Bifur", "Bombur", "Elrond", "Thranduil", "Galion"),
		"DroneBees" => array("Neo", "Morpheus", "Trinity", "Cypher", "Tank", "Agent Smith", "Dozer", "Ghost", "Lock", "Rhineheart", "Sparks" , "Thadeus"));
	
	const QUEEN_BEE_MERCENARIES = 1;
	const WORKER_BEES_MERCENARIES = 5;
	const DRONE_BEES_MERCENARIES = 8;
	
	const BEE_ROLES = array(
		'queenBee' => 'Queen Bee',
		'workerBees' => 'Worker Bee',
		'droneBees' => 'Drone Bee'
	);
	
	const BEE_CLASSES = array(
		'queenBee' => 'QueenBee',
		'workerBees' => 'WorkerBees',
		'droneBees' => 'DroneBees'
	);
	
	public function __construct()
	{
	
	}
	
	public static function build()
	{		
		foreach(self::BEE_CLASSES as $beeClass)
		{
			$beeClass = ucwords($beeClass);
			
			if(class_exists($beeClass))
			{
				$beeClasses = new $beeClass();
				$randomBeesNames = self::getRandomNamesForBees($beeClasses->beeClass, $beeClasses->_mercenaries);
				for($i = 0; $beeClasses->_mercenaries > $i; $i++)
				{
					$bees[$beeClass][] = new $beeClasses->beeClass($randomBeesNames[$i]);
				}
			}
			else
			{
				throw new Exception('Invalid Bee Class given.');
			}
		}
		
		return $bees;
	}
	
	public static function buldBees()
	{
	
	}
	
	public static function getRandomNamesForBees($beeClass, $mercenariesCount)
	{		
		shuffle(self::$_beesNameArray[$beeClass]);
		return array_slice(self::$_beesNameArray[$beeClass], 0, $mercenariesCount);
	}
}

/*
abstract class BeeNamesLoaderFromFile
{
    private static $_file; 

    public function __construct($filename)
	{
        self::$_file = $filename;
    }

    public static function getNamesFromFile($filename)
	{
        $beeNames = [];
        self::$_file = $filename;
		$fileSize = filesize(self::$_file);

		$handle = fopen(self::$_file, 'r');
        if($handle !== FALSE)
		{
            while(feof($handle) == FALSE)
			{
                $beeNames[] = fgets($handle, $fileSize);
            }
            fclose($handle);
        }

        return $beeNames;
    } 
}
*/

//$fileReader = BeeNamesLoaderFromFile::getNamesFromFile('WorkerBees-Names.txt');
//var_dump($fileReader);

class QueenBee extends BeesFactory
{	
	const QUEEN_BEE_NAME = 'Queen Bee';
	const QUEEN_BEE_HIT_POINTS = 100;
	const QUEEN_BEE_DEFENSE = 92;
	
	protected $_mercenaries = 1;
	
	public function __construct()
	{
		parent::__construct();
		$this->name = self::QUEEN_BEE_NAME;
		$this->hitPoints = self::QUEEN_BEE_HIT_POINTS;
		$this->defense = self::QUEEN_BEE_DEFENSE;
		$this->role = BeesFactory::BEE_ROLES['queenBee'];
		$this->beeClass = BeesFactory::BEE_CLASSES['queenBee'];
	}
}

class WorkerBees extends BeesFactory
{	
	const WORKER_BEES_NAME = '';
	const WORKER_BEES_HIT_POINTS = 75;
	const WORKER_BEES_DEFENSE = 86.66;
	
	protected $_mercenaries = 5;
	
	public function __construct($name = '')
	{
		parent::__construct();
		$this->name = $name;
		$this->hitPoints = self::WORKER_BEES_HIT_POINTS;
		$this->defense = self::WORKER_BEES_DEFENSE;
		$this->role = BeesFactory::BEE_ROLES['workerBees'];
		$this->beeClass = BeesFactory::BEE_CLASSES['workerBees'];
	}
}

class DroneBees extends BeesFactory
{
	const DRONE_BEES_NAME = '';
	const DRONE_BEES_HIT_POINTS = 50;
	const DRONE_BEES_DEFENSE = 76;
	
	protected $_mercenaries = 8;
	
	public function __construct($name = '')
	{
		parent::__construct();
		$this->name = $name;
		$this->hitPoints = self::DRONE_BEES_HIT_POINTS;
		$this->defense = self::DRONE_BEES_DEFENSE;
		$this->role = BeesFactory::BEE_ROLES['droneBees'];
		$this->beeClass = BeesFactory::BEE_CLASSES['droneBees'];
	}
}

$objs = BeesFactory::build();
?>
	<div id="battlefield">
		<? foreach($objs as $beeClass => $bees): ?>
			<div class="<?=$bees[0]->beeClass?> field">
				<? foreach($bees as $bee): ?>
					<div class="bee" name="<?=$bee->name?>" hitPoints="<?=$bee->hitPoints?>" refHitPoints="<?=$bee->hitPoints?>" defense="<?=$bee->defense?>" role="<?=$bee->role?>">
						<span class="beeHitPointsBarGreen">
							&nbsp;
						</span>
						<span class="beeHitPointsBarRed">
							&nbsp;
						</span>
						<span class="beeRefHitPoints">
							<?=$bee->hitPoints?>&nbsp;/
						</span>
						<span class="beeHitPoints">
							<?=$bee->hitPoints?>
						</span>
						<img class="beeImg" src="<?=$bee->role?>.png" />
						<span class="beeName">
							<?=$bee->name?>
						</span>
						<br />
						<span class="beeRole">
							<?=strtolower($bee->role)?>
						</span>
					</div>
				<? endforeach; ?>
			</div>
			<span class="clear-both"></span>
		<? endforeach; ?>
	</div>
	<div id="theHitButtonContainer">
		<div class="timerBar">
			<div id="progress"></div>
		</div>
		<button id="theHitButton" damage="100">
			<span class="left arrow"></span>
			HIT!
			<span class="right arrow"></span>
		</button>
	</div>
	<div id="actionLog">
		<p class="actionLogLabel">
			Action Log:
		</p>
	</div>
	<div id="gameObjective">
		<h2>The Bee Game Objective</h2>
		<h3>Specification:</h3>
		<p>Bees: There are three types of bees in this game:</p>
		<ul>
			<li>
				<strong>Queen Bee.</strong> The Queen Bee has a lifespan of 100 Hit Points. When the Queen Bee is hit, 8
Hit Points are deducted from her lifespan. If/When the Queen Bee has run out of Hit Points,
All remaining alive Bees automatically run out of hit points. There is only 1 Queen Bee.
			</li>
			<li>
				<strong>Worker Bee.</strong> Worker Bees have a lifespan of 75 Hit Points. When a Worker Bee is hit, 10 Hit
Points are deducted from his lifespan. There are 5 Worker Bees. 
			</li>
			<li>
				<strong>Drone Bee.</strong> Drone Bees have a lifespan of 50 Hit Points. When a Drone Bee is hit, 12 Hit
Points are deducted from his lifespan. There are 8 Drone Bees.
			</li>
		</ul>
		<h3>Gameplay:</h3>
		<p>
			To play, there must be a button that enables a user to HIT a random bee. The selection of a bee must
be random. When the bees are all dead, the game must be able to reset itself with full life bees for
another round.
		</p>
	</div>