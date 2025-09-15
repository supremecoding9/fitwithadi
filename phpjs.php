<script>



	$(function()	{
	 $("#activity").change(function() {
	 	if (this.value != '')	{

			
 			window.location.href='select_date.php?a='+this.value;
		}
	 });
   });
//////////////////////////////////////////////////////////// 
 var curDate = '';
 $(document).ready(function() {
	 
	 $('#datepicker').datepicker({
		 beforeShowDay: function(date) {
			 var dateString = $.datepicker.formatDate('mm/dd/yy', date);
			 if ($.inArray(dateString, highlightedDates) != -1) {
				 return [true, 'highlighted', 'This date is highlighted'];
			 }
			 return [true, '', ''];
		 },
		 onSelect: function(dateText, inst) {

			 curDate = dateText;
			 document.getElementById('formdate').value = dateText;
			 $.ajax({
				  type : "POST",
				  url : 'times.php', //URL to the delete php script
				  data : {dateinfo: dateText},
				  success : function(data) {
					  document.getElementById('validtimes').innerHTML = '';
					  var fullResults = JSON.parse(data);
					  var results = fullResults;
					  console.log(results);

					  $.each(results, function(index, activity)	{
						console.log("Activity " + (index + 1) + " time: " + activity.activity_time);
						const para9 = document.createElement("article");
						para9.id = 'time'+activity.id;
						
						if (activity.exists == 1)	{
							para9.className = 'timesExists';
						}else if (activity.slots == 0)	{
							para9.className = 'noRoom';
						}else{
							para9.className = 'times';
							para9.onclick = function() { confirmTime(activity.id, activity.activity_time); };
						}
						para9.innerHTML = activity.activity_time;
						
						document.getElementById('validtimes').appendChild(para9);	  
						
					 });
					 document.getElementById('legend').style.display = 'block';
					 
				  }
			  });
			 
			 
			 
			 
			 
 
		 }
	 });
 });
 
////////////////////////////////////////////////////////////
function confirmTime(elem, ct)	{
	 	if (confirm('Confirm you want to book '+ curDate + ' at ' + ct + '?')) {
			 document.getElementById('schedid').value = elem;
			  document.getElementById('formtime').value = ct;
			  document.getElementById('slotform').submit();
			  
		}
}

////////////////////////////////////////////////////////////
$(function()	{
	$(".cancelAppointment").click(function() {
		var curtimeslot = this.parentNode;
		if (confirm('Do you want to cancel this appointment/session?'))	{
			curtimeslot.submit();
		}
	});
});



////////////////////////////////////////////////////////////
$(document).ready(function() {
	$("#docsignform").validate({});



});
////////////////////////////////////////////////////////////

$(function()	{
	$(".schedulDel").click(function() {
		if (confirm('Are you sure you want to delete this schedule entry?'))	{
			var cursch = this.dataset.sched;
			$.ajax({
			 	type : "POST",
			 	url : 'delsch.php',
			 	data : {schid:cursch},
			 	success : function(data) {
					 console.log(data);
					$("#row"+cursch).hide();
			 	}
		 	});
		}
	});
});
////////////////////////////////////////////////////////////

$(function()	{
	$(".actDel").click(function() {
		if (confirm('Are you sure you want to delete this Activity?'))	{
			var curact = this.dataset.act;
			$.ajax({
				 type : "POST",
				 url : 'delact.php',
				 data : {actid:curact},
				 success : function(data) {
					 console.log(data);
					$("#row"+curact).hide();
				 }
			 });
		}
	});
});


////////////////////////////////////////////////////////////

$(function()	{
	$(".appDel").click(function() {
		if (confirm('Are you sure you want to delete this Appointment?'))	{
			var cancelid = this.dataset.cancelid;
			$.ajax({
				 type : "GET",
				 url : 'cancel.php?admin=1&cancel='+cancelid,
				 success : function(data) {
					 console.log(data);
					$("#row"+cancelid).hide();
				 }
			 });
		}
	});
});
////////////////////////////
$(function()	{
	$("#adminnav").change(function() {
		window.location.href=this.value;
		
		
	});
});

////////////////////////////////////////////
var creditArray = new Array();
$(function()	{
	$("#creditUser").change(function() {
		
		if ($("#creditActivity").val() != '')	{
			var curUser = $("#creditUser").val();
			var curAct = $("#creditActivity").val();
			if (typeof creditArray[curUser][curAct] !== 'undefined')	{
				$("#creditValue").val(creditArray[curUser][curAct]);
			}else{
				$("#creditValue").val(0);
			}
		}else{	
			$("#creditValue").val(0);
		}
	});
});



$(function()	{
	$("#creditActivity").change(function() {
		
		if ($("#creditUser").val() != '')	{
			var curUser = $("#creditUser").val();
			var curAct = $("#creditActivity").val();
			if (typeof creditArray[curUser][curAct] !== 'undefined')	{
				$("#creditValue").val(creditArray[curUser][curAct]);
			}else{
				$("#creditValue").val(0);
			}
		}else{	
			$("#creditValue").val(0);
		}
	});
});



$(function()	{
	$("#saveCredits").click(function() {
		if (($("#creditUser").val() != '') && ($("#creditActivity").val() != '') && ($("#creditValue").val() != ''))	{
			var curUser = $("#creditUser").val();
			var curAct = $("#creditActivity").val();
			creditArray[curUser][curAct] = $("#creditValue").val();
			$.ajax({
				 type : "POST",
				 url : 'admin_credit.php',
				 data : {user:curUser, act:curAct, amt:creditArray[curUser][curAct]},
				 success : function(data) {
					 //console.log(data);
					 if (document.getElementById('cr-'+curUser+'-'+curAct))	{
						 document.getElementById('cr-'+curUser+'-'+curAct).innerHTML = creditArray[curUser][curAct];
						 document.getElementById('holder-'+curUser+'-'+curAct).style.display = 'block';
						 document.getElementById('creditsUpdated').style.display = 'block';
						 
					}
				 }
			 });
			
		}else{
			alert('You must select a user, activity, and enter a credit value before updating credits.');
		}
	});
});



$(function()	{
	$("#creditValue").focus(function() {
		document.getElementById('creditsUpdated').style.display = 'none';
	});
});




////////////////////////////////////////////////////////////

$(function()	{
	$(".userDel").click(function() {
		if (confirm('Are you sure you want to delete this user? Keep in mind that any open appointments and unused credits for this user will also be deleted?'))	{
			var userid = this.dataset.userid;
			$.ajax({
				 type : "POST",
				 url : 'deluser.php',
				 data : {delid:userid},
				 success : function(data) {
					 console.log(data);
					$("#row"+userid).hide();
				 }
			 });
		}
	});
});
















</script>


<?php
#require("phpjs_admin.php");