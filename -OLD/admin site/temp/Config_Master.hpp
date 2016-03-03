#define VITEMMACRO(NAME,DISPLAYNAME,VARNAME,WEIGHT,BUYPRICE,SELLPRICE,ILLEGAL,EDIBLE,ICON) class NAME { \
		displayName = DISPLAYNAME; \
		variable = VARNAME; \
		weight = WEIGHT; \
		buyPrice = BUYPRICE; \
		sellPrice = SELLPRICE; \
		illegal = ILLEGAL; \
		edible = EDIBLE; \
		icon = ICON; \
	};
	
#define LICENSEMACRO(NAME,DISPLAYNAME,VARNAME,PRICE,ILLEGAL,SIDE) class NAME { \
		displayName = DISPLAYNAME; \
		variable = VARNAME; \
		price = PRICE; \
		illegal = ILLEGAL; \
		side = SIDE; \
	};

#define true 1
#define false 0
#include "Config_Clothing.hpp"
#include "Config_Shops.hpp"


/*
	Master settings for various features and functionality	
*/
class Life_Settings {
	/* Persistent Settings */
	save_civ_weapons = true; //Allow civilians to save weapons on them?
	save_virtualItems = true; //Save Virtual items (all sides)?

	/* Revive system settings */
	revive_cops = false; //true to enable cops the ability to revive everyone or false for only medics/ems.
	revive_fee = 3000; //Revive fee that players have to pay and medics / EMS are rewarded
	
	/* House related settings */
	house_limit = 2; //Maximum amount of houses a player can own.
	house_other_limit = 3; //Maximum amount of garages a player can own.

	/* Gang related settings */
	gang_price = 75000; //Price for creating a gang, remember they are persistent so keep it reasonable to avoid millions of gangs.
	gang_upgradeBase = 10000; //The base cost for upgrading slots in a gang
	gang_upgradeMultiplier = 2.5; //Not sure if in use?

	/* Player-related systems */
	enable_fatigue = true; //Set to false to disable the ARMA 3 false system.
	total_maxWeight = 24; //Identifies the max carrying weight (gets adjusted throughout game when wearing different types of clothing).
	total_maxWeightT = 24;  //Static variable for the maximum weight allowed without having a backpack
	paycheck_period = 5; //Scaled in minutes
	
	/* Impound Variables */
	impound_car = 350; //Price for impounding cars
	impound_boat = 250; //Price for impounding boats
	impound_air = 850; //Price for impounding helicopters / planes

	/* Car-shop Settings */
	vehicleShop_rentalOnly[] = { "B_MRAP_01_hmg_F", "B_G_Offroad_01_armed_F" };

	/* Job-related stuff */
	delivery_points[] = { "dp_1", "dp_2", "dp_3", "dp_4", "dp_5", "dp_6", "dp_7", "dp_8", "dp_9", "dp_10", "dp_11", "dp_12", "dp_13", "dp_14", "dp_15", "dp_15", "dp_16", "dp_17", "dp_18", "dp_19", "dp_20", "dp_21", "dp_22", "dp_23", "dp_24", "dp_25" };

	crimes[] = { 
		{"STR_Crime_1","350","1"}, 		// Driving without lights
		{"STR_Crime_2","1500","2"}, 	// Driving without licence
		{"STR_Crime_3","2500","3"}, 	// Speeding
		{"STR_Crime_4","3500","4"}, 	// Reckless driving
		{"STR_Crime_5","10000","5"}, 	// Grand Theft Auto (stealing vehicle)
		{"STR_Crime_6","5000","6"}, 	// Hit and run
		{"STR_Crime_7","10000","7"} 	// Attempted murder
		// WTF? Prices are declared here... but then prices are also in life_server/functions/wantedsystem/fn_wantedAdd.sqf
		// So wtf, why are there prices here AND there? why not just use these prices and not waste time redeclaring them somewhere else?
	};
	
