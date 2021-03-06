<SCRIPT language="javascript">
</SCRIPT>
<!--link rel="stylesheet" type="text/css" href=""-->


<h1>Rock-Scissors-Paper	<!--span>Por favor complete todos los datos.</span-->
</h1>

<form action="upload" method="post" enctype="multipart/form-data" >
    Select File To Upload:<br />
    <input type="file" name="userfile"  />
    <br /><br />
    <input type="submit" name="submit" value="Upload championship" class="btn btn-success" />
</form>


<form id="export" name="export" method="post" action="download">
    <INPUT type="submit" value="Download championship example"/>
</form>

Top 10
<ul>

<li><?php echo $players;?></li>
</ul>

<form id="reset" name="reset" method="post" action="reset">
    <INPUT type="submit" value="Reset"/>
</form>

<b>Source code (GitHub)</b><br />
<a href="https://github.com/leop21/rock_paper_scissors">https://github.com/leop21/rock_paper_scissors</a>
<br /><br />
<b>REST API</b>
<form id="rest" name="rest" method="post" action="rest">
    <INPUT type="submit" value="Ir"/>
</form>
<b>Leonardo Pandolfi Gonz&aacute;lez</b><br />
Was an insect researcher at kindergarten, an artist at school, and a sports journalist at high school; has a little bit of each three. Graduated as a computer engineer in his beloved UCR and currently enroled in a GIS and Remote-Sensing master program. His life carries on between books, columns, movies, football and music.
<br /><br />
<b>Solution</b><br />
A MVC approach (Model-View-Controller) was implemented using the PHP framework CodeIgniter. 
<br />
<b>Model:</b> There's only one table created in the database 'rps' and its name is 'ranking'; it has two columns, one is used to store the player's name and the other one to store the total points of that player. The model named 'Ranking_model' (ranking_model.php) represents the only table stored in the database and provides functions to select, insert, delete and upload rows. 
<br />
<b>Controller</b>: Regarding controllers, there's only one too: Championship; it contains a lot of functions in order to meet the requirements, like obtaining a top 10 list of players or registering new tournaments. It's based on the Rest_Controller class; since CodeIgniter is RPC-oriented, the REST API was implemented using code from CodeIgniter Rest Server project. 
<br />
<b>View</b>: This controller's functionality is available through the view 'main.php' (you're currently seeing it), which provides a some options and aditional information. Moreover, two directories were created: one to keep files available for download and another one to store the ones the users have uploaded. A helper (download_helper.php) was also used to provide download operations.
<br /><br />
<b>Technologies Used</b><br />
<ul>
<li>LAMP stack: It allows the developer to create something quickly and save time to meet a deadline, since you can easily code, build an app locally and then deploy it on a public web server.</li>
	<ul>
	<li>Linux</li>
	<li>Apache HTTP Server</li>
	<li>MySQL</li>
	<li>PHP</li>
	</ul>
<li>CodeIgniter Rest Server: It was needed to create the Rest API with CodeIgniter.</li>
</ul>


