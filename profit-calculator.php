<?php
	
	//The array to be filled with price data
    $dataArray = [];
    
    //The names of the variables for the types of materials used in crafting
    $types = ['mith', 'iron', 'plat',
    	'elder', 'soft', 'seasoned', 'hard',
    	'silk', 'wool', 'cotton', 'linen',
    	'marketIngot', 'marketPlank', 'marketBolt',
    	'ecto'];

    if($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
    	//Filling the price data array with the $_POST input values
    	foreach($types as $type) 
    	{
    		$dataArray[$type] = coinToInt(
    			$_POST['price_'.$type.'_gold'], 
    			$_POST['price_'.$type.'_slvr'],
    			$_POST['price_'.$type.'_cppr']);
    	}
    	
    	// -- Global material prices -- {
    	$ectoPrices = $dataArray['ecto'];
    	$thermoPrices = 1496;    //In case prices change one day
    	$coalPrices = 16;
    	$primordiumPrices = 48;
    	//	}
    }
    else 
    {
    	//If the request method is not POST, all values are zeroed out
    	
    	//Filling the data array with 0s for the initial page load
    	//The string keys are still required and must be used to assign values
    	foreach($types as $type)
    	{
    		$dataArray[$type] = 0;
    	}
    	
    	// -- Global material prices -- {
    	$ectoPrices = $dataArray['ecto'];
    	$thermoPrices = 0;    //In case prices change one day
    	$coalPrices = 0;
    	$primordiumPrices = 0;
    	//	}
    }
    
    //Market prices
    $marketIngotPrice = intToCoinArray($dataArray['marketIngot']);
    $marketPlankPrice = intToCoinArray($dataArray['marketPlank']);
    $marketBoltPrice =  intToCoinArray($dataArray['marketBolt']);

    // ---- Show-Prices Calculations ---- {
    
    	
    	
    	// ---- DELDRIMOR STEEL INGOT ----  {
    	
    	//Mithril price variables
    	$mithOreCost = $dataArray['mith'];
    	$mithBarCost = $mithOreCost * 2;
    	$mithBarTotal = $mithBarCost * 50;
    	$mithLumpTotal = $mithBarTotal + $ectoPrices + $thermoPrices;
    	
    	//Iron price variables
    	$ironOreCost = $dataArray['iron'];
    	$ironBarCost = $ironOreCost * 3;
    	$ironBarTotal = $ironOreCost * 60;
    	
    	//Steel price variables
    	$steelBarCost = ($ironOreCost * 3) + $coalPrices;
    	$steelBarTotal = $steelBarCost * 10;
    	
    	//Platinum price variables
    	$platOreCost = $dataArray['plat'];
    	$platBarCost = ($platOreCost * 2) + $primordiumPrices;
    	$platBarTotal = $platBarCost * 20;
    	
    	//Total cost to make the ingot
    	$totalIngotCost = $mithLumpTotal + $ironBarTotal + $steelBarTotal + $platBarTotal;
    	$totalIngotCostArray = intToCoinArray($totalIngotCost);
    	
    	//	}
    	
    	// ---- SPIRITWOOD PLANK ----   {
    
    	//Elder wood
    	$elderLogCost = $dataArray['elder'];
    	$elderPlankCost = $elderLogCost * 3;
    	$elderPlankTotal = $elderPlankCost * 50;
    	$elderResidueTotal = $elderPlankTotal + $ectoPrices + $thermoPrices;
    	
    	//Soft wood 
    	$softLogCost = $dataArray['soft'];
    	$softPlankCost = $softLogCost * 4;
    	$softPlankTotal = $softPlankCost * 20;
    	
    	//Seasoned wood
    	$seasonedLogCost = $dataArray['seasoned'];
    	$seasonedPlankCost = $seasonedLogCost * 3;
    	$seasonedPlankTotal = $seasonedPlankCost * 10;
    	
    	//Hard wood
    	$hardLogCost = $dataArray['hard'];
    	$hardPlankCost = $hardLogCost * 3;
    	$hardPlankTotal = $hardPlankCost * 20;
    	
    	//Total
    	$totalPlankCost = $elderResidueTotal + $softPlankTotal + $seasonedPlankTotal + $hardPlankTotal;
    	$totalPlankCostArray = intToCoinArray($totalPlankCost);
    	
    	//  }
    	
    	// ---- BOLT OF DAMASK ----    {
    	    
    	//Silk scraps
    	$silkScrapCost = $dataArray['silk'];
    	$silkBoltCost = $silkScrapCost * 3;
    	$silkBoltTotal = $silkBoltCost * 100;
    	$silkThreadTotal = $silkBoltTotal + $ectoPrices + $thermoPrices;
    	
    	//Wool scraps
    	$woolScrapCost = $dataArray['wool'];
    	$woolBoltCost = $woolScrapCost * 2;
    	$woolBoltTotal = $woolBoltCost * 20;
    	
    	//Cotton scraps
    	$cottonScrapCost = $dataArray['cotton'];
    	$cottonBoltCost = $cottonScrapCost * 2;
    	$cottonBoltTotal = $cottonBoltCost * 10;
    	
    	//Linen scraps
    	$linenScrapCost = $dataArray['linen'];
    	$linenBoltCost = $linenScrapCost * 2;
    	$linenBoltTotal = $linenBoltCost * 20;
    	
    	//Total
    	$totalBoltCost = $silkThreadTotal + $woolBoltTotal + $cottonBoltTotal + $linenBoltTotal;  
    	$totalBoltCostArray = intToCoinArray($totalBoltCost);
    	    
    	//  }
    	
    	// ---- MARKET PRICES ---- {
    	
    	//Deldrimor Ingot
    	$ingot = $dataArray['marketIngot'];
    	$ingotTax = getTax($ingot);
    	$ingotFee = getListFee($ingot);
    	$ingotTaxArray = intToCoinArray($ingotTax);
    	$ingotFeeArray = intToCoinArray($ingotFee);
    	
    	//Spiritwood plank
    	$plank = $dataArray['marketPlank'];
    	$plankTax = getTax($plank);
    	$plankFee = getListFee($plank);
    	$plankTaxArray = intToCoinArray($plankTax);
    	$plankFeeArray = intToCoinArray($plankFee);
    	
    	//Bolt of damask
    	$bolt = $dataArray['marketBolt'];
    	$boltTax = getTax($bolt);
    	$boltFee = getListFee($bolt);
    	$boltTaxArray = intToCoinArray($boltTax);
    	$boltFeeArray = intToCoinArray($boltFee);
    	
    	function getTaxArray($price) {
    		$taxArray = intToCoinArray(round($price * 0.05));
    		return $taxArray;
    	}
    	
    	// }
    
    	//Profits
    	$ingotProfitArray = calcProfits($ingot, $totalIngotCost, $ingotTax, $ingotFee);
    	$plankProfitArray = calcProfits($plank, $totalPlankCost, $plankTax, $plankFee);
    	$boltProfitArray = calcProfits($bolt, $totalBoltCost, $boltTax, $boltFee);
    	
    	//}
    		
    //	}
    
    // ---- Functions ---- {
    
    //Converts coin values to a real number for calculations
    function coinToInt($priceG, $priceS, $priceC) {
        $priceG = $priceG * 10000;
        $priceS = $priceS * 100;
        $priceConverted = $priceG + $priceS + $priceC;
        return $priceConverted;
    }
    
    //Converts an integer into an array of coin values for display
    function intToCoinArray($price) {
        $priceG = (int)($price / 10000);
        $price -= $priceG * 10000;
        $priceS = (int)($price / 100);
        $price -= $priceS * 100;
        $priceC = $price;
        $priceUnconverted = array($priceG, $priceS, $priceC);
        return $priceUnconverted;
    }
    
    /*
    //Unused
    
    // Converts a three-value coin array to a friendly string for representation
    function coinArrayToString($coinArray) {
        return sprintf("%sg %ss %sc",
            $coinArray[0], $coinArray[1], $coinArray[2]);
    }
    //Bah...  I love it!  Thanks  =)
    
    //Converts an integer value into a three-value array and then converts the array to a friendly string
    function intToCoinString($price) {
        $priceArray = intToCoinArray($price);
        return coinArrayToString($priceArray);
    }
    */
    
    //Generates the sales tax based on the price of the item passed to it
    function getTax($price) {
        $tax = round($price * 0.05);
        return $tax;
    }
    
    //Generates the listing fee based on the price of the item passed to it
    function getListFee($price) {
        $fee = round($price * 0.1);
        return $fee;
    }
    
    function calcProfits($itemCost, $costToMake, $tax, $listingFee) {
		$profitArray = intToCoinArray($itemCost - $costToMake - $tax - $listingFee);
		return $profitArray;
    }
    
    //  }
    
    