	sellArray[] = {
		{"arifle_sdar_F", 7500},
		{"hgun_P07_snds_F", 650},
		{"hgun_P07_F", 1500},
		{"ItemGPS", 45},
		{"ToolKit", 75},
		{"FirstAidKit", 65},
		{"Medikit", 450},
		{"NVGoggles", 980},
		{"16Rnd_9x21_Mag", 15},
		{"20Rnd_556x45_UW_mag", 35},
		{"ItemMap", 35},
		{"ItemCompass", 25},
		{"Chemlight_blue", 50},
		{"Chemlight_yellow", 50},
		{"Chemlight_green", 50},
		{"Chemlight_red", 50},
		{"hgun_Rook40_F", 500},
		{"arifle_Katiba_F", 5000},
		{"30Rnd_556x45_Stanag", 65},
		{"20Rnd_762x51_Mag", 85},
		{"30Rnd_65x39_caseless_green", 50},
		{"DemoCharge_Remote_Mag", 7500},
		{"SLAMDirectionalMine_Wire_Mag", 2575},
		{"optic_ACO_grn", 250},
		{"acc_flashlight", 100},
		{"srifle_EBR_F", 15000},
		{"arifle_TRG21_F", 3500},
		{"optic_MRCO", 5000},
		{"optic_Aco", 850},
		{"arifle_MX_F", 7500},
		{"arifle_MXC_F", 5000},
		{"arifle_MXM_F", 8500},
		{"MineDetector", 500},
		{"optic_Holosight", 275},
		{"acc_pointer_IR", 175},
		{"arifle_TRG20_F", 2500},
		{"SMG_01_F", 1500},
		{"arifle_Mk20C_F", 4500},
		{"30Rnd_45ACP_Mag_SMG_01", 60},
		{"30Rnd_9x21_Mag", 30}
	};

	allowedSavedVirtualItems[] = { "pickaxe", "fuelEmpty", "fuelFull", "spikeStrip", "lockpick", "defuseKit", "storageSmall", "storageBig", "redgull", "coffee", "waterBottle", "apple", "peach", "tbacon", "donut", "rabbitGrilled", "salemaGrilled", "ornateGrilled", "mackerelGrilled", "tunaGrilled", "mulletGrilled", "catsharkGrilled", "turtleSoup", "henGrilled", "roosterGrilled", "sheepGrilled", "goatGrilled", "goldbar", "blastingcharge", "boltcutter", "hazmatg", "oil_unprocessed", "oil_processed", "copper_unrefined", "copper_refined", "iron_unrefined", "iron_refined", "salt_unrefined", "salt_refined", "sand", "glass", "diamond_uncut", "diamond_cut", "rock", "cement", "uranium", "gold_ore", "gold_refined", "gold_washed", "gold", "heroin_unprocessed", "heroin_processed", "cannabis", "marijuana", "cocaine_unprocessed", "cocaine_processed", "rabbit_raw", "rabbit_grilled", "salema_raw", "salema_grilled", "ornate_raw", "ornate_grilled", "mackerel_raw", "mackerel_grilled", "tuna_raw", "tuna_grilled", "mullet_raw", "mullet_fried", "catshark_raw", "catshark_fried", "turtle_raw", "turtle_soup", "hen_raw", "hen_fried", "rooster_raw", "rooster_grilled", "sheep_raw", "sheep_grilled", "goat_raw", "goat_grilled", "bottledshine", "bottledwhiskey", "bottledbeer", "moonshine", "whiskey", "beerp", "mash", "rye", "hops", "yeast", "cornmeal", "bottles", "wool_unprocessed", "wool_processed", "sulfur", "potassium", "plastic", "silicon", "emptybarrel", "oilbarrel" };
};

