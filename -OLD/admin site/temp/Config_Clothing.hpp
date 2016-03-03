/*
	ARRAY FORMAT:
		0: STRING (Classname)
		1: STRING (Display Name, leave as "" for default)
		2: SCALAR (Price)
		4: ARRAY (This is for limiting items to certain things)
			0: Variable to read from
			1: Variable Value Type
			2: What to compare to
*/
class Clothing {
	// Police
	class cop {
		title = "STR_Shops_C_Police";
		license = "";
		side = "cop";

		uniforms[] = {
			{ "NONE", "Remove Uniform", 0, { "", "", -1 } },
			{ "U_Rangemaster", "Cop Uniform", 100, { "", "", -1 } },
			{ "U_B_Wetsuit", "Wetsuit", 500, { "life_ogCop719", "SCALAR", 2 } },
			{ "U_B_CombatUniform_mcam_worn", "SPG Black Uniform", 100, { "life_ogCop719", "SCALAR", 9 } },
			{ "U_B_CombatUniform_mcam", "SPG Multicam Uniform", 100, { "life_ogCop719", "SCALAR", 9 } },
			{ "U_I_CombatUniform", "Combat Fatigues", 2500, { "life_ogCop719", "SCALAR", 10 } },
			{ "U_B_CombatUniform_mcam_vest", "Recon Fatigues", 2500, { "life_ogCop719", "SCALAR", 10 } },
			{ "U_B_HeliPilotCoveralls", "Pilot Uniform", 100, { "life_ozCopPilotLvl", "SCALAR", 1 } }
		};

		headgear[] = {
			{ "NONE", "Remove Hat", 0, { "", "", -1 } },
			{ "H_Cap_police", "", 100, { "", "", -1 } },
			{ "H_HelmetB_plain_blk", "", 100, { "life_ogCop719", "SCALAR", 2 } },
			{ "H_Watchcap_blk", "Sniper Beanie", 1500, { "life_ogCop719", "SCALAR", 7 } },
			{ "H_HelmetSpecB_blk", "SPG Helmet Black", 1500, { "life_ogCop719", "SCALAR", 9 } },
			{ "H_Beret_blk_POLICE", "", 100, { "life_ogCop719", "SCALAR", 20 } },
			{ "H_CrewHelmetHeli_B", "Crewman Helmet", 1000, { "life_ozCopPilotLvl", "SCALAR", 1 } },
			{ "H_PilotHelmetHeli_B", "Pilot Helmet", 1000, { "life_ozCopPilotLvl", "SCALAR", 2 } }
		};

		goggles[] = {
			{ "NONE", "Remove Glasses", 0, { "", "", -1 } },
			{ "G_Shades_Black", "", 25, { "", "", -1 } },
			{ "G_Shades_Blue", "", 20, { "", "", -1 } },
			{ "G_Sport_Blackred", "", 20, { "", "", -1 } },
			{ "G_Sport_Checkered", "", 20, { "", "", -1 } },
			{ "G_Sport_Blackyellow", "", 20, { "", "", -1 } },
			{ "G_Sport_BlackWhite", "", 20, { "", "", -1 } },
			{ "G_Aviator", "", 10, { "", "", -1 } },
			{ "G_Squares", "", 100, { "", "", -1 } },
			{ "G_Lowprofile", "", 150, { "", "", -1 } },
			{ "G_Combat", "", 150, { "", "", -1 } },
			{ "G_Diving", "", 150, { "life_ozCopPilotLvl", "SCALAR", 2 } },
			{ "G_tactical_black", "", 30, { "life_ozCopPilotLvl", "SCALAR", 7 } }
		};

		vests[] = {
			{ "NONE", "Remove Vest", 0, { "", "", -1 } },
			{ "V_Rangemaster_belt", "", 800, { "", "", -1 } },
			{ "V_TacVest_blk_POLICE", "", 1500, { "life_ogCop719", "SCALAR", 1 } },
			{ "V_RebreatherB", "", 2500, { "life_ogCop719", "SCALAR", 2 } },
			{ "V_PlateCarrier2_rgr", "SPG Vest", 4000, { "life_ogCop719", "SCALAR", 9 } },
			{ "V_PlateCarrier1_blk", "SPG Vest 2", 4000, { "life_ogCop719", "SCALAR", 9 } }
		};