?>
<!DOCTYPE html>

<html lang="en">
	
	<head>
		<meta charset="UTF-8">
		<meta id="request-method" name="request-method" content="<?php echo htmlentities($_SERVER['REQUEST_METHOD']); ?>">
		<title>Profit Calculator</title>
		<link rel="stylesheet" href="style.css">
		<link rel="shortcut icon" href="resources/Gold_coin.ico">
		<script type="text/javascript" src="jQuery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="jQuery/jquery.color.js"></script>
		<script type="text/javascript" src="jQuery/jquery.color.svg-names.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript" src="APIscript.js"></script>
	</head>
	
	<body>
		<div class="header">
			<h1>Ascended Profits</h1>
		</div>
		
		<div class="container clearfix" id="get-prices">
			
			<form action="" method="post">
				<div class="item" id="ingot">
					
					<table>
						
						<thead>
							<tr>
								<th colspan=4><h2 class="itemTitle">- Deldrimor Steel Ingot -</h2></th>
							</tr>
						</thead>
						
						<tbody>
							
							<tr>
								<td><label for="marketIngot">Current market price:</label></td>
								<td><input type="text" id="delIngotG" size="1" maxlength="4" name="price_marketIngot_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="delIngotS" size="1" maxlength="2" name="price_marketIngot_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="delIngotC" size="1" maxlength="2" name="price_marketIngot_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<th colspan =4><h3>Lump of Mithrillium</h3></th>
							</tr>
							
							<tr>
								<td><label for="mith">Mith Ore:</label></td>
								<td><input type="text" id="mithG" size="1" maxlength="4" name="price_mith_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="mithS" size="1" maxlength="2" name="price_mith_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="mithC" size="1" maxlength="2" name="price_mith_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<td><label for="iron">Iron Ore:</label></td>
								<td><input type="text" id="ironG" size="1" maxlength="4" name="price_iron_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="ironS" size="1" maxlength="2" name="price_iron_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="ironC" size="1" maxlength="2" name="price_iron_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<td><label for="plat">Platinum Ore:</label></td>
								<td><input type="text" id="platG" size="1" maxlength="4" name="price_plat_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="platS" size="1" maxlength="2" name="price_plat_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="platC" size="1" maxlength="2" name="price_plat_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="item" id="plank">
					<table>
						
						<thead>
							<tr>
								<th colspan=4><h2 class="itemTitle">- Spiritwood Plank -</h2></th>
							</tr>
						</thead>
							
						<tbody>
							
							<tr>
								<td><label for="marketPlank">Current market price:</label></td>
								<td><input type="text" id="spiritPlankG" size="1" maxlength="4" name="price_marketPlank_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="spiritPlankS" size="1" maxlength="2" name="price_marketPlank_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="spiritPlankC" size="1" maxlength="2" name="price_marketPlank_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<th colspan=4><h3>Glob of Elderwood Residue</h3></th>
							</tr>
							
							<tr>
								<td><label for="elder">Elderwood Logs:</label></td>
								<td><input type="text" id="elderG" size="1" maxlength="4" name="price_elder_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="elderS" size="1" maxlength="2" name="price_elder_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="elderC" size="1" maxlength="2" name="price_elder_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<td><label for="soft">Soft Wood Logs:</label></td>
								<td><input type="text" id="softG" size="1" maxlength="4" name="price_soft_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="softS" size="1" maxlength="2" name="price_soft_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="softC" size="1" maxlength="2" name="price_soft_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<td><label for="seasoned">Seasoned Wood Logs:</label></td>
								<td><input type="text" id="seasonedG" size="1" maxlength="4" name="price_seasoned_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="seasonedS" size="1" maxlength="2" name="price_seasoned_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="seasonedC" size="1" maxlength="2" name="price_seasoned_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<td><label for="hard">Hard Wood Logs:</label></td>
								<td><input type="text" id="hardG" size="1" maxlength="4" name="price_hard_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="hardS" size="1" maxlength="2" name="price_hard_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="hardC" size="1" maxlength="2" name="price_hard_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>	
						</tbody>
					</table>
				</div>
				
				<div class="item" id="bolt">
					<table>
						
						<thead>
							<tr>
								<th colspan=4><h2 class="itemTitle">- Bolt of Damask -</h2></th>
							</tr>
						</thead>
						
						<tbody>
							
							<tr>
								<td><label for="marketBolt">Current market price:</label></td>
								<td><input type="text" id="boltDamaskG" size="1" maxlength="4" name="price_marketBolt_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="boltDamaskS" size="1" maxlength="2" name="price_marketBolt_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="boltDamaskC" size="1" maxlength="2" name="price_marketBolt_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<th colspan=4><h3>Spool of Silk Weaving Thread</h3></th>
							</tr>
							
							<tr>
								<td><label for="silk">Silk Scraps:</label></td>
								<td><input type="text" id="silkG" size="1" maxlength="4" name="price_silk_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="silkS" size="1" maxlength="2" name="price_silk_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="silkC" size="1" maxlength="2" name="price_silk_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<td><label for="wool">Wool Scraps:</label></td>
								<td><input type="text" id="woolG" size="1" maxlength="4" name="price_wool_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="woolS" size="1" maxlength="2" name="price_wool_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="woolC" size="1" maxlength="2" name="price_wool_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<td><label for="cotton">Cotton Scraps:</label></td>
								<td><input type="text" id="cottonG" size="1" maxlength="4" name="price_cotton_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="cottonS" size="1" maxlength="2" name="price_cotton_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="cottonC" size="1" maxlength="2" name="price_cotton_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
							
							<tr>
								<td><label for="linen">Linen Scraps:</label></td>
								<td><input type="text" id="linenG" size="1" maxlength="4" name="price_linen_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="linenS" size="1" maxlength="2" name="price_linen_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="linenC" size="1" maxlength="2" name="price_linen_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>	
						</tbody>
					</table>
				</div>
				
				<div class="item" id="special">
					<table>
						<thead>
							<tr>
								<th colspan=4><h2>- Misc Items -</h2></th>
							</tr>
						</thead>
						
						<tbody>
							<tr>
								<td><label for="ecto">Glob of Ectoplasm:</label></td>
								<td><input type="text" id="ectoG" size="1" maxlength="4" name="price_ecto_gold"><img src="resources/Gold_coin.ico" width="15"	height="15"></td>
								<td><input type="text" id="ectoS" size="1" maxlength="2" name="price_ecto_slvr"><img src="resources/Silver_coin.ico" width="15" height="15"></td>
								<td><input type="text" id="ectoC" size="1" maxlength="2" name="price_ecto_cppr"><img src="resources/Copper_coin.ico" width="15" height="15"></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div id="submitButton" class="clearfix">
					<ul>
						<li><button type="submit">Update!</button></li>
					</ul>
				</div>
			</form>
		</div>
			
		<div class="container clearfix" id="show-prices">
			
			<div class="item">
				<table>
					
					<thead>
						<tr>
							<th colspan=4><h2>- Ingot Profit -</h2></th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td><label for="salePrice">Current sale price: </label></td>
							<td><?= $marketIngotPrice[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $marketIngotPrice[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $marketIngotPrice[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><lable for="costToMake">Cost to make: </lable></td>
							<td>-<?= $totalIngotCostArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $totalIngotCostArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $totalIngotCostArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><label for="listingFee">Listing fee: </label></td>
							<td>-<?= $ingotFeeArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $ingotFeeArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $ingotFeeArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><label for="salesTax">Sales tax: </label></td>
							<td>-<?= $ingotTaxArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $ingotTaxArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $ingotTaxArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<th colspan=4><br></th>
						</tr>
						
						<tr>
							<td><label for="profit"><span id="profit"><b>Profit:</b></span></label></td>
							<td><?= $ingotProfitArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $ingotProfitArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $ingotProfitArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="item">
				<table>
					
					<thead>
						<tr>
							<th colspan=4><h2>- Plank Profit -</h2></th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td><label for="salePrice">Current sale price: </label></td>
							<td><?= $marketPlankPrice[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $marketPlankPrice[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $marketPlankPrice[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><lable for="costToMake">Cost to make: </lable></td>
							<td>-<?= $totalPlankCostArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $totalPlankCostArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $totalPlankCostArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><label for="listingFee">Listing fee: </label></td>
							<td>-<?= $plankFeeArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $plankFeeArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $plankFeeArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><label for="salesTax">Sales tax: </label></td>
							<td>-<?= $plankTaxArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $plankTaxArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $plankTaxArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<th colspan=4><br></th>
						</tr>
						
						<tr>
							<td><label for="profit"><span id="profit"><b>Profit:</b></span></label></td>
							<td><?= $plankProfitArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $plankProfitArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $plankProfitArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="item">
				<table>
					
					<thead>
						<tr>
							<th colspan=4><h2>- Bolt Profit -</h2></th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td><label for="salePrice">Current sale price: </label></td>
							<td><?= $marketBoltPrice[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $marketBoltPrice[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $marketBoltPrice[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><lable for="costToMake">Cost to make: </lable></td>
							<td>-<?= $totalBoltCostArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $totalBoltCostArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $totalBoltCostArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><label for="listingFee">Listing fee: </label></td>
							<td>-<?= $boltFeeArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $boltFeeArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $boltFeeArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<td><label for="salesTax">Sales tax: </label></td>
							<td>-<?= $boltTaxArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $boltTaxArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $boltTaxArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
						
						<tr>
							<th colspan=4><br></th>
						</tr>
						
						<tr>
							<td><label for="profit"><span id="profit"><b>Profit:</b></span></label></td>
							<td><?= $boltProfitArray[0] ?><img src="resources/Gold_coin.ico" width="15" height="15"></td>
							<td><?= $boltProfitArray[1] ?><img src="resources/Silver_coin.ico" width="15" height="15"></td>
							<td><?= $boltProfitArray[2] ?><img src="resources/Copper_coin.ico" width="15" height="15"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
        </div>
			
			<div class="footer">
				<strong>© Copyright 2015 and all that</strong>
			</div>
			
		</div>
	</body>
</html>