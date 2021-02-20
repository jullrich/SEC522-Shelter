let params = new URLSearchParams(document.location.search.substring(1));
let mode = params.get("mode");
let qs = params.get("qs");



$(document).ready(function() {
    $('#login').click(
	function() {
	    var data={};
	    data['username']=$("#username").val();
	    data['password']=$('#password').val();
	    $.post("api/login.php",data,function(data) {
	    })
		.done(function(role) {
	            if ( role=='admin'||role=='cat') {
			if ( mode==='oauth' ) {
			    document.location=decodeURI('oauth/authorize.php?'+qs);
			} else {
			    document.location='u2f.php';
			}
		    }
		})
	});
});
