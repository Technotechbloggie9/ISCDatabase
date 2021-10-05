/*
ISC DB javascript for database interactions
For now, it just finds an html table tag with TablePrint as ID
And replaces the html with a text tag labeled TableData as ID
*/

//JQuery loads in compatibility, one must used JQuery()
//Inside this function the $ notation can start to be used for DOM
//Document.Ready is used for when the page is finished loading
jQuery(document).ready(function( $ ) {
			
	$("#TablePrint").html($("TableData").html());
	

});//end of doc.ready function