		backpacks[] = {
			{ "NONE", "Remove Backpack", 0, { "", "", -1 } },
			{ "B_Bergen_blk", "", 800, { "", "", -1 } },
			{ "B_Parachute", "", 500, { "", "", -1 } },
			{ "B_Bergen_sgg", "SPG Backpack", 4000, { "life_ogCop719", "SCALAR", 7 } },
			{ "G_AssaultPack", "Unmarked Backpack", 4000, { "life_ogCop719", "SCALAR", 7 } }
		};
	};

	class cop_spg {
		title = "STR_Shops_C_Police_SPG";
		license = "";
		side = "cop";

		uniforms[] = {};
		headgear[] = {};
		goggles[] = {};
		vests[] = {};
		backpacks[] = {};
	};

	class cop_undercover {
		title = "STR_Shops_C_Police_UC";
		license = "";
		side = "cop";

		uniforms[] = {
			{ "NONE", "Remove Uniform", 0, { "", "", -1 } },
			{ "U_C_Hunterbody_grn", "The Hunters Look", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_C_Poloshirt_blue", "Poloshirt Blue", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_C_Poloshirt_burgundy", "Poloshirt Burgundy", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_C_Poloshirt_redwhite", "Poloshirt Red/White", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_C_Poloshirt_salmon", "Poloshirt Salmon", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_C_Poloshirt_stripped", "Poloshirt Stripped", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_C_Poloshirt_tricolour", "Poloshirt Tricolor", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_C_Poor_2", "Rag Tagged Clothes", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_C_WorkerCoveralls", "Mechanic Coveralls", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_I_G_resistanceLeader_F", "Combat Fatigues (Stavrou)", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_IG_Guerilla2_3", "The Outback Rangler", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_IG_Guerilla3_1", "Brown Jacket & Pants", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "U_IG_leader", "Guerilla Leader", 100, { "life_ogCopUndercover", "BOOL", true } }
		};

		headgear[] = {
			{ "NONE", "Remove Hat", 0, { "", "", -1 } },
			{ "H_Booniehat_dirty", "", 1500, { "life_ogCopUndercover", "BOOL", true } },
			{ "H_Booniehat_dgtl", "", 1500, { "life_ogCopUndercover", "BOOL", true } },
			{ "H_Hat_tan", "", 100, { "life_ogCopUndercover", "BOOL", true } }
		};

		goggles[] = {
			{ "NONE", "Remove Glasses", 0, { "", "", -1 } },
			{ "G_Bandanna_beast", "", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "G_Bandanna_aviator", "", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "G_Bandanna_sport", "", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "G_Balaclava_lowprofile", "", 100, { "life_ogCopUndercover", "BOOL", true } },
			{ "G_Balaclava_oli", "", 100, { "life_ogCopUndercover", "BOOL", true } }
		};

		vests[] = {
			{ "NONE", "Remove Vest", 0, { "", "", -1 } },
			{ "V_HarnessO_brn", "", 4000, { "life_ogCopUndercover", "BOOL", true } },
			{ "V_BandollierB_rgr", "Unmarked Bandolier", 4000, { "life_ogCopUndercover", "BOOL", true } },
			{ "V_PlateCarrier1_rgr", "Unmarked Vest", 4000, { "life_ogCopUndercover", "BOOL", true } },
			{ "V_TacVest_khk", "", 12500, { "life_ogCopUndercover", "BOOL", true } }
		};

		backpacks[] = {
			{ "NONE", "Remove Backpack", 0, { "life_ogCopUndercover", "BOOL", true } },
			{ "B_AssaultPack_cbr", "", 2500, { "life_ogCopUndercover", "BOOL", true } },
			{ "B_Kitbag_mcamo", "", 4500, { "life_ogCopUndercover", "BOOL", true } },
			{ "B_TacticalPack_oli", "", 3500, { "life_ogCopUndercover", "BOOL", true } },
			{ "B_FieldPack_ocamo", "", 3000, { "life_ogCopUndercover", "BOOL", true } },
			{ "B_Bergen_sgg", "", 4500, { "life_ogCopUndercover", "BOOL", true } },
			{ "B_Kitbag_cbr", "", 4500, { "life_ogCopUndercover", "BOOL", true } },
			{ "B_Carryall_oli", "", 5000, { "life_ogCopUndercover", "BOOL", true } },
			{ "B_Carryall_khk", "", 5000, { "life_ogCopUndercover", "BOOL", true } }
		};
	};