//Virtual Items
class VirtualItems {
	//Misc
	VITEMMACRO(pickaxe, "STR_Item_Pickaxe", "pickaxe", 2, 750, 350, false, -1, "icons\ico_pickaxe.paa")
	VITEMMACRO(fuelEmpty, "STR_Item_FuelE", "fuelEmpty", 2, -1, -1, false, -1, "icons\ico_fuelempty.paa")
	VITEMMACRO(fuelFull, "STR_Item_FuelF", "fuelFull", 5, 850, 500, false, -1, "icons\ico_fuel.paa")
	VITEMMACRO(spikeStrip, "STR_Item_SpikeStrip", "spikeStrip", 15, 2500, 1200, false, -1, "icons\ico_spikestrip.paa")
	VITEMMACRO(lockpick, "STR_Item_Lockpick", "lockpick", 1, 150, 75, true, -1, "icons\ico_lockpick.paa")
	VITEMMACRO(goldbar, "STR_Item_GoldBar", "goldBar", 12, -1, 95000, true, -1, "icons\ico_goldbar.paa")
	VITEMMACRO(treasure, "STR_Item_Treasure", "treasure", 12, -1, 75000, false, -1, "icons\ico_goldbar.paa")
	VITEMMACRO(blastingcharge, "STR_Item_BCharge", "blastingCharge", 15, 35000, -1, true, -1, "icons\ico_blastingCharge.paa")
	VITEMMACRO(boltcutter, "STR_Item_BCutter", "boltCutter", 5, 7500, -1, true, -1, "icons\ico_boltcutters.paa")
	VITEMMACRO(defusekit, "STR_Item_DefuseKit", "defuseKit", 2, 2500, -1, false, -1, "icons\ico_defusekit.paa")
	VITEMMACRO(storagesmall, "STR_Item_StorageBS", "storageSmall", 5, 75000, -1, false, -1, "icons\ico_storageSmall.paa")
	VITEMMACRO(storagebig, "STR_Item_StorageBL", "storageBig", 10, 150000, -1, false, -1, "icons\ico_storageBig.paa")
    VITEMMACRO(hazmatg, "STR_Item_Hazmatg", "hazmatg", 1, 2000, 1000, false, -1, "icons\ico_fuel.paa")
    VITEMMACRO(wool_unprocessed, "STR_Item_WoolU", "woolunprocessed", 2, -1, -1, false, -1, "icons\ico_boltcutters.paa")
    VITEMMACRO(wool_processed, "STR_Item_WoolP", "woolprocessed", 1, -1, -1, false, -1, "icons\ico_boltcutters.paa")
    VITEMMACRO(sulfur, "STR_Item_Sulfur", "sulfur", 3, -1, -1, false, -1, "icons\ico_goldbar.paa")
    VITEMMACRO(potassium, "STR_Item_Potassium", "potassium", 2, -1, -1, false, -1, "icons\ico_saltu.paa")
    VITEMMACRO(plastic, "STR_Item_Plastic", "plastic", 2, -1, -1, false, -1,  "icons\ico_storageSmall.paa")
    VITEMMACRO(silicon, "STR_Item_Silicon", "silicon", 3, -1, -1, false, -1, "icons\ico_fuel.paa")
    VITEMMACRO(emptybarrel, "STR_Item_BarrelE", "emptybarrel", 5, -1, -1, false, -1, "icons\ico_fuel.paa")
    VITEMMACRO(oilbarrel, "STR_Item_BarrelO", "oilbarrel", 8, -1, -1, false, -1, "icons\ico_fuel.paa")
    VITEMMACRO(processedoil, "STR_Item_BarrelP", "processedoil", 6, -1, 4000, false, -1, "icons\ico_fuel.paa")
    VITEMMACRO(schem_m10, "STR_Item_SchM10", "schem_m10", 1, -1, -1, false, -1, "icons\ico_storageBig.paa")
    VITEMMACRO(schem_asp, "STR_Item_SchAsp", "schem_asp", 1, -1, -1, false, -1, "icons\ico_storageBig.paa")
    VITEMMACRO(schem_spm, "STR_Item_SchSpm", "schem_spm", 1, -1, -1, false, -1, "icons\ico_storageBig.paa")
    VITEMMACRO(schem_cyr, "STR_Item_SchCyr", "schem_cyr", 1, -1, -1, false, -1, "icons\ico_storageBig.paa")
    VITEMMACRO(electronics, "STR_Item_Electronics", "electronics", 1, -1, -1, false, -1, "icons\ico_storageBig.paa")

