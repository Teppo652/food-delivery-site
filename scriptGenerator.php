<?php
include('date.php');
?>

<!DOCTYPE>

<html>
<head>
    <title></title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
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
            width: 210px;
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
            width: 110px;
        }
        .clear
        {
            background-color: #F25C9A;
        }
        .textarea
        {
            height: 800px;
            //overflow: hidden;
            padding: 5px;
            width: 100%;
        }
		#pageCodeAA, #fileNames {
			display: none;
		}
		#sButton {
			float: none;
		}
		.smallInput {
			width: 90px;
		}        
        .half  {
            width: 100px;
            height: 36px;
        }
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript">
        $(document).ready(function () {
            init();

            // table button clicked
            $('.tableButton').click(function (ev) {
                clearAll();
                $(this).addClass('selected');
                showActionButtons();
            })

            // action button clicked
            $('.action').click(function (ev) {
                clearActions();
                $(this).addClass('selected');
                generateCode(this.id);
            })

            // clear clicked
            $('#clear').click(function (ev) {
                clearAll();
            })

            // createSqlInserts
            $('#createSqlInserts').click(function (ev) {
                createInserts(true, false);
            })
            // createJsonInserts
            $('#createJsonInserts').click(function (ev) {
                 createInserts(false, true);
            })

			// createFiles			
			$('#createFiles').click(function (ev) {
                createFiles();
            })

            // cleanCode clicked
            /*
            $('#cleanCode').click(function (ev) {
            var data = $("#code").val(data);
                
            data = data.replace('"', '\"');
            data = data.replace("'", "\'");
            data = data.replace(/(\t)/gm, "\t");
            data = data.replace(/(\r\n|\n|\r)/gm, "\n");
            alert(data);
            $("#code").val(data);
            })
            */


            function generateCode(id) {
                /* " --> \"    ' --> \'   \n ok  \t ok */
                var data = "";

                var dataArr = Array();
                var textboxArr = Array();
                var droplistArr = Array();
                var radioArr = Array();
                var totalCsSections = 10;

                var iterableSectionTextbox = "";
                var iterableSectionDroplist = "";
                var iterableSectionRadio = "";
                var iteratedData = "";

				var includesFolder = '../includes/';

                var phpSelectedTable = $('#tables .selected').attr('id');
                // ======================================================================
                switch (id) {
                    case "getAll":
                        // PHP
                        data = '';
						
                        // DB CONNECTION
                        data += '// <?php\n';
						data += '// session_start();\n';						
                        data += '// ';
                        data += '// include(\'' + includesFolder + 'dataFunctions.php\');\n'; 
                        data += '// include(\'' + includesFolder + 'functions.php\');\n';
                        //data += 'include(\'' + includesFolder + 'date.php\');\n';
                        data += '// include(\'' + includesFolder + 'header.php\');\n';
						data += '// include(\'' + includesFolder + 'autentication.php\');\n';
                        data += '// $conn = getDBConnection();\n';
                        data += '\n';

                        data += '// ' + '$' + 'thisPage = \"' + phpSelectedTable + '.php\";\n';
                        data += '// ' + '$' + 'nextPage = \"' + removeLastChar(phpSelectedTable) + '.php\";\n';
                        data += '// ' + '$' + 'table = \"' + phpSelectedTable + '\";\n';
                        data += '\n';

						data += '// --------------------- BEGIN CODE ------------------------\n';
						data += '\n';
						
                        data += "// activate or deactivate\n";
                        data += "$id = '';\n";
                        data += "$action = '';\n";
                        data += "$activeStatus = '';\n";
                        data += "$quickDelete = '';\n";
                        data += "if (isset($_GET['action']))\n"; 
                        data += "{\n";
                        data += "    if (isset($_GET['id']))\n"; 
                        data += "    {\n"; 
                        data += "        $action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_URL );\n"; 
                        data += "        $id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_URL );\n"; 
                        data += "        if($action =='deactivate') { $activeStatus = '0'; echo '<br><div style=\"color:green\">Item Deactivated.</div>'; }\n";
                        data += "        if($action =='activate') { $activeStatus = '1'; echo '<br><div style=\"color:green\">Item Activated.</div>'; }\n";
                        data += "        if($action =='quickDelete') { $quickDelete = '1'; echo '<br><div style=\"color:green\">Item Deleted.</div>'; }\n"; 
                        data += "        if($activeStatus != '')\n";
                        data += "        {\n";
                        data += "            $sql = 'UPDATE ' . $table . ' SET active=' . $activeStatus . ' WHERE id=' . $id;\n";
                        data += "            //echo '<br>SQL: ' . $sql . '<br>';\n";
                        data += "            if ($conn->query($sql) != TRUE) { echo 'Error changing active status' . $conn->error; }\n";
                        data += "        }\n";

                        data += "        if($quickDelete != '')\n";
                        data += "        {\n";
                        data += "            $sql = 'DELETE FROM ' . $table . ' WHERE id=' . $id;\n";
                        data += "            //echo '<br>SQL2: ' . $sql . '<br>';\n";
                        data += "            if ($conn->query($sql) != TRUE) { echo 'Error quickdeleting item' . $conn->error; }\n";
                        data += "        }\n";

                        data += "    }\n";

                        data += "}\n";
                        data += "\n";


						data += '' + '$' + 'isDebug = \'\'; if(isset(' + '$' + '_GET[\'poiu1234\'])) { $isDebug = \'1\'; }\n';
                        data += 'echo \'<div class="container-fluid"><div class="row"><div class="col-md-12 col-lg-12">\';\n';
                        data += 'echo \'<h1>My ' + phpSelectedTable + '</h1>\';\n';
						
                        data += '// pagination init\n';
                        data += '$firstText = "Alkuun";\n';
                        data += '$prevText = "Edellinen";\n';
                        data += '$nextText = "Seuraava";\n';
                        data += '$lastText = "Loppuun";\n';
                        data += '$limit = 20;\n';
                        data += '$page = 1;\n';
                        data += 'if (isset($_GET[\'p\'])) { $page = filter_input( INPUT_GET, \'p\', FILTER_SANITIZE_URL ); }\n';
                        data += '$start=($page-1)*$limit;\n';
                        data += '$totalItems = mysqli_num_rows(mysqli_query($conn,  "SELECT * FROM " . $table));\n';
                        data += '$totalPages = $totalItems/$limit;\n';

                        data += '// SELECT\n';
                        data += '$sql = "SELECT * FROM " . $table . " ORDER BY id LIMIT " . $start . ", " . $limit;\n';
                        data += '$result = mysqli_query($conn, $sql);\n';
                        data += 'if (mysqli_num_rows($result) > 0)\n';
                        data += '{\n';

                        data += '// pagination\n';
                        data += 'echo showPagination($thisPage, $firstText, $prevText, $nextText, $lastText, $totalPages, $start, $page, $limit);\n';

                        //data += '\techo \'<div class="container-fluid"><div class="row"><div class="col-md-12"><table class="table"><thead><tr>\';\n';
                        data += '\techo \'<table class=\"table table-hover\"><thead><tr>\';\n';

						
                        var phpSelectedTable = $('#tables .selected').attr('id');
                        var phpFields = getTable(phpSelectedTable);
                        var phpFieldsArr = phpFields.split(',');
                        var longestLength = getLongestLength(phpFields);
                        // data += '\t\techo \"<th>\" . \"Id\" ' + getSpaces(longestLength, 2) + '. \"</th>\";\n'; // 11 3 new
		// FAILS IF THERE IS A SINGLE EXTRA comma in the end of field names (,:)
                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\t\techo \"<th>\" . \"' + makeReadable(phpFieldsArr[i]) + '\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + '. \"</th>\";\n';							
                        }

                        data += '\techo "<th>&nbsp;</th>";\n';
                        data += '\techo "<th>&nbsp;</th>";\n';
                        data += '\techo \"</tr></thead>\";\n\n';

                        // tbody
                        data += '\techo \"<tbody>\"; \n';
                        data += '\twhile($row = mysqli_fetch_assoc($result))\n';
                        data += '\t{\n';
                        data += '\t\techo \"<tr>\";\n';
                        // data += '\t\techo \"<td>\" . $row[\"' + 'id' + '\"] ' + getSpaces(longestLength, 2) + '. \"</td>\";\n'; // 11 3 new
                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            if (includesWord('date', phpFieldsArr[i])) {
                                // date row     
                                data += '\t\techo \"<td>\" . displayDate($row[\"' + phpFieldsArr[i] + '\"]) ' + '. \"</td>\";\n';
                            } else if (includesWord('name', phpFieldsArr[i])) {
                                // name row
                                data += '\t\techo \"<td><a href=\\"\" . $nextPage . \"?id=\" . $row[\"id\"] . \'&action=\" title=\"View\">\' . $row[\"' + phpFieldsArr[i] + '\"] ' + '. \"</a></td>\";\n';
                                // <a href=\"exam.php?id=\' . $row[\"id\"] . \'&action=\" title=\"View\">\' . $row["examName"] . '</a></td>';
                            } else if (includesWord('active', phpFieldsArr[i])) {
								data += '\t\techo \"<td>\" . getActiveIcon($row[\"' + phpFieldsArr[i] + '\"]) ' + getSpaces(longestLength, phpFieldsArr[i].length) + '. \"</td>\";\n';
							} else if (includesWord('permission', phpFieldsArr[i])) {
                                //data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . getOnOffDroplist(\'active\', \'\', ' + '$' + 'active) . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
								data += '\t\techo \"<td>\" . getActiveIcon($row[\"' + phpFieldsArr[i] + '\"]) ' + getSpaces(longestLength, phpFieldsArr[i].length) + '. \"</td>\";\n';
                            } else {	
                                // default row
                                data += '\t\techo \"<td>\" . $row[\"' + phpFieldsArr[i] + '\"] ' + getSpaces(longestLength, phpFieldsArr[i].length) + '. \"</td>\";\n';
                            }
                        }
                        data += '\t\techo "<td>" . \'<a class="" href=\"\' . $nextPage . \'?id=\' . $row["id"] . \'&action=edit" title="Edit">\' . \'<i class="fa fa-edit" aria-hidden="true"></i>\' . "" . \'</a>\'. "</td>";\n';
                        
						data += '\t\techo "<td>" . \'<a class="" href=\"\' . $nextPage . \'?id=\' . $row["id"] . \'&action=delete" title="Delete">\' . \'<i class="fa fa-remove" aria-hidden="true"></i>\' . "" . \'</a>\'. "</td>";\n';
						data += '\t\t// TO ADD CONFIRM FUNCTION, ADD THIS TO DELETE LINK: onclick=\"return confirm(\'Confirm delete\');\" ';
						

                        data += '\t\techo \"</tr>\";\n';
                        data += '\t}\n';
                        data += '\techo \"</tbody>\";\n';
                        data += '\techo \"</table>\";\n';

                        data += '\t// pagination\n';
                        data += '\techo showPagination($thisPage, $firstText, $prevText, $nextText, $lastText, $totalPages, $start, $page, $limit);\n';
                        data += '\techo \'<br><a class="btn" href=\"\' . $nextPage . \'?action=edit">\' . "Add" . \'</a>\';\n';

                        data += '\techo \"</div></div></div>\";\n';
                        data += '} else { echo \"0 results\"; }\n';
                        data += 'echo \"<br>\";\n\n?>\n';



                        // FORM
                        // data += '// --------------------------------------------------------------\n\n';
                        // data += '// FORM\n\n';
                        // data += 'department: \n';
                        // data += '<select id=\"department\" name=\"department\" onchange=\"run()\">\n';
                        // data += '\t<option value=\"biology\">biology</option>\n';
                        // data += '</select><br><br>\n';

                        break;
                    case "getAllOld":
                        //data = 'using System.Data.SqlClient;\n\n\nstring data = \"\";\nusing (SqlDataReader reader = GetDataClass.GetLines(\"[fieldlist]\", \"[table]\", \"active=\'1\' AND langId\", langId, \"\"))\n{\n\twhile (reader.Read())\n\t {\n\t\tdata += \"\" + reader.GetInt32(0) + \". \";\n\t\tdata += reader.GetString(Globals.getDbFieldId(\"maps\", \"mapName\"));\n\t\tdata += \" <a href=\\"\" + Globals.PageContext.PageName + \"?del=\" + reader.GetInt32(0) + \"\\">Del</a>\"; \n\t}\n}\nreturn (string)data;\n\n';
                        // PHP
                        data = '';

                        // DB CONNECTION
                        data = '<?php\n\n';
                        data += '// DB settings\n';

                        // PHP testserver 
                        //data += '$servername = \"localhost\";\n';
                        //data += '$username = \"1029520\";\n';
                        //data += '$password = \"qwerty\";\n';
                        //data += '$dbname = \"1029520\";\n';
                        //data += '// Create connection\n';
                        //data += '$conn = new mysqli($servername, $username, $password, $dbname);\n';
                        //data += '// Check connection\n';
                        //data += 'if ($conn->connect_error) {\n';
                        //data += '    die(\"Connection failed: \" . $conn->connect_error);\n';
                        //data += '}\n\n';

                        // Amazon
                        data += '$conn = getDBConnection();\n';
                        data += '$table = \"[table]\";\n\n';


                        data += '// SELECT\n';
                        data += '$sql = \"SELECT * FROM \" . $table . \" ORDER BY id\";\n';
                        data += '$result = mysqli_query($conn, $sql);\n';
                        data += 'if (mysqli_num_rows($result) > 0)\n';
                        data += '{\n';
                        //data += '\techo \"<table>\";\n';
                        data += '\techo \'<div class="container-fluid"><div class="row"><div class="col-md-12"><table class="table"><thead><tr>\';\n';

                        // data += '\techo \"<th><tr><td>Id</td><td>CatId</td><td>PaCatId</td><td>LangId</td><td>Name</td><td>OrderId</td></tr></th><tbody>\"; \n';                        
                        //data += '\techo \"<th><tr>\";\n';
                        //data += '\t\techo \"<td>Id</td>\";\n';
                        var phpSelectedTable = $('#tables .selected').attr('id');
                        var phpFields = getTable(phpSelectedTable);
                        //data += '\n' + phpFields + '\n';
                        var phpFieldsArr = phpFields.split(',');
                        var longestLength = getLongestLength(phpFields);
                        data += '\t\techo \"<th>\" . \"Id\" ' + getSpaces(longestLength, 2) + '. \"</th>\";\n'; // new

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\t\techo \"<th>\" . \"' + makeReadable(phpFieldsArr[i]) + '\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + '. \"</th>\";\n';
                        }
                        //data += '\techo \"</tr></th>\"; \n\n';
                        data += '\techo \"</tr></thead>\";\n\n';

                        // tbody
                        data += '\techo \"<tbody>\"; \n';
                        data += '\twhile($row = mysqli_fetch_assoc($result))\n';
                        data += '\t{\n';
                        data += '\t\techo \"<tr>\";\n';
                        data += '\t\techo \"<td>\" . $row[\"' + 'id' + '\"] ' + getSpaces(longestLength, 2) + '. \"</td>\";\n'; // new                        
                        for (var i = 0; i < phpFieldsArr.length; i++) { data += '\t\techo \"<td>\" . $row[\"' + phpFieldsArr[i] + '\"] ' + getSpaces(longestLength, phpFieldsArr[i].length) + '. \"</td>\";\n'; }
                        data += '\t\techo \"</tr>\";\n';
                        data += '\t}\n';
                        data += '\techo \"</tbody>\";\n';
                        data += '\techo \"</table>\";\n';
                        data += '\techo \"</div></div></div>\";\n';
                        data += '} else { echo \"0 results\"; }\n';
                        data += 'echo \"<br>\";\n\n?>\n';

                        // FORM
                        // data += '// --------------------------------------------------------------\n\n';
                        // data += '// FORM\n\n';
                        // data += 'department: \n';
                        // data += '<select id=\"department\" name=\"department\" onchange=\"run()\">\n';
                        // data += '\t<option value=\"biology\">biology</option>\n';
                        // data += '</select><br><br>\n';

                        break;
                    case "getSingle":
                        //data = 'string id = Convert.ToString(Request.QueryString[\"id\"]);\nif (id != null && id.Length > 0)\n{\n\t// read from db\n\tInt32 fieldId = 2;\n\t\n\tstring del1 = Globals.getDbFieldName(Globals.PageContext.TableName, \"\");\n\tstring del2 = Globals.PageContext.TableName;\n\t\n\tusing (SqlDataReader reader = GetDataClass.GetLines(Globals.getDbFieldName(Globals.PageContext.TableName, \"\"), Globals.PageContext.TableName, \"id\", id, \"\"))\n\t{\n\t\twhile (reader.Read()) \n\t\t{\n\t\t\t[iterate]\n\t\t}\n\t}\n}\n';
                        //iterableSectionDroplist = '// FIELD droplist\n\t\t\tFIELDDropDownList.SelectedValue = (reader.GetInt32(Globals.getDbFieldId(Globals.PageContext.TableName, \"FIELD\")) > -1) ? FIELDDropDownList.SelectedValue = reader.GetInt32(Globals.getDbFieldId(Globals.PageContext.TableName, \"FIELD\")).ToString() : \"0\"; fieldId++;\n\t\t\t';
                        //iterableSectionTextbox = '// FIELD textbox for FIELD\n\t\t\tFIELDTextBox.Text = reader.GetString(Globals.getDbFieldId(Globals.PageContext.TableName, \" FIELD\")); fieldId++;\n\t\t\t\n\t\t\t// droplist\n\t\t\tFIELDDropDownList.SelectedValue = (reader.GetInt32(Globals.getDbFieldId(Globals.PageContext.TableName, \"FIELD\")) > -1) ? FIELDDropDownList.SelectedValue = reader.GetInt32(Globals.getDbFieldId(Globals.PageContext.TableName, \"FIELD\")).ToString() : \"0\"; fieldId++;\n\t\t\t// radio\n\t\t\tFIELDRadioButtonList.SelectedValue = reader.GetInt32(Globals.getDbFieldId(Globals.PageContext.TableName, \"FIELD\")).ToString();\n\t\t\t';
                        //iterableSectionRadio = '// FIELD radio\n\t\t\tFIELDRadioButtonList.SelectedValue = reader.GetInt32(Globals.getDbFieldId(Globals.PageContext.TableName, \"FIELD\")).ToString();\n\t\t\t';

                        // php
                        var phpSelectedTable = $('#tables .selected').attr('id');
                        var phpFields = getTable(phpSelectedTable);
                        var phpFieldsArr = phpFields.split(',');
                        var longestLength = getLongestLength(phpFields);
                        /* ----------------------------------- */
                        data = '';

                        // DB CONNECTION
                        data = '<?php\n\n';
                        // data += '// db settings\n';
                        // data += '$servername = \"localhost\";\n';
                        // data += '$username = \"1029520\";\n';
                        // data += '$password = \"qwerty\";\n';
                        // data += '$dbname = \"1029520\";\n';
                        // data += '// Create connection\n';
                        // data += '$conn = new mysqli($servername, $username, $password, $dbname);\n';
                        // data += '// Check connection\n';
                        // data += 'if ($conn->connect_error) {\n';
                        // data += '    die(\"Connection failed: \" . $conn->connect_error);\n';
                        // data += '}\n\n';

                        data += 'echo "<h3>Edit single</h3>";\n';

                        data += 'echo \'<form action=\"\' . htmlspecialchars(' + '$' + 'thisPage . \'&action=save\') . \'\" method=\"post\">\';\n';
                        data += 'echo "<table>";\n';

                        //data += 'echo \"<tr><td>\" . \"siteId:   \" . \"</td><td>\" . \'<input type=\"text\" value=\"\' . ' + '$' + 'siteId . \'\" name=\"siteId\">\' . \"</td></tr>\";\n';

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += 'echo \"<tr><td>\"';
                            data += ' . \"' + phpFieldsArr[i] + '\"';
                            data += ' . \"</td><td>\" . \'<input type=\"';
                            data += 'text';
                            data += '\" value=\"\' . ' + '$' + phpFieldsArr[i] + ' . \'\" name=\"' + phpFieldsArr[i] + '\">\'';
                            data += ' . \"</td></tr>\";\n';

                            //getSpaces(longestLength, phpFieldsArr[i].length)
                            // + ' $row[\"' + phpFieldsArr[i] + '\"] ' + getSpaces(longestLength, phpFieldsArr[i].length) +
                        }

                        //data += 'echo "<tr><td>" . "name:     " . "</td><td>" . '<input type="text" value="' . $name . '" name="name">' . "</td></tr>";\n';
                        //data += 'echo "<tr><td>" . "tableDesc:       " . "</td><td>" . '<textarea name="tableDesc" rows="5" cols="40">' . $tableDesc .'</textarea>' . "</td></tr>";\n';
                        //data += 'echo "<tr><td>" . "orderId:        " . "</td><td>" . $orderId . '<input type="hidden" value="' . $orderId . '" name="orderId">' . "</td></tr>";\n';

                        data += 'echo \"<tr><td>\" . \"&nbsp;\" . \"</td><td>\" . \'<input type=\"submit\" value=\"Save\">\' . \"</td></tr>\";\n';
                        data += 'echo "</table>";\n';
                        data += 'echo "</form>";\n\n\n\n';



                        // add new 
                        data += 'echo "<h3>Add new</h3>";\n';

                        data += 'echo \'<form action=\"\' . htmlspecialchars(' + '$' + 'thisPage . \'?action=save\') . \'\" method=\"post\">\';\n';
                        data += 'echo "<table>";\n';
                        data += '$siteId = \"URL DATA siteId ERROR\"; if (isset(' + '$' + '_GET[\'siteId\'])){ $siteId = filter_input( INPUT_GET, \'siteId\', FILTER_SANITIZE_URL );  }\n';

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += 'echo \"<tr><td>\"';
                            data += ' . \"' + phpFieldsArr[i] + '\"';
                            data += ' . \"</td><td>\" . \'<input type=\"';
                            data += 'text';
                            data += '\" value=\"\' . ' + '$' + phpFieldsArr[i] + ' . \'\" name=\"' + phpFieldsArr[i] + '\">\'';
                            data += ' . \"</td></tr>\";\n';
                        }

                        // echo "<tr><td>" . "siteId:   " . "</td><td>" . $siteId . '<input type="hidden" value="' . $siteId . '" name="siteId">' . "</td></tr>";   
                        // echo "<tr><td>" . "name:     " . "</td><td>" . '<input type="text" name="name">' . "</td></tr>";
                        // echo "<tr><td>" . "tableDesc:" . "</td><td>" . '<textarea name="tableDesc" rows="5" cols="40">' . $tableDesc .'</textarea>' . "</td></tr>";		                        

                        //data += 'echo \"<tr><td>\" . \"orderId:  \" . \"</td><td>\" . (getLargestValue(\"orderId\",\"gen_tables\",$conn)+1) . \"</td></tr>\";\n';
                        data += 'echo \"<tr><td>\" . \"&nbsp;\" . \"</td><td>\" . \"&nbsp;\" . \"</td></tr>\";\n\n\n\n';




                        // show one record
                        data += 'echo \"<h3>Single information</h3>\";\n';

                        data += 'echo \"<table>\";\n';

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += 'echo \"<tr><td>\"';
                            data += ' . \"' + phpFieldsArr[i] + ': \"';
                            data += ' . \"</td><td>\"';
                            data += ' . $row[\"' + phpFieldsArr[i] + '\"]';
                            data += ' . \"</td></tr>\";\n';
                        }
                        //echo \"<tr><td>\" . \"siteId: \" .     \"</td><td>\" . $row[\"siteId\"]    . \"</td></tr>\";
                        //echo \"<tr><td>\" . \"name: \" .       \"</td><td>\" . $row[\"name\"]      . \"</td></tr>\";
                        //echo \"<tr><td>\" . \"tableDesc: \" .  \"</td><td>\" . $row[\"tableDesc\"] . \"</td></tr>\";
                        //echo \"<tr><td>\" . \"orderId: \" .    \"</td><td>\" . $row[\"orderId\"]   . \"</td></tr>\";

                        data += 'echo \"<tr><td>\" . \"&nbsp;\" . \"</td><td>\" . \"&nbsp;\" . \"</td></tr>\";\n';
                        data += 'echo \"<tr><td>\" . \"\" . \"</td><td>\" . \'<a href=\"\' . ' + '$' + 'returnPage . \'\">Return</a>\' . \"</td></tr>\";\n';
                        data += 'echo \"</table>\";\n\n\n\n';






                        data += '$table = \"exams\";\n\n';

                        data += '// GET SINGLE - DISPLAY ONLY\n';
                        data += '$sql = \"SELECT * FROM \" . $table . \" LIMIT 1\";\n';
                        data += '$result = mysqli_query($conn, $sql);\n';
                        data += 'if (mysqli_num_rows($result) > 0)\n';
                        data += '{\n';

                        var phpSelectedTable = $('#tables .selected').attr('id');
                        var phpFields = getTable(phpSelectedTable);
                        //data += '\n' + phpFields + '\n';
                        var phpFieldsArr = phpFields.split(',');
                        var longestLength = getLongestLength(phpFields);
                        // form
                        data += '\twhile($row = mysqli_fetch_assoc($result))\n';
                        data += '\t{\n';

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\t\techo \"' + phpFieldsArr[i] + ': \" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + ' $row[\"' + phpFieldsArr[i] + '\"] ' + getSpaces(longestLength, phpFieldsArr[i].length) + '. \"<br>\";\n';
                        }
                        data += '\t\techo \"</tr>\";\n';
                        data += '\t}\n';

                        data += '} else { echo \"0 results\"; }\n';
                        data += 'echo \"<br>\";\n\n\n';

                        /* ----------------------------------- */
                        //data += 'ControlTypes:\n';
                        //var phpControlTypes2 = getTableControlTypes(phpSelectedTable);
                        //data += phpControlTypes2 + '\n';
                        //var phpControlTypesArr3 = phpControlTypes2.split(',');
                        //var tempArr = phpControlTypes2.split(',');

                        //data += 'ZZZZZZZZZZZZZZ: ' + tempArr[1] + '\n';

                        //for (var b = 0; b < phpControlTypesArr2.length; b++) 
                        //{
                        //    data += phpControlTypesArr2[b] + '\n';
                        //}
                        //data += '\n\n\n';

                        //data += 'TableDbTypes:\n';
                        //var phpTableDbTypesArr2 = (getTableDbTypes(phpSelectedTable)).split(',');
                        //for (var i = 0; i < phpTableDbTypesArr2.length; i++) {
                        //    data += phpTableDbTypesArr2[i] + '\n';
                        //}
                        //data += '\n\n\n';

                        /* ----------------------------------- */

                        data += '\n\n\n' + '// FORM 3';
                        data += '\n' + '<form action=\"importCategories.php\" method=\"post\">';

                        //data += '\n' + '\t category_name: ';
                        //data += '\n' + '\t <textarea name=\"category_name\"></textarea><br>';
                        //data += '\n' + '\t category_desc: <input type=\"text\" name=\"category_desc\"><br>';

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            //data += '\t\techo \"<td>\" . \"' + phpFieldsArr[i] + '\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + '. \"</td>\";\n';
                            data += '\n\t\t' + phpFieldsArr[i] + ':' + getSpaces(longestLength, phpFieldsArr[i].length);
                            data += '<input type=\"text\" name=\"' + phpFieldsArr[i] + '\">' + getSpaces(longestLength, phpFieldsArr[i].length) + ' <br>';
                        }


                        data += '\n' + '\t <input type=\"submit\" value=\"Save\">';
                        data += '\n' + '</form>';



                        break;
                    case "validate":
                        // php
                        var phpSelectedTable = $('#tables .selected').attr('id');
                        var phpFields = getTable(phpSelectedTable);
                        var phpFieldsArr = phpFields.split(',');
                        var longestLength = getLongestLength(phpFields);

                        var phpControlTypes = getTableControlTypes(phpSelectedTable);
                        var phpDBTypes = getTableDbTypes(phpSelectedTable);
                        // var phpControlTypesArr5 = phpControlTypes.split(',');
                        // var phpDBTypesArr = (phpDBTypes).split(',');


                        var DBtypes = getTable(phpSelectedTable);
                        var dbTypesArr = DBtypes.split(',');