	// Medic
	class med {
		title = "STR_Shops_C_Medic";
		license = "";
		side = "med";

		uniforms[] = {
			{ "NONE", "Remove Uniform", 0, { "", "", -1 } },
			{ "U_I_CombatUniform", "", 500, { "", "", -1 } }
		};

		headgear[] = {
			{ "NONE", "Remove Hat", 0, { "", "", -1 } },
			{ "H_Cap_blu", "", 100, { "", "", -1 } }
		};

		goggles[] = {
			{ "NONE", "Remove Glasses", 0, { "", "", -1 } },
			{ "G_Shades_Black", "", 25, { "", "", -1 } },
			{ "G_Shades_Blue", "", 20, { "", "", -1 } },
			{ "G_Sport_Blackred", "", 20, { "", "", -1 } },
			{ "G_Sport_Checkered", "", 20, { "", "", -1 } },
			{ "G_Sport_Blackyellow", "", 500, { "", "", -1 } },
			{ "G_Sport_BlackWhite", "", 20, { "", "", -1 } },
			{ "G_Squares", "", 10, { "", "", -1 } },
			{ "G_Aviator", "", 100, { "", "", -1 } },
			{ "G_Lady_Mirror", "", 150, { "", "", -1 } },
			{ "G_Lady_Dark", "", 150, { "", "", -1 } },
			{ "G_Lady_Blue", "", 150, { "", "", -1 } },
			{ "G_Lowprofile", "", 30, { "", "", -1 } }
		};

		vests[] = {
			{ "NONE", "Remove Vest", 0, { "", "", -1 } },
			{ "V_RebreatherB", "", 5000, { "", "", -1 } },
			{ "V_Rangemaster_belt", "", 800, { "", "", -1 } },
		};

		backpacks[] = {
			{ "NONE", "Remove Backpack", 0, { "", "", -1 } },
			{ "B_AssaultPack_khk", "", 800, { "", "", -1 } }
		};
	};

	// Civilian
	class bruce {
		title = "STR_Shops_C_Bruce";
		license = "";
		side = "civ";

		uniforms[] = {
			{ "NONE", "Remove Uniform", 0, { "", "", -1 } },
			{ "U_C_Poloshirt_blue", "Poloshirt Blue", 250, { "", "", -1 } },
			{ "U_C_Poloshirt_burgundy", "Poloshirt Burgundy", 275, { "", "", -1 } },
			{ "U_C_Poloshirt_redwhite", "Poloshirt Red/White", 150, { "", "", -1 } },
			{ "U_C_Poloshirt_salmon", "Poloshirt Salmon", 175, { "", "", -1 } },
			{ "U_C_Poloshirt_stripped", "Poloshirt stripped", 125, { "", "", -1 } },
			{ "U_C_Poloshirt_tricolour", "Poloshirt Tricolor", 350, { "", "", -1 } },
			{ "U_C_Poor_2", "Rag tagged clothes", 250, { "", "", -1 } },
			{ "U_IG_Guerilla2_2", "Green stripped shirt & Pants", 650, { "", "", -1 } },
			{ "U_IG_Guerilla3_1", "Brown Jacket & Pants", 735, { "", "", -1 } },
			{ "U_IG_Guerilla2_3", "The Outback Rangler", 1200, { "", "", -1 } },
			{ "U_C_HunterBody_grn", "The Hunters Look", 1500, { "", "", -1 } },
			{ "U_C_WorkerCoveralls", "Mechanic Coveralls", 2500, { "", "", -1 } },
			{ "U_OrestesBody", "Surfing On Land", 1100, { "", "", -1 } },
			{ "U_NikosAgedBody", "Casual Wears", 5000, { "", "", -1 } },
			{ "U_I_G_Story_Protagonist_F", "Workers Camos", 5000, { "", "", -1 } },
			{ "U_C_Journalist", "Press Uniform", 5000, { "", "", -1 } }
		};

