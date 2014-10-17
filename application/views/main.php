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

<form id="salida" name="salida" method="post" action="reset">
    <INPUT type="submit" value="Reset"/>
</form>
