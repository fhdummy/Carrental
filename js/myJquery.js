/* Reagiert auf den Button-Klick und sendet die Eingaben an den Server */
$("#form1").submit(function() {
	$.ajax({                                      
	  url: 'api.php', data: "", dataType: 'json',  success: function()
	  {
		/*for (var i in rows)
		{
		  var row = rows[i];          

		  var id = row[0];
		  var vname = row[1];
		  $('body').append("<b>id: </b>"+id+"<b> name: </b>"+vname)
					  .append("<hr />");
		} */
		alert("okay");
	  },
	  error: function()
	  {
		  alert("fail");
	  }
	});
});
