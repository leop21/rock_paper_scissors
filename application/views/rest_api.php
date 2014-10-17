<SCRIPT language="javascript">
</SCRIPT>
<!--link rel="stylesheet" type="text/css" href=""-->
<form id="rest" name="rest" method="" action="">

<h1>REST API	<!--span>Por favor complete todos los datos.</span-->
</h1>
<b>POST api/championship/result</b></br>
Stores the first and second place of a tournament, each user is stored with their respective scores. The user names will be unique, but the same user can win 1 or more championships. Returns the operation status if successfully.</br>
Resource information:</br>
Resource URL: /api/championship/result</br>
HTTP Method: POST</br>
Response format: JSON</br>
Parameters:</br>
first</br>
required</br>
The name of the winner of the championship.</br>
Example: Dave</br>
second</br>
required</br>
The name of the second place of the championship.</br>
Example: Armando</br>
Example Request</br>
POST</br>
http://geocr.ccp.ucr.ac.cr/rps/index.php/api/championship/result</br>
POST Data</br>
first=Dave&second=Armando</br>
Example Output</br>
{</br>
status: 'success'</br>
}</br>
</br>
<b>GET api/championship/top</b></br>
Retrieves the top players of all championships. Returns the list of player names based on the count provided.</br>
Resource information:</br>
Resource URL: /api/championship/top</br>
HTTP Method: POST</br>
Response format: JSON</br>
Parameters:</br>
count</br>
optional</br>
Sets the count of records to be retrieved. If not provided, the default value is 10.</br>
Example: 123</br>
Example Request</br>
GET</br>
http://geocr.ccp.ucr.ac.cr/rps/index.php/api/championship/top?count=10</br>
Example Output</br>
{</br>
players: ["Dave", "Armando", "Robert"]</br>
}
</br>
</br>
<b>POST api/championship/new</b></br>
Receives the championship data and computes it to identify the winner. The first and second place are stored into a database with their respective scores. Returns the winner of the championship.</br>
Resource information:</br>
Resource URL: /api/championship/new</br>
HTTP Method: POST</br>
Response format: JSON</br>
Parameters:</br>
data</br>
mandatory</br>
The data of the championship following the bracketed array standard.</br>
Example:</br>
[["Armando", "P"],["Dave", "S"]]</br>
Example Request</br>
POST</br>
http://geocr.ccp.ucr.ac.cr/rps/index.php/api/championship/new</br>
POST Data</br>
data=[["Armando", "P"],["Dave", "S"]]</br>
Example Output</br>
{</br>
winner: ["Dave", "S"]</br>
}
</form>
