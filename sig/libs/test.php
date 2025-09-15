




<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<!-- you load jquery somewhere before jSignature ... -->
<script src="jSignature.min.js"></script>
<script>
	$(document).ready(function() {
		$("#signature").jSignature()
	})
</script>
<script>
function aaa()	{
	var datapair = $('#signature').jSignature('getData', 'image'); 
	var i = new Image();
	i.src = "data:" + datapair[0] + "," + datapair[1] ;
	$(i).appendTo($("#someelement")); // append the image (SVG) to DOM.
	
	$("#sig").val(i.src);
	
}
</script>




<div id="signature"></div>
<button type=button onclick="$('#signature').jSignature('reset');">Clear</button>


<button type=button onclick="aaa();">SVG</button>


<form action="sigsave.php" method=post>
<input type="hidden" value="" id="sig" name="sig">

<input type=submit value=submit>
</form>

<div id="someelement"></div>