	//Mined Items
	VITEMMACRO(oil_unprocessed, "STR_Item_OilU", "oilUnprocessed", 7, -1, -1, false, -1, "icons\ico_oilu.paa")
	VITEMMACRO(oil_processed, "STR_Item_OilP", "oilProcessed", 6, -1, 3200, false, -1, "icons\ico_oilp.paa")
	VITEMMACRO(copper_unrefined, "STR_Item_CopperOre", "copperUnrefined", 4, -1, -1, false, -1, "icons\ico_copperu.paa")
	VITEMMACRO(copper_refined, "STR_Item_CopperIngot", "copperRefined", 3, -1, 1500, false, -1, "icons\ico_copperp.paa")
	VITEMMACRO(iron_unrefined, "STR_Item_IronOre", "ironUnrefined", 5, -1, -1, false, -1, "icons\ico_ironu.paa")
	VITEMMACRO(iron_refined, "STR_Item_IronIngot", "ironRefined", 3, -1, 3200, false, -1, "icons\ico_ironp.paa")
	VITEMMACRO(salt_unrefined, "STR_Item_Salt", "saltUnrefined", 3, -1, -1, false, -1, "icons\ico_saltu.paa")
	VITEMMACRO(salt_refined, "STR_Item_SaltR", "saltRefined", 1, -1, 1450, false, -1, "icons\ico_saltp.paa")
	VITEMMACRO(sand, "STR_Item_Sand", "sand", 3, -1, -1, false, -1, "icons\ico_sandu.paa")
	VITEMMACRO(glass, "STR_Item_Glass", "glass", 1, -1, 1450, false, -1, "icons\ico_glassp.paa")
	VITEMMACRO(diamond_uncut, "STR_Item_DiamondU", "diamondUncut", 4, -1, 750, false, -1, "icons\ico_diamondu.paa")
	VITEMMACRO(diamond_cut, "STR_Item_DiamondC", "diamondCut", 2, -1, 2000, false, -1, "icons\ico_diamondp.paa")
	VITEMMACRO(rock, "STR_Item_Rock", "rock", 6, -1, -1, false, -1, "icons\ico_rocku.paa")
	VITEMMACRO(cement, "STR_Item_CementBag", "cement", 5, -1, 1950, false, -1, "icons\ico_cementp.paa")
    VITEMMACRO(uranium, "STR_Item_Uranium", "uranium", 5, -1, 3500, false, -1, "icons\ico_fuel.paa")
    VITEMMACRO(gold_ore, "STR_Item_Goldore", "goldore", 6, -1, 4800, false, -1, "icons\ico_goldu.paa")
    VITEMMACRO(gold_refined, "STR_Item_GoldR", "goldr", 5, -1, 4800, false, -1, "icons\ico_goldr.paa")
    VITEMMACRO(gold_washed, "STR_Item_GoldW", "goldw", 6, -1, 4800, false, -1, "icons\ico_goldw.paa")
    VITEMMACRO(gold, "STR_Item_Gold", "gold", 4, -1, 4800, false, -1, "icons\ico_goldbar.paa")

	//Drugs
	VITEMMACRO(heroin_unprocessed, "STR_Item_HeroinU", "heroinUnprocessed", 6, -1, -1, true, -1, "icons\ico_heroinu.paa")
	VITEMMACRO(heroin_processed, "STR_Item_HeroinP", "heroinProcessed", 4, -1, 2560, true, -1, "icons\ico_heroinp.paa")
	VITEMMACRO(cannabis, "STR_Item_Cannabis", "cannabis", 4, -1, -1, true, -1, "icons\ico_cannabis.paa")
	VITEMMACRO(marijuana, "STR_Item_Marijuana", "marijuana", 3, -1, 2350, true, -1, "icons\ico_marijuana.paa")
	VITEMMACRO(cocaine_unprocessed, "STR_Item_CocaineU", "cocaineUnprocessed", 6, -1, 3000, true, -1, "icons\ico_cocaineu.paa")
	VITEMMACRO(cocaine_processed, "STR_Item_CocaineP", "cocaineProcessed", 4, -1, 5000, true, -1, "icons\ico_cocainep.paa")

	//Drink
	VITEMMACRO(redgull, "STR_Item_RedGull", "redgull", 1, 1500, 200, false, 100, "icons\ico_redgull.paa")
	VITEMMACRO(coffee, "STR_Item_Coffee", "coffee", 1, 10, 5, false, 100, "icons\ico_coffee.paa")
	VITEMMACRO(waterBottle, "STR_Item_WaterBottle", "waterBottle", 1, 10, 5, false, 100, "icons\ico_waterBottle.paa")

