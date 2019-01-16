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

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/roboto-condensed" type="text/css"/>
<link rel="stylesheet" href="jquery-ui.css" />
<title>The Bee Game</title>
<style type="text/css">
html, body
{
	width: 100%;
	font-family: helvetica;
	margin: 0px;
	padding: 0px;
}

h1
{
	font-family: 'RobotoCondensedRegular';
	text-align: center;
}
	
#battlefieldWrapper
{
	max-height: 560px;
	background: url('background-01.jpg') 0px 0px;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	border-top: 7px solid black;
	border-bottom: 7px solid black;
	margin: 30px 0px 0px 0px;
	padding: 10px 0px;
}

#battlefield
{
	width: 800px;
	height: 530px;
	background-color: rgba(255, 255, 255,0.3);
	border-radius: 15px;
	margin: 0px auto;
	padding: 15px 0px;
}
	
.field
{
	width: 800px;
	height: 180px;
	display: block;
	overflow: hidden;
	text-align: center;
	margin: 0px auto;
}

.bee
{
	width: 70px;
	display: inline-block;
	margin: 8px 3px;
	padding: 3px;
	background-color: rgb(255, 255, 255, 0.3);
	border: 3px solid black;
	border-radius: 5px;
	
	height: 140px;
}

.beeName
{
	font-size: 12px;
	font-weight: bold;
}

.beeRole
{
	width: 100%;
	background-color: black;
	display: inline-block;
	color: #CCC;
	font-size: 12px;
	padding: 1px 0px;
}

.beeImg
{
	max-width: 100%;
	max-height: 100%;
}

.thisBee
{
	border: 1px solid red !important;
}

.hittedBee
{
	border: 1px solid blue;
}

.beeHitPointsBarGreen,
.beeHitPointsBarRed
{
	width: 100%;
	height: 5px;
	display: inline-block;
	position: relative;
	float: left;
}

.deadBee{}

.beeHitPointsBarRed
{
	background-color: #FF3333;
	bottom: 5px;
}

.beeHitPointsBarGreen
{
	background-color: #66AA66;
	z-index: 1;
}

.beeRefHitPoints,
.beeHitPoints
{
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}

#theHitButtonContainer
{
	width: 200px;
	text-align: center;	
	margin: 50px auto;
}

#theHitButton
{
	width: 120px;
	height: 30px;
	font-size: 14px;
	font-weight: bold;
	border-radius: 8px;
	margin: 5px auto;
	
	background-color: #4CAF50;
	color: #FFFFFF;
	border: 1px solid green;
	cursor: pointer;
	
	transition: all 0.5s;
}

#theHitButton[disabled],
#theHitButton[disabled]:hover
{	
	background-color: lightgrey;
	color: #000000;
	border: 1px solid darkgrey;
	
	transition: all 0.5s;
}

#theHitButton:hover
{
    background-color: #3e8e41;
}

.timerBar
{
	width: 100%;
	height: 5px;
	border: 1px solid grey;
}

#progress
{
	width: 0%;
	height: 5px;
	background-color: darkgrey;
}

#actionLog
{
	width: 360px;
    min-height: 25px;
    max-height: 145px;
    position: fixed;
    overflow: hidden;
    border: 1px solid darkgray;
	bottom: 0px;
	background-color: rgba(255, 255, 255,0.8);
	border-radius: 5px 5px 0px 0px;
	padding: 0px 10px;
	z-index: 9;
	box-shadow: 0px 0px 15px black;
}

#actionLog p
{
	font-size: 12px;
	color: green;
}

#actionLog p.actionLogLabel
{
	width: 100%;
	background-color: #FFF;
	font-size: 12px;
	color: #333;
	font-weight: bold;
	border-bottom: 1px dashed darkgray;
	position: sticky;
	top: 0px;
	padding: 7px 12px;
	margin: 0px;
	right: -12px;
}

#gameObjective
{
	width: 800px;
	font-size: 14px;
	font-family: 'RobotoCondensedRegular';
	color: #333;
	padding: 25px;
	margin: 50px auto;
	border: 1px dashed darkgray;
}

#gameObjective ul li
{
	padding: 5px 0px;
}

.clear-both
{
	clear: both;
}