		headgear[] = {
			{ "NONE", "Remove Hat", 0, { "", "", -1 } },
			{ "H_Bandanna_camo", "Camo Bandanna", 120, { "", "", -1 } },
			{ "H_Bandanna_surfer", "Surfer Bandanna", 130, { "", "", -1 } },
			{ "H_Bandanna_gry", "Grey Bandanna", 150, { "", "", -1 } },
			{ "H_Bandanna_cbr", "", 165, { "", "", -1 } },
			{ "H_Bandanna_khk", "Khaki Bandanna", 145, { "", "", -1 } },
			{ "H_Bandanna_sgg", "Sage Bandanna", 160, { "", "", -1 } },
			{ "H_StrawHat", "Straw Fedora", 225, { "", "", -1 } },
			{ "H_BandMask_blk", "Hat & Bandanna", 300, { "", "", -1 } },
			{ "H_Booniehat_tan", "", 425, { "", "", -1 } },
			{ "H_Hat_blue", "", 310, { "", "", -1 } },
			{ "H_Hat_brown", "", 276, { "", "", -1 } },
			{ "H_Hat_checker", "", 340, { "", "", -1 } },
			{ "H_Hat_grey", "", 280, { "", "", -1 } },
			{ "H_Hat_tan", "", 265, { "", "", -1 } },
			{ "H_Cap_blu", "", 150, { "", "", -1 } },
			{ "H_Cap_grn", "", 150, { "", "", -1 } },
			{ "H_Cap_grn_BI", "", 150, { "", "", -1 } },
			{ "H_Cap_oli", "", 150, { "", "", -1 } },
			{ "H_Cap_red", "", 150, { "", "", -1 } },
			{ "H_Cap_tan", "", 150, { "", "", -1 } },
			{ "H_Cap_blk_CMMG", "Guns Club", 150, { "", "", -1 } },
			{ "H_Cap_blk_ION", "ION Supporter", 150, { "", "", -1 } },
			{ "H_Cap_press", "Press Hat", 400, { "", "", -1 } }
		};

		goggles[] = {
			{ "NONE", "Remove Glasses", 0, { "", "", -1 } },
			{ "G_Shades_Black", "", 25, { "", "", -1 } },
			{ "G_Shades_Blue", "", 20, { "", "", -1 } },
			{ "G_Sport_Blackred", "", 20, { "", "", -1 } },
			{ "G_Sport_Checkered", "", 20, { "", "", -1 } },
			{ "G_Sport_Blackyellow", "", 20, { "", "", -1 } },
			{ "G_Sport_BlackWhite", "", 20, { "", "", -1 } },
			{ "G_Squares", "", 10, { "", "", -1 } },
			{ "G_Aviator", "", 100, { "", "", -1 } },
			{ "G_Lady_Mirror", "", 150, { "", "", -1 } },
			{ "G_Lady_Dark", "", 150, { "", "", -1 } },
			{ "G_Lady_Blue", "", 150, { "", "", -1 } },
			{ "G_Lowprofile", "", 30, { "", "", -1 } }
		};

		vests[] = {
			{ "NONE", "Remove Vest", 0, { "", "", -1 } },
			{ "V_Rangemaster_belt", "", 850, { "", "", -1 } },
			{ "V_Press_F", "", 5000, { "", "", -1 } }
		};

		backpacks[] = {
			{ "NONE", "Remove Backpack", 0, { "", "", -1 } },
			{ "B_AssaultPack_cbr", "", 2500, { "", "", -1 } },
			{ "B_Kitbag_mcamo", "", 4500, { "", "", -1 } },
			{ "B_TacticalPack_oli", "", 3500, { "", "", -1 } },
			{ "B_FieldPack_ocamo", "", 3000, { "", "", -1 } },
			{ "B_Bergen_sgg", "", 4500, { "", "", -1 } },
			{ "B_Kitbag_cbr", "", 4500, { "", "", -1 } },
			{ "B_Carryall_oli", "", 5000, { "", "", -1 } },
			{ "B_Carryall_khk", "", 5000, { "", "", -1 } }
		};
	};

	class dive {
		title = "STR_Shops_C_Diving";
		license = "dive";
		side = "civ";

		uniforms[] = {
			{ "NONE", "Remove Uniform", 0, { "", "", -1 } },
			{ "U_B_Wetsuit", "", 2000, { "", "", -1 } }
		};

		headgear[] = {
			{ "NONE", "Remove Hat", 0, { "", "", -1 } }
		};

