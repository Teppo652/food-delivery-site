<!DOCTYPE>

<html>
<head>
    <title></title>
	<!--
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	-->
    <style type="text/css">
        body {
            background-color: #F5F5F5;
            color: #555;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 1.2em;
        }
        #tables, #actionButtons
        {
            clear: left;
        }
        .title
        {
            color: #64854c;
            font-size: 2.1em;
            margin: 0 0 0.3em;
        }
        .button {
            background-clip: padding-box;
            background-color: #888;
            background-image: -moz-linear-gradient(center bottom , rgba(0, 0, 0, 0.15) -17%, rgba(255, 255, 255, 0.15) 117%);
            border: 1px solid rgba(87, 121, 63, 0.8);
            border-radius: 3px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4), 0 1px 0 rgba(255, 255, 255, 0.25) inset;
            color: #fff;
            font-weight: bold;
            margin: 10px 10px 0 0;
            padding: 7px 10px;
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
            font-size: 1em;
            cursor: pointer;
            float: left;
            text-align: center;
            // width: 210px;
        }
        .button:hover {
            background-color: #90b575;
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .4),  inset 0 1px 0 rgba(255, 255, 255, .25);
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .4),  inset 0 1px 0 rgba(255, 255, 255, .25);
            box-shadow: 0 1px 2px rgba(0, 0, 0, .4),  inset 0 1px 0 rgba(255, 255, 255, .25);
            background-image: -moz-linear-gradient(top,  rgba(0, 0, 0, .05) -17%,  rgba(255, 255, 255, .05) 117%);
            background-image: -o-linear-gradient(top,  rgba(0, 0, 0, .05) -17%,  rgba(255, 255, 255, .05) 117%);
            background-image: -webkit-linear-gradient(top,  rgba(0, 0, 0, .05) -17%,  rgba(255, 255, 255, .05) 117%);
            background-image: linear-gradient(top,  rgba(0, 0, 0, .05) -17%,  rgba(255, 255, 255, .05) 117%);
        }
        .selected
        {
            background-color: #90b575;
        }
        .action
        {
            /*background-color: #888; */
            font-size: 0.8em;
            // width: 110px;
        }
		.narrow
		{
			background-color: lightblue;
			font-size: 0.7em;
			padding: 8px 2px;
			width: 30px;
		}
		.fieldName
		{
			background-color: lightGreen;
			font-size: 0.9em;
			font-weight: bold;
			padding: 8px 5px;
			width: 150px;
			text-align: left;
		}
		.dbTypeGroup { width: 50px; /* 50px */ }
		.selectionSummary { width: 60px; }
		.fieldLabel, .fieldError
		{
			float: left; 
			margin-top: 13px
		}
		.fieldError 
		{
			background-color: salmon;
		}
        .clear
        {
            background-color: #F25C9A;
        }
		.hidden
        {
            display: none;
        }
        .textarea
        {
            height: 50px;
            // //overflow: hidden;
            padding: 5px;
            width: 100%;
        }
		.newRow
		{
			clear: left;
		}
		.right
		{
			float: right;
		}
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript">
        $(document).ready(function () {
            clearAll();

			$("#dbTypeGroupToggle").addClass('hidden right'); 
			$("#controlTypeGroupToggle").addClass('hidden right'); 
			$("#fieldLabelGroupToggle").addClass('hidden right'); 
			$("#fieldErrorGroupToggle").addClass('hidden right'); 

			$('#readDBFields').click(function (ev) {
                getRawDBFieldNames();
				$(this).addClass('selected');

				$("#dbTypeGroupToggle").removeClass('hidden'); 
				$("#controlTypeGroupToggle").removeClass('hidden'); 
				$("#fieldLabelGroupToggle").removeClass('hidden'); 
				$("#fieldErrorGroupToggle").removeClass('hidden'); 
            })
			$('#clear').click(function (ev) {
                clearAll();
            })
            function clearAll() {
                $("#code").val('');
				clearActions();
				$("#allData").text('');
				$("#fieldTypes").text('');
				$("#controlTypes").text('');
				$("#dynamicControls").text('');				
				$("#dbTypeGroupToggle").addClass('hidden'); 
				$("#controlTypeGroupToggle").addClass('hidden'); 
				$("#fieldLabelGroupToggle").addClass('hidden'); 
				$("#fieldErrorGroupToggle").addClass('hidden'); 

				for (var i = 0; i < 11; i++) {
					$("#b" + i).text(''); 
					$("#b" + i).removeClass('selected'); 
					$("#b" + i).addClass('hidden');
				}
            }

			function clearActions() {
                $(".action").removeClass('selected');
			}

            $('.action').click(function (ev) {     
				clearActions();           
                $(this).addClass('selected');
				$("#dynamicControls").html(''); // new
				//$("#dynamicControls").text(''); // new
                showTableFields(removeFirstChar(this.id));				
            })

			$('#saveButton').click(function (ev) {
                if(validate() == true) {
					// alert('validation succeeded');					
				} else {
					// alert('validation FAILED');
				}
            })			

			// hide show groups buttins
			$('#dbTypeGroupToggle').click(function () { 
				$(".dbTypeGroup").toggle();
			})
			$('#controlTypeGroupToggle').click(function () { 
				$(".controlTypeGroup").toggle();
			})
			$('#fieldLabelGroupToggle').click(function () { 
				$(".fieldLabelGroup").toggle();
			})
			$('#fieldErrorGroupToggle').click(function () { 
				$(".fieldErrorGroup").toggle();
			})
			
			// ---------------------- DEFINE FIELD & CONTROL TYPES -------------------
			

			function getFieldNames(tableId) { 
				return $("#allData").text().split('#')[tableId];  // var fieldNamesArr = $("#allData").text().split('#')[tableId].split(',');
			}
			
			function getDbTypes() { 
				//return 'number,text'; 
				return 'TINT_128,INT,CHAR_8,VC_15,VC_20,VC_50,VC_100,VC_5K,DATE,BOOL' + '';
				/*
safeShipmentId VARCHAR(30),friendlyShipmentId INT,siteId TINYINT UNSIGNED,countryId INT,senderUserId INT,senderIsCompany BOOLEAN,pickupUserId INT,pickupPointIsCompany BOOLEAN,driverUserId INT,driverIsCompany BOOLEAN,receiverId INT,receiverIsCompany BOOLEAN,email VARCHAR(50),fromTown VARCHAR(50),toTown VARCHAR(50),fromAdr VARCHAR(50),toAdr VARCHAR(50),fromXY VARCHAR(20),toXY VARCHAR(20),shipmentTypeId TINYINT UNSIGNED,shipmentTypeId2 TINYINT UNSIGNED,weightId INT,image VARCHAR(50),offersAskedDate INT,startDate INT,endDate INT,shipmentStatusId TINYINT UNSIGNED);
				*/
			}
			function getControlTypes() {
				return 'hide,input,textarea,on-off,email,phone,zip,city,country,droplist,radio';
			}
			function getTexts() {
				return 'fieldLabel,fieldError';
			}

			// ---------------------- PREDEFINE FIELD & CONTROL TYPES FROM NAME -------------------
			function getPredefinedDbType(str) { 	
				var types = 'test,id,phone,zip,postalcode,date,order,status,active'; // predefine here - original
				//var types = 'b,c'; // predefine here

				var typesArr = types.split(',')
				for (var a = 0; a < typesArr.length; a++)
				{
					//alert('checking if ' + str + ' includes ' + idTypesArr[a]);
					// if(str.toLowerCase().indexOf(typesArr[a]) != -1) { return 'id'; exit; } // original
					if(str.toLowerCase().indexOf(typesArr[a]) != -1) { return typesArr[a]; exit; }
					/*
					if(str.toLowerCase().indexOf(typesArr[a]) != -1) 
					{ 
						switch (typesArr[a])
						{
							case 'test': return 'id'; exit; break;  // row 653
							case '':  break;
							case '':  break;
						}
					}
					*/
				}
				return '';
			}

			function getPredefinedControlType(str) { 	
				var types = 'name,address,town,email,desc'; // predefine here
				var typesArr = types.split(',')
				for (var a = 0; a < typesArr.length; a++)
				{
					//alert('checking if ' + str + ' includes ' + idTypesArr[a]);
					if(str.toLowerCase().indexOf(typesArr[a]) != -1) { return 'text'; exit; }
				}
				return '';
			}


			//function getPredefinedDbType2(str) { 
			//
			//	// check for text
			//	var textTypes = 'name,address,town,email,desc'; // predefine here
			//	var textTypesArr = textTypes.split(',')
			//	for (var a = 0; a < textTypesArr.length; a++)
			//	{
			//		//alert('checking if ' + str + ' includes ' + textTypesArr[a]);
			//		if(str.toLowerCase().indexOf(textTypesArr[a]) != -1) { return 'text'; exit; }
			//	}
			//	return '';
			//}

			//function getPredefinedControlType(str) { 
			//	alert('starting getPredefinedControlType: ' + str);
			//	str = str.toLowerCase();
			//	
			//	
			//	
			//	// check for text
			//	var textTypes = 'name,address,town,email,desc'; // predefine here
			//	var textTypesArr = textTypes.split(',')
			//	for (var a = 0; a < textTypesArr.length; a++)
			//	{
			//		alert('checking if ' + str + ' includes ' + textTypesArr[a]);
			//		if(str.indexOf(textTypesArr[a]) != -1) { alert('Yes'); return 'text'; } else { alert('No'); }
			//	}
			//	return '';
			//}

			// ---------------------- GET SELECTIONS HERE -------------------
			function getDbTypeSelections() {
				var totalDbTypes = getDbTypes().split(',').length;
				alert('totalDbTypes: ' + totalDbTypes);
				// NUM or TEXT: ft_3_0_n or ft_3_0_t	
					
			}

			// function setControlTypeSelection() { 
			// // var controlTypesArr = getControlTypes().split(',');
			// // for (var a = 0; a < controlTypesArr.length; a++) 
			// // {
			// // 	// controlType: ct_3_0_1
			// // 	// $("#b" + i).removeClass('selected'); 
			// // 	// if() { }
			// // }
			// }
			// function getControlTypeSelections() { 
			// 	// var controlTypesArr = getControlTypes().split(',');
			// 	// var totalControlTypes = controlTypesArr.length;
			// 	// // alert('totalControlTypes: ' + totalControlTypes);
			// 	// var controlTypeSelections = '';
			// 	// for (var a = 0; a < controlTypesArr.length; a++) 
			// 	// {
			// 	// 	
			// 	// }
			// 	// // controlType: ct_3_0_1
			// }
			// function getLabelSelections() { 
			// 	// labels
			// 	// fieldLabel3_0
			// }
			// function getErrorSelections() { 
			// 	// validation errors
			// 	// fieldError3_0
			// }
			// 
			// function allSelectionsAreMade() {
			// // check fieldtype and controltype selections: xxx_ft or xxx_ct
			// }
			
			function getActiveTableId()
			{
				var activeTableId = '';
				var currTableId = '';
				for (var tableId = 0; tableId < 10; tableId++) {
					currTableId = $('#b' + tableId).hasClass('selected').toString(); // find table with CLASS active
					if(currTableId == 'true') {
						activeTableId = tableId;
					}
				}
				return activeTableId;
			}


			// --------------------------- validate and collect all selections -------------------------------
			function validate() {
				// validate that two selections have been made on each row

				var table = getActiveTableId();
				var fieldNames = getFieldNames(table);				
				fieldNames = removeLastChar(fieldNames); // NEW
				var fieldNamesArr = fieldNames.split(',');
				// collect DATA
				var data = fieldNames;	
				data += ':'; // NEWWW
				var ftData = '';
				var ctData = '';
				// ------------- FT - ft_selected_2_0 -------------
				var groupToIterateArr = getDbTypes().split(',');
				var selectedValue = '';
				var ft_selectionsArr = new Array(fieldNamesArr.length-1);		
				for (var row = 0; row < fieldNamesArr.length; row++) // NEWW
				{
					ft_selectionsArr[row] = ''; // init
					for (var i = 0; i < groupToIterateArr.length; i++) {
				//alert('fieldNamesArr.length-1:' + fieldNamesArr.length);
				//alert('groupToIterateArr.length:' + groupToIterateArr.length);

						selectedValue = $('#ft_selected_' + table + '_' + row).hasClass('s_' + i).toString(); // get selection from CLASS
						// ft_selected_2_0
				//alert('searching for: ft_selected_' + table + '_' + row); 

						if(selectedValue == 'true') 
						{ 
							//alert('FT - rivillä ' + row + ' valinta on ' + i + ': ' + groupToIterateArr[i]);
							// ft_selectionsArr[row] = groupToIterateArr[selectedValue];
							ft_selectionsArr[row] = groupToIterateArr[i];
						} 
					}
					// save not selected field name for validation error
				}
	
				//alert('KAIKKI ft_selectionsArr: ' + ft_selectionsArr.join()); // EMPTY

				// check for skipped ft selections				
				var shortDBList = getNewDbShortTypes(); //'TINT_128,INT,CHAR_8,VC_15,VC_20,VC_50,VC_100,VC_5K,DATE,DSTAMP';
				var longDBList = getNewDbLongTypes(); //'TINYINT UNSIGNED,INT UNSIGNED,CHAR(8),VARCHAR(15),VARCHAR(20),VARCHAR(50),VARCHAR(100),VARCHAR(5000),DATETIME,TIMESTAMP';
				var shortDBListArr = shortDBList.split(',');
				var longDBListArr = longDBList.split(',');
				var temp = '';
				for (var i = 0; i < ft_selectionsArr.length-1; i++) {
					temp += ft_selectionsArr[i] + ',';
					//if(ft_selectionsArr[i] == null) { alert('Check row ' + (i+1) + ': ' + fieldNamesArr[i+1]); return false; } // validation HACK

					// OLD
					// if(ft_selectionsArr[i] === 'number') { data += 'i,'; } else { data += 't50,'; }
					// NEW	
					// JATKA TÄSTÄ!!!!!!!!!!!!!!!--------------				
					for (var k = 0; k < shortDBListArr.length; k++) 
					{
						// ft_selectionsArr = UNDEFINED!
						//alert(k + '/' + shortDBListArr.length  + '. comparing: ' + ft_selectionsArr[i] + ' WITH ' + shortDBListArr[k]);
						if(ft_selectionsArr[i] == shortDBListArr[k]) { data += longDBListArr[k]; } // alert('Dataan lisätään:' + longDBListArr[k]); } 
					}
					data += ','; // comma
					
				}
				//alert('ALL FT answers: ' + temp);
				//alert('FT answers as joined array: ' + ft_selectionsArr.join());
				
				
				data = removeLastChar(data);
				data += ':';

				// ------------- CT - ct_selected_2_0 -------------
				var groupToIterateArr = getControlTypes().split(',');
				var selectedValue = '';
				var ct_selectionsArr = new Array(fieldNamesArr.length-1);

//!!!! -1 poistettu
				for (var row = 0; row < fieldNamesArr.length; row++) 
				{
					for (var i = 0; i < groupToIterateArr.length; i++) {
						selectedValue = $('#ct_selected_' + table + '_' + row).hasClass('s_' + i).toString(); // get selection from CLASS

						//alert('CT - Checking if ' + 'ct_selected_' + table + '_' + row + ' has the value ' + 's_' + i); 						
						if(selectedValue == 'true') 
						{ 
							//alert('CT - rivillä ' + row + ' valinta on ' + i + ': ' + groupToIterateArr[i]);
							ct_selectionsArr[row] = groupToIterateArr[i];
							//ctData += groupToIterateArr[i] + ',';		
						} 
					}
					// save not selected field name for validation error
				}
				// check for skipped ct selections
	//!!!! -1 poistettu
				for (var i = 0; i < ct_selectionsArr.length; i++) {
						//alert('CHECKING CT answers IF: ' + i + '. ' + ct_selectionsArr[i] + ' is EMPTY');
					if(ct_selectionsArr[i] == null) { alert('Check row ' + (i+1) + ': ' + fieldNamesArr[i+1]); return false; } // HACK
				
					// add switch here!

					//data += 't,';	
					data += ct_selectionsArr[i] + ','; // NEW
					
					// hide,input,textarea,on-off,email,phone,zip,city,country,droplist,radio
					// if(ft_selectionsArr[i] === 'number') { data += 'i,'; } else { data += 't50,'; }
					switch(ft_selectionsArr[i])
					{	
						case "": data += 'i,'; break;
					}
				}


				// new 
				data = removeLastChar(data);
				data += ':';
				// ------------- LABELS AND ERRORS-------------
				var groupToIterateArr = getTexts().split(','); // fieldLabel,fieldError
				var selectedValue = '';
				var currItem = '';
				var currError = '';
				var allErrors = '';
				var ct_selectionsArr = new Array(fieldNamesArr.length-1);
	//!!!! -1 poistettu
				for (var row = 0; row < fieldNamesArr.length-1; row++) 
				{
					for (var i = 0; i < groupToIterateArr.length; i++) {

						currItem = $('#' + groupToIterateArr[i] + table + '_' + row).val();
						//alert('398 FIELD' + row + ' LABEL' + i + ' : ' + currItem);
						if(i == 0) { data += currItem + ','; } else { allErrors += currItem + ','; }

						// selectedValue = $('#ct_selected_' + table + '_' + row).hasClass('s_' + i).toString(); // get selection from CLASS
						// //alert('CT - Checking if ' + 'ct_selected_' + table + '_' + row + ' has the value ' + 's_' + i); 
						// if(selectedValue == 'true') 
						// { 
						// 	//alert('CT - rivillä ' + row + ' valinta on ' + i + ': ' + groupToIterateArr[i]);
						// 	ct_selectionsArr[row] = groupToIterateArr[i];
						// 	//ctData += groupToIterateArr[i] + ',';							
						// } 
					}
					// save not selected field name for validation error
				}
				data = removeLastChar(data);
				data += ':';
				//allErrors = removeLastChar(allErrors);
				data += allErrors;


				//alert('CT answers as joined array: ' + ct_selectionsArr.join());

				// validation succeeded - collect data
				// tables[a] = "users:userId,firstName,lastName,email,login,password,active:i,t20,t50,t50,t30,t30,b:d,t,t,t,t,t,d"; a++;				
								
				data = removeLastChar(data);
				data = data.replace(",", ":");
				data = ' tables[a] = \"' + data + '\"; a++; ';
				// alert(data);	

				$("#code").val(data);
				return true;
			}

			function registerSelection(controlId) {
				// ct_2_0_3: ct=controlTypeGroup 2=table 0=row 3=item				
				// ADD TO: ft_selected_2_0 AND ct_selected_2_0
				// button clicked: ct_2_0_8
				// alert('xxx controlId' + controlId);
				
				var controlTypeGroup = controlId.split('_')[0];
				var table = controlId.split('_')[1];
				var row = controlId.split('_')[2];
				var controlItem = controlId.split('_')[3];						

				// remove earlier button selections on this row and in this group
				var groupToIterate = '';
				switch(controlTypeGroup)
				{
					case 'ft': groupToIterateArr = getDbTypes().split(',');		 break; 
					case 'ct': groupToIterateArr = getControlTypes().split(','); break;
				}
				for (var i = 0; i < groupToIterateArr.length; i++) {
					$('#' + controlTypeGroup + '_' + table + '_' + row + '_' + i).removeClass('selected');
					$('#' + controlTypeGroup + '_selected_' + table + '_' + row).removeClass('s_' + i); // remove selection from CLASS
					// alert('REMOVING CLASS: ' + 's_' + i + ' FROM ID: ' + controlTypeGroup + '_selected_' + table + '_' + row);
				}

				// set button selected
				$('#' + controlTypeGroup + '_' + table + '_' + row + '_' + controlItem).addClass('selected');
				//alert('MARKING selected: ' + controlTypeGroup + '_' + table + '_' + row + '_' + controlItem);

				// copy selection name to selected_ft / ct
				$('#' + controlTypeGroup + '_selected_' + table + '_' + row).addClass('selected');
				$('#' + controlTypeGroup + '_selected_' + table + '_' + row).text(groupToIterateArr[controlItem]); // NAME

				// copy selection ID to selected_ft ID CLASS
				$('#' + controlTypeGroup + '_selected_' + table + '_' + row).addClass('s_' + controlItem); // ID
			}

			function preRegisterSelection(controlId, controlName) {	
				alert('preRegisterSelection: controlId: ' + controlId + '  controlName:' + controlName);
				var controlTypeGroup = controlId.split('_')[0];
				var table = controlId.split('_')[1];
				var row = controlId.split('_')[2];
				var controlItem = controlId.split('_')[3];						



				// set button selected
				// $('#' + controlTypeGroup + '_' + table + '_' + row + '_' + controlItem).addClass('selected'); // iD:ft_0_0_0
				$('#' + controlId.split(' ')[0]).addClass('selected');

				// copy selection name to selected_ft / ct
				$('#' + controlTypeGroup + '_selected_' + table + '_' + row).addClass('selected');
				$('#' + controlTypeGroup + '_selected_' + table + '_' + row).text(controlName); // NAME
				// alert('yyyyy : ' + controlName);
				// alert('set text to: ' + controlTypeGroup + '_selected_' + table + '_' + row + ' - TO - ' + groupToIterateArr[controlItem]);

				// copy selection ID to selected_ft ID CLASS
				//if(controlName == 'TEXT') {
				//	var numExists = $('#ft_selected_' + table + '_' + row).hasClass('s_1'i).toString(); // HACK remove NUM class if exists
				//	if(numExists == true) {
				//		alert('NUM class exists');
				//	} else {
				//		alert('No NUM class found');
				//	}
				//}
				$('#' + controlTypeGroup + '_selected_' + table + '_' + row).addClass('s_' + controlItem); // ID
				// alert('8. copy selection ID or TEXT: ' + 's_' + controlItem + ' - TO - ' + controlTypeGroup + '_selected_' + table + '_' + row);
			}

			// ------------------------- CREATE TABLE ----------------------
			function showTableFields(tableId){
				// load table fields
				var fieldNamesArr = $("#allData").text().split('#')[tableId].split(',');
				var tableName = fieldNamesArr.shift();
				var fieldTypeValuesArr = $("#fieldTypes").text().split('#')[tableId].split(',');
				var controlTypeValuesArr = $("#controlTypes").text().split('#')[tableId].split(',');			

				// // init field and control type buttons
				// var fieldTypesArr = "".split(',,,,,,,,,,,,,,,,,,,,,,,,,,,,,');
				// var controlTypesArr = "".split(',,,,,,,,,,,,,,,,,,,,,,,,,,,,,');
				// for (var i = 0; i < fieldTypesArr.length; i++) {
				// 	
				// }

				// add button test
				var newButton = ''; // TEST
				var buttonName = ''; // TEST

				var fieldName = '';
				var fieldType = '';
				var controlType = '';
				var fieldNameControl = '';
				var fieldTypeControl = '';
				var controlTypeControl = '';
				for (var i = 0; i < fieldNamesArr.length-1; i++) 
				{
					// $("#providersFormElementsTable").html("

					// FIELD NAME
					fieldName = fieldNamesArr[i];
					fieldNameControl = $('<button/>',
					{
					    id: fieldName,
						class: 'button fieldName',
						text: fieldName,
						text: fieldName,
						click: function () {  
							//$(this).siblings().removeClass('selected');
							$(this).addClass('selected');
							registerSelection($(this).attr("id"), fieldName);
						}
					});
					$("#dynamicControls").append(fieldNameControl);
				
					// SELECTIONS SUMMARY
					var controlTypes = 'ft,ct';
					var controlTypesArr = controlTypes.split(','); // number,text
					for (var t = 0; t < controlTypesArr.length; t++) 
					{
						controlId = controlTypesArr[t] + '_selected_' + tableId + '_' + i;
						// controlText = 'Selected_' + controlTypesArr[t];
						controlText = '_';
						fieldTypeControl = $('<button/>',
						{
						    id: controlId,
							class: 'button action selectionSummary',
							text: controlText,
							click: function () {	
								registerSelection($(this).attr("id"));		
							}
						});
						$("#dynamicControls").append(fieldTypeControl);
					}

					/*
					if (phpDBTypesArr[j].substr(0, 1) == "i") { data += "'" + t + "',"; } // id
                    if (phpDBTypesArr[j].substr(0, 1) == "t") { data += "'" + phpFieldsArr[j] + 'Text' + t + "',"; } // varchar  
                    if (phpDBTypesArr[j].substr(0, 1) == "T") { data += "'" + 'blob' + "',"; } // blob
                    if (phpDBTypesArr[j].substr(0, 1) == "b") { data += "'" + "1" + "',"; } // bit(1)
					*/


					// DATABASE TYPE GROUP - NUM AND TEXT - FT
					var controlTypes = getDbTypes();
					var controlTypesArr = controlTypes.split(','); // number,text
					var predefinedFieldFound = false;
					for (var t = 0; t < controlTypesArr.length; t++) 
					{
						// controlText = getFirst3Chars(controlTypesArr[t]).toUpperCase();
						controlText = controlTypesArr[t].toUpperCase();
						//controlId = 'ft_' + tableId + '_' + i + '_' + getFirstChar(controlTypesArr[t]);
						controlId = 'ft_' + tableId + '_' + i + '_' + t;
						fieldTypeControl = $('<button/>',
						{
						    id: controlId,
							class: 'button action narrow dbTypeGroup',
							text: controlText,
							click: function () {  
								//$(this).siblings().removeClass('selected');
								$(this).addClass('selected');
								registerSelection($(this).attr("id"));
							}
						});
						$("#dynamicControls").append(fieldTypeControl);
	
						// ------------------ set predefined selections ------------------
						if(predefinedFieldFound == false)
						{
							var predefined = getPredefinedDbType(fieldNamesArr[i]);
							if(predefined != '') 
							{ 
								predefinedFieldFound = true;
								//alert('2 predefined ID found! controlID: ' + controlId + '   F:' + getPredefinedDbType(fieldNamesArr[i])); 
								//alert('3 preRegisterSelection controlID: ' + controlId + '   controlText:' + controlText); 
								// preRegisterSelection(controlId, 'NUM'); // original
								preRegisterSelection(controlId, predefined);
								
								//// ft_selected_3_0 --> add class s_1
							
							} /*else if(getPredefinedControlType(fieldNamesArr[i]) != '') {
								//alert('7 preRegisterSelection controlID: ' + controlId + '   controlText: TEXT'); 
								// ft_2_2_1   controlText: TEXT
								preRegisterSelection(controlId, 'TEXT'); // NEW
							}*/
						}
					}

					// CONTROL TYPES - CT
					//controlTypes = 'hide,input,textarea,on-off,email,phone,zip,city,country,droplist,radio';
					controlTypes = getControlTypes();
					controlTypesArr = controlTypes.split(','); 								
					predefinedFieldFound = false;
					for (var t = 0; t < controlTypesArr.length; t++) 
					{
						controlText = controlTypesArr[t]; // + ' (ct_' + tableId + '_' + i + '_' + t + ')';
						controlId = 'ct_' + tableId + '_' + i + '_' + t;
						controlTypeControl = $('<button/>',
						{
						    id: controlId,
							class: 'button action controlTypeGroup',
							text: controlText,
							click: function () {  
								//$(this).siblings().removeClass('selected');
								$(this).addClass('selected');
								// new
								// $(this).addClass('ct' + i);
								// $("#selections").append($(this).attr("id") + ','); // lisää yläriville TEMP
								registerSelection($(this).attr("id"));
							}
						});
						$("#dynamicControls").append(controlTypeControl);

						// // ------------------ set predefined selections ------------------
						// if(predefinedFieldFound == false)
						// {
						// 	if(getPredefinedControlType(fieldNamesArr[i]) != '') 
						// 	{ 
						// 		alert('CT FOUND: ' + getPredefinedControlType(fieldNamesArr[i]));
						// 		predefinedFieldFound = true;
						// 		alert('2 predefined TEXT found! controlID: ' + controlId + '   F:' + getPredefinedControlType(fieldNamesArr[i])); 
						// 		alert('3 preRegisterSelection controlID: ' + controlId + '   controlText:' + controlText); 
						// 		preRegisterSelection(controlId, controlText); // NEW
						// 		
						// 		//// ft_selected_3_0 --> add class s_1
						// 	
						// 	} else if(getPredefinedDbType2(fieldName) != '') {
						// 		//alert('predefined TEXT found! controlID: ' + controlId); 
						// 		//registerSelection($('#' + controlId).attr("text"));
						// 	}
						// }

					}
					
					// LABEL & ERROR TEXTS
					// var controlTypes = 'fieldLabel,fieldError';
					var controlTypes = getTexts();
					var controlTypesArr = controlTypes.split(','); 	
					var theClass = '';	
					for (var t = 0; t < controlTypesArr.length; t++) 
					{
						theClass = controlTypesArr[t] + 'Group '  + controlTypesArr[t];
						controlId = controlTypesArr[t] + tableId + '_' + i;
						//controlText = ''; //'Entered_' + controlTypesArr[t];
						// label default text
						//if(controlTypesArr[t] == 'fieldLabel') { controlText = makeReadable(fieldNamesArr[i]); } else { controlText = ''; }// NEW
						// label and error default texts
						controlText = makeReadable(fieldNamesArr[i]);

						fieldTypeControl = $('<input/>',
						{
						    id: controlId,
							class: theClass,
							value: controlText,
							click: function () {							
								registerSelection($(this).attr("id"));
							}
						});
						$("#dynamicControls").append(fieldTypeControl);
					}


					// new row
					$("#dynamicControls").append('<div class="newRow"></div>');

					// text: buttonName,
					// click: function () { $("#code").val(buttonName + ' clicked'); alert(buttonName + ' button clicked'); }


					// ---------------------------------------- TESTING ---------------------------------------------------
					// getDbTypeSelections();
					// getControlTypeSelections();
				}


				







				/*
				fieldTypes (i=int,t=text,T=blob,b=bit)				
				controlTypes (t=textbox,d=droplist,r=radio) 
				
				<table>
				*/

				
				// var data = '';
				// data += '<table>';
				// // data += '<tr><td>1</td><td>3</td><td>4</td></tr>';
				// for (var i = 0; i < fieldTypesArr.length; i++) {
                //         //result += '<div class="button tableButton" id="' + tables[i] + '">' + cap(tables[i]) + '</div>';
				// 		// result += '<div class="button tableButton" id="' + tables[i].split(':')[0] + '">' + cap(tables[i].split(':')[0]) + '</div>';
				// 	data += "<tr><td>" + fieldNamesArr[i] + "</td><td>" + fieldTypeValuesArr[i] + "</td><td>" + controlTypeValuesArr[i] + "</td></tr>";    
                // }
				// data += '</table>';
				// 
				// 
				// 
				// $("#table").html(data)

				//$("#fieldNamesPanel").text('');
				//$("#fieldTypesPanel").text('');
				//$("#controlTypesPanel").text('');

			}


			function getRawDBFieldNames() {
				// read entered data from input box
				var data = $("#code").val();
				$("#code").val('');

				// usage 1:
				// tablename
				// field,field,field...

				// usage 2:
				// tablename
				// field
				// field
				// field
				// ...

				
				// data = data.replace(",", ";"); // replace , with ; ----- NEW

				data = data.replace(",", "\n"); // NEW
				data = data.replace(":", "\n"); // NEW

				data = data.replace(/(\r\n|\n|\r)/gm, ";"); // replace newlines with ;
				data = data.replace(/\s/g, ""); // remove all whitespace characters
				//data = data + ';'; // needed for duplicate validation to work correctly
				$("#code").val(data); // show all data

				// separate tables
				var allData = '';
				var fieldTypes = ''; 
				var controlTypes = '';
				var tableCounter = 0;				
				var duplicateCheckStart = 1; // skips table name
				var duplicateCheckEnd = 0;
				var lastTableName = '';
				var validationError = false;
				var dbFieldsArr = data.split(';');
                for (var i = 0; i < dbFieldsArr.length; i++) {
                    lengthsArr += dbFieldsArr[i].length += ',';
					
					// first table name is in first line
					if( i == 0) {  
						$("#b" + tableCounter).text(cap(removeLastChar(dbFieldsArr[i]))); 
						$("#b" + tableCounter).removeClass("hidden");
						lastTableName = removeLastChar(dbFieldsArr[i]);
						tableCounter++;
					} 

					// next table names found
					if(dbFieldsArr[i].length == 0)
					{ 
						// end of table found
						allData = removeLastChar(allData);
						allData += '#'; 

						fieldTypes = removeLastChar(fieldTypes);
						fieldTypes += '#'; 

						controlTypes = removeLastChar(controlTypes);
						controlTypes += '#'; 

						// check for duplicate fields within table
						duplicateCheckEnd = i;						
						if(findDuplicates(dbFieldsArr.slice(duplicateCheckStart, duplicateCheckEnd), lastTableName.toUpperCase()) == false) { validationError = true; }
						duplicateCheckStart = i+2;

						// create table button
						$("#b" + tableCounter).text(cap(removeLastChar(dbFieldsArr[i+1]))); 
						$("#b" + tableCounter).removeClass("hidden");
						lastTableName = removeLastChar(dbFieldsArr[i+1]);
						tableCounter++;
					} else { 
						allData += dbFieldsArr[i].trim() + ','; 
						fieldTypes += i +','; 
						controlTypes += i +',';
					}
                }
				// validate last table here
				duplicateCheckEnd = dbFieldsArr.length;				
				if(findDuplicates(dbFieldsArr.slice(duplicateCheckStart, duplicateCheckEnd), lastTableName.toUpperCase()) == false) { validationError = true; }

				// if duplicates were found:
				if (validationError == true) { clearAll(); return; }

				var lengthsArr = lengthsArr.split(',');

				allData = allData.replace(/:/g, ''); // replaces all occurances
				fieldTypes = removeLastChar(fieldTypes); 
				controlTypes = removeLastChar(controlTypes);

				// store all data 
				$("#allData").text(allData);
				$("#fieldTypes").text(fieldTypes);
				$("#controlTypes").text(controlTypes);

				//alert('fieldTypes: ' + fieldTypes);
				//alert('controlTypes: ' + controlTypes);				
				//$("#code").val(allData);

				// alert(dbFieldsArr.join(', '));








				// // 16 11 2016 - Certification selling
                // tables[a] = "users:userId,firstName,lastName,email,login,password,active:i,t20,t50,t50,t30,t30,b:d,t,t,t,t,t,d"; a++;
                // tables[a] = "exams:examId,creatorUserId,langId,examCode,dateCreated,examName,shortDesc,prerequisiteExamIds,timeLimitMinutes,orderId,active:i,i,i,t10,i,t50,t255,t50,i,i,i:d,d,d,t,t,t,t,t,d,d,d"; a++;
                // tables[a] = "modules:moduleId,examId,langId,moduleName,moduleDesc,timeLimitMinutes,orderId,active:i,i,i,t50,t255,i,i,i:d,d,d,t,t,t,d,d"; a++;
                // tables[a] = "questions:questionId,moduleId,langId,questionTypeId,questionFormatId,orderId,active:i,i,i,i,i,i,i:d,d,d,d,d,d,d"; a++;
                // tables[a] = "content:contentId,questionId,langId,text,orderId,active:i,i,i,t255,i,i:d,d,d,t,d,d"; a++;
                // tables[a] = "questionTypes:questionTypeId,langId,text,shortDesc,imageName,orderId,active:i,i,t50,t255,t255,i,i:d,d,t,t,t,d,d"; a++;



				// put firld names in tables			
				// var tables = Array(); // [0]=db table name, [1] = db fieldnames, [2]=db field types (id,t50), [3] = controltype (d=droplist,t=textbox,r=radio)
				// var a = 0;
				// tables[a] = "areas:countryId,langId,areaName:i,i,t50:d,d,t"; a++;
				// tables[a] = "towns:areaId,langId,townName:i,i,t50:d,d,t"; a++;
				// tables[a] = "langs:langName:t50:t"; a++;
				// tables[a] = "categories:langId,parentCatId,catName,catDesc,adTypeIds,orderId,active:i,i,t50,t250,i,i,i:d,d,t,t,d,d,r"; a++;
				// tables[a] = "users:countryId,areaId,townId,loginName,password,email,phone:i,i,i,t50,t50,t50,t25:d,d,d,t,t,t"; a++;
				// tables[a] = "ads:userId,langId,countryId,catId,title,adText,email,phone,startDateTime,endDate,imgNames,active:i,i,i,i,t50,t250,t10,t6,t250,i:d,d,d,d,t,t,d,d,t,r"; a++;
				// tables[a] = "adTypes:langId,adTypeName,orderId:i,i,t50:d,d,t"; a++;

			}

			
			function findDuplicates(arr, table) {
				for(a=0; a<arr.length; a++) {					
					for(b=0; b<arr.length; b++) {
						if(a != b) {
							// alert( a + '. Comparing: ' + arr[a] + ' - ' + arr[b]);
							if(arr[a] == arr[b]) { alert('Error: duplicate field ' + arr[a] + ' found in ' + table + ' (pos: ' + a + ' and ' + b + '). Please fix and paste again.'); return false; }
						}
					}
				}
				return true;
			}

            function getTables() {
                var tables = Array(); // [0]=db table name, [1] = db fieldnames, [2]=db field types (id,t50), [3] = controltype (d=droplist,t=textbox,r=radio)
                var a = 0;
              
                // 16 11 2016 - Certification selling
                tables[a] = "users:userId,firstName,lastName,email,login,password,active:i,t20,t50,t50,t30,t30,b:d,t,t,t,t,t,d"; a++;
                tables[a] = "exams:examId,creatorUserId,langId,examCode,dateCreated,examName,shortDesc,prerequisiteExamIds,timeLimitMinutes,orderId,active:i,i,i,t10,i,t50,t255,t50,i,i,i:d,d,d,t,t,t,t,t,d,d,d"; a++;
                tables[a] = "modules:moduleId,examId,langId,moduleName,moduleDesc,timeLimitMinutes,orderId,active:i,i,i,t50,t255,i,i,i:d,d,d,t,t,t,d,d"; a++;
                tables[a] = "questions:questionId,moduleId,langId,questionTypeId,questionFormatId,orderId,active:i,i,i,i,i,i,i:d,d,d,d,d,d,d"; a++;
                tables[a] = "content:contentId,questionId,langId,text,orderId,active:i,i,i,t255,i,i:d,d,d,t,d,d"; a++;
                tables[a] = "questionTypes:questionTypeId,langId,text,shortDesc,imageName,orderId,active:i,i,t50,t255,t255,i,i:d,d,t,t,t,d,d"; a++;

            }
           
		   function removeLastChar(str) {
				return str.slice(0, -1);
                return str;
            }
            function removeFirstChar(str) {
				str = str.substr(1);
				return str;
            }
			function getFirstChar(str) {
				str = str.substr(0,1);
				return str;
            }
			getFirst3Chars
			function getFirst3Chars(str) {
				str = str.substr(0,3);
				return str;
            }
			function cap(s) {
                return s[0].toUpperCase() + s.slice(1);
            }
			function createDbButton(name) {
				$('#actionButtons').innerHTML('<div>ABC</div>'); 
			}

			function makeReadable(str) {
                var strArray = str.split("");
                var result = strArray[0].toUpperCase();
				var toUpper = false;
                for (var i = 1; i < strArray.length; i++) {
                    if (isUpperCase(strArray[i]) === true) 
					{ 
						// when upper case letter found, add space and convert letter to lower case
						result += ' ' + (strArray[i]).toLowerCase(); 
					} else { 
						result += strArray[i]; 
					}
                    
                }
                return result;
            }

			function isUpperCase(character) {
                if (character == character.toLowerCase()) {
                    return false;
                }
                else {
                    return true;
                }
            }
			
				
			function getNewDbShortTypes() {
				return 'TINT_128,INT,CHAR_8,VC_15,VC_20,VC_50,VC_100,VC_5K,DATE,BOOL';
            };
			function getNewDbLongTypes() {
				return 'TINYINT UNSIGNED,INT,CHAR(8),VARCHAR(15),VARCHAR(20),VARCHAR(50),VARCHAR(100),VARCHAR(5000),DATETIME,BOOLEAN';
            };


			// // NOT TESTED YET
			// function findDuplicates(arr) {
			//   var i,
			//       len=arr.length,
			//       out=[],
			//       obj={};
			// 
			//   for (i=0;i<len;i++) {
			//     obj[arr[i]]=0;
			//   }
			//   for (i in obj) {
			// 	// out.push(i);
			// alert('Error: duplicate field (' + i + ') '+ arr[i] + ' found in table!');
			//   }
			//   return out;
			// }
			

        });
    </script>