.redMsg
{
	color: red !important;
}
</style>
<script type="text/javascript" src="jquery-git.min.js"></script>
<script src="jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	function init()
	{
		var MyGlobalVars = {
			$battlefieldWrapper: $('#battlefieldWrapper'),
			$theHitButton: $('#theHitButton'),
			get damage()
			{
				return this.$theHitButton.attr('damage');
			},
			$progressBar: $('#progress'),
			get progressBarWidth()
			{
				return parseInt(this.$progressBar.css('width'));
			},
			$actionLogElement: $('#actionLog'),
			$allBees: $('.bee'),
			stopCheckingForQueen: false,
			gameBackgrounds: [
				'background-01.jpg',
				'background-02.jpg',
				'background-03.jpg',
				'background-04.jpg',
				'background-05.jpg'
			]
		}
		
		return MyGlobalVars;
	}
	
	gameCount = 0;
	MyGlobalVars = init();
	
	function restartGame()
	{
		setTimeout(function(){
			MyGlobalVars.$battlefieldWrapper.load('ajax-call.php', function(){	
				MyGlobalVars = init();
				gameBackground = getNextGameBackground();
				MyGlobalVars.$battlefieldWrapper.css({background: 'url("' + gameBackground + '") 0px 0px', backgroundSize: 'cover'});
			});
		}, 5000);
	}
	
	function getNextGameBackground()
	{
		gameCount++;
		var gameBackgroundsCount = MyGlobalVars.gameBackgrounds.length;
		if(gameCount >= gameBackgroundsCount)
		{
			gameCount = 0;
		}
		var gameBackground = MyGlobalVars.gameBackgrounds[gameCount];
		
		return gameBackground;
	}
	
	MyGlobalVars.$battlefieldWrapper.on('click', '#theHitButton', hitRandomBee);
		
	function hitRandomBee()
	{
		var $randomBee = getRandomBee();
		var randomBeeStats = getRandomBeeStats($randomBee);
		var randomBeeHitPointsAfterAttack = calculateHitPointsAfterAttack(randomBeeStats, MyGlobalVars.damage);
		
		$randomBee.attr('hitPoints', randomBeeHitPointsAfterAttack);
		$randomBee.find('.beeHitPoints').html(randomBeeHitPointsAfterAttack);
						
		//refactor!!!
		randomBeeStats = getRandomBeeStats($randomBee);
				
		var hitPointsBar = calculateHitPointsBar(randomBeeStats);
		$randomBee.find('.beeHitPointsBarGreen').css('width', hitPointsBar);
		
		// refactor - don not duplicate the function!!!
		var inflictedDmg = calculateInflictedDamage(randomBeeStats);
				
		hitRandomBeeAnimationEffect($randomBee);
		fillTimeBar();
		actionLog('hitBee', randomBeeStats, inflictedDmg);
		
		var isBeeDyingVar = isBeeDying($randomBee, randomBeeStats);
		
		var areAllBeesDeadVar = areAllBeesDead();
		var isQueenDeadVar = isQueenDead();
				
		if(areAllBeesDeadVar === true)
		{
			MyGlobalVars.$theHitButton.prop('disabled', true).html('GAME OVER!');
			restartGame();
			return;
		}
		if(isQueenDeadVar === true)
		{
			var $allAliveBees = getAllAliveBees();
			allBeeGetsLowerHitPoints($allAliveBees);
		}
		
		preventFastClick($(this));
	}
	
	function hitRandomBeeAnimationEffect($randomBee)
	{
		var options = [];
		$randomBee.effect('pulsate', options, 500);
	}
	
	function beeDiesAnimationEffect($randomBee)
	{		
		var options = [];
		$randomBee.effect('explode', options, 500);
	}
	
	function preventFastClick(btnElement)
	{
		$(btnElement).html('WAIT!');
		$(btnElement).prop('disabled', true);
		setTimeout(function(){
			$(btnElement).html('HIT!');
			$(btnElement).prop('disabled', false);
		}, 1000);
	}
	
	function fillTimeBar()
	{
		progressBarWidth = parseInt($('#progress').css('width'));
		var intervalId = setInterval(function(){
			progressBarWidth = progressBarWidth + 10;
			if(progressBarWidth >= 100)
			{
				setTimeout(function(){
					progressBarWidth = 0;
					MyGlobalVars.$progressBar.css('width', progressBarWidth + '%');
				}, 20);
				clearInterval(intervalId);
			}
			MyGlobalVars.$progressBar.css('width', progressBarWidth + '%');
		}, 100);
	}
	
	function isBeeDying($randomBee, randomBeeStats)
	{
		var isBeeDyingVar = false;
		if(randomBeeStats.hitPoints <= 0)
		{
			isBeeDyingVar = true;
			killBee($randomBee);
			actionLog('beeDied', randomBeeStats)
		}
		
		return isBeeDyingVar;
	}
	
	function getAllAliveBees()
	{
		var $allAliveBees = $('.bee').not('.bee.deadBee');
		
		return $allAliveBees;
	}

	function areAllBeesDead()
	{
		var areAllBeesDeadVar = false;
		if($('.bee.deadBee').length == $('.bee').length)
		{
			actionLog('allBeesDied');
			actionLog('gameOver');
			areAllBeesDeadVar = true;
		}
		
		return areAllBeesDeadVar;
	}
	
	function isQueenDead()
	{
		var isQueenDeadVar = false;
		if($('.bee[name="Queen Bee"]').hasClass('deadBee') && MyGlobalVars.stopCheckingForQueen == false)
		{
			actionLog('queenDied');
			isQueenDeadVar = true;
			MyGlobalVars.stopCheckingForQueen = true;
		}
		
		return isQueenDeadVar;
	}
	
	function allBeeGetsLowerHitPoints($allAliveBees)
	{
		$allAliveBees.attr('hitPoints', '1').find('.beeHitPoints').html('1').addBack().find('.beeHitPointsBarGreen').css('width', '3px');
	}
	
	function killBee($randomBee)
	{
		$randomBee.addClass('deadBee');
		$randomBee.find('.beeHitPoints').html(0);
		beeDiesAnimationEffect($randomBee)
	}
	
	function getRandomBee()
	{
		var beesCount = $('.bee').not('.deadBee').length;
		var randomBeeNumber = Math.floor(Math.random() * beesCount);
		var $randomBee = $('.bee').not('.deadBee').eq(randomBeeNumber);
		
		return $randomBee;
	}
	
	function getRandomBeeStats($randomBee)
	{
		var randomBeeStats = {
			name: $randomBee.attr('name'),
			hitPoints: $randomBee.attr('hitPoints'),
			refHitPoints: $randomBee.attr('refHitPoints'),
			defense: $randomBee.attr('defense'),
			beeHitPointsBarGreenWidth: ($randomBee.find('.beeHitPointsBarGreen')
	.outerWidth()).toFixed(2),
			beeHitPointsBarRedWidth: $randomBee.find('.beeHitPointsBarRed')
	.outerWidth()
		};
		
		return randomBeeStats;
	}
	
	function actionLog(action, randomBeeStats, inflictedDmg)
	{
		if(randomBeeStats === undefined)
		{
			randomBeeStats = {};
		}
			
		var ActionLogTxts = {
			hitTxt: '<p> - Hit Button successfully attacked <strong>' + randomBeeStats.name + '</strong> for <strong>' + inflictedDmg + '</strong> Hit points.</p>',
			beeDiedTxt: '<p>...and now <strong class="redMsg">' + randomBeeStats.name + '</strong> is <em class="redMsg">dead</em>!</p>',
			allBeesDiedTxt: '<p class="redMsg"> - <strong>All bees are dead!</strong></p>',
			queenDiedTxt: '<p class="redMsg"> - <strong>Queen is dead! RETREAT!!!</strong></p>',
			queenHitWarningTxt: '',
			gameOverTxt: '<p class="redMsg"> - <strong>GAME OVER!</strong></p><p class="redMsg"> - The game will restart in 5 seconds.</p>'
		};
		
		switch(action)
		{
			case 'hitBee':
				MyGlobalVars.$actionLogElement.append(ActionLogTxts.hitTxt);
				break;
			case 'beeDied':
				MyGlobalVars.$actionLogElement.append(ActionLogTxts.beeDiedTxt);
				break;
			case 'allBeesDied':
				MyGlobalVars.$actionLogElement.append(ActionLogTxts.allBeesDiedTxt);
				break;
			case 'queenDied':
				MyGlobalVars.$actionLogElement.append(ActionLogTxts.queenDiedTxt);
				break;
			case 'gameOver':
				MyGlobalVars.$actionLogElement.append(ActionLogTxts.gameOverTxt);
				break;
			default:
				MyGlobalVars.$actionLogElement.append('???');
				break;
		}
		
		MyGlobalVars.$actionLogElement.prop('scrollTop', MyGlobalVars.$actionLogElement.prop('scrollHeight'));
	}
	
	function calculateInflictedDamage(randomBeeStats)
	{		
		var inflictedDmg = (((MyGlobalVars.damage - (randomBeeStats.defense / 100) * MyGlobalVars.damage) / 100) * randomBeeStats.refHitPoints).toFixed(0);
		
		return inflictedDmg;
	}
	
	function calculateDmgInPercents(randomBeeStats)
	{
		var inflictedDmg = calculateInflictedDamage(randomBeeStats);
		var dmgInPercents = ((inflictedDmg / randomBeeStats['refHitPoints']) * 100).toFixed(2);
		
		return dmgInPercents;
	}
	
	function calculateHitPointsBar(randomBeeStats)
	{
		var dmgInPercents = calculateDmgInPercents(randomBeeStats);
		
		var hitPointsBar = (randomBeeStats.beeHitPointsBarGreenWidth - ((dmgInPercents / 100) * randomBeeStats.beeHitPointsBarRedWidth)).toFixed(2);
		
		return hitPointsBar;
	}
	
	function calculateHitPointsAfterAttack(randomBeeStats)
	{
		var inflictedDmg = calculateInflictedDamage(randomBeeStats);
		var randomBeeHitPointsAfterAttack = Math.ceil(randomBeeStats.hitPoints - inflictedDmg);
				
		return randomBeeHitPointsAfterAttack;
	}
});	
</script>
</head>
<body>
<h1><em>"The Bee"</em> Game</h1>
<div id="battlefieldWrapper">
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
</div>
</body>
</html>