// ---------------------- new validation 17.11.2017 --------------------------------- 

               data += '\n\n\n\n' + '<!-- --------- new form validation 17.11.2017 -------------- -->';
               data += '\n\n' + '<fieldset>';

               data += '\n\nphpControlTypes: ' + phpControlTypes + '\n\n';

               data += '\n' + '<input type="hidden" name="action" value="save">'; 
               data += '\n' + '<input type="hidden" id="countryId" name="countryId" value="<' + '?php echo $countryId; ?>">'; 
               data += '\n' + '<input type="hidden" id="langId" name="langId" value="<' + '?php echo $langId; ?>">'; 


               data += '\n\n\n' + '<!-- --------- input compulsory-------------- -->' + '\n';
               for (var i = 0; i < phpFieldsArr.length; i++) {
                data += '\n\n' + '<!-- ' + i + ' ' + phpFieldsArr[i] + ' input compulsory -->';
                data += '\n' + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + ':* </label>'; 
                data += '\n' + '<input type="text" id="' + phpFieldsArr[i] + '" name="' + phpFieldsArr[i] + '" ';
                data += '\n\t' + ' placeholder="type_placeholder_here" ';
                data += '\n\t' + ' class="validate[required]" ';
                data += '\n\t' + ' data-errormessage-value-missing="' + phpFieldsArr[i] + ' is required field." ';
                data += '\n\t' + '>'; 
               }

               data += '\n\n\n' + '<!-- --------- input -------------- -->' + '\n';
               for (var i = 0; i < phpFieldsArr.length; i++) {
                data += '\n\n' + '<!-- ' + i + ' ' + phpFieldsArr[i] + ' input -->';
                data += '\n' + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + ': </label>'; 
                data += '\n' + '<input type="text" id="' + phpFieldsArr[i] + '" name="' + phpFieldsArr[i] + '" ';
                data += '\n\t' + ' placeholder="type_placeholder_here" ';
                data += '\n\t' + '>'; 
               }

               data += '\n\n\n' + '<!-- --------- check compulsory -------------- -->' + '\n';
               for (var i = 0; i < phpFieldsArr.length; i++) {
                data += '\n\n' + '<!-- ' + i + ' ' + phpFieldsArr[i] + ' check compulsory -->';
                data += '\n' + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + ': </label>'; 
                data += '\n' + '<input type="text" id="' + phpFieldsArr[i] + '" name="' + phpFieldsArr[i] + '" ';
                data += '\n\t' + ' placeholder="type_placeholder_here" ';
                data += '\n\t' + ' class="validate[required]" ';
                data += '\n\t' + ' data-errormessage-value-missing="' + phpFieldsArr[i] + ' is required field." ';
                data += '\n\t' + '>'; 
               }

               data += '\n\n\n' + '<!-- --------- radio -------------- -->' + '\n';
               for (var i = 0; i < phpFieldsArr.length; i++) {
                data += '\n\n' + '<!-- ' + i + ' ' + phpFieldsArr[i] + ' radio -->';
                data += '\n' + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + ': </label>'; 
                data += '\n' + '<' + '?php echo getStylishRadioFromString(\"' + phpFieldsArr[i] + '\", ' + '$' + phpFieldsArr[i] + ', \"Choise 1,Choise 2,Choise 3\"); ?>' + '<br>';
               }

               data += '\n\n\n' + '<!-- --------- radio compulsory-------------- -->' + '\n';
               for (var i = 0; i < phpFieldsArr.length; i++) {
                data += '\n\n' + '<!-- ' + i + ' ' + phpFieldsArr[i] + ' radio compulsory-->';
                data += '\n' + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + ':* </label>'; 

                data += '\n' + '<input class="validate[required]" name="' + phpFieldsArr[i] + '" type="radio" value="a" ';
                data += '\n\t' + 'data-errormessage-value-missing="' + phpFieldsArr[i] + ' is required field." ';
                data += '\n\t' + 'data-prompt-position="bottomLeft"';
                data += '\n\t' + '> Choise A';
                data += '\n' + '<input name="gender" type="radio" value="b"> Choise B';
                data += '\n' + '<input name="gender" type="radio" value="c"> Choise C';
               }


               data += '\n\n\n' + '<!-- --------- checkbox compulsory -------------- -->' + '\n';
               for (var i = 0; i < phpFieldsArr.length; i++) {
                data += '\n\n' + '<!-- ' + i + ' ' + phpFieldsArr[i] + ' checkbox compulsory -->';
                data += '\n' + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + ':* </label>'; 
                data += '\n' + '<input class="validate[required]" type="checkbox" id="' + phpFieldsArr[i] + '" name="' + phpFieldsArr[i] + '" ';
                data += '\n\t' + 'data-errormessage-value-missing="You must accept ' + phpFieldsArr[i] + '." ';
                data += '\n\t' + 'data-prompt-position="bottomLeft"/> ' + phpFieldsArr[i] + '<br>';
               }

               data += '\n\n\n' + '<!-- --------- checkbox -------------- -->' + '\n';
               for (var i = 0; i < phpFieldsArr.length; i++) {
                data += '\n\n' + '<!-- ' + i + ' ' + phpFieldsArr[i] + ' checkbox -->';
                data += '\n' + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + ': </label>'; 
                data += '\n' + '<input class="validate[required]" type="checkbox" id="' + phpFieldsArr[i] + '" name="' + phpFieldsArr[i] + '" /> ' + phpFieldsArr[i] + '<br>';
               }










               data += '\n\n' + ' </fieldset>';

                        data += '\n\n\n\n\n\n\n\n\n' + '// FORM VALIDATION';