	//Food
	VITEMMACRO(apple, "STR_Item_Apple", "apple", 1, 65, 50, false, 10, "icons\ico_apple.paa")
	VITEMMACRO(peach, "STR_Item_Peach", "peach", 1, 68, 55, false, 10, "icons\ico_peach.paa")
	VITEMMACRO(tbacon, "STR_Item_TBacon", "tbacon", 1, 75, 25, false, 40, "icons\ico_tbacon.paa")
	VITEMMACRO(donut, "STR_Item_donuts", "donut", 1, 120, 60, false, 30, "icons\ico_donut.paa")
	VITEMMACRO(rabbit_raw, "STR_Item_Rabbit", "rabbitRaw", 2, -1, 65, false, -1, "icons\ico_rawMeat.paa")
	VITEMMACRO(rabbit_grilled, "STR_Item_RabbitGrilled", "rabbitGrilled", 1, 150, 115, false, 20, "icons\ico_cookedMeat.paa")
	VITEMMACRO(salema_raw, "STR_Item_Salema", "salemaRaw", 2, -1, 45, false, -1, "icons\ico_salema.paa")
	VITEMMACRO(salema_grilled, "STR_Item_SalemaGrilled", "salemaGrilled", 1, 75, 55, false, 30, "icons\ico_cookedMeat.paa")
	VITEMMACRO(ornate_raw, "STR_Item_OrnateMeat", "ornateRaw", 2, -1, 40, false, -1, "icons\ico_ornate.paa")
	VITEMMACRO(ornate_grilled, "STR_Item_OrnateGrilled", "ornateGrilled", 1, 175, 150, false, 25, "icons\ico_cookedMeat.paa")
	VITEMMACRO(mackerel_raw, "STR_Item_MackerelMeat", "mackerelRaw", 4, -1, 175, false, -1, "icons\ico_mackerel.paa")
	VITEMMACRO(mackerel_grilled, "STR_Item_MackerelGrilled", "mackerelGrilled", 2, 250, 200, false, 30, "icons\ico_mackerel_cooked.paa")
	VITEMMACRO(tuna_raw, "STR_Item_TunaMeat", "tunaRaw", 6, -1, 700, false, -1, "icons\ico_tuna.paa")
	VITEMMACRO(tuna_grilled, "STR_Item_TunaGrilled", "tunaGrilled", 3, 1250, 1000, false, 100, "icons\ico_cookedMeat.paa")
	VITEMMACRO(mullet_raw, "STR_Item_MulletMeat", "mulletRaw", 4, -1, 250, false, -1, "icons\ico_mullet.paa")
	VITEMMACRO(mullet_fried, "STR_Item_MulletFried", "mulletFried", 2, 600, 400, false, 80, "icons\ico_cookedMeat.paa")
	VITEMMACRO(catshark_raw, "STR_Item_CatSharkMeat", "catsharkRaw", 6, -1, 300, false, -1, "icons\ico_catshark.paa")
	VITEMMACRO(catshark_fried, "STR_Item_CatSharkFried", "catsharkFried", 3, 750, 500, false, 100, "icons\ico_cookedMeat.paa")
	VITEMMACRO(turtle_raw, "STR_Item_TurtleMeat", "turtleRaw", 6, 4000, 3000, true, -1, "icons\ico_turtle.paa")
	VITEMMACRO(turtle_soup, "STR_Item_TurtleSoup", "turtleSoup", 2, 2500, 1000, false, 100, "icons\ico_turtleSoup.paa")
	VITEMMACRO(hen_raw, "STR_Item_HenRaw", "henRaw", 1, -1, 35, false, -1, "icons\ico_rawMeat.paa")
	VITEMMACRO(hen_fried, "STR_Item_HenFried", "henFried", 1, 115, 85, false, 65, "icons\ico_cookedMeat.paa")
	VITEMMACRO(rooster_raw, "STR_Item_RoosterRaw", "roosterRaw", 1, -1, 35, false, -1, "icons\ico_rawMeat.paa")
	VITEMMACRO(rooster_grilled, "STR_Item_RoosterGrilled", "roosterGrilled", 115, 85, false, 45, "icons\ico_cookedMeat.paa")
	VITEMMACRO(sheep_raw, "STR_Item_SheepRaw", "sheepRaw", 2, -1, 50, false, -1, "icons\ico_rawMeat.paa")
	VITEMMACRO(sheep_grilled, "STR_Item_SheepGrilled", "sheepGrilled", 2, 155, 115, false, 100, "icons\ico_cookedMeat.paa")
	VITEMMACRO(goat_raw, "STR_Item_GoatRaw", "goatRaw", 2, -1, 75, false, -1, "icons\ico_rawMeat.paa")
	VITEMMACRO(goat_grilled, "STR_Item_GoatGrilled", "goatGrilled", 2, 175, 135, false, 100, "icons\ico_cookedMeat.paa")
    