		goggles[] = {
			{ "NONE", "Remove Glasses", 0, { "", "", -1 } },
			{ "G_Diving", "", 500, { "", "", -1 } }
		};

		vests[] = {
			{ "NONE", "Remove Vest", 0, { "", "", -1 } },
			{ "V_RebreatherB", "", 5000, { "", "", -1 } }
		};

		backpacks[] = {
			{ "NONE", "Remove Backpack", 0, { "", "", -1 } }
		};
	};

	class kart {
		title = "STR_Shops_C_Kart";
		license = "";
		side = "civ";

		uniforms[] = {
			{ "NONE", "Remove Uniform", 0, { "", "", -1 } },
			{ "U_C_Driver_1_black", "", 1500, { "", "", -1 } },
			{ "U_C_Driver_1_blue", "", 1500, { "", "", -1 } },
			{ "U_C_Driver_1_red", "", 1500, { "", "", -1 } },
			{ "U_C_Driver_1_orange", "", 1500, { "", "", -1 } },
			{ "U_C_Driver_1_green", "", 1500, { "", "", -1 } },
			{ "U_C_Driver_1_white", "", 1500, { "", "", -1 } },
			{ "U_C_Driver_1_yellow", "", 1500, { "", "", -1 } },
			{ "U_C_Driver_2", "", 3500, { "", "", -1 } },
			{ "U_C_Driver_1", "", 3600, { "", "", -1 } },
			{ "U_C_Driver_3", "", 3700, { "", "", -1 } },
			{ "U_C_Driver_4", "", 3700, { "", "", -1 } }
		};

		headgear[] = {
			{ "NONE", "Remove Hat", 0, { "", "", -1 } },
			{ "H_RacingHelmet_1_black_F", "", 1000, { "", "", -1 } },
			{ "H_RacingHelmet_1_red_F", "", 1000, { "", "", -1 } },
			{ "H_RacingHelmet_1_white_F", "", 1000, { "", "", -1 } },
			{ "H_RacingHelmet_1_blue_F", "", 1000, { "", "", -1 } },
			{ "H_RacingHelmet_1_yellow_F", "", 1000, { "", "", -1 } },
			{ "H_RacingHelmet_1_green_F", "", 1000, { "", "", -1 } },
			{ "H_RacingHelmet_1_F", "", 2500, { "", "", -1 } },
			{ "H_RacingHelmet_2_F", "", 2500, { "", "", -1 } },
			{ "H_RacingHelmet_3_F", "", 2500, { "", "", -1 } },
			{ "H_RacingHelmet_4_F", "", 2500, { "", "", -1 } }
		};

		goggles[] = {
			{ "NONE", "Remove Glasses", 0, { "", "", -1 } }
		};

		vests[] = {
			{ "NONE", "Remove Vest", 0, { "", "", -1 } }
		};

		backpacks[] = {
			{ "NONE", "Remove Backpack", 0, { "", "", -1 } }
		};
	};

	// Rebel
	class reb {
		title = "STR_Shops_C_Rebel";
		license = "rebel";
		side = "civ";

		uniforms[] = {
			{ "NONE", "Remove Uniform", 0, { "", "", -1 } },
			{ "U_IG_Guerilla1_1", "", 5000, {"", "", -1} },
			{ "U_IG_Guerilla2_2", "", 5000, { "", "", -1 } },
			{ "U_IG_Guerilla2_3", "", 5000, { "", "", -1 } },
			{ "U_IG_Guerilla3_1", "", 5000, { "", "", -1 } },
			{ "U_I_G_Story_Protagonist_F", "", 7500, { "", "", -1 } },
			{ "U_I_G_resistanceLeader_F", "", 11500, { "", "", -1 } },
			{ "U_O_SpecopsUniform_ocamo", "", 17500, { "", "", -1 } },
			{ "U_B_SpecopsUniform_sgg", "", 50000, { "", "", -1 } },
			{ "U_O_CombatUniform_oucamo", "", 50000, { "", "", -1 } },
			{ "U_O_PilotCoveralls", "", 15610, { "", "", -1 } },
			{ "U_B_PilotCoveralls", "", 15610, { "", "", -1 } },
			{ "U_IG_leader", "Guerilla Leader", 15340, { "", "", -1 } },
			{ "U_O_GhillieSuit", "", 50000, { "", "", -1 } },
			{ "U_I_GhillieSuit", "", 50000, { "", "", -1 } },
			{ "U_B_FullGhillie_lsh", "", 65000, { "", "", -1 } },
			{ "U_I_FullGhillie_sard", "", 65000, { "", "", -1 } }
		};