// ------------------------test----------------------------------
                        //data += '\n\n' + '// JS validation';
                        data += '\n\n' + '// List all info';
                        // 570  DBtype,DBtype:Control,Control:Label,Label:Error,Error

                var selectedTable = $('#tables .selected').attr('id');
                var fields = getTable(selectedTable);
                var controlTypesArr = getTableControlTypes(selectedTable);
                var action = id;
                var table = getTable(selectedTable); // tablename+fields
                data = data.replaceAll("[table]", selectedTable);
                data = data.replaceAll("[fieldlist]", fields);
                // [0]=db table name, [1] = db fieldnames, [2]=db field types (id,t50), [3] = controltype (d=droplist,t=textbox,r=radio)
                var fieldsArr = fields.split(',');
                var phpControlTypes7 = getTableControlTypes2(selectedTable);
                var dbTypesArr7 = phpControlTypes7.split(":")[2].split(",");
                var phpControlTypesArr7 = phpControlTypes7.split(":")[3].split(",");
                // data += '\n\nphpControlTypes7:  ' + phpControlTypesArr7 + '\n';
                var comp = '';


                var nl = '\n'; var t = '\t'; var nlt = '\n\t'; var nlt2 = '\n\t\t'; var nlt3 = '\n\t\t\t';
                // nl=t=nlt=nlt2=nlt3=''; // in production
                var rb = nl + '<div class="form-group">' + nl;
                var rm = '';
                var re = '</div>' + nl;

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\n' + phpFieldsArr[i] + ' -- ';
                            //data += phpDBTypesArr[i] + ' - ';
                            //data += phpControlTypesArr[i] + ' ';

                            
                            switch (phpControlTypesArr7[i])  // .substr(0, 1)
                            {
case "input": 
    data += nl + '// ' + phpFieldsArr[i]; 
    data += rb + t + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + '</label>' + rm + nlt;
    data += '<input type="text" name="' + phpFieldsArr[i] + '" '  + nlt2;
    data += 'data-validation="length alphanumeric" ' + nlt2;
    data += 'data-validation-length="3-50" ' + nlt2;
    data += 'data-validation-error-msg-container="#' + phpFieldsArr[i] + '_error" ' + nlt2;
    data += 'data-validation-ignore="-åäöÅÄÖ">' + nlt2;
    data += '<div id="' + phpFieldsArr[i] + '_error">' + nl;
    data += re;
    break; 

case "email": 
    data += nl + '// ' + phpFieldsArr[i]; 
    data += rb + t + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + '</label>' + rm + nlt;
    data += '<input type="text" name="' + phpFieldsArr[i] + '" '  + nlt2;
    data += 'data-validation="email" ' + nlt2;
    data += 'data-validation-error-msg-container="#' + phpFieldsArr[i] + '_error" ' + nlt2;
    data += 'data-validation-ignore="-åäöÅÄÖ">' + nlt2;
    data += '<div id="' + phpFieldsArr[i] + '_error">' + nl;
    data += re;
    break; 

case "password": 
    data += nl + '// ' + phpFieldsArr[i]; 
    data += rb + t + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + '</label>' + rm + nlt;
    data += '<input type="password" name="pass_confirmation" '  + nlt2;
    data += 'data-validation="strength" '  + nlt2;
    data += 'data-validation-strength="2" '  + nlt2;
    data += 'data-validation-length="8-50" '  + nlt2; 
    data += 'data-validation-help=" Vinkki: Salasanan tulee olla yli 8 merkkiä pitkä ja siihen on hyvä laittaa numeroita erikoismerkkejä."> '  + nl;
    data += '<div id="' + phpFieldsArr[i] + '_error">' + nl;
    data += re;
    // repeat password
    data += nl + '// repeat password'; 
    data += rb + t + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + '</label>' + rm + nlt;
    data += '<input type="password" name="pass" data-validation="confirmation" '  + nlt2;
    data += 'data-validation-error-msg-container="#' + phpFieldsArr[i] + '_error" ' + nlt2;
    data += 'data-validation-help=" Syötä sama salasana uudelleen."> '  + nl;
    data += '<div id="' + phpFieldsArr[i] + '_error">' + nl;
    data += re;
    break; 

case "droplist": data += 'droplist'; 
    break; 
case "gender":  
    data += nl + '// ' + phpFieldsArr[i];
    data += rb + t + '<label for="' + phpFieldsArr[i] + '">' + phpFieldsArr[i] + '</label>' + rm + nlt;
    data += '<input type="radio" data-validation="required" name="gender[]">Female<br />'  + nl;
    data += '<input type="radio" data-validation="required" name="gender[]">Male<br />'  + nlt;
    data += 'data-validation-error-msg-container="#' + phpFieldsArr[i] + '_error" ' + nlt;
    data += '<div id="' + phpFieldsArr[i] + '_error">' + nl;
    data += re;
    break; 

case "yyyy":
    break; 

case "droplistFromString": data += ' \
\n// droplist from string \n \
echo "<tr><td>" . "weightId:" . "</td><td>Max " . $weightId .  getDroplistFromString("weightId", "--- select ---", $weightId, "0.2,0.5,1,2,5,7,10,13,15,17,20,25,30") . " kg</td></tr>"; \n';
    break; 
case "on-off": data += 'on-off'; 
                                    break; 
                                case "dateRange": 
                                    getJsCode('dateRange'); 
                                    data += ' \
                                    \n// date range \n \
                                    echo \'<tr><td>\' . \'Date range\' . \'</td><td>\'; \n \
                                    echo \'<table><tr><td>\'; \n \
                                    echo \'   <div id="jrange" class="dates">\'; \n \
                                    echo \'    <input placeholder="Nouto pvm - perillä pvm" />\'; \n \
                                    echo \'    <div></div>\'; \n \
                                    echo \'   </div>\'; \n \
                                    echo \'</td><td>\'; \n \
                                     \
                                    echo \'</td></tr></table>\'; \n \
                                    echo \'</td></tr>\'; \n \
                                    ';
                                    break; 
                                //default: data += phpControlTypesArr7[i] + ', ';



                                default: data += "ERROR: " + dbTypesArr7[i] + ', '; break;
                            }
                            
                        }
                        
                        //data += '\n\n' + phpControlTypes + '\n'; // t,t,t,t,t
                        //data += '\n\n' + phpDBTypes + '\n'; // TINYINT UNSIGNED,INT,VARCHAR(50),VARCHAR(60)



 // ----------------------------------------------------------
                        data += '\n\n\n' + '// define variables and set to empty values';

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\n$' + phpFieldsArr[i] + getSpaces(longestLength, phpFieldsArr[i].length) + ' = ';
                        }
                        data += '"";' + '\n';

                        // part 2 A   if (empty($_POST
                        data += '\n\n// EACH FIED HAS OWN ERROR VARIABLE';
                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\n' + 'if (empty($_POST[\"' + phpFieldsArr[i] + '\"])) ' + getSpaces(longestLength, phpFieldsArr[i].length) + '{ $' + phpFieldsArr[i] + 'Err = ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"' + phpFieldsArr[i] + ' is required\"; } ' + getSpaces(longestLength, phpFieldsArr[i].length) + 'else { $' + phpFieldsArr[i] + ' = ' + getSpaces(longestLength, phpFieldsArr[i].length) + 'test_input($_POST[\"' + phpFieldsArr[i] + '\"]); }';
                        }
                        data += '\n\n';

                        // part 2 B   if (empty($_POST
                        data += '\n\n// ALL ERRORS IN ONE VARIABLE';
                        data += '\n$' + 'err = "";';
                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\n' + 'if (empty($_POST[\"' + phpFieldsArr[i] + '\"])) ' + '{ $' + 'err .= ' + '\"' + phpFieldsArr[i] + ' is required<br>\"; } ' + 'else { $' + phpFieldsArr[i] + ' = ' + 'test_input($_POST[\"' + phpFieldsArr[i] + '\"]); }';
                        }

                        // part 3
                        data += '\n\n\n' + '// CONTROLS' + '\n\n';
                        var phpControlTypesArr = getTableControlTypes(phpSelectedTable);
                        for (var j = 0; j < phpControlTypesArr.length; j++) {
                            data += '\n' + phpFieldsArr[j] + ':';

                            // input
                            if (phpControlTypesArr[j] == 't') {
                                //data += '\n <!-- ' + phpFieldsArr[j] + ' input -->\n';
                                data += getSpaces(longestLength, phpFieldsArr[j].length) + ' <input type=\"text\" name=\"' + phpFieldsArr[j] + '\">\n';
                            }

                            // radio
                            if (phpControlTypesArr[j] == 'r') {
                                data += '\n\n <!-- ' + phpFieldsArr[j] + ' radiobuttons -->\n';
                                data += getSpaces(longestLength, phpFieldsArr[j].length) + ' <input type="radio" name="' + phpFieldsArr[j] + '" value="Choise1">Choise 1\n';
                                data += getSpaces(longestLength, phpFieldsArr[j].length) + '\t <input type="radio" name="' + phpFieldsArr[j] + '" value="Choise2">Choise 2\n';
                                // <input type="radio" name="gender" value="male">Male
                                data += '\t';
                            }

                            // check
                            //if (phpControlTypesArr[j] == 'c') { }

                            // drop
                            if (phpControlTypesArr[j] == 'd') {
                                data += '\n\n <!-- ' + phpFieldsArr[j] + ' droplist -->\n';
                                data += '<select id=\"department\" name=\"department\" onchange=\"run()\">\n';
                                data += '\t<option value=\"choise1\">choise1</option>\n';
                                data += '\t<option value=\"choise2\">choise2</option>\n';
                                data += '\t<option value=\"choise3\">choise3</option>\n';
                                data += '</select><br><br>\n';
                            }

							// next line temp commented out because of PHP error
                            
                        }

						
						
						// HIDDEN CONTROLS
						data += '\n' + '// HIDDEN CONTROLS' + '\n\n';
						data += '\n\n';
						for (var j = 0; j < phpControlTypesArr.length; j++) {
                            data += '' + ' <input type=\"hidden\" name=\"' + phpFieldsArr[j] + '\" value=\"\">\n';

							}



                        /*
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
                        Name: <input type="text" name="name">
                        <span class="error">* <?php echo $nameErr;?></span><br><br>

                        Comment: <textarea name="comment" rows="5" cols="40"></textarea>
                        <br><br>

                        Gender:
                        <input type="radio" name="gender" value="female">Female
                        <input type="radio" name="gender" value="male">Male
                        <span class="error">* <?php echo $genderErr;?></span>
                        <br><br>

                        <input type="submit" name="submit" value="Submit">  
                        </form>
                        */
                     break;
                    case "vue": data = '\n';    
                      var phpSelectedTable = $('#tables .selected').attr('id');
                        var phpFields = getTable(phpSelectedTable);
                        var phpFieldsArr = phpFields.split(',');
                        var longestLength = getLongestLength(phpFields);
                        /* ----------------------------------- */
                        data = '';
                        data += '\n' + '// ------------------------------------ GET -------------------------------' + '\n\n';
                        
                        data += '<'+'?'+'php \n';
                        data += 'include_once(\'functions.php\'); \n'; 
                        data += '$' + 'conn = getDBConn(\'noWelcomeText\'); \n';

                        data += '\n' + '// read from url' + '\n';
                        //$someId = '-1';
                        data += '$' + 'someId = \'-1\';' + '\n';
                        //$someId = filter_input( INPUT_GET, "s", FILTER_SANITIZE_URL );
                        data += '$' + 'someId = filter_input( INPUT_GET, \"s\", FILTER_SANITIZE_URL );' + '\n';
                        // if($some == '') { echo "<br>Error - hsomeId missing!"; exit; }
                        data += 'if(' + '$' + 'some == \'\') { echo \"Error - someId missing!\"; exit; }' + '\n';


                        data += '\n' + '// OR read from postdata' + '\n';
                        // $content = file_get_contents('php://input');
                        data += '$' + 'content = file_get_contents(\'php://input\');' + '\n';
                        // $d = json_decode($content, true);
                        data += '$' + 'd = json_decode('+'$'+'content, true);' + '\n\n';

                        // $sql = "SELECT id,machineId...,aptNumber FROM bookings WHERE houseId = $houseId ORDER BY date,startTime";
                        data += '$' + 'sql = \"SELECT ';
                        for (var i = 0; i < phpFieldsArr.length-1; i++) { data += phpFieldsArr[i] + ','; }
                        data += phpFieldsArr[phpFieldsArr.length-1];
                        data += ' FROM XXXXXXXX WHERE someId = ' + '$' + 'someId\";';

                        // $result = mysqli_query($conn, $sql);
                        data += '\n' + '$'+'result = mysqli_query('+'$'+'conn, '+'$'+'sql);' + '\n';
                        // if ($result === false) { 
                        data += 'if ('+'$'+'result === false) {' + '\n';
                        // echo 0;
                        data += 'echo 0;' + '\n';
                        // exit;
                        data += 'exit;' + '\n';

                        data += '}' + '\n\n\n';

                        data += '// ---------- pass DB object --------- \n';
                        // pass DB object
                        // $array = (array) $result;
                        data += '$'+'array = (array) ' + '$' + 'result;' + '\n\n\n';

                        data += '// ---------- read each field --------- \n';
                        // while($row = mysqli_fetch_assoc($result)){
                        data += '' + '\n';

                        // $arr = array(); 
                        data += '$'+'arr = array();' + '\n';

                        // array_push($arr, array(
                        data += 'array_push(' +'$'+ 'arr, array(' + '\n';
                        // 'id'         => $row['id'],
                        for (var i = 0; i < phpFieldsArr.length-1; i++) { 
                            data += '\t'+'\'' + '' + phpFieldsArr[i] + '\' => ' +
                            '$'+'row[\'' + phpFieldsArr[i] + '\'],' + '\n'; 
                        }                        
                        data += '\t'+'\'' + '' + phpFieldsArr[phpFieldsArr.length-1] + '\' => ' +
                            '$'+'row[\'' + phpFieldsArr[phpFieldsArr.length-1] + '\']' + '\n';

                        //  ));
                        data += '\t' + '));' + '\n';
                        // }
                        data += '}' + '\n';
                        // header('Content-Type: application/json');
                        data += 'header(\'Content-Type: application/json\');' + '\n';
                        // echo json_encode($arr);
                        data += 'echo json_encode(' +'$'+ 'arr);' + '\n';
                        // ? >
                        data += '?>' + '\n\n\n';




                        data += '\n' + '// --------------------------------- SAVE ------------------------------' + '\n\n';

                        data += '<'+'?'+'php \n';
                        data += 'include_once(\'functions.php\'); \n'; 
                        data += '' + '$' + 'conn = getDBConn(\'noWelcomeText\'); \n\n';


                        // $isPublished = ... $lang = NULL;
                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '$' + phpFieldsArr[i] + ' = ';
                        }
                        data += 'NULL;' + '\n\n';

                        data += '// ---------- if  all fields have values --------- \n';
                        // $content = file_get_contents('php://input');
                        data += '$' + 'content = file_get_contents(\'php://input\');' + '\n';
                        // $d = json_decode($content, true);
                        data += '$' + 'd = json_decode('+'$'+'content, true);' + '\n';


                        // $ table = "bookings";    
                        data += '$' + 'table = \"XXXXXX";' + '\n';
                        // $ fields = "userId,houseId,machineId,date,startTime,name,aptNumber";
                        data += '$' + 'fields = \"';
                        for (var i = 0; i < phpFieldsArr.length-1; i++) { data += phpFieldsArr[i] + ','; }
                        data += phpFieldsArr[phpFieldsArr.length-1];
                        data += '\";';

                        /*$ values = 
                        $ d["userId"]    . "," . 
                        $ d["houseId"]   . "," . 
                        $ d["machineId"]     . "," . 
                        $ d["date"]      . "," . 
                        $ d["startTime"]     . ",'" . 
                        $ d["name"]  . "','" . 
                        $ d["aptNumber"] . "'"; */
                        data += '\n\n' + '$' + 'values = ' + '\"\'\"' + '\n';
                        for (var i = 0; i < phpFieldsArr.length-1; i++) { 
                            data += '$'+'d'+'[\"' + phpFieldsArr[i] + '\"'+'] . \"\',\'\" . '+'\n'; 
                        }
                        data += '$'+'d'+'[\"' + phpFieldsArr[phpFieldsArr.length-1] + '\"'+'] . \"\'\"; '+'\n\n'; 
                        


                        data +=  '\n' + '// ---------- if not all fields have values --------- \n';
                        // if (isset($_GET["title"]))
                        // {
                        data += 'if (isset($_GET[\"' + phpFieldsArr[0] + '\"]))' + '\n';
                        data += '{' + '\n';

                        // if($_GET["videoIid"] != null) { $videoIid = $_GET["videoIid"]; }
                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\t' + 'if(' + '$' + '_GET[\"' + phpFieldsArr[i] + '\"] != null)' + getSpaces(longestLength, phpFieldsArr[i].length) + ' { ' + '$' + phpFieldsArr[i] + ' = ' + '$' + '_GET[\"' + phpFieldsArr[i] + '\"]; }' + '\n';
                        }
                        data += '}' + '\n\n';

                        data +=  '\n' + '// -------------------------------------------------- \n';

                        //$values = $houseId . "," . $isAdmin . ",'" . $name . "','" . $email . "','" . $password . "','" . $aptNumber . "'";
                        data += '$' + 'values = \"\'\" . '; 
                        for (var i = 0; i < phpFieldsArr.length-1; i++) { 
                            data += '$' + phpFieldsArr[i] + ' . \"\',\'\" . '; 
                        }
                        data += phpFieldsArr[phpFieldsArr.length-1] + ' . \"\'\";' + '\n';

                        // $sql = "INSERT INTO " . $table . " (" . $fields . ") VALUES (" . $values . ")";
                        data += '$' + 'sql = \"INSERT INTO \" . ' + '$' + 'table . \" (\" . ' + '$' + 'fields . \") VALUES (\" . ' + '$' + 'values . \")\";'  + '\n\n';

                        // if ($conn->query($sql) === TRUE) {
                        data += 'if (' + '$' + 'conn->query(' + '$' + 'sql) === TRUE) {' + '\n';
                        // $arr = array('id' => mysqli_insert_id($conn));
                        data += '\t' + '$' + 'arr = array(\'id\' => mysqli_insert_id(' + '$' + 'conn));' + '\n';
                        //     header('Content-Type: application/json');
                        data += '\t' + 'header(\'Content-Type: application/json\');' + '\n';
                        //     echo json_encode($arr);
                        data += '\t' + 'echo json_encode(' + '$' + 'arr);' + '\n';
                        // } else {
                        data += '} else {' + '\n';
                        // echo 'error:' . $conn -> error; // remove in production
                        data += '\t' + 'echo \'error: \'' + '$' + 'conn -> error;  // remove in poroduction' + '\n';
                        // }
                        data += '}' + '\n\n';

                        // $conn->close();     
                        data += '$' + 'conn->close();' + '\n';
                        // ? > 
                        data += '?>' + '\n\n\n';




                        data +=  '\n' + '// ------------------------ DELETE -------------------------- \n\n\n';

                        data += '<'+'?'+'php \n';
                        data += 'include_once(\'functions.php\'); \n'; 
                        data += '' + '$' + 'conn = getDBConn(\'noWelcomeText\'); \n';
                        // $err = '';
                        data += '$' + 'err = \'\';' + '\n\n';

                        // $content = file_get_contents('php://input');
                        data += '$' + 'content = file_get_contents(\'php://input\');' + '\n';
                        // $d = json_decode($content, true);
                        data += '$' + 'd = json_decode('+'$'+'content, true);' + '\n';
                        // $id = $d["id"];
                        data += '$' + 'd[\"id\"];' + '\n\n';

                        // $sql = "DELETE FROM XXXXXX WHERE id = $id LIMIT 1"; 
                        data += '$' + 'sql = \"DELETE FROM XXXXXX WHERE id = ' + '$' + 'id LIMIT 1\";' + '\n\n';


                        // if ($conn->query($sql) === TRUE) {
                        data += 'if ' + '$' + 'conn->query(' + '$' + 'sql) === TRUE) {' + '\n';
                        // echo 1;
                        data += '\t' + 'echo 1;' + '\n';
                        // } else {
                        data += '} else {' + '\n';
                        // echo 'error:' . $conn -> error; // remove in production
                        data += '\t' + 'echo \'error: \'' + '$' + 'conn -> error;  // remove in poroduction' + '\n';
                        // }
                        data += '}' + '\n\n';

                        // $conn->close();     
                        data += '$' + 'conn->close();' + '\n';
                        // ? > 
                        data += '?>' + '\n\n\n';


                        data +=  '\n' + '// ------------------------ VUEX -------------------------- \n\n\n';

                        /*
                        const state = {  
                            code: [],
                            house: null,
                            user: [],
                            bookings: [],
                            booking: []
                          }; */
                        data += 'const state = {' + '\n';
                        for (var i = 0; i < phpFieldsArr.length-1; i++) { 
                            data += '\t' + phpFieldsArr[i] + ': [],' + '\n';
                        }
                        data += '\t' + phpFieldsArr[phpFieldsArr.length-1] + ': []' + '\n';
                        data += '};'+ '\n';
                        data += '// NOTE: all are set as arrays!'+ '\n\n';

                        /*
                          const getters = {
                            code: state => state.code,
                            house: state => state.house,
                            user: state => state.user,
                            bookings: state => state.bookings,
                            booking: state => state.booking
                          };
                        */
                        data += 'const getters = {' + '\n';
                        for (var i = 0; i < phpFieldsArr.length-1; i++) { 
                            data += '\t' + phpFieldsArr[i] + ': '+ 
                                'state => state.'+
                                phpFieldsArr[i] + ',' + '\n';
                        }
                        data += '\t' + phpFieldsArr[phpFieldsArr.length-1] + ': state => state.'+
                                phpFieldsArr[phpFieldsArr.length-1] + '' + '\n';
                        data += '};'+ '\n\n';

                        // const actions = {
                        data += 'const actions = {' + '\n';
                        data += 'async saveItem({ commit }, data) {' + '\n';
                        data += '  let newId = null; ' + '\n';
                        data += '  let postData = null;' + '\n';
                        data += '  if(data) { postData  = JSON.stringify(data); }' + '\n';
                        data += '  const url = \'https://stuffonaut.com/XXXXXXXX/saveItem.php\';' + '\n';
                        data += '  fetch(url, {' + '\n';
                        data += '    method: \'POST\',' + '\n';
                        data += '    headers: new Headers({' + '\n';
                        data += '        \'Content-Type\': \'application/json\',' + '\n';
                        data += '        \'Accept\': \'application/json\'' + '\n';
                        data += '      }),' + '\n';
                        data += '    body: postData' + '\n';
                        data += '  }).then(res => {' + '\n';
                        data += '    if (res.ok) {' + '\n';
                        data += '      return res.json();' + '\n';
                        data += '    } else {' + '\n';
                        data += '      console.log(res);' + '\n';
                        data += '    }' + '\n';
                        data += '  }).then(newItem => {' + '\n';
                        data += '    data.id = newItem.id;' + '\n';
                        data += '    commit(\'setXXXX\', data);' + '\n';
                        data += '  })' + '\n';
                        data += '  .catch(error => { ' + '\n';
                        data += '    console.error(error);' + '\n';
                        data += '  }); ' + '\n';
                        data += '},' + '\n\n';

                        data += '}; // end actions' + '\n\n\n\n';

                        /*
                        async saveItem({ commit }, data) {       
                          let newId = null; 
                          let postData = null;
                          if(data) { postData  = JSON.stringify(data); }
                          const url = 'https://stuffonaut.com/XXXXXXXX/saveItem.php';
                          fetch(url, {
                            method: 'POST',
                            headers: new Headers({
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                              }),
                            body: postData
                          }).then(res => {
                            if (res.ok) {
                              return res.json();
                            } else {
                              console.log(res);
                            }
                          }).then(newItem => {
                            data.id = newItem.id;
                            commit('setXXXX', data);
                          })
                          .catch(error => { 
                            console.error(error);
                          }); 
                        },
                        */




                        /*
                          const mutations = {
                            setBookings: (state, bookings) => (state.bookings = bookings),
                            setBooking: (state, booking) => (state.booking = booking),
                            addBooking: (state, data) => state.bookings.push(data),    
                            removeBooking: (state, bookings) => state.bookings.filter(booking => booking.id !== id)
                          };
                        */
                        data += '// NOTE: REMOVE UNNEEDED ONES!'+ '\n';
                        // const mutations = {
                        data += 'const mutations = {' + '\n'; 

                        var mutationtypesArr = 'set,set,add,remove'.split(",");
                        for (var m = 0; m < mutationtypesArr.length; m++) { 
                            // if(m==1) { phpFieldsArr[i] = phpFieldsArr[i] + 's'; } // add s

                            // setBookings: 
                            for (var i = 0; i < phpFieldsArr.length; i++) { 
                                // setBookings: 
                                data += '\t' + mutationtypesArr[m] + phpFieldsArr[i].charAt(0).toUpperCase() + phpFieldsArr[i].slice(1) + ': ';
                                // (state, bookings) => (state.bookings = bookings),
                                //data += '(state, ' + phpFieldsArr[i] + ') => (state.'+
                                //    phpFieldsArr[i] + ' = ' + phpFieldsArr[i] + '),\n';
                                data += '(state, data) => (state.'+
                                    phpFieldsArr[i] + ' = data),\n';
                            }
                            data += '\n';
                        }           
                        data += '};'+ '\n\n';


                          /*
                          export default {
                            state,
                            getters,
                            actions,
                            mutations
                          };
                          */
                        data += 'const default = {' + '\n';
                        for (var i = 0; i < phpFieldsArr.length-1; i++) { 
                            data += '\t' + phpFieldsArr[i] + ',' + '\n';
                        }
                        data += '\t' + phpFieldsArr[phpFieldsArr.length-1] + '\n';
                        data += '};'+ '\n';


                        /*
                        data +=  '\n' + '// ------------------------ ROUTES -------------------------- \n\n\n';
                        data += '// NOTE: REMOVE UNNEEDED ONES!'+ '\n';
                        data += 'routes: ['+ '\n';
                        for (var i = 0; i < phpFieldsArr.length-1; i++) {                             
                            data += '\t'+'{'+ '\n';
                            // path: '/login',
                            data += '\t\t' + 'path: \'/'+phpFieldsArr[i] + '\',' + '\n';
                            // name: 'login',
                            data += '\t\t' + 'name: \''+phpFieldsArr[i] + '\',' + '\n';
                            // component: Login
                            data += '\t\t' + 'component: '+ 
                                phpFieldsArr[i].charAt(0).toUpperCase() + phpFieldsArr[i].slice(1) + '\n';
                            data += '\t'+'},'+ '\n';
                        }
                        data += ']'+ '\n';
                        */

/*
routes: [
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  */



                        break;
                    case "saveUpdate":
                        // php - save
                        var phpSelectedTable = $('#tables .selected').attr('id');
                        var phpFields = getTable(phpSelectedTable);
                        var phpFieldsArr = phpFields.split(',');

                        //$fields = "tableId,name,db_FieldTypeId,db_notNull,db_defaultValue,form_TypeId,form_errorTextContentId,form_foreignKey,form_foreignValue,form_foreignOrderBy,fieldDesc,orderId";
                        //$values = $tableId . ", " . $name . ", " . $db_FieldTypeId . ", " . $db_notNull . ", " . $db_defaultValue . ", " . $form_TypeId . ", " . $form_errorTextContentId . ", " . $form_foreignKey . ", " . $form_foreignValue . ", " . $form_foreignOrderBy . ", " . $fieldDesc . ", " . $orderId;

                        var allPhpFields = '$fields = \"';
                        var allPhpValues = '$values = ';

                        var longestLength = getLongestLength(phpFields);

                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '$' + phpFieldsArr[i] + ' = ' + getSpaces(longestLength, phpFieldsArr[i].length) + '$array[\"' + phpFieldsArr[i] + '\"];\n';
                            allPhpFields += phpFieldsArr[i] + ',';
                            allPhpValues += '$' + phpFieldsArr[i] + ' . \", \" . ';
                        }

                        allPhpFields = allPhpFields.substr(0, allPhpFields.length - 1);
                        allPhpValues = allPhpValues.substr(0, allPhpValues.length - 10);
                        allPhpFields += '\";\n';
                        allPhpValues += ';\n';
                        data += '\n' + allPhpFields;
                        data += allPhpValues;

                        // data += '\n';
                        // data += '$sql = \"INSERT INTO \" . $table . \" (\" . $fields . \") VALUES (\" . $values . \");";\n';
                        // data += 'if ($conn->query($sql) === TRUE) {\n';
                        // data += '\t$result = \"1\";\n';
                        // data += '\techo \"Record inserted successfully in \" . $table . \"<br>\";\n';
                        // data += '} else { \n';
                        // data += '//echo $sql . \"<br>Error inserting record: \" . $conn->error . \"<br><br><br>\";\n';
                        // data += '$result = \"0\";\n';
                        // data += '}\n';

                        // ------------------------ NEW EDIT UPDATE - ALL IN SINGLE PAGE --------------------------
                        data = '';
                        data += '// <?php\n';
						data += '// session_start();\n';						
						var includesFolder = '../includes/';
                        data += '// include(\'' + includesFolder + 'dataFunctions.php\');\n'; 
                        data += '// include(\'' + includesFolder + 'functions.php\');\n';
                        //data += 'include(\'' + includesFolder + 'date.php\');\n';
                        data += '// include(\'' + includesFolder + 'header.php\');\n';
                        data += '// ' + '$' + 'conn = getDBConnection();\n';
                        data += '\n';			
						
                        data += '// ' + '$' + 'selectedId = \"\";\n';
                        data += '// ' + '$' + 'thisPage = \"' + removeLastChar(phpSelectedTable) + '.php\";\n';
                        data += '// ' + '$' + 'returnPage = \"' + phpSelectedTable + '.php\";\n';
                        data += '// ' + '$' + 'table = \"' + phpSelectedTable + '\";\n';
                        data += '// ' + '$' + 'selectedId = \"\";\n';

						data += '\n\n// --------------------- BEGIN CODE ------------------------\n';
						data += '\n';			
						data += '' + '$' + 'isDebug = \'\'; if(isset(' + '$' + '_GET[\'poiu1234\'])) { $isDebug = \'1\'; }\n';
						data += 'if(!empty($_SESSION["info"])) { echo \'<div class="panel panel-success"><div class="panel-heading">\' . $_SESSION["info"] . \'</div></div>\'; $_SESSION["info"] = \'\'; }\n';
						data += 'if(!empty($_SESSION["error"])) { echo \'<div class="panel panel-error"><div class="panel-heading">Error</div><div class="panel-body">\' . $_SESSION["error"] . \'</div></div>\'; $_SESSION["error"] = \'\'; }\n';
						data += '\n';

                        data += '\n';
                        data += '// read id from url\n';
                        data += '' + '$' + 'siteId = \"\";\n';
                        data += 'if (isset(' + '$' + '_GET[\'id\']))\n';
                        data += '{\n';
                        data += '  ' + '$' + 'selectedId = filter_input( INPUT_GET, \'id\', FILTER_SANITIZE_URL );\n';
                        data += '  ' + '$' + 'thisPage .= \"?id=\" . ' + '$' + 'selectedId;\n';
                        data += '  ' + '$' + 'returnPage .= \"?siteId=\" . ' + '$' + '_GET[\"id\"];\n';
                        data += '	  echo \'The id is: \' . ' + '$' + 'selectedId;\n';
                        // data += '} else {\n';
                        // data += '  ' + '$' + 'returnPage .= \"?siteId=\" . ' + '$' + '_GET[\"siteId\"];\n';
                        data += '}\n';
                        data += '\n';

                        // define vars
                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '$' + phpFieldsArr[i] + ' = ';
                        }
                        data += '"";\n';

                        // get posted values
                        data += 'if (isset($_POST[\"' + phpFieldsArr[1] + '\"]))\n';
                        data += '{\n';
                        //data += '\t$' + phpFieldsArr[0] + ' = getLargestValue(\'id\', ' + '$' + 'table, ' + '$' + 'conn);\n';
                        //// $orderId = $_POST["orderId"];
                        for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += '\t$' + phpFieldsArr[i] + ' = ' + getSpaces(longestLength, phpFieldsArr[i].length) + '$' + '_POST[\"' + phpFieldsArr[i] + '\"];\n';
                        }
                        data += '}\n';
                        //data += '$' + 'siteId =    ' + '$' + '_POST[\"siteId\"];\n';
                        //data += '' + '$' + 'name =      ' + '$' + '_POST[\"name\"];\n';
                        //data += '' + '$' + 'tableDesc = ' + '$' + '_POST[\"tableDesc\"];\n';
                        //data += '' + '$' + 'orderId =   ' + '$' + '_POST[\"orderId\"];\n';

                        data += '\n';
                        data += 'if(isset(' + '$' + '_GET[\'action\']))\n';
                        data += '{\n';
                        data += '  ' + '$' + 'selectedAction = filter_input( INPUT_GET, \'action\', FILTER_SANITIZE_URL );\n';
                        data += '  if(' + '$' + 'selectedAction == \"save\")\n';
                        data += '  {\n';
                        data += '    ' + '$' + 'fields = \"' + phpFields + '\";\n';
                        data += '    ' + '$' + 'values = ' + '$' + phpFields.replace(/,/g, ' . "," . $') + ';\n'; // No spaces!!!!! NEW
                        data += '    \n';
                        data += '    // UPDATING VALUES\n';
                        data += '    if(' + '$' + 'selectedId != \"\")\n';
                        data += '    {\n';
                        data += '      ' + '$' + 'updateFieldsWithValues = \"\";\n';
                        data += '      ' + '$' + 'fieldsArr = explode(\',\', ' + '$' + 'fields);\n';
                        data += '      ' + '$' + 'valuesArr = explode(\',\', ' + '$' + 'values);\n';
                        data += '      for(' + '$' + 'x = 0; ' + '$' + 'x < count(' + '$' + 'fieldsArr); ' + '$' + 'x++) {\n';
                        data += '          ' + '$' + 'updateFieldsWithValues .= ' + '$' + 'fieldsArr[' + '$' + 'x] . \"=\'\" . ' + '$' + 'valuesArr[' + '$' + 'x] . \"\', \";\n';
                        data += '      }\n';
                        data += '      ' + '$' + 'updateFieldsWithValues = substr(' + '$' + 'updateFieldsWithValues, 0, -2);\n';
                        data += '      \n';
                        data += '      ' + '$' + 'sql = \"UPDATE \" . ' + '$' + 'table . \" SET \" . ' + '$' + 'updateFieldsWithValues . \" WHERE id=\" . ' + '$' + 'selectedId;\n';
                        data += '      echo \'<br>UPDATING updateFieldsWithValues: \' . ' + '$' + 'updateFieldsWithValues . \'<br>\';\n';
                        data += '      if (' + '$' + 'conn->query(' + '$' + 'sql) === TRUE) {\n';
                        data += '          $_SESSION["info"] = \"Record updated successfully.\";\n';
                        data += '      } else {\n';
						data += '          $_SESSION["error"] = "Error updating record (Errcode: 100)";\n';
						data += '          if($isDebug) { echo "Error updating record: " . $conn->error; }\n';
                        data += '      }\n';
                        data += '      ' + '$' + 'conn->close();\n';
                        data += '    \n';
                        data += '    }\n';
                        data += '    else\n';
                        data += '    {\n';
                        // data += '      ' + '$' + 'orderId = (getLargestValue(\"orderId\",' + '$' + 'table,' + '$' + 'conn)+1);\n';
                        data += '      \n';
                        //data += '      //' + '$' + 'values = \"\'\" . ' + '$' + 'siteId . \"\',\'\" . ' + '$' + 'name . \"\',\'\" . ' + '$' + 'tableDesc . \"\',\'\" . ' + '$' + 'orderId . \"\'\";\n';
                        //data += '      if (isset(' + '$' + '_GET[\'siteId\'])) { ' + '$' + 'siteId = filter_input( INPUT_GET, \'siteId\', FILTER_SANITIZE_URL ); }\n';
                        //data += '      \n';
						//data += '      ' + '$' + 'insertValues = \"\'\" . ' + '$' + 'siteId . \"\',\'\" . ' + '$' + 'name . \"\',\'\" . ' + '$' + 'tableDesc . \"\',\'\" . ' + '$' + 'orderId . \"\'\";\n';
                        data += '      \n';
                        //data += '      ' + '$' + 'sql = \"INSERT INTO \" . ' + '$' + 'table . \" (\" . ' + '$' + 'fields . \") VALUES (\" . ' + '$' + 'insertValues . \")\";\n';
						data += '      ' + '$' + 'sql = \"INSERT INTO \" . ' + '$' + 'table . \" (\" . ' + '$' + 'fields . \") VALUES (\'\" . str_replace(\", \",\"\',\'\",$values) . \"\')\";\n'; // NEW 22 2 2017
                        data += '      echo \'<br>INSERTING: \' . ' + '$' + 'sql;\n';
                        data += '      if (' + '$' + 'conn->query(' + '$' + 'sql) === TRUE) {\n';
                        data += '          $_SESSION["info"] = \"Record inserted successfully.\";\n';
                        data += '      } else {\n';
						data += '          $_SESSION["error"] = "Error inserting record (Errcode: 101)";\n';
						data += '          if($isDebug) { echo "Error inserting record: " . $conn->error; }\n';
                        data += '      }\n';
                        data += '      ' + '$' + 'conn->close();\n';
                        data += '    }\n';
                        data += '  }\n';
                        data += '  elseif (' + '$' + 'selectedAction == \"delete\")\n';
                        data += '  {\n';
                        data += '    ' + '$' + 'sql = \"DELETE FROM \" . ' + '$' + 'table . \" WHERE id=\" . ' + '$' + 'selectedId;\n';
                        data += '    if (mysqli_query(' + '$' + 'conn, ' + '$' + 'sql))\n';
                        data += '    {\n';
                        data += '          $_SESSION["info"] = \"Record deleting successfully.\";\n';
                        data += '    }\n';
                        data += '    else\n';
                        data += '    {\n';
						data += '          $_SESSION["error"] = "Error deleting item (Errcode: 102)";\n'; 
						data += '          if($isDebug) { echo "Error deleting item: " . mysqli_error(' + '$' + 'conn); }\n';
                        data += '    }\n';
                        data += '    mysqli_close(' + '$' + 'conn);\n';
                        data += '  }\n';
                        data += '  elseif (' + '$' + 'selectedAction == \"edit\")\n';
                        data += '  {\n';
                        data += '    if(' + '$' + 'selectedId != \"\")\n';
                        data += '    {\n';
                        data += '      echo \'<br>Editing<br>\';\n';
                        data += '      \n';
                        data += '      // get single ' + removeLastChar(phpSelectedTable) + '\n';
                        data += '	    ' + '$' + 'sql = \"SELECT * FROM \" . ' + '$' + 'table . \" WHERE id=\" . ' + '$' + 'selectedId;\n';
                        data += '	    echo \'<br>SQL2: \' . ' + '$' + 'sql . \'<br>\';\n';
                        data += '	    ' + '$' + 'result = mysqli_query(' + '$' + 'conn, ' + '$' + 'sql);\n';
                        data += '	    if (mysqli_num_rows(' + '$' + 'result) > 0)\n';
                        data += '	    {\n';
                        data += '	    	while(' + '$' + 'row = mysqli_fetch_assoc(' + '$' + 'result))\n';
                        data += '	    	{\n';

                        // $orderId = $row["orderId"];
                        for (var i = 1; i < phpFieldsArr.length; i++) {
                            data += '               ' + '$' + phpFieldsArr[i] + ' = ' + getSpaces(longestLength, phpFieldsArr[i].length) + '$' + 'row[\"' + phpFieldsArr[i] + '\"];\n';
                        }

                        //data += '            ' + '$' + 'siteId =    ' + '$' + 'row[\"siteId\"];\n';
                        //data += '            ' + '$' + 'name =      ' + '$' + 'row[\"name\"];\n';
                        //data += '            ' + '$' + 'tableDesc = ' + '$' + 'row[\"tableDesc\"];\n';
                        //data += '            ' + '$' + 'orderId =   ' + '$' + 'row[\"orderId\"];\n';

                        data += '                \n';
                        data += '	    		echo \"<h3>Edit ' + removeLastChar(phpSelectedTable) + '</h3>\";\n';
                        data += '                \n';
                        data += '	    		echo \'<form action=\"\' . htmlspecialchars(' + '$' + 'thisPage . \'&action=save\') . \'\" method=\"post\">\';\n';
                        data += '	    		echo \"<table>\";\n';
                        data += '                \n';

                        for (var i = 1; i < phpFieldsArr.length; i++) {
                            //data += '$' + phpFieldsArr[i] + ' = ' + getSpaces(longestLength, phpFieldsArr[i].length) + '$' + 'row[\"' + phpFieldsArr[i] + '\"];\n';
                            if (includesWord('desc', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . \'<textarea name=\"' + phpFieldsArr[i] + '\" rows=\"5\" cols=\"40\">\' . ' + "$" + phpFieldsArr[i] + ' . "</textarea></td></tr>";\n';
                            } else if (includesWord('date', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . displayDate(' + '$' + phpFieldsArr[i] + ') .  \'<input type=\"hidden\" value=\"\' . ' + '$' + '' + phpFieldsArr[i] + ' . \'\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + 'name=\"' + phpFieldsArr[i] + '\">\' . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else if (includesWord('lang', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . getLangDroplist(\'langId\', \'-- Select --\', ' + '$' + 'langId) . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else if (includesWord('active', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . getOnOffDroplist(\'active\', \'\', ' + '$' + 'active) . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else if (includesWord('permission', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . getOnOffDroplist(\'active\', \'\', ' + '$' + 'active) . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else if (includesWord('id', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . ' + '$' + phpFieldsArr[i] + ' .  \'<input type=\"hidden\" value=\"\' . ' + '$' + '' + phpFieldsArr[i] + ' . \'\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + 'name=\"' + phpFieldsArr[i] + '\">\' . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . \'<input type=\"text\" value=\"\' . ' + '$' + '' + phpFieldsArr[i] + ' . \'\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + 'name=\"' + phpFieldsArr[i] + '\">\' . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            }
                        }

                        //data += '                echo \"<tr><td>\" . \"siteId:   \" . \"</td><td>\" . \'<input type=\"text\" value=\"\' . ' + '$' + 'siteId . \'\" name=\"siteId\">\' . \"</td></tr>\";\n';
                        //data += '		         echo \"<tr><td>\" . \"name:     \" . \"</td><td>\" . \'<input type=\"text\" value=\"\' . ' + '$' + 'name . \'\" name=\"name\">\' . \"</td></tr>\";\n';
                        //data += '                echo \"<tr><td>\" . \"tableDesc:       \" . \"</td><td>\" . \'<textarea name=\"tableDesc\" rows=\"5\" cols=\"40\">\' . ' + '$' + 'tableDesc .\'</textarea>\' . \"</td></tr>\";\n';
                        //data += '                echo \"<tr><td>\" . \"orderId:        \" . \"</td><td>\" . ' + '$' + 'orderId . \'<input type=\"hidden\" value=\"\' . ' + '$' + 'orderId . \'\" name=\"orderId\">\' . \"</td></tr>\";\n';


                        data += '                \n';
                        data += '	    		echo \"<tr><td>\" . \"&nbsp;\" . \"</td><td>\" . \'<input type=\"submit\" value=\"Save\">\' . \"</td></tr>\";\n';
                        data += '	    		\n';
                        data += '            echo \"</table>\";\n';
                        data += '	    		echo \"</form>\";\n';
                        data += '	    	}\n';
                        data += '	    }\n';
                        data += '        else\n';
                        data += '        {\n';
                        data += '	    	echo \'<br>ERROR: no such ' + removeLastChar(phpSelectedTable) + ' found.<br>\';\n';
                        data += '	    }\n';
                        data += '      ' + '$' + 'conn->close();\n';
                        data += '    }\n';
                        data += '    else\n';
                        data += '    {\n';
						/* ------------------------------------ CREATE NEW --------------------------------------------- */
                        data += '      // Create new ' + removeLastChar(phpSelectedTable) + '\n';
                        data += '      echo \"<h3>Create ' + removeLastChar(phpSelectedTable) + '</h3>\";\n';
                        data += '      \n';
                        data += '	    echo \'<form action=\"\' . htmlspecialchars(' + '$' + 'thisPage . \'?action=save\') . \'\" method=\"post\">\';\n';
                        data += '	    echo \"<table>\";\n';
                        data += '              ' + '$' + 'siteId = \"URL DATA siteId ERROR\"; if (isset(' + '$' + '_GET[\'siteId\'])){ ' + '$' + 'siteId = filter_input( INPUT_GET, \'siteId\', FILTER_SANITIZE_URL ); }\n';

						/* no validation */
						/*
                        for (var i = 1; i < phpFieldsArr.length; i++) {
                            if (includesWord('desc', phpFieldsArr[i])) {
                                data += '		       echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':' + getSpaces(longestLength, phpFieldsArr[i].length) + '\" . \"</td><td>\" . \'<textarea name=\"' + phpFieldsArr[i] + '\" rows=\"5\" cols=\"40\">\' . ' + "$" + phpFieldsArr[i] + ' . "</textarea></td></tr>";\n';
                            } else if (includesWord('date', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . displayDate(getCurrentDateAsYYMMDDHHMM()) . \'<input type=\"hidden\" value=\"\' . getCurrentDateAsYYMMDDHHMM() . \'\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + 'name=\"' + phpFieldsArr[i] + '\">\' . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else if (includesWord('lang', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . getLangDroplist(\'langId\', \'-- Select --\', ' + '$' + 'langId) . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else if (includesWord('active', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . getOnOffDroplist(\'active\', \'\', ' + '$' + 'active) . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else {
                                data += '		       echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':' + getSpaces(longestLength, phpFieldsArr[i].length) + '\" . \"</td><td>\" . \'<input type=\"text\" name=\"' + phpFieldsArr[i] + '\">\' . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            }
                        }
						*/
						/* with validation */
						/*
							data += '<tr><td>'; 
							data += '<label for="name">Name:* </label>' . '</td><td>';
							data += '<input type="text" id="name" name="name">';
							data += '</td><td>';
							data += '<span class="errorFeedback errorSpan" id="nameError">Name is required</span>';
							data += '</td></tr>'; 

						*/
						for (var i = 1; i < phpFieldsArr.length; i++) {
                            if (includesWord('desc', phpFieldsArr[i])) {
                                data += '		       echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':' + getSpaces(longestLength, phpFieldsArr[i].length) + '\" . \"</td><td>\" . \'<textarea name=\"' + phpFieldsArr[i] + '\" rows=\"5\" cols=\"40\">\' . ' + "$" + phpFieldsArr[i] + ' . "</textarea></td></tr>";\n';
                            } else if (includesWord('date', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . displayDate(getCurrentDateAsYYMMDDHHMM()) . \'<input type=\"hidden\" value=\"\' . getCurrentDateAsYYMMDDHHMM() . \'\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + 'name=\"' + phpFieldsArr[i] + '\">\' . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else if (includesWord('lang', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . getLangDroplist(\'langId\', \'-- Select --\', ' + '$' + 'langId) . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else if (includesWord('active', phpFieldsArr[i])) {
                                data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . getOnOffDroplist(\'active\', \'\', ' + '$' + 'active) . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            } else {
								/* input is default field */
                                data += '		       echo \"<tr><td>\" . ';
								data += '\'<label for="' + phpFieldsArr[i] + '">' + makeReadable(phpFieldsArr[i]) + ':* </label>' + getSpaces(longestLength, phpFieldsArr[i].length) + '\' . '; 
								data += '\"</td><td>\" . ';
								data += '\'<input type=\"text\" id=\"' + phpFieldsArr[i] + '\" name=\"' + phpFieldsArr[i] + '\">\' . ';
								data += getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . ';
								data += '\'<span class=\"errorFeedback errorSpan\" id=\"' + phpFieldsArr[i] + 'Error\">' + makeReadable(phpFieldsArr[i]) + ' is required field</span>\' . \"</td></tr>\";\n';

							/*
							<tr><td>'; 
							<label for="name">Name:* </label>' . '</td><td>';
							<input type="text" id="name" name="name">';
							</td><td>';
							<span class="errorFeedback errorSpan" id="nameError">Name is required</span>';
							</td></tr>'; 
							*/
                            }
                        }


                        //data += '              echo \"<tr><td>\" . \"siteId:   \" . \"</td><td>\" . ' + '$' + 'siteId . \'<input type=\"hidden\" value=\"\' . ' + '$' + 'siteId . \'\" name=\"siteId\">\' . \"</td></tr>\";\n';   
                        //data += '		       echo \"<tr><td>\" . \"name:     \" . \"</td><td>\" . \'<input type=\"text\" name=\"name\">\' . \"</td></tr>\";\n';
                        //data += '              echo \"<tr><td>\" . \"tableDesc:\" . \"</td><td>\" . \'<textarea name=\"tableDesc\" rows=\"5\" cols=\"40\">\' . ' + '$' + 'tableDesc .\'</textarea>\' . \"</td></tr>\";\n';
                        //data += '              echo \"<tr><td>\" . \"orderId:  \" . \"</td><td>\" . (getLargestValue(\"orderId\",\"gen_tables\",' + '$' + 'conn)+1) . \"</td></tr>\";\n';		            

                        data += '        \n';
                        data += '	    echo \"<tr><td>\" . \"&nbsp; \" . \"</td><td>\" . \"&nbsp; \" . \"</td></tr>\";\n';
                        data += '	    \n';
                        data += '      echo \"<tr><td>\" . \"\" . \"</td><td>\"; // if (isset(' + '$' + '_GET[\'siteId\'])) { ' + '$' + 'siteId = filter_input( INPUT_GET, \'siteId\', FILTER_SANITIZE_URL ); }\n';
                        data += '        //echo \'<a href=\"\' . ' + '$' + 'returnPage . \'\">Cancel</a> &nbsp; <a href=\"\' . ' + '$' + 'thisPage . \'?action=create\">Save</a>\';\n';

                        //data += '        ?>;\n';
                        //data += '      <input type=\"submit\" value=\"Save\">;\n';
                        //data += '        <?php;\n';

                        data += '	    echo \'<input type=\"submit\" value=\"Save\">\';\n';


                        data += '      echo \"</td></tr>\";\n';
                        data += '	  \n';
                        data += '      echo \"</table>\";\n';
                        data += '	  echo \"</form>\";\n';
                        data += '      \n';
                        data += '    }\n';
                        data += '  } elseif (' + '$' + 'selectedAction == null) {\n';
                        data += '  \n';
                        data += '  // show single ' + removeLastChar(phpSelectedTable) + '\n';
                        data += '	  ' + '$' + 'sql = \"SELECT * FROM \" . ' + '$' + 'table . \" WHERE id=\" . ' + '$' + 'selectedId . \"\";\n';
                        data += '	  echo \'<br>\' . ' + '$' + 'sql . \'<br>\';\n';
                        data += '    \n';
                        data += '    ' + '$' + 'result = mysqli_query(' + '$' + 'conn, ' + '$' + 'sql);\n';
                        data += '    if (mysqli_num_rows(' + '$' + 'result) > 0)\n';
                        data += '    {\n';
                        data += '    	while(' + '$' + 'row = mysqli_fetch_assoc(' + '$' + 'result))\n';
                        data += '		  {\n';
                        data += '		  	echo \"<h3>' + makeReadable(removeLastChar(phpSelectedTable)) + ' information</h3>\";\n';
                        data += '        \n';
                        data += '        echo \"<table>\";\n';
                        data += '        \n';

                        for (var i = 1; i < phpFieldsArr.length; i++) {
                            //data += '                echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ':\" . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td><td>\" . \'<input type=\"text\" value=\"\' . ' + '$' + '' + phpFieldsArr[i] + ' . \'\" ' + getSpaces(longestLength, phpFieldsArr[i].length) + 'name=\"' + phpFieldsArr[i] + '\">\' . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                            //data += '		    echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ': \" .' + getSpaces((longestLength + 2), phpFieldsArr[i].length) + '\"</td><td>\" . ' + '$' + 'row[\"' + phpFieldsArr[i] + '\"] . ' + getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';

							data += '		    echo \"<tr><td>\" . \"' + makeReadable(phpFieldsArr[i]) + ': \" .' + getSpaces((longestLength + 2), phpFieldsArr[i].length) + '\"</td><td>\" . '; 
							if (includesWord('active', phpFieldsArr[i])) {						
								data += 'getActiveIcon(' + '$' + 'row[\"' + phpFieldsArr[i] + '\"]) . ';
							} else if (includesWord('permission', phpFieldsArr[i])) {						
								data += 'getActiveIcon(' + '$' + 'row[\"' + phpFieldsArr[i] + '\"]) . ';
							} else {
								data += '$' + 'row[\"' + phpFieldsArr[i] + '\"] . ';
							}
							data +=  getSpaces(longestLength, phpFieldsArr[i].length) + '\"</td></tr>\";\n';
                        }
                        //data += '           echo \"<tr><td>\" . \"siteId: \" .     \"</td><td>\" . ' + '$' + 'row[\"siteId\"]    . \"</td></tr>\";\n';
                        //data += '		    echo \"<tr><td>\" . \"name: \" .       \"</td><td>\" . ' + '$' + 'row[\"name\"]      . \"</td></tr>\";\n';
                        //data += '		    echo \"<tr><td>\" . \"tableDesc: \" .  \"</td><td>\" . ' + '$' + 'row[\"tableDesc\"] . \"</td></tr>\";\n';
                        //data += '		    echo \"<tr><td>\" . \"orderId: \" .    \"</td><td>\" . ' + '$' + 'row[\"orderId\"]   . \"</td></tr>\";\n';

                        data += '           \n';
                        data += '		  	echo \"<tr><td>\" . \"&nbsp;\" . \"</td><td>\" . \"&nbsp;\" . \"</td></tr>\";\n';
                        data += '		  	echo \"<tr><td>\" . \"\" . \"</td><td>\" . \'<a href=\"\' . ' + '$' + 'returnPage . \'\">Return</a>\' . \"</td></tr>\";\n';
                        data += '		  	echo \"</table>\";\n';
                        data += '		  }\n';
                        data += '    } else {\n';
                        data += '      echo \"No records found.\";\n';
                        data += '    }\n';
                        data += '    ' + '$' + 'conn->close();\n';
                        data += '  }\n';
                        data += '}\n';
                        data += '\n';
                        data += '// footer\n';
                        data += '// echo \'<br><a class=\"butt vih\"href=\"\' . ' + '$' + 'returnPage . \"?siteId=\" . ' + '$' + '_GET[\"siteId\"] . \'\">Return</a>\';\n';
                        data += '\n';
                        data += '?>\n';

						// // put data in pageCode
						// //data = data.replace('\'\n\'', '\"\n\"');
						// data = data.replace(/(\r\n|\n|\r)/gm, "\n");
						// 
						// //data = data.replace('"', '\"');
						// //data = data.replace("'", "\'");
						// //data = data.replace(/(\t)/gm, "\t");						
						// //data = data.replace(/(\r\n|\n|\r)/gm, "\n");
						// $("#pageCode").val(data);  
						// var creatableFile = $('#tables .selected').attr('id'); 					
						// creatableFile = creatableFile.substr(0, creatableFile.length - 1);
						// $("#pageName").val(creatableFile);  
						





                        break;
                    case "delete": data = 'string del = Convert.ToString(Request.QueryString[\"del\"]);\nif (del != null && del.Length > 0)\n{\n\tGetDataClass.DeleteItem(Globals.PageContext.TableName, \"id\", del.Trim());\n\tResponse.Redirect(Globals.PageContext.PageName);\n}\n';
                        break;
                    case "sql":
                        var phpSelectedTable = $('#tables .selected').attr('id');
                        var phpFields = getTable(phpSelectedTable);
                        var phpFieldsArr = phpFields.split(',');
                        var phpControlTypesArr = getTableControlTypes(phpSelectedTable);
                        var phpDBTypesArr = getTableDbTypes(phpSelectedTable);

						// DATA = SQL rows for LOCAL PHP
						// AWS = SQL rows for AWS PHP
				var aws = "\n\n\n // ---------------------- AWS CREATE TABLE ---------------------- \n\n";
				aws += "<?php\n";
				aws += "include('dataFunctions.php');\n";
				aws += "echo 'this is AWS db creation tool';\n";
				aws += "$" + "conn = getDBConnection(); if(!" + "$" + "conn) { echo '<br>Could not getConnection.';  } else { echo '<br>Connection established.';  }\n";
				aws += "\n";
				aws += "// CREATE TABLE\n";						
						
						
						// aws += "// TEST DATA\n";
						// aws += '';
						// aws += " createTable($sql, getDBConnection());\n";

						                       
                        // data += 'drop table [table];\n';                       
					
                        // data += '// create table \n';
                        // data += '$sql = "';

						// OLD with plain int
                        //data += 'create table [table] (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,[iterate]);';

						// NEW with different specific fields
						data += 'create table [table] (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,';
						for (var j = 0; j < phpFieldsArr.length; j++) 
						{
							
							data += phpFieldsArr[j]; // field name
							data += ' ' + phpDBTypesArr[j];
							data += ','; // comma
						}
                        data = data.substr(0, data.length - 1); // remove last comma
						data += ');';


			aws += '$sql = \'' + data + '\';\n'; 
			aws += 'createTable(' + '$' + 'sql, getDBConnection());\n\n';
												
                        data += '\n\n';

						// -------------------------------------
                        //data += '// test data for [table] \n';
			aws += ' // test data for [table] \n';
			aws += '$sql = \"';
                        // add test data
						var rowCounter = 1;
			
                        for (var t = 0; t < 5; t++) {
                            //data += '$sql = "INSERT INTO [table] (';
							data += 'INSERT INTO [table] (';
							aws += 'INSERT INTO [table] (';
                            for (var j = 0; j < phpFieldsArr.length; j++) {
                                data += phpFieldsArr[j] + ',';
								aws += phpFieldsArr[j] + ',';
                            }
                            data = data.substr(0, data.length - 1);
							aws = aws.substr(0, aws.length - 1);
                            data += ') VALUES (';
							aws += ') VALUES (';
                            //for (var j = 0; j < phpDBTypesArr.length; j++) {
                            //    if (phpDBTypesArr[j].substr(0, 1) == "i") { data += "'" + t + "',"; } // id
                            //    if (phpDBTypesArr[j].substr(0, 1) == "t") { data += "'" + phpFieldsArr[j] + 'Text' + t + "',"; } // varchar  
                            //    if (phpDBTypesArr[j].substr(0, 1) == "T") { data += "'" + 'blobx' + "',"; } // blob
                            //    if (phpDBTypesArr[j].substr(0, 1) == "b") { data += "'" + "1" + "',"; } // bit(1) 
                            //}
							// new

							for (var j = 0; j < phpFieldsArr.length; j++) {
								//alert(j + '. ' + phpDBTypesArr[j] + ': ' + phpDBTypesArr[j].toLowerCase().indexOf('int'));								
								if(phpDBTypesArr[j].toLowerCase().indexOf('int') != -1) // int
								{  
									data += rowCounter + ','; 
									aws += rowCounter + ','
								} else if(phpDBTypesArr[j].toLowerCase().indexOf('8') != -1) // length 8 --> scrambled id
								{  
									data += "'" + phpFieldsArr[j].substr(0, 5) + rowCounter + "',";						
									aws += "'" + phpFieldsArr[j].substr(0, 5) + rowCounter + "',";						
								} else if(phpDBTypesArr[j].toLowerCase() == 'active') // active
								{  
									data += "'1',";	
									aws += "'1',";	
								} else { 
									data += "'" + phpFieldsArr[j] + rowCounter + "',"; // default 
									aws += "'" + phpFieldsArr[j] + rowCounter + "',"; // default 
								}
								
                            }				

							rowCounter++;
							data = data.substr(0, data.length - 1);
							aws = aws.substr(0, aws.length - 1);
							

                            // data += ');"; ';
							data += ');\n';
							aws += ');\"; ';  // end insert line
							aws += 'createTable(' + '$' + 'sql, getDBConnection());\n' + '$' + 'sql = \"';

                            // data += 'createTable($sql, getDBConnection());\n'; // AWS
							//alert('SQL DATA: ' + data);
                        }
				//aws += '$' + 'sql = \"' + awsRow + '\";';
				//aws += ' createTable(' + '$' + 'sql, getDBConnection());\n';


				// combine local and aws sql code
				data = "\n // ---------------------- LOCAL CREATE TABLE ---------------------- \n" + data;
				aws = aws.substr(0, aws.length - 8);
				data += aws;

						//// FRIENDLY SQL - kesken
						//var friendlySQL = '\n\n\n-------------------------- --------------------------\n\n';
						//friendlySQL += 'FRIENDLY SQL:\n\n' + 'create table [table] (\n\nid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,\n';
						//
						//for (var j = 0; j < phpFieldsArr.length; j++) {
                        //    friendlySQL += phpFieldsArr[j] + ' ' + phpDBTypesArr[j] + '\n';
                        //} 
						//friendlySQL = removeLastChar(friendlySQL);
						//friendlySQL += '\n\n' + ');';
						//
						//data += friendlySQL;

                        /*                        
                        CREATE TABLE `products` (
                        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                        `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                        `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                        `content` text COLLATE utf8_unicode_ci NOT NULL,
                        `image` text COLLATE utf8_unicode_ci NOT NULL,
                        `status` int(11) NOT NULL,
                        `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                        `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `orig_image` text COLLATE utf8_unicode_ci,
                        `image2` text COLLATE utf8_unicode_ci,
                        `image3` text COLLATE utf8_unicode_ci,
                        `orig_image2` text COLLATE utf8_unicode_ci,
                        `orig_image3` text COLLATE utf8_unicode_ci,
                        `price` float(10,2) DEFAULT NULL,
                        `category_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                        PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                        
                        */

                        break;
                    case "html": data = '<asp:Label runat=\"server\" ID=\"all[table]Label\" />\n<h1><asp:Label runat=\"server\" ID=\"formTitleLabel\" /></h1>\n\n[iterate]<asp:Button ID=\"save[table]Button\" runat=\"server\" onclick=\"save[table]Button_Click\" />\n\n<asp:Label ID=\"errLabel\" class=\"error\" runat=\"server\" />\n\n';
                        iterableSectionDroplist = '<label><asp:Label runat=\"server\" ID=\"FIELDLabel\" />\n<asp:DropDownList ID=\"FIELDDropDownList\" runat=\"server\" /><br />\n\n'; /* onselectedindexchanged=\"FIELDDropDownList_SelectedIndexChanged\"  */
                        iterableSectionTextbox = '<label><asp:Label runat=\"server\" ID=\"FIELDLabel\" />\n<asp:TextBox ID=\"FIELDTextBox\" runat=\"server\" /><br />\n\n';
                        iterableSectionRadio = '<asp:RadioButtonList ID=\"FIELDRadioButtonList\" runat=\"server\" /><br />\n\n';
                        break;
                    case "XXX": 
                    /*
                    for (var i = 0; i < phpFieldsArr.length; i++) {
                            data += 'echo \"<tr><td>\"';
                            data += ' . \"' + phpFieldsArr[i] + ': \"';
                            data += ' . \"</td><td>\"';
                            data += ' . $row[\"' + phpFieldsArr[i] + '\"]';
                            data += ' . \"</td></tr>\";\n';
                        }*/

                    
                        break; /* --------------------------------------- */
                }

                var selectedTable = $('#tables .selected').attr('id');
                var fields = getTable(selectedTable);
                var controlTypesArr = getTableControlTypes(selectedTable);
                var action = id;

                /* ------------------------------------------------------------------- GENERATE ---------------------------------------------------------------------*/
                var table = getTable(selectedTable); // tablename+fields
                data = data.replaceAll("[table]", selectedTable);
                data = data.replaceAll("[fieldlist]", fields);
                // [0]=db table name, [1] = db fieldnames, [2]=db field types (id,t50), [3] = controltype (d=droplist,t=textbox,r=radio)
                var fieldsArr = fields.split(',');
                if (id == "sql") {
                    var dbTypesArr = getTableDbTypes(selectedTable);

                    // SQL

                    for (var i = 0; i < fieldsArr.length; i++) {
                        var comp = "";
                        if (isCompulsory(dbTypesArr[i]) == true) { comp = " NOT NULL"; }
                        switch (dbTypesArr[i].substr(0, 1)) {
                            case "i": iteratedData += removeStar(fieldsArr[i]) + " int" + comp + ", "; break;
                            //case "b": iteratedData += removeStar(fieldsArr[i]) + " boolean" + comp + ", "; break;                          
                            case "t": iteratedData += removeStar(fieldsArr[i]) + " varchar(" + dbTypesArr[i].substr(1, dbTypesArr[i].length - 1) + ")" + comp + ", "; break;
                            case "T": iteratedData += removeStar(fieldsArr[i]) + " text" + comp + ", "; break; // bit(1)  
                            case "b": iteratedData += removeStar(fieldsArr[i]) + " bit" + comp + ", "; break; // bit(1)  
                            default: iteratedData += "ERROR!"; break;
                        }
                    }
                    iteratedData = iteratedData.substr(0, iteratedData.length - 2);
                    data = data.replace("[iterate]", iteratedData);
                }
                // else if (id == "cs") {
                //     // CS
                //     for (var c = 0; c < totalCsSections; c++) {
                //         if (dataArr[c] != null) {
                //             for (var i = 0; i < fieldsArr.length; i++) {
                // 
                //                 switch (controlTypesArr[i]) {
                //                     case "d": iteratedData += droplistArr[c].replaceAll("FIELD", fieldsArr[i]) + ""; break;
                //                     case "t": iteratedData += textboxArr[c].replaceAll("FIELD", fieldsArr[i]) + ""; break;
                //                     case "r": iteratedData += radioArr[c].replaceAll("FIELD", fieldsArr[i]) + ""; break;
                //                     default: iteratedData += "ERROR!"; break;
                //                 }
                // 
                //             }
                //             data = data.replaceAll("[fieldlist]", fields);
                //             data += dataArr[c].replace("[iterate]", iteratedData);
                //             iteratedData = "";
                //         }
                //     }
                //     data = data.replaceAll("[table]", selectedTable);
                // }
                // else {
                //     // all but SQL and CS
                //     for (var i = 0; i < fieldsArr.length; i++) {
                //         switch (controlTypesArr[i]) {
                //             case "d": iteratedData += iterableSectionDroplist.replaceAll("FIELD", fieldsArr[i]); break;
                //             case "t": iteratedData += iterableSectionTextbox.replaceAll("FIELD", fieldsArr[i]); break;
                //             case "r": iteratedData += iterableSectionRadio.replaceAll("FIELD", fieldsArr[i]); break;
                //             default: iteratedData += "ERROR!"; break;
                //         }
                //     }
                //     data = "// " + action + " " + removeLastS(selectedTable) + "\n" + data.replace("[iterate]", iteratedData);
                // }

				

                $("#code").val(data);

				// put data in pageCode
						//data = data.replace('\'\n\'', '\"\n\"');
						//data = data.replace(/(\r\n|\n|\r)/gm, "\n");

						//data = data.replace('"', '\"');
						//data = data.replace("'", "\'");
						//data = data.replace(/(\t)/gm, "\t");						
						//data = data.replace(/(\r\n|\n|\r)/gm, "\n

						//data = data.replace("\n", "\n" . PHP_EOL);
						//data = data.replace('\n', ';\n');
						
						// PREPARE CODE FOR FILE SAVE - add newlines
						//data = data.replace(/(\r\n|\n|\r)/gm, ";"); // replace newlines with ;
						//data = data.replace(/\s/g, ""); // remove all whitespace characters

	
						data = data.replace(/(\r\n|\n|\r)/gm, "£"); // replace newlines with £
						$("#pageCode").val(data);  // for filesave

						// page name for save
						var creatableFile = $('#tables .selected').attr('id'); 					
						creatableFile = creatableFile.substr(0, creatableFile.length - 1);
						$("#pageName").val(creatableFile);  						
            }

            // PHP functions
            function getLongestLength(phpFields) {
                var longestLength = 0;
                var currLength = 0;
                var phpFieldsArr = phpFields.split(',');
                for (var i = 0; i < phpFieldsArr.length; i++) {
                    currLength = phpFieldsArr[i].length;
                    if (currLength > longestLength) { longestLength = currLength; }
                }
                return longestLength;
            }
            function getLongestNameLength(phpFields) {
                var longestLength = 0;
                var currLength = 0;
                var phpFieldsArr = phpFields.split(',');
                for (var i = 0; i < phpFieldsArr.length; i++) {
                    currLength = phpFieldsArr[i].length;
                    if (currLength > longestLength) { longestLength = currLength; }
                }
                return longestLength;
            }

            function getSpaces(longestLength, currFieldLength) {
                var spaces = "";
                while (currFieldLength < longestLength) {
                    spaces = spaces + " ";
                    currFieldLength++;
                }
                return spaces;
            }



            // C#
            function isCompulsory(str) {
                if (str.substr(str.length - 1, 1) == "*") {
                    return true;
                }
                return false;
            }
            function removeStar(str) {
                if (str.substr(str.length - 1, 1) == "*") {
                    str = str.substr(0, str.length - 1);
                }
                return str;
            }

            function clearAll() {
                $(".button").removeClass('selected');
                $("#code").val('');
                hideActionButtons();
            }
            function clearActions() {
                $(".action").removeClass('selected');
                $("#code").val('');
            }

            function init() {
                // list table buttons
                $("#tables").html(getTable("all"));
                hideActionButtons();


                //var tables = getTables("");
                //alert(tables);
                /*
                $("span#usedNumbersLabel").text('');
                var words1 = $("span#wordSetLabel1").text().split('#')[getCurrentSetId()].split(',');
                clearOldWords();

                // show words 
                for (var i = 0; i < $(words1).size(); i++) {
                $("#i" + i).text(words1[i]); $("#i" + i).css("display", "block");
                }
                getNextRandomNumber();
                */
            }

            function getJsCode(getWhat)
            {
                // reads getWhat.txt named file and puts contents to #code2
                var result = '';                                
                // url : path1 + "test2.txt",
                var path1 = '/UUSI/scriptGeneratorCodeSnippets/'; 
                    $.ajax({
                        url : path1 + getWhat + ".txt",
                        success : function(result){                            
                            $("#code2").val(result);
                        },
                        error : function(xhr, thrownError){                
                        alert('Ajax error: ' + thrownError);            
                            $("#code2").val("Ajax error: " + xhr.responseText);
                        }
                    });
            }
            /*
,
                        error: function(xhr){
                        $("#code2").val("An error occured: " + xhr.status + " " + xhr.statusText);
                        });
            */

            function getTables() {
                var tables = Array(); // [0]=db table name, [1] = db fieldnames, [2]=db field types (id,t50), [3] = controltype (d=droplist,t=textbox,r=radio)
                var a = 0;
                // tables[a] = "organisations:countryId,mapDefaultLangId,businessTypeId,businessSubTypeId,name,description,address,www,active:id,id,id,id,t50,t200,t100,t100,id:d,d,d,d,t,t,t,t,r"; a++;
                // tables[a] = "maps:orgId,mapName,mapFileName,accessId,structureTypeId,defaultLangId,sizeX,sizeY,unitType,mapSource,active:id,t50,t50,id,id,id,id,id,id,id,id:d,t,t,d,d,d,t,t,r,d,r"; a++;
                // tables[a] = "contentFieldNames:pageId,fieldName:id,t50:d,t"; a++;
                // tables[a] = "content:contentFieldId,langId,fieldName:id,id,t50:d,d,t"; a++;
                // tables[a] = "userDetails:genderId,fName,lName,address,zip,town,countryId,active:id,t50,t50,t50,t10,t50,id,id:r,t,t,t,t,d,d,r"; a++;

                // // PHP certification testing
                // // [0]=db table name, [1] = db fieldnames, [2]=db field types (id,t50), [3] = controltype (d=droplist,t=textbox,r=radio)
                // //tables[a] = "organisations:zzz:id,id,id,id,t50,t200,t100,t100,id:d,d,d,d,t,t,t,t,r"; a++;
                // tables[a] = "users:userId,firstName,lastName,email,login,password,active:id,t50,t50,t50,t25,t25,id:t,t,t,t,t,t,r"; a++;
                // tables[a] = "countries:countryId,langId,countryName:id,id,t50:d,d,t"; a++;
                // tables[a] = "languages:langId,langName:id,t50:d,t"; a++;
                // tables[a] = "userAndOrganisationInfo:userId,countryId,langId,phone,gender,birthYear,emailPermission,userSince:id,id,id,t20,id,t8,id,t6:t,d,d,t,r,t,c,t"; a++;
                // tables[a] = "rolesToUsers:userId,roleId:id,id:t,t"; a++;
                // tables[a] = "usersToOrganisations:userId,organisationId,activeInOrganisationSince,notActiveInOrganisationSince,active:id,id,t6,t6,id:t,t,t,t,r"; a++;
                // tables[a] = "organisations:organisationId,organisationName,aliasName,mainUserId,mainContactUserId,secondaryContactUserId,active:id,t50,t50,id,id,id,id:t,t,t,t,t,t,r"; a++;

                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

                // // 19 10 2016 - Certification sellling
                // tables[a] = "cert_users:userId,firstName,lastName,email,login,password,active:i,t20,t50,t50,t30,t30,b:d,t,t,t,t,t,d"; a++;
                // tables[a] = "cert_exams:examId,creatorUserId,langId,examCode,dateCreated,examName,shortDesc,prerequisiteExamIds,timeLimitMinutes,orderId,active:i,i,i,t10,i,t50,t255,t50,i,i,i:d,d,d,t,t,t,t,t,d,d,d"; a++;
                // tables[a] = "cert_modules:moduleId,examId,langId,moduleName,moduleDesc,timeLimitMinutes,orderId,active:i,i,i,t50,t255,i,i,i:d,d,d,t,t,t,d,d"; a++;
                // tables[a] = "cert_questions:questionId,moduleId,langId,questionTypeId,questionFormatId,orderId,active:i,i,i,i,i,i,i:d,d,d,d,d,d,d"; a++;
                // tables[a] = "cert_content:contentId,questionId,langId,text,orderId,active:i,i,i,t255,i,i:d,d,d,t,d,d"; a++;
                // tables[a] = "cert_questionTypes:questionTypeId,langId,text,shortDesc,imageName,orderId,active:i,i,t50,t255,t255,i,i:d,d,t,t,t,d,d"; a++;


			// oikotie 
			tables[a] = "oikotie_ads:countryId,langId,adPublishedDate,adEndDate,userId,adSellTypeId,adCountryId,stateId,zip,streetAddress,streetAddress2,townId,area1Id,area2Id,area3Id,area4Id,area5Id,adTitle,adTexts,price,debtFreePrice,livingArea,numberOfRooms,kitchenTypeId,saunaTypeId,balconyTypeId,roomsDesc,houseTypeId,keyWords,hasElevator,showingDate,landOwnerTypeId,yearBuilt,landSize,beachId,conditionId,ownershipTypeId,sellPublicityId,sellerTypeId,offerDealId,paidByUserId,paymentDate,paidSum,paidCurrencyId,active:TINYINT UNSIGNED,TINYINT UNSIGNED,INT,INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,CHAR(8),VARCHAR(50),VARCHAR(50),INT,INT,INT,INT,INT,INT,VARCHAR(50),VARCHAR(2000),INT,INT,INT,CHAR(8),TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,VARCHAR(20),TINYINT UNSIGNED,VARCHAR(100),TINYINT UNSIGNED,INT,TINYINT UNSIGNED,CHAR(8),CHAR(8),TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,INT,INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Country id,Lang id,Ad published date,Ad end date,User id,Ad sell type id,Ad country id,State id,Zip,Street address,Street address2,Town id,Area1 id,Area2 id,Area3 id,Area4 id,Area5 id,Ad title,Ad text,Price,Debt free price,Living area,Number of rooms,Kitchen type id,Sauna type id,Balcony type id,Rooms desc,House type id,Key words,Has elevator,Showing date,Land owner type,Year built,Land size,Beach id,Condition id,Ownership type id,Sell publicity id,Seller type id,Offer deal id,Paid by user id,Payment date,Paid sum,Paid currency,Active:Country id,Lang id,Ad published date,Ad end date,User id,Ad sell type id,Ad country id,State id,Zip,Street address,Street address2,Town id,Area1 id,Area2 id,Area3 id,Area4 id,Area5 id,Ad title,Ad text,Price,Debt free price,Living area,Number of rooms,Kitchen type id,Sauna type id,Balcony type id,Rooms desc,House type id,Key words,Has elevator,Showing date,Land owner type,Year built,Land size,Beach id,Condition id,Ownership type id,Sell publicity id,Seller type id,Offer deal id,Paid by user id,Payment date,Paid sum,Paid currency,Active"; a++; 
			
            // // 16 11 2016 - Certification selling 
            tables[a] = "users:userId,firstName,lastName,email,login,password,active:i,t20,t50,t50,t30,t30,b:d,t,t,t,t,t,d"; a++;

			// 22 3
            //tables[a] = "exams:examId,creatorUserId,langId,examCode,dateCreated,examName,shortDesc,prerequisiteExamIds,timeLimitMinutes,orderId,active:i,i,i,t10,i,t50,t255,t50,i,i,i:d,d,d,t,t,t,t,t,d,d,d"; a++;
			tables[a] = "exams:examId,creatorUserId,code,createdDate,name,img,intDesc,pubDesc,prer,notes,examTime,totalModules,maxTimePerModule,totalQuestions,questionsPerModule,percQEasy,percQMod,percQDiff,active:VARCHAR(15),INT,VARCHAR(15),INT,VARCHAR(50),VARCHAR(100),VARCHAR(5000),VARCHAR(5000),VARCHAR(20),VARCHAR(5000),INT,INT,INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Exam id,Creator user id,Code,Created date,Name,Img,Int desc,Pub desc,Prer,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Perc q easy,Perc q mod,Perc q diff,Active:Exam id,Creator user id,Code,Created date,Name,Img,Int desc,Pub desc,Prer,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Perc q easy,Perc q mod,Perc q diff,Active"; a++; 
            
			//tables[a] = "modules:moduleId,examId,langId,moduleName,moduleDesc,timeLimitMinutes,orderId,active:i,i,i,t50,t255,i,i,i:d,d,d,t,t,t,d,d"; a++;
			tables[a] = "modules:moduleId,examId,langId,moduleName,moduleDesc,timeLimitMinutes,orderId,active:INT,INT,TINYINT UNSIGNED,VARCHAR(100),VARCHAR(2000),INT,INT,TINYINT UNSIGNED:t,t,t,t,t,t,t,t:Module id,Exam id,Lang id,Module name,Module desc,Time limit minutes,Order id,Active:Module id,Exam id,Lang id,Module name,Module desc,Time limit minutes,Order id,Active"; a++; 

            //tables[a] = "questions:questionId,moduleId,langId,questionTypeId,questionFormatId,orderId,active:i,i,i,i,i,i,i:d,d,d,d,d,d,d"; a++;
			  tables[a] = "questions:questionId,moduleId,langId,questionTypeId,difficultyLevelId,questionText,correctAnswerId,answers,internalName,sourceNotes,groupId,addedDate,lastEditedDate,active:INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,VARCHAR(500),INT,VARCHAR(500),VARCHAR(100),VARCHAR(500),VARCHAR(50),INT,INT,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t:Question id,Module id,Lang id,Question type id,Difficulty level id,Question text,Correct answer id,Answers,Internal name,Source notes,Group id,Added date,Last edited date,Active:Question id,Module id,Lang id,Question type id,Difficulty level id,Question text,Correct answer id,Answers,Internal name,Source notes,Group id,Added date,Last edited date,Active"; a++; 
            tables[a] = "content:contentId,questionId,langId,text,orderId,active:i,i,i,t255,i,i:d,d,d,t,d,d"; a++;
            tables[a] = "questionTypes:questionTypeId,langId,text,shortDesc,imageName,orderId,active:i,i,t50,t255,t255,i,i:d,d,t,t,t,d,d"; a++;
			// 22 3
			tables[a] = "bookedExams:bookedExamId,userId,examId,langId,testPeriodEndsDate,internalNotes:VARCHAR(50),INT,INT,TINYINT UNSIGNED,INT,VARCHAR(100):t,t,t,t,t,t:Booked exam id,User id,Exam id,Lang id,Test period ends date,Internal notes:Booked exam id,User id,Exam id,Lang id,Test period ends date,Internal notes"; a++; 

			//tables[a] = "taken_exam_questions:userId,langId,takenExamId,moduleId,questionId,difficultyLevel,selectedAnswerId,answerStartDateTime,answerEndDateTime,isCorrect:INT,TINYINT UNSIGNED,INT,INT,INT,TINYINT UNSIGNED,VARCHAR(100),INT,TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t:Taken exam question id,Lang id,Taken exam id,Module id,Question id,Difficulty level,Selected answer id,Answer start date time,Answer end date time,Is correct:Taken exam question id,Lang id,Taken exam id,Module id,Question id,Difficulty level,Selected answer id,Answer start date time,Answer end date time,Is correct"; a++; 
			tables[a] = "takenExamQuestions:userId,langId,takenExamId,moduleId,questionId,questionText,correctAnswerId,answers,difficultyLevel,selectedAnswerId,answerStartDateTime,answerEndDateTime,isCorrect:INT,TINYINT UNSIGNED,INT,INT,INT,VARCHAR(500),INT,VARCHAR(500),TINYINT UNSIGNED,INT,INT,INT,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t:User id,Lang id,Taken exam id,Module id,Question id,Question text,Correct answer id,Answers,Difficulty level,Selected answer id,Answer start date time,Answer end date time,Is correct:User id,Lang id,Taken exam id,Module id,Question id,Question text,Correct answer id,Answers,Difficulty level,Selected answer id,Answer start date time,Answer end date time,Is correct"; a++; 


				// // 20 2 2017 - Uusi puskaradio                
                // tables[a] = "uusipuskis_contents:contentId,contentName,siteId,langId,text:i,t50,i,i,t255:d,t,d,d,t"; a++;
				// tables[a] = "uusipuskis_companies:companyId,countryId,category1,category2,name,nameCont,address,town,www,contactEmail,companyDesc,companyAddedDate,companyAddedByUserId,averageGrade,totalReviews,status:i,i,i,i,t50,t50,t50,t50,t50,t50,t255,i,i,i,i,i:d,d,d,d,t,t,t,t,t,t,t,i,i,i,i,i"; a++;

				// blocket 3 2017
tables[a] = "blocket_sites:countryId,siteName,siteDesc:INT,VARCHAR(50),VARCHAR(5000):t,t,t:Country id,Site name,Site desc:Country id,Site name,Site desc"; a++; 
tables[a] = "blocket_ads:userId,countryId,langId,cat1,cat2,title,img,texts,price,createdDate,startDate,endDate,isEnhanced,active:INT,INT,INT,INT,INT,VARCHAR(50),VARCHAR(500),VARCHAR(2000),INT,INT,INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t:User id,Country id,Lang id,Cat1,Cat2,Title,Img,Texts,Price,Created date,Start date,End date,Is admin,Active:User id,Country id,Lang id,Cat1,Cat2,Title,Texts,Image,Price,Created date,Start date,End date,Is admin,Active"; a++; 
tables[a] = "blocket_users:langId,isCompany,name,areaId,cityId,address,address2,img,email,password,phone,active:INT,TINYINT UNSIGNED,VARCHAR(50),INT,INT,VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t:Lang id,Is company,Name,Area id,City id,Address,Address2,Img,Email,Password,Phone,Active:Lang id,Is company,Name,Area id,City id,Address,Address2,Img,Email,Password,Phone,Active"; a++; 
tables[a] = "blocket_messages:fromUserId,toUserId,dateSent,dateRead,concerningAdId,title,text,email,phone,active:INT,INT,INT,INT,INT,VARCHAR(50),VARCHAR(2000),VARCHAR(50),VARCHAR(20),TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t:From user id,To user id,Date sent,Date read,Concerning ad id,Title,Text,Email,Phone,Active:From user id,To user id,Date sent,Date read,Concerning ad id,Title,Text,Email,Phone,Active"; a++; 
tables[a] = "blocket_categories:parentId,countryId,langId,name,catDesc,orderId,active:INT,INT,INT,VARCHAR(50),VARCHAR(200),TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t,t,t,t:Parent id,Country id,Lang id,Name,Cat desc,Order id,Active:Parent id,Country id,Lang id,Name,Cat desc,Order id,Active"; a++; 
tables[a] = "blocket_currencies:countryId,code,sign,format:INT,CHAR(3),CHAR(3),CHAR(10):t,t,t,t:Country id,Code,Sign,Format:Country id,Code,Sign,Format"; a++; 
tables[a] = "blocket_languages:langId,name,orderId,active:TINYINT UNSIGNED,VARCHAR(20),TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t:Lang id,Name,Order id,Active:Lang id,Name,Order id,Active"; a++; 
tables[a] = "blocket_countries:langId,name,orderId,active:TINYINT UNSIGNED,VARCHAR(15),TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t:Lang id,Name,Order id,Active:Lang id,Name,Order id,Active"; a++; 

//			// XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
//			// 7 3 2017
//							
//			// // tables[a] = "users:id,scrambledUserId,firstName,lastName,email,login,password,photo,signature,countryId,langId,smsPermission,emailPermission,active,:i,i,t50,t50,t50,t50,t50,t50,t50,i,i,i,i,i:t,t,t,t,t,t,t,t,t,t,t,t,t,t:Id,Scrambled user id,First name,Last name,Email,Login,Password,Photo,Signature,Country id,Lang id,Sms permission,Email permission,Active:Id,Scrambled user id,First name,Last name,Email,Login,Password,Photo,Signature,Country id,Lang id,Sms permission,Email permission,Active"; a++; 
//			// ////tables[a] = "users:id,scrambledUserId,firstName,lastName,email,login,password,photo,signature,countryId,langId,smsPermission,emailPermission,active,:i,i,t50,t50,t50,t50,t50,t50,t50,i,i,i,i,i:t,t,t,t,t,t,t,t,t,t,t,t,t,t"; a++; 
//			// tables[a] = "users:id,firstName,lastName,email,login,password,photo,signature,countryId,langId,smsPermission,emailPermission,active:t50,t50,t50,t50,t50,t50,t50,i,i,i,i,i,i:t,t,t,t,t,t,t,t,t,t,t,t,t"; a++; 
//			// //tables[a] = "exams:creatorUserId,code,date,name,img,intDesc,pubDesc,prer,notes,examTime,totalModules,maxTimePerModule,totalQuestions,questionsPerModule,percQEasy,percQMod,percQDiff,active:i,t50,i,t50,t50,t50,t50,t50,t50,i,i,i,i,i,i,i,i,i,t50:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,i";
//			 
//			 //tables[a] = "users:scrambledUserId,firstName,lastName,email,login,password,photo,signature,countryId,langId,smsPermission,emailPermission,active:t50,t50,t50,t50,t50,t50,t50,t50,i,i,i,i,i:t,t,t,t,t,t,t,t,t,t,t,t,t:Scrambled user id,First name,Last name,Email,Login,Password,,,Country id,Lang id,,,:Scrambled user id,First name,Last name,Email,Login,Password,,,Country id,Lang id,,,"; a++; 
//			 // 19 , 19, 19, 18, 21
//			 //tables[a] = "exams:scrambledExamId,creatorUserId,code,date,name,img,intDesc,pubDesc,prer,notes,examTime,totalModules,maxTimePerModule,totalQuestions,questionsPerModule,percQEasy,percQMod,percQDiff,active:t50,i,t50,i,t50,t50,t50,t50,t50,t50,i,i,i,i,i,i,i,i,i:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:,,Code,Date,Name,Image,Internal description,Public description,Prerequisites,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Easy,Moderate,Difficult,:,,Code,Date,Name,Image,,Public description,Prerequisites,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Easy percentage,Moderate percentage,Difficult percentage,"; a++; 
//			 //tables[a] = "exams:scrambledExamId,creatorUserId,code,createdDate,name,img,intDesc,pubDesc,prer,notes,examTime,totalModules,maxTimePerModule,totalQuestions,questionsPerModule,percQEasy,percQMod,percQDiff,active:t50,i,t50,i,t50,t50,t50,t50,t50,t50,i,i,i,i,i,i,i,i:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:,,Code,Date,Name,Image,Internal description,Public description,Prerequisites,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Easy,Moderate,Difficult,:,,Code,Date,Name,Image,,Public description,Prerequisites,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Easy percentage,Moderate percentage,Difficult percentage"; a++; 
//			 
//			 // NEW 15 3
//			 // exams,scrambledExamId,creatorUserId,code,createdDate,name,img,intDesc,pubDesc,prer,notes,examTime,totalModules,maxTimePerModule,totalQuestions,questionsPerModule,percQEasy,percQMod,percQDiff,active
//			 //tables[a] = "exams:scrambledExamId,creatorUserId,code,createdDate,name,img,intDesc,pubDesc,prer,notes,examTime,totalModules,maxTimePerModule,totalQuestions,questionsPerModule,percQEasy,percQMod,percQDiff,active"; a++; 
//
//			 // this will not be needed
//			 ////tables[a] = "allSafeIds:safeId,isUsedInType:VARCHAR(15),TINYINT UNSIGNED:t,t:Safe id,Is used in type:Safe id,Is used in type"; a++; 
//			 //tables[a] = "allSafeIds:safeId,unsafeId,isUsedInType:VARCHAR(15),INT UNSIGNED,TINYINT UNSIGNED:t,t,t:Safe id,UnsafeId,Is used in type:Safe id,Unsafe id,Is used in type"; a++; 
//
//			 // AWS test 15 3
//			 tables[a] = "zzz:scrambledExamId,creatorUserId,code,createdDate,name,img,intDesc,pubDesc,prer,notes,examTime,totalModules,maxTimePerModule,totalQuestions,questionsPerModule,percQEasy,percQMod,percQDiff,active:VARCHAR(20),INT,CHAR(8),INT,VARCHAR(100),VARCHAR(100),VARCHAR(5000),VARCHAR(5000),VARCHAR(100),VARCHAR(100),TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Scrambled exam id,Creator user id,Code,Created date,Name,Img,Int desc,Pub desc,Prer,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Perc q easy,Perc q mod,Perc q diff,Active:Scrambled exam id,Creator user id,Code,Created date,Name,Img,Int desc,Pub desc,Prer,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Perc q easy,Perc q mod,Perc q diff,Active"; a++; 
//
//			 // HUOM!
//			 // safeId = CHAR(10)
//
//			 tables[a] = "users:safeId,firstName,lastName,email,login,password,photo,signature,countryId,langId,smsPermission,emailPermission,active:CHAR(10),VARCHAR(50),VARCHAR(50),VARCHAR(100),VARCHAR(50),VARCHAR(50),VARCHAR(100),CHAR(8),TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t:Scrambled user id,First name,Last name,Email,Login,Password,Photo,Signature,Country id,Lang id,Sms permission,Email permission,Active:Scrambled user id,First name,Last name,Email,Login,Password,Photo,Signature,Country id,Lang id,Sms permission,Email permission,Active"; a++; 
//
//			 tables[a] = "exams:safeId,creatorUserId,code,createdDate,name,img,intDesc,pubDesc,prer,notes,examTime,totalModules,maxTimePerModule,totalQuestions,questionsPerModule,percQEasy,percQMod,percQDiff,active:VARCHAR(10),INT,CHAR(8),INT,VARCHAR(100),VARCHAR(100),VARCHAR(5000),VARCHAR(5000),VARCHAR(100),VARCHAR(100),TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Scrambled exam id,Creator user id,Code,Created date,Name,Img,Int desc,Pub desc,Prer,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Perc q easy,Perc q mod,Perc q diff,Active:Scrambled exam id,Creator user id,Code,Created date,Name,Img,Int desc,Pub desc,Prer,Notes,Exam time,Total modules,Max time per module,Total questions,Questions per module,Perc q easy,Perc q mod,Perc q diff,Active"; a++; 
//			 
//			 //tables[a] = "modules:safeId,examId,order,name,img,randomiseQuestions,intDesc,pubDesc,addedDate,lastEditedDate,active:t50,i,i,t50,t50,i,t50,t50,i,i,i:t,t,t,t,t,t,t,t,t,t,t:Scrambled module id,Exam id,Order,Name,Image,Randomise questions,Internal description,Public description,Added date,Last edited date,Active:Scrambled module id,Exam id,Order,Name,Image,Randomise questions,Internal description,Public description,Added date,Last edited date,Active"; a++; 
//			 //tables[a] = "questions:safeId,questionTypeId,difficultyLevelId,questionText,correctAnswerId,answers,internalName,sourceNotes,groupId,addedDate,lastEditedDate,active:t50,i,i,t50,i,t50,t50,t50,i,i,i,i:t,t,t,t,t,t,t,t,t,t,t,t:,Question type,Difficulty level,Question text,Correct answer,Answers,Internal name,Source notes,Group,Added,Last edited,Active:,Question type,Difficulty level,Question text,Correct answer,Answers,Internal name,Source notes,Group,,,Active"; a++; 
//			 //tables[a] = "questionGroupNames:langId,examId,moduleId,groupName:i,i,i,t50:t,t,t,t:Language,Exam id,Module id,Group name:Language,Exam id,Module id,Group name"; a++; 
//			 //tables[a] = "questionTypes:langId,name,order:i,t50,i:t,t,t:Language,Name,Order:Language,Name,Order"; a++; 
//			 //tables[a] = "languages:langId,name,flag:TINYINT UNSIGNED,VARCHAR(25),VARCHAR(7):t,t,t"; a++; 
//			 //tables[a] = "countries:langId,name,flag,orderId:TINYINT UNSIGNED,VARCHAR(25),VARCHAR(7),TINYINT UNSIGNED:t,t,t,t"; a++; 
//			 //tables[a] = "currencies:code,sign,name,format:VARCHAR(3),VARCHAR(3),VARCHAR(25),VARCHAR(10):t,t,t,t"; a++;
//			 //tables[a] = "contents:langId,parentId,contentName,contentText:TINYINT UNSIGNED,INT UNSIGNED, VARCHAR(30),VARCHAR(50):t,t,t,t"; a++;
				 
				 
				 
				 
				 // TARVEL EXPENSES - OMA
				 //tables[a] = "travelExpenses:date,itemDesc,sum,paidById,chargedFromId,rememberId:INT UNSIGNED,VARCHAR(50),INT UNSIGNED,CHAR(1),CHAR(1),CHAR(1):t,t,t,t,t,t";
				 
				 
                //// script generator 14 11 2016
                //tables[a] = "gen_sites:name,siteDesc,dateCreated,isMultiLanguage,orderId,siteTypeId:t50,t255,int,int,int,int:t,t,d,d,d,d"; a++;
                //tables[a] = "gen_tables:siteId,name,tableDesc,isDefault,orderId:int,t50,t255,int,int:d,t,t,d,d"; a++;
                //tables[a] = "gen_fields:tableId,name,db_FieldTypeId,db_notNull,db_defaultValue,form_TypeId,form_errorTextContentId,form_foreignKey,form_foreignValue,form_foreignOrderBy,fieldDesc,orderId:int,t50,int,int,t50,int,t100,t50,t50,t50,t255,int:d,t,d,d,t,d,t,t,t,t,t,d"; a++;
                //tables[a] = "gen_dbFieldTypes:name,fieldTypeDesc,data,orderId:t50,t255,t255,int:t,t,t,d"; a++;
                //// Test data: (data: int,varchar(16),varchar(60),varchar(255),bool)
                //tables[a] = "gen_formTypes:name,formTypeDesc,data,orderId:t50,t255,t255,int:t,t,t,d"; a++;
                //// Test data: (data: text,phone,password,email,address,postal code,active,countryId,countyId,cityId)
                //tables[a] = "gen_pages:name,data,orderId:t50,t255,int:t,t,d"; a++;
                //tables[a] = "gen_pagesToSites:siteId,pageId,orderId:int,int,int:d,d,d"; a++;
                //tables[a] = "gen_navigationItems:siteId,langId,name,url,orderId:int,int,t50,t50,int:d,d,t,t,d"; a++;
                //tables[a] = "gen_controls:name,controlDesc,controlTypeId,dbTable,defaultListId,data:t50,t255,int,t50,t50,t255:t,t,d,t,t,t"; a++;
                //tables[a] = "gen_controlsToPages:pageId,langId,orderId:int,int,int:d,d,d"; a++;
                //tables[a] = "gen_languages:langId,name:int,t50:d,t"; a++;
                //tables[a] = "gen_contents:langId,codeName,text:int,t50,t255:d,t,t"; a++;

                // // Jonnan dating site
                // tables[a] = "dat_users:userId,siteId,langId,genderId,ageId,searchingForGenderId,searchingForAgeId,userStatusId,userName,email,password,title,cityId,mainImageName,userSinceDate,active:t10,int,int,int,int,int,int,int,t50,t50,t30,t50,int,t20,int,int:t,d,d,d,d,d,d,d,t,t,t,t,d,t,d,d"; a++;
                // tables[a] = "dat_userActivity:userId,userActivityTypeId,date:t10,int,int,int:t,d,d,d"; a++;
                // tables[a] = "dat_profile:userId,countyId,cityId,lifeStatusId,familyStatusId,height,hasChildrenId,educationId,doesForLiving,incomeId,livesIncountryId,postcode,howHeardAboutUs,ageId,bodyTypeId,smokingId,petsId,numberOfChildrenId,shortIntroText,personalText,mainImageName,imageNames:t10,int,int,int,int,int,int,int,t50,int,int,int,t50,int,int,int,int,int,T,T,t50,T:t,d,d,d,d,d,d,d,t,d,d,d,t,d,d,d,d,d,t,t,t,t"; a++;
                // tables[a] = "dat_cities:langId,name:int,t50:d,t"; a++;

				// topical chat
				 tables[a] = "topicalChat_eventMessages:fromUserId,toUserId,sentDateTime,message:INT UNSIGNED,INT UNSIGNED,INT UNSIGNED,VARCHAR(255):t,t,t,t:From user,To user,Date time,Message:From user id,To user id,Date time,Message"; a++; 
				 tables[a] = "TopicalChat_users:safeId,siteId,langId,login,email,password,countryId,stateId,regionId,countyId,cityId,suburbId,genderId,ageGroupId,description,picture,userSinceDate:VARCHAR(100),TINYINT UNSIGNED,TINYINT UNSIGNED,VARCHAR(50),VARCHAR(50),VARCHAR(50),INT,INT,INT,INT,INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,VARCHAR(100),VARCHAR(100),INT:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Safe id,Site id,Lang id,Login,Email,Password,Country id,State id,Region id,County id,City id,Suburb id,Gender id,Age group id,Description,Picture,User since date:Safe id,Site id,Lang id,Login,Email,Password,Country id,State id,Region id,County id,City id,Suburb id,Gender id,Age group id,Description,Picture,User since date"; a++; 
				 tables[a] = "TopicalChat_topics:topicId,parentTopicId,langId,name,topicDesc,active:INT, INT,TINYINT UNSIGNED,VARCHAR(50),VARCHAR(100),TINYINT UNSIGNED:t,t,t,t,t,t:Topic id,Parent topic id,Lang id,Name,Topic desc,Active:Topic id,Parent topic id,Lang id,Name,Topic desc,Active"; a++; 
				 tables[a] = "TopicalChat_usersToGroups:userId,groupId:INT,INT:t,t:User id,Group id:User id,Group id"; a++; 

				 tables[a] = "topicalchat_events:siteId,hostUserId,eventCreatedDate,roomId,EventStartTime,eventEndTime,eventTypeId,langId,topicId,topicId2,topicId3,title,eventDescription,images,seatsTotal,seatsWomen,seatsMen,ageLimitation,badgeLimitation,invitationLimitation,countryId,stateId,areaId,countyId,cityId,suburbId,active:INT,INT,INT,TINYINT UNSIGNED,INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,INT,INT,INT,VARCHAR(100),VARCHAR(5000),VARCHAR(100),TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,INT,INT,INT,INT,INT,INT,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Site id,Host user id,Event created date,Room id,Start date,End date,Event type id,Lang id,Topic id,Topic id2,Topic id3,Title,Event description,Images,Seats total,Seats women,Seats men,Age limitation,Badge limitation,Invitation limitation,Country id,State id,Area id,County id,City id,Suburb id,Active:Site id,Host user id,Event created date,Room id,Start time,End time,Event type id,Lang id,Topic id,Topic id2,Topic id3,Title,Event description,Images,Seats total,Seats women,Seats men,Age limitation,Badge limitation,Invitation limitation,Country id,State id,Area id,County id,City id,Suburb id,Active"; a++; 
				 
				 tables[a] = "topicalchat_eventTypes:eventTypeId,langId,name,typeDesc:INT, TINYINT UNSIGNED,VARCHAR(50),VARCHAR(5000):t,t,t,t:Event type id,Lang id,Name,Type desc:Event type id,Lang id,Name,Type desc"; a++; 
				 // use common languages table!
				 //tables[a] = "topicalchat_languages:langId,name,flag:TINYINT UNSIGNED,VARCHAR(20),CHAR(8):t,t,t:Lang id,Name,Flag:Lang id,Name,Flag"; a++; 
				 tables[a] = "topicalchat_usersToEvents:userId,eventId,registrationDateTime,startedTime,finishedTime:INT,INT,INT,INT,INT:t,t,t,t,t:User id,Event id,Registration date time,Started time,Finished time:User id,Event id,Registration date time,Started time,Finished time"; a++; 

				 // assholes behind wheels
				 tables[a] = "assholes_entries:regPlate,safeId,siteId,countryId,stateId,regionId,countyId,cityId,suburbId,streetName,houseNumber,locationDetail,dateTimeObserved,mapX,mapY,locationTypeId,actionTypeId,driverEthnicityId,driverGenderId,driverAgeGroupId,driverFirstName,driverLastName,userId:CHAR(8),VARCHAR(15),INT,INT,INT,INT,INT,INT,INT,VARCHAR(50),CHAR(8),VARCHAR(100),INT,VARCHAR(15),VARCHAR(15),INT,INT,INT,INT,INT,VARCHAR(20),VARCHAR(50),INT:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Reg plate,Safe id,Site id,Country id,State id,Region id,County id,City id,Suburb id,Street name,House number,Location detail,Date time observed,Map x,Map y,Location type id,Action type id,Driver ethnicity id,Driver gender id,Driver age group id,Driver first name,Driver last name,User id:Reg plate,Safe id,Site id,Country id,State id,Region id,County id,City id,Suburb id,Street name,House number,Location detail,Date time observed,Map x,Map y,Location type id,Action type id,Driver ethnicity id,Driver gender id,Driver age group id,Driver first name,Driver last name,User id"; a++; 
				 tables[a] = "assholes_detailData:dataTypeId,langId,name,order:TINYINT UNSIGNED,TINYINT UNSIGNED,VARCHAR(50),INT:t,t,t,t:Data type id,Lang id,Name,Order:Data type id,Lang id,Name,Order"; a++; 
				 tables[a] = "assholes_usersAndComments:commentsEntryId,siteId,langId,dateTimeWritten,title,entryOrCommentText,pictures,userName,genderIdId,ageGroupId,profilePicture,hiddenEmail:INT,TINYINT UNSIGNED,TINYINT UNSIGNED,INT,VARCHAR(50),VARCHAR(100),VARCHAR(100),VARCHAR(50),TINYINT UNSIGNED,TINYINT UNSIGNED,VARCHAR(20),VARCHAR(50):t,t,t,t,t,t,t,t,t,t,t,t:Comments entry id,Site id,Lang id,Date time written,Title,Entry or comment text,Pictures,User name,Gender id id,Age group id,Profile picture,Hidden email:Comments entry id,Site id,Lang id,Date time written,Title,Entry or comment text,Pictures,User name,Gender id id,Age group id,Profile picture,Hidden email"; a++; 
				 tables[a] = "assholes_featuredData:featureTypeId,siteId,langId,dataId,orderId:TINYINT UNSIGNED,INT,INT,INT,INT:t,t,t,t,t:Feature type id,Site id,Lang id,Data id,Order id:Feature type id,Site id,Lang id,Data id,Order id"; a++; 
				 tables[a] = "assholes_userActivity:dataTypeId,dataId,clickCount:TINYINT UNSIGNED,TINYINT UNSIGNED,INT:t,t,t:Data type id,Data id,Click count:Data type id,Data id,Click count"; a++; 

                 // time between us
                 tables[a] = "timeBetweenUs_profile:login,password,email,genderId,coords1,coords2,coords3,birthYear,ageGroupId,incomeLevelId,educationLevelId,hasChildrenId,wantsChildrenId,worksOutId,travelsId,hasVehicleId,hasSummerCottageId,smokesId,drinksId,shortDesc,title,longDesc,totalPersonsContacted,totalMessagesSent,totalMessagesReceived,totalMessagesAnswered,messageResponseSpeeds,userSinceDate,creditsLeft,active:VARCHAR(50),VARCHAR(50),VARCHAR(50),TINYINT UNSIGNED,INT,INT,INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,VARCHAR(250),VARCHAR(50),VARCHAR(2500),INT,INT,INT,INT,VARCHAR(20),INT,INT,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Login,Password,Email,Gender id,Coords1,Coords2,Coords3,Birth year,Age group,Income level,Education level,Has children,Wants children,Works out,Travels,Has vehicle,Has summer cottage,Smokes,Drinks,Short desc,Title,Long desc,Total persons contacted,Total messages sent,Total messages received,Total messages answered,Message response speeds,User since date,Credits left,Active:Login,Password,Email,Gender id,Coords1,Coords2,Coords3,Birth year,Age group id,Income level id,Education level id,Has children id,Wants children id,Works out id,Travels id,Has vehicle id,Has summer cottage id,Smokes id,Drinks id,Short desc,Title,Long desc,Total persons contacted,Total messages sent,Total messages received,Total messages answered,Message response speeds,User since date,Credits left,Active"; a++; 

                // packetsEvrywhere
               
                 /*
                 // ORIGINAL
                tables[a] = "packets_shipments:siteId,countryId,senderUserId,senderIsCompany,pickupUserId,pickupPointIsCompany,driverUserId,driverIsCompany,receiverId,receiverIsCompany,shipmenId,fromXY,toXY,shipmentTypeId,sizeId,weightId,image,offersAskedDate,startDate,endDate,shipmentStatusId:TINYINT UNSIGNED,INT,INT,VARCHAR(5000),INT,VARCHAR(5000),INT,VARCHAR(5000),INT,VARCHAR(5000),INT,VARCHAR(20),VARCHAR(20),TINYINT UNSIGNED,TINYINT UNSIGNED,INT,VARCHAR(50),INT,INT,INT,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Site id,Country id,Sender user id,Sender is company,Pickup user id,Pickup point is company,Driver user id,Driver is company,Receiver id,Receiver is company,Shipmen id,From x y,To x y,Shipment type id,Size id,Weight id,Image,Offers Asked Date,Start date,End date,Shipment status id:Site id,Country id,Sender user id,Sender is company,Pickup user id,Pickup point is company,Driver user id,Driver is company,Receiver id,Receiver is company,Shipmen id,From x y,To x y,Shipment type id,Size id,Weight id,Image,Offers Asked Date,Start date,End date,Shipment status id"; a++; 
                */
                 // WITH BOOLEANS AND EMAIL AND fromAdr and toAdr
                tables[a] = "packets_shipments:safeShipmentId,friendlyShipmentId,siteId,countryId,senderUserId,senderIsCompany,pickupUserId,pickupPointIsCompany,driverUserId,driverIsCompany,receiverId,receiverIsCompany,email,fromTown,toTown,fromAdr,toAdr,fromXY,toXY,shipmentTypeId,shipmentTypeId2,weightId,image,offersAskedDate,startDate,endDate,shipmentStatusId:VARCHAR(30),INT,TINYINT UNSIGNED,INT,INT,BOOLEAN,INT,BOOLEAN,INT,BOOLEAN,INT,BOOLEAN,VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(20),VARCHAR(20),TINYINT UNSIGNED,TINYINT UNSIGNED,INT,VARCHAR(50),INT,INT,INT,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Safe Shipment Id,Friendly Shipment Id,Site id,Country id,Sender user id,Sender is company,Pickup user id,Pickup point is company,Driver user id,Driver is company,Receiver id,Receiver is company,From Town,To Town,Email,From Address,To Address,From x y,To x y,Shipment type id,Size id,Weight id,Image,Offers Asked Date,Start date,End date,Shipment status id:Safe Shipment Id,Friendly Shipment Id,Site id,Country id,Sender user id,Sender is company,Pickup user id,Pickup point is company,Driver user id,Driver is company,Receiver id,Receiver is company,Email,From Town,To Town,From Address,To Address,From xy,To xy,Shipment type id,Size id,Weight id,Image,Offers Asked Date,Start date,End date,Shipment status id"; a++; 

                 tables[a] = "packets_offers:siteId,shipmentId,driverUserId,savedDateTime,offerEndDate,priceAsked,priceComment,acceptedDateTime,accepted:TINYINT UNSIGNED,INT,INT,INT,INT,CHAR(8),VARCHAR(100),INT,TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t:Site id,Shipment id,Driver user id,Saved date time,Offer end date,Price asked,Comment,Accepted date time,Accepted:Site id,Shipment id,Driver user id,Saved date time,Offer end date,Price asked,Comment,Accepted date time,Accepted"; a++; 

                /* password NOTE: hashed password is a 60-character string */
                /* encrypted email NOTE: in database use  VARCHAR(21844) */
                 tables[a] = "packets_users:siteId,countryId,login,password,firstName,lastName,phone,email,langId,picture,userSinceDate,isDriver,active:TINYINT UNSIGNED,INT,VARCHAR(50),VARCHAR(60),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(21844),INT,VARCHAR(50),INT,BOOLEAN,BOOLEAN:t,t,t,t,t,t,t,t,t,t,t,t,t:Site id,Country id,Login,Password,First name,Last name,Phone,Email,Lang id,Picture,User since date,Is driver,Active:Site id,Country id,Login,Password,First name,Last name,Phone,Email,Lang id,Picture,User since date,Is driver,Active"; a++; 

                 tables[a] = "packets_companies:siteId,countryId,name,name2,parentCompanyId,division,address,address2,houseNumber,floor,description,image,postalCode,cityId,xy,active:TINYINT UNSIGNED,INT,VARCHAR(50),VARCHAR(50),INT,VARCHAR(50),VARCHAR(50),VARCHAR(50),CHAR(8),CHAR(8),VARCHAR(100),VARCHAR(100),CHAR(8),INT,VARCHAR(20),TINYINT UNSIGNED:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:Site id,Country id,Name,Name2,Parent company id,Division,Address,Address2,House number,Floor,Description,Image,Postal code,City id,Xy,Active:Site id,Country id,Name,Name2,Parent company id,Division,Address,Address2,House number,Floor,Description,Image,Postal code,City id,Xy,Active"; a++; 

                  tables[a] = "packets_cdriverDetails:driverUserId,vehicleTypeId,vehicleSizeId,maxShipmentSizeId,startDate,totalShipments,reviewScore:INT,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,INT,INT,INT:t,t,t,t,t,t,t:Driver user id,Vehicle type id,Vehicle size id,Max shipment size id,Start date,Total shipments,Review score:Driver user id,Vehicle type id,Vehicle size id,Max shipment size id,Start date,Total shipments,Review score"; a++; 

                    tables[a] = "packets_shipmentStatusIds:statusId,siteId,langId,name,shipmentDesc:INT,TINYINT UNSIGNED,INT,VARCHAR(50),VARCHAR(100):t,t,t,t,t:Status id,Site id,Lang id,Name,Shipment desc:Status id,Site id,Lang id,Name,Shipment desc"; a++; 



             
                // MVP evriwhere
                tables[a] = "mvp_evriwhere_shipments:siteCountryCode,frLangId,frHouseNumber,frStreet,frNeighborhoodOrAreaOpt,frCityOrBorough,frCounty,frState,frCountry,frZip,frExtraNumberOpt,frLat,frLng,frFloor,frApt,frExtraInfo,toHouseNumber,toStreet,toNeighborhoodOrAreaOpt,toCityOrBorough,toCounty,toState,toCountry,toZip,toExtraNumberOpt,toLat,toLng,toFloor,toApt,toExtraInfo:CHAR(8),CHAR(8),CHAR(8),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),CHAR(8),CHAR(8),CHAR(8),CHAR(8),CHAR(8),CHAR(8),CHAR(8),CHAR(8),VARCHAR(255),CHAR(8),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),CHAR(8),CHAR(8),CHAR(8),CHAR(8),CHAR(8),CHAR(8),CHAR(8),CHAR(8),VARCHAR(255):input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Site country code,Fr lang id,Fr house number,Fr street,Fr neighborhood or area opt,Fr city or borough,Fr county,Fr state,Fr country,Fr zip,Fr extra number opt,Fr lat,Fr lng,Fr floor,Fr apt,Fr extra info,To house number,To street,To neighborhood or area opt,To city or borough,To county,To state,To country,To zip,To extra number opt,To lat,To lng,To floor,To apt,To extra info:Site country code,Fr lang id,Fr house number,Fr street,Fr neighborhood or area opt,Fr city or borough,Fr county,Fr state,Fr country,Fr zip,Fr extra number opt,Fr lat,Fr lng,Fr floor,Fr apt,Fr extra info,To house number,To street,To neighborhood or area opt,To city or borough,To county,To state,To country,To zip,To extra number opt,To lat,To lng,To floor,To apt,To extra info"; a++; 

                 tables[a] = "mvp_evriwhere_shipmentDetails:siteCountryCode,frName,frCompany,frEmail,frTel,toName,toCompany,toEmail,toTel,startDate,endDate,shType,shWeight,shWidth,shLength,shHeight,shStatus,paymentType,amount,currency,driverUserId,promisedDropOffDate,paidDate,pickedUpDate,droppedOffDate,shSpeed:CHAR(8),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),INT,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,CHAR(8),CHAR(8),INT,INT,INT,INT,INT,TINYINT UNSIGNED:input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Site country code,Fr name,Fr company,Fr email,Fr tel,To name,To company,To email,To tel,Start date,End date,Sh type,Sh weight,Sh width,Sh length,Sh height,Sh status,Payment type,Amount,Currency,Driver user id,Promised drop off date,Paid date,Picked up date,Dropped off date,Sh speed:Site country code,Fr name,Fr company,Fr email,Fr tel,To name,To company,To email,To tel,Start date,End date,Sh type,Sh weight,Sh width,Sh length,Sh height,Sh status,Payment type,Amount,Currency,Driver user id,Promised drop off date,Paid date,Picked up date,Dropped off date,Sh speed"; a++; 

                 tables[a] = "mvp_evriwhere_availableGigs:siteCountryCode,shipmentId,isFrom,shType,shSpeed,shWeight,startDate,endDate,countryGeocodePCLI,adm1GeonameId,adm2GeonameId,adm3GeonameId,lat,lng,street,neighborhoodOrAreaOpt,cityOrBorough,county,state,zip:CHAR(8),INT,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED,INT,INT,INT,INT,INT,INT,CHAR(8),CHAR(8),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),CHAR(8),CHAR(8):input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Site country code,Shipment id,Is from,Sh type,Sh speed,Sh weight,Start date,End date,Country geocode p c l i,Adm1 geoname id,Adm2 geoname id,Adm3 geoname id,Lat,Lng,Street,Neighborhood or area opt,City or borough,County,State,Zip:Site country code,Shipment id,Is from,Sh type,Sh speed,Sh weight,Start date,End date,Country geocode p c l i,Adm1 geoname id,Adm2 geoname id,Adm3 geoname id,Lat,Lng,Street,Neighborhood or area opt,City or borough,County,State,Zip"; a++; 

                 /*
                 tables[a] = "mvp_evriwhere_drivers:siteCountryCode,name,company,email,tel,images,title,text,geonameId1,geonameId2,geonameId3,signupDate,active:CHAR(3),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(100),VARCHAR(50),VARCHAR(3000),INT,INT,INT,INT,TINYINT UNSIGNED:input,input,input,input,input,input,input,input,input,input,input,input,input:Site country code,Name,Company,Email,Tel,Images,Title,Text,Geoname id1,Geoname id2,Geoname id3,Signup date,Active:Site country code,Name,Company,Email,Tel,Images,Title,Text,Geoname id1,Geoname id2,Geoname id3,Signup date,Active"; a++; 
                */ 

                 // siteCountryCode,email,postalcode,birthYear,geonameId1,geonameId2,geonameId3,geonameId4,geonameId5,geonameId6,signupDate,active
                 // NOTE!!! email must be at least 60 chars long!!
                 tables[a] = "mvp_evriwhere_drivers:siteCountryCode,name,company,email,tel,images,title,text,geonameId1,geonameId2,geonameId3,geonameId4,geonameId5,geonameId6,signupDate,active:CHAR(3),VARCHAR(50),VARCHAR(50),VARCHAR(60),VARCHAR(50),VARCHAR(100),VARCHAR(50),VARCHAR(3000),INT,INT,INT,INT,INT,INT,INT,TINYINT UNSIGNED:input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Site country code,Name,Company,Email,Tel,Images,Title,Text,Geoname id1,Geoname id2,Geoname id3,Geoname id1,Geoname id2,Geoname id3,Signup date,Active:Site country code,Name,Company,Email,Tel,Images,Title,Text,Geoname id1,Geoname id2,Geoname id3,Geoname id1,Geoname id2,Geoname id3,Signup date,Active"; a++; 
                


                
                // airbnb cleaners  LAT = CHAR(16)
                  tables[a] = "airbnb_cleaners:countryGeocode,geocode1,geocode2,geocode3,geocode4,geocode5,geocode6,lat,lng,displayName,numberOfPersonnel,startYear,companyName,companyId,firstName,lastName,email,password,phone,title,text,images,startDate,nextAdRenewDate,active:INT,INT,INT,INT,INT,INT,INT,CHAR(16),CHAR(16),VARCHAR(50),TINYINT UNSIGNED,INT,VARCHAR(50),VARCHAR(15),VARCHAR(20),VARCHAR(20),VARCHAR(50),VARCHAR(50),VARCHAR(20),VARCHAR(50),VARCHAR(5000),VARCHAR(50),INT,INT,TINYINT UNSIGNED:input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Country geocode,Geocode1,Geocode2,Geocode3,Geocode4,Geocode5,Geocode6,Lat,Lng,Display name,Number of personnel,Start year,Company name,Company id,First name,Last name,Email,Password,Phone,Title,Text,Images,Start date,Next ad renew date,Active:Country geocode,Geocode1,Geocode2,Geocode3,Geocode4,Geocode5,Geocode6,Lat,Lng,Display name,Number of personnel,Start year,Company name,Company id,First name,Last name,Email,Password,Phone,Title,Text,Images,Start date,Next ad renew date,Active"; a++; 
                 tables[a] = "airbnb_cleaner_workingDays:cleanerId,weekDayNumber,notWorking,timeStart,timeEnd:INT,TINYINT UNSIGNED,TINYINT UNSIGNED,INT,INT:input,input,input,input,input:Cleaner id,Week day number,Not working,Time start,Time end:Cleaner id,Week day number,Not working,Time start,Time end"; a++; 
                 tables[a] = "airbnb_cleaner_prices:cleanerId,perRoom10sqmPrice,perRoom20sqmPrice,perRoom30sqmPrice,perApartment30sqmPrice,perApartment50sqmPrice,perApartment80sqmPrice,perApartment120sqmPrice,perApartment150sqmPrice,perHouse100sqmPrice,perHouse200sqmPrice,perHouse300sqmPrice,perHouse400sqmPrice,perHouse500sqmPrice,withKitchen,hourlyPrice,currencyId,validStartDate,validEndDate:INT,INT,INT,INT,INT,INT,INT,INT,INT,INT,INT,INT,INT,INT,INT,INT,CHAR(8),INT,INT:input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Cleaner id,Per room10sqm price,Per room20sqm price,Per room30sqm price,Per apartment30sqm price,Per apartment50sqm price,Per apartment80sqm price,Per apartment120sqm price,Per apartment150sqm price,Per house100sqm price,Per house200sqm price,Per house300sqm price,Per house400sqm price,Per house500sqm price,With kitchen,Hourly price,Currency id,Valid start date,Valid end date:Cleaner id,Per room10sqm price,Per room20sqm price,Per room30sqm price,Per apartment30sqm price,Per apartment50sqm price,Per apartment80sqm price,Per apartment120sqm price,Per apartment150sqm price,Per house100sqm price,Per house200sqm price,Per house300sqm price,Per house400sqm price,Per house500sqm price,With kitchen,Hourly price,Currency id,Valid start date,Valid end date"; a++; 





                /* ----------------New tables 27.2. ----------------------- */
                tables[a] = "funwithbox_users:siteCountryCode,login,password,firstName,lastName,company,phone,email,langId,images,isDriver,userSinceDate:CHAR(3),VARCHAR(50),VARCHAR(60),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(20),VARCHAR(50),VARCHAR(3),VARCHAR(255),BOOLEAN,INT:t,t,t,t,t,t,t,t,t,t,t,t:siteCountryCode,login,password,firstName,lastName,company,phone,email,langId,images,isDriver,userSinceDate:siteCountryCode,login,password,firstName,lastName,company,phone,email,langId,images,isDriver,userSinceDate"; a++;

                tables[a] = "funwithbox_addresses:siteCountryCode,shipmentId,isFromOrTo,ChainOrderNumber,houseNumber,street,neighborhoodOrAreaOpt,cityOrBorough,county,state,country,zip,extraNumberOpt,lat,lng,floor,apt,extraInfo,createdDate: CHAR(3), INT, CHAR(1),TINYINT,TINYINT,VARCHAR(50), VARCHAR(50), VARCHAR(50),VARCHAR(50),CHAR(8), CHAR(3),CHAR(8),TINYINT,CHAR(8),CHAR(8),CHAR(8), CHAR(8), VARCHAR(255),INT:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:siteCountryCode,shipmentId,isFromOrTo,ChainOrderNumber,houseNumber,street,neighborhoodOrAreaOpt,cityOrBorough,county,state,country,zip,extraNumberOpt,lat,lng,floor,apt,extraInfo,createdDate:siteCountryCode,shipmentId,isFromOrTo,ChainOrderNumber,houseNumber,street,neighborhoodOrAreaOpt,cityOrBorough,county,state,country,zip,extraNumberOpt,lat,lng,floor,apt,extraInfo,createdDate"; a++;

                tables[a] = "funwithbox_shipments:siteCountryCode,langId,frCountryGeocodePCLI,frAdm1GeonameId,frAdm2GeonameId,frAdm3GeonameId,frLat,frLng,toCountryGeocodePCLI,toAdm1GeonameId,toAdm2GeonameId,toAdm3GeonameId,toLat,toLng,frUserId,frCompanyId,toFirstName,toLastName,toCompanyId,toEmail,toTel,startDate,endDate,shType,shType2,numberPersons,numberChildSeats,shWeight,shValue,shDesc,shSpeed,shWidth,shLength,shHeight,shStatus,paymentType,amount,currency,driverUserId,promisedDropOffDate,paidDate,pickedUpDate,droppedOffDate,createdDate,activeUntilDate,active:CHAR(3),INT, INT,VARCHAR(50),VARCHAR(50),VARCHAR(50),CHAR(8),CHAR(8), INT,VARCHAR(50),VARCHAR(50),VARCHAR(50),CHAR(8),CHAR(8),INT,VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(21844),VARCHAR(50),INT,INT,TINYINT,TINYINT,TINYINT,TINYINT, INT, INT,VARCHAR(255), TINYINT,INT, INT, INT,TINYINT,TINYINT,CHAR(8),CHAR(8),INT,INT,INT,INT,INT,INT,INT, BOOLEAN:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:siteCountryCode,langId,frCountryGeocodePCLI,frAdm1GeonameId,frAdm2GeonameId,frAdm3GeonameId,frLat,frLng,toCountryGeocodePCLI,toAdm1GeonameId,toAdm2GeonameId,toAdm3GeonameId,toLat,toLng,frUserId,frCompanyId,toFirstName,toLastName,toCompanyId,toEmail,toTel,startDate,endDate,shType,shType2,numberPersons,numberChildSeats,shWeight,shValue,shDesc,shSpeed,shWidth,shLength,shHeight,shStatus,paymentType,amount,currency,driverUserId,promisedDropOffDate,paidDate,pickedUpDate,droppedOffDate,createdDate,activeUntilDate,active:siteCountryCode,langId,frCountryGeocodePCLI,frAdm1GeonameId,frAdm2GeonameId,frAdm3GeonameId,frLat,frLng,toCountryGeocodePCLI,toAdm1GeonameId,toAdm2GeonameId,toAdm3GeonameId,toLat,toLng,frUserId,frCompanyId,toFirstName,toLastName,toCompanyId,toEmail,toTel,startDate,endDate,shType,shType2,numberPersons,numberChildSeats,shWeight,shValue,shDesc,shSpeed,shWidth,shLength,shHeight,shStatus,paymentType,amount,currency,driverUserId,promisedDropOffDate,paidDate,pickedUpDate,droppedOffDate,createdDate,activeUntilDate,active"; a++;

                tables[a] = "funwithbox_companies:siteCountryCode,mainContactUserId,name,name2,parentCompanyId,division,address,address2,houseNumber,floor,description,image,postalCode,cityGeonameId,userSinceDate,active: CHAR(3),INT,VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),TINYINT,CHAR(8),VARCHAR(255),VARCHAR(100), CHAR(8),VARCHAR(50),INT, BOOLEAN:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:siteCountryCode,mainContactUserId,name,name2,parentCompanyId,division,address,address2,houseNumber,floor,description,image,postalCode,cityGeonameId,userSinceDate,active:siteCountryCode,mainContactUserId,name,name2,parentCompanyId,division,address,address2,houseNumber,floor,description,image,postalCode,cityGeonameId,userSinceDate,active"; a++;

                tables[a] = "funwithbox_availableGigs:siteCountryCode,shipmentId,isFrom,shType,shType2,numberPersons,shWeight,shSpeed,startDate,endDate,countryGeocodePCLI,adm1GeonameId,adm2GeonameId,adm3GeonameId,lat,lng,houseNumber,street,neighborhoodOrAreaOpt,cityOrBorough,county,state,zip,createdDate,activeUntilDate: CHAR(3),INT, BOOLEAN,TINYINT,TINYINT,TINYINT, INT, TINYINT,INT,INT, INT,VARCHAR(50),VARCHAR(50),VARCHAR(50),CHAR(8),CHAR(8),TINYINT,VARCHAR(50), INT, INT,VARCHAR(50),CHAR(8),CHAR(8),INT,INT:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:siteCountryCode,shipmentId,isFrom,shType,shType2,numberPersons,shWeight,shSpeed,startDate,endDate,countryGeocodePCLI,adm1GeonameId,adm2GeonameId,adm3GeonameId,lat,lng,houseNumber,street,neighborhoodOrAreaOpt,cityOrBorough,county,state,zip,createdDate,activeUntilDate:siteCountryCode,shipmentId,isFrom,shType,shType2,numberPersons,shWeight,shSpeed,startDate,endDate,countryGeocodePCLI,adm1GeonameId,adm2GeonameId,adm3GeonameId,lat,lng,houseNumber,street,neighborhoodOrAreaOpt,cityOrBorough,county,state,zip,createdDate,activeUntilDate"; a++;

                tables[a] = "funwithbox_driverProfiles:siteCountryCode,userId,title,text,vehicleTypeId,vehicleSizeId,maxShipmentSizeId,isStoragePoint,isLongDistanceDriver,geonameId1,geonameId2,geonameId3,geonameId4,geonameId5,geonameId6,totalShipments,reviewScore: CHAR(3),INT,VARCHAR(50),VARCHAR(3000),TINYINT,INT,INT, BOOLEAN, BOOLEAN,VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50), INT, INT:t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t,t:siteCountryCode,userId,title,text,vehicleTypeId,vehicleSizeId,maxShipmentSizeId,isStoragePoint,isLongDistanceDriver,geonameId1,geonameId2,geonameId3,geonameId4,geonameId5,geonameId6,totalShipments,reviewScore:siteCountryCode,userId,title,text,vehicleTypeId,vehicleSizeId,maxShipmentSizeId,isStoragePoint,isLongDistanceDriver,geonameId1,geonameId2,geonameId3,geonameId4,geonameId5,geonameId6,totalShipments,reviewScore"; a++;

                tables[a] = "funwithbox_offers:shipmentId,driverUserId,priceOffered,currencyId,priceComment,pickupStartDate,pickupEndDate,dropoffStartDate,dropoffEndDate,offerValidUntilDate,savedDateTime,acceptedDateTime,accepted,active:INT,INT,INT,CHAR(3),VARCHAR(250),INT,INT,INT,INT,INT,INT,TINYINT,TINYINT,BOOLEAN:t,t,t,t,t,t,t,t,t,t,t,t,t,t:shipmentId,driverUserId,priceOffered,currencyId,priceComment,pickupStartDate,pickupEndDate,dropoffStartDate,dropoffEndDate,offerValidUntilDate,savedDateTime,acceptedDateTime,accepted,active:shipmentId,driverUserId,priceOffered,currencyId,priceComment,pickupStartDate,pickupEndDate,dropoffStartDate,dropoffEndDate,offerValidUntilDate,savedDateTime,acceptedDateTime,accepted,active"; a++;




        
                 tables[a] = "topicUtopia_messages:eventId,savedDate,frUserId,toUserId,msg:INT,INT,INT,INT,VARCHAR(100):input,input,input,input,input:Event id,Saved date,Fr user id,To user id,Msg:Event id,Saved date,Fr user id,To user id,Msg"; a++; 



                tables[a] = "homes_ads:siteCountryCode,adTypeId,countryId,county,town,streetAaddress,postalCode,aptTypeId,img,title,text,contactName,contactEmail,showEmail,phone,password,price,rooms,aptSize,kitchenTypeId,numberOfBathrooms,hasBalcony,hasPool,hasSauna,builtYear,renovationYear,viewedTimes,isPremiumAd,availableForRentSinceDate,depositSum,hasInternet,internetProviderCompany,internetIncludedSpeed,internetMaxSpeed,hasCableTv,petsAllowed,SmokingAllowed,electricityIncluded,waterIncluded,gasIncluded,internetIncluded,cableTvIncluded,garbagePickupIncluded,createdDate,activeStartDate,activeEndDate,active:CHAR(3),TINYINT UNSIGNED,INT,INT,INT,VARCHAR(50),CHAR(8),TINYINT UNSIGNED,VARCHAR(250),VARCHAR(250),VARCHAR(30),VARCHAR(20),VARCHAR(20),BOOLEAN,VARCHAR(15),VARCHAR(20),INT,TINYINT UNSIGNED,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,BOOLEAN,BOOLEAN,BOOLEAN,INT,INT,INT,BOOLEAN,INT,INT,BOOLEAN,VARCHAR(20),CHAR(8),CHAR(8),BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,INT,INT,INT,BOOLEAN:input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Site country code,Ad type id,Country id,County,Town,Street aaddress,Postal code,Apt type id,Img,Title,Text,Contact name,Contact email,Show email,Phone,Password,Price,Rooms,Apt size,Kitchen type id,Number of bathrooms,Has balcony,Has pool,Has sauna,Built year,Renovation year,Viewed times,Is premium ad,Available for rent since date,Deposit sum,Has internet,Internet provider company,Internet included speed,Internet max speed,Has cable tv,Pets allowed,Smoking allowed,Electricity included,Water included,Gas included,Internet included,Cable tv,Garbage pickup included,Created date,Active start date,Active end date,Active:Site country code,Ad type id,Country id,County,Town,Street aaddress,Postal code,Apt type id,Img,Title,Text,Contact name,Contact email,Show email,Phone,Password,Price,Rooms,Apt size,Kitchen type id,Number of bathrooms,Has balcony,Has pool,Has sauna,Built year,Renovation year,Viewed times,Is premium ad,Available for rent since date,Deposit sum,Has internet,Internet provider company,Internet included speed,Internet max speed,Has cable tv,Pets allowed,Smoking allowed,Electricity included,Water included,Gas included,Internet included,Cable tv,Garbage pickup included,Created date,Active start date,Active end date,Active"; a++; 

                 tables[a] = "homes_users:countryCode,login,password,firstName,lastName,phone,email,langId,picture,userSinceDate,isAdmin,active:CHAR(3),VARCHAR(50),VARCHAR(60),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),INT,VARCHAR(50),INT,BOOLEAN,BOOLEAN:t,t,t,t,t,t,t,t,t,t,t,t:Country id,Login,Password,First name,Last name,Phone,Email,Lang id,Picture,User since date,Is driver,Active:Country id,Login,Password,First name,Last name,Phone,Email,Lang id,Picture,User since date,Is driver,Active"; a++; 


                 // EAT
                 /*
                  tables[a] = "meals:country,area1,area2,area3,area4,title,desc,mealType,date,startTime,endTime,mainImg,imgs,seatsTotal,seatsBooked,price,paymentType:INT,INT,INT,INT,INT,VARCHAR(50),VARCHAR(100),TINYINT UNSIGNED,INT,INT,INT,CHAR(8),VARCHAR(100),TINYINT UNSIGNED,TINYINT UNSIGNED,INT,TINYINT UNSIGNED:input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Country,Area1,Area2,Area3,Area4,Title,Desc,Meal type,Date,Start time,End time,Main img,Imgs,Seats total,Seats booked,Price,Payment type:Country,Area1,Area2,Area3,Area4,Title,Desc,Meal type,Date,Start time,End time,Main img,Imgs,Seats total,Seats booked,Price,Payment type"; a++; 
                  */

                  // videoManager
                   tables[a] = "videoContent:videoIid,country,lang,creatorUserId,parentContentId,isComplementaryToContentId,isAlternativeToContentId,genre,type,name,description,textContent,saveDate,status,isPublished:INT,TINYINT UNSIGNED,TINYINT UNSIGNED,INT,INT,INT,INT,INT,TINYINT UNSIGNED,VARCHAR(50),VARCHAR(255),BLOB,INT,TINYINT UNSIGNED,BOOLEAN:input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Id,Country,Lang,Creator user id,Parent content id,Is complementary to content id,Is alternative to content id,Genre,Type,Name,Description,Text content,Save date,Status,Is published:Id,Country,Lang,Creator user id,Parent content id,Is complementary to content id,Is alternative to content id,Genre,Type,Name,Description,Text content,Save date,Status,Is published"; a++; 



                   // laundrier
                    tables[a] = "laundrier_users:houseId,isAdmin,name,email,password,aptNumber:INT,BOOLEAN,VARCHAR(50),VARCHAR(50),VARCHAR(50),CHAR(8):input,input,input,input,input,input:House id,Is admin,Name,Email,Password,Apt number:House id,Is admin,Name,Email,Password,Apt number"; a++; 

                     tables[a] = "houses:adminUserId,bookingTimeSpan,description,houseName,maxBookingsPerUser,noMachines,machineNames,registrationCode,slotEnd,slotLength,slotStart:INT,INT,BLOB,VARCHAR(50),TINYINT UNSIGNED,BOOLEAN,VARCHAR(250),CHAR(8),TINYINT UNSIGNED,TINYINT UNSIGNED,TINYINT UNSIGNED:input,input,input,input,input,input,input,input,input,input,input:Admin user id,Booking time span,Description,House name,Max bookings per user,No machines,Machine names,Registration code,Slot end,Slot length,Slot start:Admin user id,Booking time span,Description,House name,Max bookings per user,No machines,Machine names,Registration code,Slot end,Slot length,Slot start"; a++; 

                      tables[a] = "bookings:userId,houseId,machineId,date,startTime,name,aptNumber:INT,INT,TINYINT UNSIGNED,INT,INT,VARCHAR(50),VARCHAR(8):input,input,input,input,input,input,input:User id,House id,Machine id,Date,Start time,Name,Apt number:User id,House id,Machine id,Date,Start time,Name,Apt number"; a++; 




                    // EAT 2
                     tables[a] = "mealsStore:meal,addMeal,addMealDetails,addLocation,booking,bookings,payment,payments,user,register,login,reviews,addReview:BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN,BOOLEAN:input,input,input,input,input,input,input,input,input,input,input,input,input:Meal,Add meal,Add meal details,Add location,Booking,Bookings,Payment,Payments,User,Register,Login,Reviews,Add review:Meal,Add meal,Add meal details,Add location,Booking,Bookings,Payment,Payments,User,Register,Login,Reviews,Add review"; a++; 

                      tables[a] = "meals:country,area1,area2,area3,area4,title,description,mealType,date,startTime,endTime,mainImg,seatsTotal,seatsBooked,pickUpAvailable,deliveryAvailable,price,paymentType:TINYINT UNSIGNED,INT,INT,INT,INT,VARCHAR(50),VARCHAR(255),TINYINT UNSIGNED,INT,TINYINT UNSIGNED,TINYINT UNSIGNED,VARCHAR(20),TINYINT UNSIGNED,TINYINT UNSIGNED,BOOLEAN,BOOLEAN,INT,TINYINT UNSIGNED:input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Country,Area1,Area2,Area3,Area4,Title,Desc,Meal type,Date,Start time,End time,Main img,Seats total,Seats booked,Pick up available,Delivery available,Price,Payment type:Country,Area1,Area2,Area3,Area4,Title,Desc,Meal type,Date,Start time,End time,Main img,Seats total,Seats booked,Pick up available,Delivery available,Price,Payment type"; a++; 


                    tables[a] = "eat_users:countryId,name,email,password:INT,VARCHAR(50),VARCHAR(50),VARCHAR(50):input,input,input,input:House id,Name,Email,Password:House id,Name,Email,Password"; a++; 




                    // sportspoll
                     tables[a] = "poll_votes:event,vote:INT,TINYINT UNSIGNED:input,input:Event,Vote:Event,Vote"; a++; 

                    
                    // pizza online

         tables[a] = "pizza_users:name,email,phone,password,address,coordsXY,city,doorCode,joinedDate,totOrders,defaultRestaurantIds:VARCHAR(50),VARCHAR(50),VARCHAR(20),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(20),INT,INT,VARCHAR(50):input,input,input,input,input,input,input,input,input,input,input:Name,Email,Phone,Password,Address,Coords x y,City,Door code,Joined date,Tot orders,Default restaurant ids:Name,Email,Phone,Password,Address,Coords x y,City,Door code,Joined date,Tot orders,Default restaurant ids"; a++; 

         tables[a] = "pizza_cashUsers:restaurantId,userId:INT,INT:input,input:Restaurant id,User id:Restaurant id,User id"; a++; 

         tables[a] = "pizza_meals:restaurantId,groupId,name,descText,ingredientIds,price,variationIds,orderId:INT,TINYINT UNSIGNED,VARCHAR(50),VARCHAR(255),VARCHAR(255),INT,VARCHAR(255),INT:input,input,input,input,input,input,input,input:Restaurant id,Group id,Name,Description text,Ingredient ids,Price,variations,orderId:Restaurant id,Group id,Name,Description text,Ingredient ids,Price,variations,orderId"; a++; 

         tables[a] = "pizza_mealVariations:mealId,name,priceAdd:INT,VARCHAR(50),INT:input,input,input:Meal id,Name,Price add:Meal id,Name,Price add"; a++; 

         tables[a] = "pizza_ingredientsToMeals:mealId,ingredientId,priceIfextra,orderId:INT,INT,INT,TINYINT UNSIGNED:input,input,input,input:Meal id,Ingredient id,Price ifextra,Order id:Meal id,Ingredient id,Price ifextra,Order id"; a++; 

         tables[a] = "pizza_ingredientNames:restaurantId,langId,name:INT,TINYINT UNSIGNED,VARCHAR(50):input,input,input:Restaurant id,Lang id,Name:Restaurant id,Lang id,Name"; a++; 

         tables[a] = "pizza_mealGroups:restaurantId,langId,name,orderId:INT,INT,VARCHAR(50),TINYINT:input,input,input,input:restaurantId,Lang id,Name,orderId:restaurantId,Lang id,Name,orderId"; a++; 

         tables[a] = "pizza_orders:userId,estimatedDeliveryTime,isDelivery,message,doorCode,phone,totalSum,paymentType:TINYINT UNSIGNED,INT,BOOLEAN,VARCHAR(255),VARCHAR(20),VARCHAR(20),INT,INT:input,input,input,input,input,input,input,input:User id,Estimated delivery time,Is delivery,Message,Door code,Phone,Total sum,Payment type:User id,Estimated delivery time,Is delivery,Message,Door code,Phone,Total sum,Payment type"; a++; 

         tables[a] = "pizza_orderItems:orderId,mealId,variationId,price:INT,INT,INT,INT:input,input,input,input:Order id,Meal id,Variation id,Price:Order id,Meal id,Variation id,Price"; a++; 

         tables[a] = "pizza_restaurants:country,area1,area2,area3,area4,area5,coordsXY,address,phone,listingImg,outsideImg,imgTagIds,deliveryTime,name,avgStars,totVotes,priceLevel,foodTypeIds,minPurchase,deliveryPrice,bonus,openingHoursString,mapCoords,paymentTime,paymentTypeIds:TINYINT UNSIGNED,INT,INT,INT,INT,INT,VARCHAR(50),VARCHAR(50),VARCHAR(20),CHAR(8),CHAR(8),VARCHAR(50),INT,VARCHAR(50),TINYINT UNSIGNED,INT,TINYINT UNSIGNED,VARCHAR(50),INT,INT,TINYINT UNSIGNED,VARCHAR(255),VARCHAR(50),TINYINT UNSIGNED,VARCHAR(255):input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input,input:Country,Area1,Area2,Area3,Area4,Area5,Coords x y,Address,Phone,Listing img,Outside img,Img tag ids,Delivery time,Name,Avg stars,Tot votes,Price level,Food type ids,Min purchase,Delivery price,Bonus,Opening hours string,Map coords,Payment time,Payment type ids:Country,Area1,Area2,Area3,Area4,Area5,Coords x y,Address,Phone,Listing img,Outside img,Img tag ids,Delivery time,Name,Avg stars,Tot votes,Price level,Food type ids,Min purchase,Delivery price,Bonus,Opening hours string,Map coords,Payment time,Payment type ids"; a++; 

          tables[a] = "pizza_businessHours:resaurantId,weekdayIdOrDate,openHour,closeHour:INT,INT,INT,INT:input,input,input,input:Resaurant id,Weekday id or date,Open hour,Close hour:Resaurant id,Weekday id or date,Open hour,Close hour"; a++; 


         tables[a] = "pizza_imgTags:lang,name,orderId:TINYINT UNSIGNED,VARCHAR(15),INT:input,input,input:Lang,Name,Order id:Lang,Name,Order id"; a++; 

         tables[a] = "pizza_foodTypes:langId,name,orderId:INT,VARCHAR(50),TINYINT UNSIGNED:input,input,input:Lang id,Name,Order id:Lang id,Name,Order id"; a++; 

         tables[a] = "pizza_reviews:restaurantId,date,reviewText,stars:INT,INT,BLOB,TINYINT UNSIGNED:input,input,input,input:Restaurant id,Date,Review text,Stars:Restaurant id,Date,Review text,Stars"; a++; 


                /*
Truncate table funwithbox_users;
Truncate table funwithbox_addresses;
Truncate table funwithbox_shipments;
Truncate table funwithbox_companies;
Truncate table funwithbox_availableGigs;
Truncate table funwithbox_driverProfiles;
Truncate table funwithbox_offers;


                siteCountryCode,login,password,firstName,lastName,company,phone,email,langId,images,isDriver,userSinceDate:

                CHAR(3),VARCHAR(50),VARCHAR(60),VARCHAR(50),VARCHAR(50),VARCHAR(50),VARCHAR(20),VARCHAR(50),VARCHAR(3),VARCHAR(255),BOOLEAN,INT:
                t,t,t,t,t,t,t,t,t,t,t,t:

                siteCountryCode,login,password,firstName,lastName,company,phone,email,langId,images,isDriver,userSinceDate:

                siteCountryCode,login,password,firstName,lastName,company,phone,email,langId,images,isDriver,userSinceDate"; a++;
                */









				// check that array lenghs match
                for (var g = 0; g < tables.length; g++) 
				{
					var lengthsArr = tables[g].split(':');
					var firstLength = lengthsArr[1].split(',').length;
					var allLengths = firstLength + ' ,';
					for (var h = 2; h < lengthsArr.length; h++) {
						allLengths += ' ' + lengthsArr[h].split(',').length + ',';
						if(firstLength != lengthsArr[h].split(',').length) 
						{
							alert('Error! Field amounts do not match in table ' + tables[g].split(':')[0]);
							alert(g + '. The lengths of ' + tables[g].split(':')[0] + ' is ' + allLengths);
						}
					}
					
                }

                return tables;
            }
            /*
            function getTables() {
            var tables = Array(); // [0]=db table name, [1] = db fieldnames, [2]=db field types (id,t50), [3] = controltype (d=droplist,t=textbox,r=radio)
            var a = 0;
            tables[a] = "areas:countryId,langId,areaName:i,i,t50:d,d,t"; a++;
            tables[a] = "towns:areaId,langId,townName:i,i,t50:d,d,t"; a++;
            tables[a] = "langs:langName:t50:t"; a++;
            tables[a] = "categories:langId,parentCatId,catName,catDesc,adTypeIds,orderId,active:i,i,t50,t250,i,i,i:d,d,t,t,d,d,r"; a++;
            tables[a] = "users:countryId,areaId,townId,loginName,password,email,phone:i,i,i,t50,t50,t50,t25:d,d,d,t,t,t"; a++;
            tables[a] = "ads:userId,langId,countryId,catId,title,adText,email,phone,startDateTime,endDate,imgNames,active:i,i,i,i,t50,t250,t10,t6,t250,i:d,d,d,d,t,t,d,d,t,r"; a++;
            tables[a] = "adTypes:langId,adTypeName,orderId:i,i,t50:d,d,t"; a++;

            return tables;
            }
            */
            function getTable(tableName) {
                var result = "";
                var tables = getTables();
                if (tableName == "all") {

                    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
                    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
                    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
                    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
                    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
                    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
                    // NOTE!!!!! BELOW WAS tables.length; CORRECTED!!!!

                    for (var i = 0; i < tables.length; i++) {
                        //result += '<div class="button tableButton" id="' + tables[i] + '">' + cap(tables[i]) + '</div>';
                        result += '<div class="button tableButton" id="' + tables[i].split(':')[0] + '">' + cap(tables[i].split(':')[0]) + '</div>';
                    }
                    return result;
                }
                else if (tableName != "") {
                    // return field names of a table
                    for (var i = 0; i < tables.length; i++) {
                        //if (tables[i] == tableName) { return fields[i]; }
                        if (tables[i].split(':')[0] == tableName) { return tables[i].split(':')[1]; }
                    }
                }
            }
            function getTableControlTypes(tableName) {
                var result = "";
                var tables = getTables();
                // return controltypes of a table
                for (var i = 0; i < tables.length; i++) {
                    if (tables[i].split(':')[0] == tableName) { return tables[i].split(':')[3].split(','); }
                }
            }
            function getTableControlTypes2(tableName) {
                var result = "";
                var tables = getTables();
                // return controltypes of a table
                for (var i = 0; i < tables.length; i++) {
                    if (tables[i].split(':')[0] == tableName) { return tables[i]; }
                }
            }
            
            function getTableDbTypes(tableName) {
                var result = "";
                var tables = getTables();
                // return controltypes of a table
                for (var i = 0; i < tables.length; i++) {
                    if (tables[i].split(':')[0] == tableName) { return tables[i].split(':')[2].split(','); }
                }
            }
						
            function showActionButtons() {
                $("#actionButtons").css("display", "block");
            }
            function hideActionButtons() {
                $("#actionButtons").css("display", "none");
            }

            function cap(s) {
                return s[0].toUpperCase() + s.slice(1);
            }

            function removeLastS(str) {
                if (str.slice(-1) == "s") { return str.slice(0, -1); }
                return str;
            }

            String.prototype.replaceAll = function (str1, str2, ignore) {
                return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, "\\$&"), (ignore ? "gi" : "g")), (typeof (str2) == "string") ? str2.replace(/\$/g, "$$$$") : str2);
            }

            
			function makeReadable(str) {
			    var strArray = str.split("");
			    var result = '';
				if(strArray[0] != null) { result = strArray[0].toUpperCase(); } // NEW
			    for (var i = 1; i < strArray.length; i++) {
			        if (isUpperCase(strArray[i]) === true) { result += ' '; }
			        result += strArray[i];
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
			
            function removeLastChar(str) {
                return str = str.slice(0, -1);
            }


            function includesWord(word, str) {
                if (str.toLowerCase().indexOf(word) != -1) { return true; } else { return false; }
            }
// ======================================================================================
            function createInserts(sql=true, json=false) {
                var hasGroupId = false; // set manually here
                var begin, result, comment = '';
                var resArr = [];
                var data = $("#code").val();

                var arr = linesIntoArray(data); // to array

                // move groupId to end of each item
                for (var i = 0; i < arr.length; i++) { 
                    let a = arr[i].split(',')[0];
                    let b = arr[i].split(',')[1];
                    arr[i] = b + ',' + a;
                }
                

                arr = cleanJunkArr(arr); comment += 'cleaned ';
                arr = capitalize(arr); comment += 'calitalize ';
                arr = [...new Set(arr)]; comment += 'duplicates removed ';                
                arr.sort(); comment += 'alphabetized ';

                console.log(arr); // ALTER TABLE `foodTypes` ADD `foodTypeId` INT NOT NULL AFTER `id`;

                var langId = 'fi';
                if(sql) { begin = 'INSERT INTO  ingredientNames (langId,restaurantId,name,groupId,orderId) VALUES '; }
                if(json) { begin = "XXXXXXXX: [" }                
                for (var i = 0; i < arr.length; i++) {                     
                    if(arr[i].trim() == '') continue;
                    //if(typeof arr[i] !== 'undefined') {
                        if(sql) { 
                            // hasGroupId:  2,Paprikaa
                            if(hasGroupId) {
                                //data[i] = data[i].replace(",", ' "group:" ' + ); // make groupId right
                                a = arr[i].split(',')[0];
                                b = arr[i].split(',')[1];
                                resArr.push("('" + langId + "',null,'" + a.trim() + "'," + b + ',' + i + ")");
                            } else {
                                // no groupId
                                resArr.push("('" + langId + "','" + arr[i].trim() + "'," + i + ")"); 
                            }
                        }
                        if(json) { resArr.push('{ "id": ' + i + ', "name": "' + arr[i].trim() + '" }'); }
                    //}
                }               
                if(sql)  { result = comment + '\n\n' + begin + '\n'   + resArr.join(', ') + ';'; }
                if(json) { result = comment + '\n\n' + begin + '\n\t' + resArr.join('\n\t') + '\n]'; }
                $("#code").val(result);

            }
            function linesIntoArray(data) {
                data = data.replace(/(\r\n|\n|\r)/gm, "#"); // replace newlines
                let arr = data.split("#"); // put into arr
                return arr;
            }
            function cleanJunkArr(arr) { // removes junk
                for (var i = 0; i < arr.length; i++) {
                    //arr[i] = cleanJunkStr(arr[i]);
                    arr[i] = InternationalCleanJunkStr(arr[i]);                    
                }
                return arr;    
            }            
            // works for english only! - removes accented characters and cyrillic
            /*
            function cleanJunkStr(data) { // removes junk
                return data.replace(/(?!\w|\s)./g, '')
                    .replace(/\s+/g, ' ')
                    .replace(/^(\s*)([\W\w]*)(\b\s*$)/g, '$2');               
            }*/
            
            // works for accented characters and cyrillic
            function InternationalCleanJunkStr(data) { // removes junk                               
                var accentedCharacters = "*àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";
                var regex = "^[a-zA-Z" + accentedCharacters + "]+,\\s[a-zA-Z" + accentedCharacters + "]+$";
                regexCompiled = new RegExp(regex);
                return data.replace(regexCompiled, "");
            }

            function capitalize(arr) {
                for (var i = 0; i < arr.length; i++) {
                    arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
                }
                return arr;
            }

			function createFiles() {
				var data = $("#code").val();				
				// data = data.replace('"', '\"');
				// data = data.replace("'", "\'");
				// data = data.replace(/(\t)/gm, "\t");
				// data = data.replace(/(\r\n|\n|\r)/gm, "\n");				
				data = data.replace(/(\r\n|\n|\r)/gm, ",");				

				
				$("#fileNames").val(data);

				var defaultCode = '';
				var includesFolder = "";
				defaultCode = '<?php\n\n';
                defaultCode += '\n';
                defaultCode += 'include(\'' + includesFolder + 'dataFunctions.php\');\n'; 
                defaultCode += 'include(\'' + includesFolder + 'functions.php\');\n';
                defaultCode += 'include(\'' + includesFolder + 'date.php\');\n';
                defaultCode += 'include(\'' + includesFolder + 'header.php\');\n';
                defaultCode += '$conn = getDBConnection();\n';
                defaultCode += '\n';

				$("#pageCode").val(defaultCode); 
			}

			function getNewDbShortTypes() {
				return 'TINT_128,INT,CHAR_8,VC_15,VC_20,VC_50,VC_100,VC_5K,DATE,DSTAMP';
            };
			function getNewDbLongTypes() {
				return 'TINYINT UNSIGNED,INT,CHAR(8),VARCHAR(15),VARCHAR(20),VARCHAR(50),VARCHAR(100),VARCHAR(5000),DATETIME,TIMESTAMP';
            };		


			/* ============================== END OF JS CODE ============================ */
        });
    </script>
</head>
<body>

<div id="content">

    <div id="tables">Error</div>
    <div id="clear" class="button clear">Clear</div>
    <div id="createSqlInserts" class="button clear half">SQL insert</div>
    <div id="createJsonInserts" class="button clear half">json file</div>
    
	<div id="createFiles" class="button clear">Create files</div>
	&nbsp; To create files: list filenames in separate rows, click &quot;Create files&quot;,<br> add code to screen, click Save.
    <!-- <div id="cleanCode" class="button clear">Clean</div> -->
    <br />

    <div id="title"></div>

    
    <div id="actionButtons">
        <div id="getAll" class="button action">Get all</div>&nbsp;
        <div id="getSingle" class="button action">Get single</div>&nbsp;
        <div id="validate" class="button action">Validate</div>&nbsp;
        <div id="saveUpdate" class="button action">New-Edit-Update</div>&nbsp;
        <div id="delete" class="button action">Delete</div>&nbsp;
        <div id="sql" class="button action">SQL</div>&nbsp
        <div id="html" class="button action">HTML</div>&nbsp;
        <div id="vue" class="button action">VUE</div>&nbsp;
    </div>
    <br /><br />





	<form action="scriptGenerator.php" method="post">
	<input type="input" id="pageCode" value="empty" name="pageCode">&nbsp; <!-- hidden -->
	Save in file: 
	<input type="input" id="filePath" class="smallInput" value="GENERATED" name="filePath" placeholder="subfolder">/
	<input type="input" id="pageName" class="smallInput" value="" name="pageName">.php&nbsp;

	<!-- fileNames -->
	&nbsp;<input type="input" id="fileNames" value="" name="fileNames">&nbsp; <!-- hidden -->

	<input id="sButton" type="submit" class="button action" value="Save">
	</form><br />
		
	<?php
	$includesFolder = '../includes/';	
	$defaultPageData = $defaultPageData1 = $defaultPageData2 = '';
    $t1 = "\t";
    $t2 = "\t\t";
    $t3 = "\t\t\t";    
    $t4 = "\t\t\t";   
    $t5 = "\t\t\t\t";
    /*
	$defaultPageData .= '<?php£';
	$defaultPageData .= 'require_once(\'' . $includesFolder . 'session.php\');£';
	$defaultPageData .= 'include(\'' . $includesFolder . 'dataFunctions.php\');£'; 
	$defaultPageData .= 'include(\'' . $includesFolder . 'validationFunctions.php\');£'; 
	$defaultPageData .= 'include(\'' . $includesFolder . 'functions.php\');£';
	$defaultPageData .= 'include(\'' . $includesFolder . 'header.php\');£';
	$defaultPageData .= '$conn = getDBConnection();£';
	$defaultPageData .= '£// ';
    */

    // empty vue template
    $defaultPageData .= '<template>£';
    $defaultPageData .= $t1 . '<div>£';
    $defaultPageData .=     $t2 . '<div class="container is-fluid">£';
    $defaultPageData .=             $t3 . '<section class="section">£';
    $defaultPageData .=                 $t4 . '<div class="container has-text-centered">£££';
    
    $defaultPageData .=                     $t5 . '<h1>';
    $defaultPageData1 .=                            '</h1>£';
    
    $defaultPageData1 .=                 $t4 . '</div>£';
    $defaultPageData1 .=             $t3 . '</section>£';
    $defaultPageData1 .=     $t2 . '</div>£';
    $defaultPageData1 .= $t1 . '</div>£';
    $defaultPageData1 .= '</template>££';

    $defaultPageData1 .= '<script>£';
    $defaultPageData1 .= 'import { mapGetters, mapActions } from "vuex"£';
    $defaultPageData1 .= 'export default {£';
    $defaultPageData1 .= $t1 . 'name: \'';

    $defaultPageData2 .= '\',£';
    $defaultPageData2 .= $t1 . 'data () {£';
    $defaultPageData2 .=    $t2 . 'return {££';

    $defaultPageData2 .=    $t2 . '}£';
    $defaultPageData2 .= $t1 . '},£';

    $defaultPageData2 .= $t1 . 'methods: {£';
    $defaultPageData2 .=    $t2 . 'xxxxxx: function() {£';
    $defaultPageData2 .=    $t2 . '// console.log(\'xxxxxx\');£';
    $defaultPageData2 .=    $t2 . '},£';
    //$defaultPageData2 .= $t1 . '},£';
    $defaultPageData2 .= $t2 . '...mapActions(["saveXxxxxx"]),£';
    $defaultPageData2 .= $t2 . '// calculates number of characters left, returns array: [is limit exceeded, characters left / max]£';
    $defaultPageData2 .= $t2 . 'charsLeft(maxLen, str) {£';
    $defaultPageData2 .=    $t3 . 'return [ str.length > maxLen ? true : false,£';
    $defaultPageData2 .=        $t4 . 'maxLen - str.length + " / " + maxLen ];£';
    $defaultPageData2 .= $t2 . '},£';
    $defaultPageData2 .= $t2 . 'forwardToNextPage() {£';
    $defaultPageData2 .=    $t3 . '// this.$router.replace({name: \'xxxxxxx\'});£';
    $defaultPageData2 .= $t2 . '}£';
    $defaultPageData2 .= $t1 . '},£';
    $defaultPageData2 .= $t1 . 'watch: {£';
    $defaultPageData2 .= $t2 . 'xxxxx: function() {££';

    $defaultPageData2 .= $t2 . '}£';
    $defaultPageData2 .= $t1 . '},£';
    $defaultPageData2 .= $t1 . 'computed: mapGetters(["xxxx"])£';
    
    $defaultPageData2 .= '}£';
    $defaultPageData2 .= '</script>££';

    $defaultPageData2 .= '<style scoped>£';

    $defaultPageData2 .= '</style>£';


	// WRITE INTO FILE
	if (isset($_POST['pageCode']))
	{
			$fileNames = $_POST['fileNames'];
			$filePath = $_POST['filePath'];
			$pageCode = $_POST['pageCode']; 				
			$fileName = $_POST['pageName'] . '.php';
			if($fileNames == '')
			{
				if($_POST['pageName'] != '')				{
					echo 'generating single file with code';									
					// remove .php in end if exists
					//if(strtolower(substr($fileName, -4)) == '.php') 
					//{ 
					//	$fileName = 'xcxcx_' . $fileName; // substr($fileName, 0, strlen($fileName)); 
					//}
					// $date = '<!-- FILE AUTO CREATED: ' . displayDate(getCurrentDateAsYYMMDDHHMM()) . ' -->\n';
					
					
					$pageCode = str_replace('£', PHP_EOL, $pageCode);	

					// ---- add newlines for file write----	
					if(!file_exists($fileName))
					{
						$fp = fopen($filePath . '/' . $fileName, 'w');
						fwrite($fp, $pageCode);		
						fclose($fp);
						echo "<br>Successfully generated file " . $fileName . "<br>";
					} else { echo '<br><b>Error: File already exists.</b> Creation cancelled.'; return; }
				} else { echo 'Error 3: To create files you must click &quot;Create files&quot; -button first. Action cancelled.'; return; }
			}
			else
			{
				echo 'saving empty files only';
				$fileNamesArr = explode(",", $fileNames);

				$defaultPageData = str_replace('£', PHP_EOL, $defaultPageData);	
                $defaultPageData1 = str_replace('£', PHP_EOL, $defaultPageData1);
                $defaultPageData2 = str_replace('£', PHP_EOL, $defaultPageData2);
				echo '<br>defaultPageData: ' . $defaultPageData;
                $writePageData = '';
				for ($x = 0; $x < count($fileNamesArr); $x++) 
				{
					$fileName = ucfirst($fileNamesArr[$x]);
                    $writePageData = $defaultPageData . ucfirst($fileName) . $defaultPageData1 . $fileName . $defaultPageData2;

					// create folder if dont exist
					$newFolder = explode("/", $fileName)[0];
					//echo '<br>New folder is: ' . $newFolder;
					//if($newFolder.length > 1) // -------- enable to create files in root ------
        // 25.1.2020
					//{
			//			if(!folder_exist(getcwd() . '/' . $filePath . '/' . $newFolder)) {  
							//echo "<br>Current PATH: <b>" . getcwd();
			//				mkdir(getcwd() . '/' . $filePath . '/' . $newFolder, 0777);
							//echo "<br>Created folder: <b>" . getcwd() . '/' . $filePath . '/' . $newFolder . "</b>";
			//			}
					//}
			//		if(!file_exists($fileName))
			//		{
						$fp = fopen($filePath . '/' . $fileName . '.vue', 'w');
						fwrite($fp, $writePageData);		
						echo "<br>Generated file: " . $fileName . "";
			//		} else { echo '<br><b>SKIPPED File that already exists: ' . $fileName . '</b>'; }
				}

                        // ------------------------ ROUTES --------------------------
                        $routeData = '';                        
                        $routeData .=  'import Vue from \'vue\''. '£';
                        $routeData .=  'import VueRouter from \'vue-router\''. '£';

                        for ($x = 0; $x < count($fileNamesArr); $x++) {
                            $routeData .=  'import ' .  ucfirst($fileNamesArr[$x]) . ' from \'@/components/' .  ucfirst($fileNamesArr[$x]) . '\''. '£';
                        }
                        $routeData .= '£';
                        $routeData .=  'Vue.use(VueRouter)'. '££';
                        $routeData .=  'let router = new VueRouter({'. '££';

                        $routeData .= '// NOTE: REMOVE UNNEEDED ONES!'. '£';
                        $routeData .= 'routes: ['. '£';
                        for ($x = 0; $x < count($fileNamesArr); $x++) 
                        {
                            $routeData .= "\t".'{'. '£';
                            // path: '/login',
                            $routeData .= "\t\t" . 'path: \'/' . $fileNamesArr[$x] .'\',' . '£';
                            // name: 'login',
                            $routeData .= "\t\t" . 'name: \'' . $fileNamesArr[$x] . '\',' . '£';
                            // component: Login
                            $routeData .= "\t\t" . 'component: ' . ucfirst($fileNamesArr[$x]) . '£';
                            $routeData .= "\t".'},'. '£';
                        }
                        $routeData .= ']'. '£';
                        $routeData .=  '});'; // let router

                        // save file 
                        $routeData = str_replace('£', PHP_EOL, $routeData);   
                        $fp = fopen($filePath . '/' . 'index.js', 'w');
                        fwrite($fp, $routeData);                        
                        echo "<br>Generated file: index.js";


                        // ------------------------ App.vue links --------------------------
                        // links App.vue
                        // create vue route links -file
                        $linksData = '';
                        for ($x = 0; $x < count($fileNamesArr); $x++) 
                        {
                            //  <router-link class="navbar-item" to="/booking">My bookings</router-link>
                            $linksData .= "<router-link class=\"navbar-item\" to=\"/" . $fileNamesArr[$x] . '\">' . ucfirst($fileNamesArr[$x]) . '</router-link>' . '£';
                        }
                        $linksData = str_replace('£', PHP_EOL, $linksData);   
                        $fp = fopen($filePath . '/' . 'App.vue', 'w');
                        fwrite($fp, $linksData);                        
                        echo "<br>Generated file: App.vue";
                
                fclose($fp);
			}
			
	}

	function folder_exist($folder)
	{
	    // Get canonicalized absolute pathname
	    $path = realpath($folder);	
	    // If it exist, check if it's a directory
	    if($path !== false AND is_dir($path))
	    {
	        // Return canonicalized absolute pathname
	        return $path;
	    }	
	    // Path/folder does not exist
	    return false;
	}


	?>

    <!-- <input type="text" id="code" class="textarea" onClick="this.select();" />-->
    <textarea id="code" class="textarea"></textarea> <!-- onClick="this.select();" -->
</div>
<br>JavaScript:<br>
<textarea id="code2" class="textarea"></textarea>

</body>
</html>