    //Alcohol
    VITEMMACRO(bottledshine, "STR_Item_BottledShine","bottledshine",2,12500,10000,true,-1,"ico_moonshine.paa")
    VITEMMACRO(bottledwhiskey, "STR_Item_BottledWhiskey","bottledwhiskey",2,8000,5000,false,-1,"ico_vodka.paa")
    VITEMMACRO(bottledbeer, "STR_Item_BottledBeer","bottledbeer",2,6000,4000,false,-1,"ico_beer.paa")
    VITEMMACRO(moonshine, "STR_Item_Moonshine","moonshine",2,8000,7000,true,-1,"")
    VITEMMACRO(whiskey, "STR_Item_Whiskey","whiskey",2,5000,4500,false,-1,"")
    VITEMMACRO(beerp, "STR_Item_Beerp","beerp",2,5000,4500,false,-1,"")
    VITEMMACRO(mash, "STR_Item_Mash","mash",2,3000,2500,false,-1,"")
    VITEMMACRO(rye, "STR_Item_Rye","rye",2,2500,2000,false,-1,"")
    VITEMMACRO(hops, "STR_Item_Hops","hops",2,2000,1800,false,-1,"")
    VITEMMACRO(yeast, "STR_Item_Yeast","yeast",2,2100,2000,false,-1,"")
    VITEMMACRO(cornmeal, "STR_Item_Cornmeal","cornmeal",2,500,200,false,-1,"")
    VITEMMACRO(bottles, "STR_Item_Bottles","bottles",2,100,75,false,-1,"")
};


/*
	Licenses
	
	Params:
	CLASS ENTRY,DisplayName,VariableName,price,illegal,side indicator
*/
class Licenses {
	// Police
	LICENSEMACRO(cAir,"STR_License_Pilot","cAir",15000,false,"cop")
	LICENSEMACRO(coastguard,"STR_License_CG","cg",8000,false,"cop")
	// Medic
	LICENSEMACRO(mAir,"STR_License_Pilot","mAir",15000,false,"med")
	// Civilian
	LICENSEMACRO(driver,"STR_License_Driver","driver",500,false,"civ")
	LICENSEMACRO(boat,"STR_License_Boat","boat",1000,false,"civ")
	LICENSEMACRO(pilot,"STR_License_Pilot","pilot",25000,false,"civ")
	LICENSEMACRO(gun,"STR_License_Firearm","gun",10000,false,"civ")
	LICENSEMACRO(dive,"STR_License_Diving","dive",2000,false,"civ")
	LICENSEMACRO(oil,"STR_License_Oil","oil",100000,false,"civ")
	LICENSEMACRO(heroin,"STR_License_Heroin","heroin",25000,true,"civ")
	LICENSEMACRO(marijuana,"STR_License_Marijuana","marijuana",19500,true,"civ")
	LICENSEMACRO(medmarijuana,"STR_License_Medmarijuana","medmarijuana",15000,false,"civ")
	LICENSEMACRO(rebel,"STR_License_Rebel","rebel",75000,true,"civ")
	LICENSEMACRO(truck,"STR_License_Truck","truck",20000,false,"civ")
	LICENSEMACRO(diamond,"STR_License_Diamond","diamond",35000,false,"civ")
	LICENSEMACRO(salt,"STR_License_Salt","salt",12000,false,"civ")
	LICENSEMACRO(cocaine,"STR_License_Cocaine","cocaine",30000,false,"civ")
	LICENSEMACRO(sand,"STR_License_Sand","sand",14500,false,"civ")
	LICENSEMACRO(iron,"STR_License_Iron","iron",9500,false,"civ")
	LICENSEMACRO(copper,"STR_License_Copper","copper",8000,false,"civ")
	LICENSEMACRO(cement,"STR_License_Cement","cement",6500,false,"civ")
	LICENSEMACRO(home,"STR_License_Home","home",75000,false,"civ")
    LICENSEMACRO(uranium,"STR_License_Uranium","uranium",80000,false,"civ")
    LICENSEMACRO(stiller,"STR_License_Stiller","stiller",50000,false,"civ")
    LICENSEMACRO(liquor,"STR_License_Liquor","liquor",100000,false,"civ")
    LICENSEMACRO(bottler,"STR_License_Bottler","bottler",100000,false,"civ")
    LICENSEMACRO(mash,"STR_License_Mash","mash",100000,false,"civ")
	LICENSEMACRO(gold,"STR_License_Gold","gold",10000,false,"civ")
};