</head>
<body>

<div id="content">

	<div id="readDBFields" class="button clear">Read DB fields</div>
    <div id="clear" class="button clear">Clear</div>
	<br />
	
	<div id="actionButtons">
		<div id="b0" class="button action hidden">Btn</div>&nbsp;
		<div id="b1" class="button action hidden">Btn</div>&nbsp;
		<div id="b2" class="button action hidden">Btn</div>&nbsp;
		<div id="b3" class="button action hidden">Btn</div>&nbsp;
		<div id="b4" class="button action hidden">Btn</div>&nbsp;
		<div id="b5" class="button action hidden">Btn</div>&nbsp;
		<div id="b6" class="button action hidden">Btn</div>&nbsp;
		<div id="b7" class="button action hidden">Btn</div>&nbsp;
		<div id="b8" class="button action hidden">Btn</div>&nbsp;
		<div id="b9" class="button action hidden">Btn</div>&nbsp;
    </div>    
		
	<div id="fieldErrorGroupToggle" class="button">Errors</div>&nbsp;
	<div id="fieldLabelGroupToggle" class="button">Labels</div>&nbsp;	
	<div id="controlTypeGroupToggle" class="button">Controls</div>&nbsp;
	<div id="dbTypeGroupToggle" class="button">Db types</div>&nbsp;
    <br />
    <div id="table" style="text-align: left;"></div> 
	<div id="selections"></div>
	<!--
	<br><br>
	<div data-role="controlgroup" data-type="horizontal" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal"><div class="ui-controlgroup-controls">
			<a href="index.html" data-role="button" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="c" class="ui-btn ui-corner-left ui-btn-up-c"><span class="ui-btn-inner ui-corner-left"><span class="ui-btn-text">Yes</span></span></a>
			<a href="index.html" data-role="button" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="c" class="ui-btn ui-btn-up-c"><span class="ui-btn-inner"><span class="ui-btn-text">No</span></span></a>
			<a href="index.html" data-role="button" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="c" class="ui-btn ui-corner-right ui-controlgroup-last ui-btn-up-c"><span class="ui-btn-inner ui-corner-right ui-controlgroup-last"><span class="ui-btn-text">Maybe</span></span></a>
		</div></div>
	-->


	<?php
	// WRITE INTO FILE

	//  echo '<form action="scriptGenerator.php" method="post">';
	//  echo '<input type="input" id="pageCode" value="" name="pageCode">';
	//  echo '<input type="submit" value="Create file">';
    //  echo "</form>";

	if (isset($_POST['pageCode']))
	{
		// $fileName = $_POST['pageName']; // "testFile___test.txt";
		// $myfile = fopen($fileName, "w") or die("Error: Unable to update " . $fileName . "");		
		// $pageCode = $_POST['pageCode'] . PHP_EOL;
		// file_put_contents($fileName, $pageCode);
		// echo "<br>Successfully updated at " . $fileName . "<br>";


		$fileName = $_POST['pageName'] . '.php';
		$pageCode = $_POST['pageCode']; // . PHP_EOL;

		// ---- addd newlines ----
		//$order   = array("\r\n", "\n", "\r");
		$order   = '\n';
		$replace = '<br />';
		$pageCode = str_replace($order, $replace, $pageCode);



		$fp = fopen($fileName, 'w');
		fwrite($fp, $pageCode);
		fclose($fp);
		echo "<br>Successfully updated at " . $fileName . "<br>";
	}
	?>

    <!-- <input type="text" id="code" class="textarea" onClick="this.select();" />-->
    <textarea id="code" class="textarea"></textarea> <!-- onClick="this.select();" -->

	<br />
	<div id="allData" class="hidden"></div>
	<div id="fieldTypes" class="hidden"></div>
	<div id="controlTypes" class="hidden"></div>

	<!-- [0]=db table name, [1] = db fieldnames, [2]=db fieldTypes (id,t50), [3] = controlTypes (d=droplist,t=textbox,r=radio) -->

	
	<!--
	<button id="staticButtonTest0" class="dynamicButton">Static new button0</button>
	<button id="staticButtonTest1" class="dynamicButton selected">Static new button1</button>
	-->


	<div id="dynamicControls"></div><br>
	<div id="saveButton" class="button clear selected">Save</div>

</div>

</body>
</html>