		headgear[] = {
			{ "NONE", "Remove Hat", 0, { "", "", -1 } },
			{ "H_Beret_red", "", 1000, { "", "", -1 } },
			{ "H_ShemagOpen_tan", "", 850, { "", "", -1 } },
			{ "H_Shemag_olive", "", 800, { "", "", -1 } },
			{ "H_ShemagOpen_khk", "", 800, { "", "", -1 } },
			{ "H_HelmetO_ocamo", "", 2500, { "", "", -1 } },
			{ "H_MilCap_oucamo", "", 1200, { "", "", -1 } },
			{ "H_Bandanna_camo", "", 650, { "", "", -1 } },
			{ "H_Bandanna_cbr", "", 650, { "", "", -1 } },
			{ "H_Bandanna_gry", "", 650, { "", "", -1 } },
			{ "H_Bandanna_khk", "", 650, { "", "", -1 } },
			{ "H_Bandanna_sgg", "", 650, { "", "", -1 } },
			{ "H_Bandanna_surfer", "", 650, { "", "", -1 } },
			{ "H_PilotHelmetFighter_B", "", 2500, { "", "", -1 } }
		};

		goggles[] = {
			{ "NONE", "Remove Glasses", 0, { "", "", -1 } },
			{ "G_Shades_Black", "", 25, { "", "", -1 } },
			{ "G_Shades_Blue", "", 20, { "", "", -1 } },
			{ "G_Sport_Blackred", "", 20, { "", "", -1 } },
			{ "G_Sport_Checkered", "", 20, { "", "", -1 } },
			{ "G_Sport_Blackyellow", "", 20, { "", "", -1 } },
			{ "G_Sport_BlackWhite", "", 20, { "", "", -1 } },
			{ "G_Squares", "", 10, { "", "", -1 } },
			{ "G_Lowprofile", "", 30, { "", "", -1 } },
			{ "G_Combat", "", 55, { "", "", -1 } },
			{ "G_Balaclava_blk", "", 650, { "", "", -1 } },
			{ "G_Balaclava_combat", "", 650, { "", "", -1 } },
			{ "G_Balaclava_lowprofile", "", 650, { "", "", -1 } },
			{ "G_Balaclava_oli", "", 650, { "", "", -1 } },
			{ "G_Bandanna_aviator", "", 650, { "", "", -1 } },
			{ "G_Bandanna_beast", "", 650, { "", "", -1 } },
			{ "G_Bandanna_blk", "", 650, { "", "", -1 } },
			{ "G_Bandanna_khk", "", 650, { "", "", -1 } },
			{ "G_Bandanna_oli", "", 650, { "", "", -1 } },
			{ "G_Bandanna_shades", "", 650, { "", "", -1 } },
			{ "G_Bandanna_sport", "", 650, { "", "", -1 } },
			{ "G_Bandanna_tan", "", 650, { "", "", -1 } }
		};

		vests[] = {
			{ "NONE", "Remove Vest", 0, { "", "", -1 } },
			{ "V_TacVest_khk", "", 12500, { "", "", -1 } },
			{ "V_BandollierB_cbr", "", 4500, { "", "", -1 } },
			{ "V_HarnessO_brn", "", 7500, { "", "", -1 } },
			{ "V_Rangemaster_belt", "", 850, { "", "", -1 } }
		};

		backpacks[] = {
			{ "NONE", "Remove Backpack", 0, { "", "", -1 } },
			{ "B_AssaultPack_cbr", "", 2500, { "", "", -1 }},
			{ "B_Kitbag_mcamo", "", 4500, { "", "", -1 } },
			{ "B_TacticalPack_oli", "", 3500, { "", "", -1 } },
			{ "B_FieldPack_ocamo", "", 3000, { "", "", -1 } },
			{ "B_Bergen_sgg", "", 4500, { "", "", -1 } },
			{ "B_Kitbag_cbr", "", 4500, { "", "", -1 } },
			{ "B_Carryall_oli", "", 5000, { "", "", -1 } },
			{ "B_Carryall_khk", "", 5000, { "", "", -1 } }
		};
	};
};