class VirtualShops {
	// Police
	class cop {
		name = "STR_Shops_Cop";
		items[] = { "donut", "coffee", "spikeStrip", "waterBottle", "rabbit_grilled", "apple", "redgull", "fuelFull", "defusekit" };
	};

	// Medic
	class med {
		name = "STR_Shops_Market";
		items[] = { "waterBottle", "rabbit_grilled", "apple", "redgull", "tbacon", "lockpick", "fuelFull", "peach" };
	};

	// Civilian
	class market {
		name = "STR_Shops_Market";
		items[] = { "waterBottle", "rabbit_grilled", "apple", "redgull", "tbacon", "lockpick", "pickaxe", "fuelFull", "peach", "storagesmall", "storagebig", "hazmatg" };
	};

	class coffee {
		name = "STR_Shops_Coffee";
		items[] = { "coffee", "donut" };
	};

	// Rebel/Gang
	class rebel {
		name = "STR_Shops_Rebel";
		items[] = { "waterBottle", "rabbit_grilled", "apple", "redgull", "tbacon", "lockpick", "pickaxe", "fuelFull", "peach", "boltcutter", "blastingcharge" };
	};

	class gang {
		name = "STR_Shops_Gang";
		items[] = { "waterBottle", "rabbit_grilled", "apple", "redgull", "tbacon", "lockpick", "pickaxe", "fuelFull", "peach", "boltcutter", "blastingcharge" };
	};

	// Illegal Activities
	class wongs {
		name = "STR_Shops_Wongs";
		items[] = { "turtle_soup", "turtle_raw" };
	};
	
	class drugdealer {
		name = "STR_Shops_DrugDealer";
		items[] = { "cocaine_processed", "heroin_processed", "marijuana" };
	};

	// Legal Activity / Shop combos
	class bar {
        name = "Bar";
        items[] = { "bottledbeer", "bottledwhiskey", "cornmeal", "bottles" };
    };
    
    class speakeasy {
        name = "Speakeasy";
        items[] = { "bottledwhiskey", "bottledshine", "bottledbeer", "moonshine" };
    };

    class fishmarket {
		name = "STR_Shops_FishMarket";
		items[] = { "salema_raw", "salema_grilled", "ornate_raw", "ornate_grilled", "mackerel_raw", "mackerel_grilled", "tuna_raw", "tuna_grilled", "mullet_raw", "mullet_fried", "catshark_raw", "catshark_fried" };
	};

	// Legal Activity
	class oil {
		name = "STR_Shops_Oil";
		items[] = { "oil_processed", "pickaxe", "fuelFull" };
	};

	class glass {
		name = "STR_Shops_Glass";
		items[] = { "glass" };
	};

	class iron  {
		name = "STR_Shops_Minerals";
		items[] = { "iron_refined", "copper_refined" };
	};

	class diamond {
		name = "STR_Shops_Diamond";
		items[] = { "diamond_uncut", "diamond_cut", "gold" };
	};

	class salt {
		name = "STR_Shops_Salt";
		items[] = { "salt_refined" };
	};

	class cement {
		name = "STR_Shops_Cement";
		items[] = { "cement" };
	};

	class gold {
		name = "STR_Shops_Gold";
		items[] = { "goldbar" };
	};
    
    class uranium {
        name = "STR_Shops_Uranium";
        items[] = { "euranium", "uranium" };
    };
    
    class Prospector {
        name = "Treasure Hunter";
        items[] = { "treasure" };
    };
};

#include "Config_Vehicles.hpp"
#include "Config_Houses.hpp"
#include "Config_Lighting.hpp"
#include "Config_Placeables.hpp"