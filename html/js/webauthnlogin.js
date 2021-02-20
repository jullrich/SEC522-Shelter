$(function(){
    /* activate the key and get the response */
    $.ajax({url: 'api/u2fgetuser.php',
	    success: function(j) {
		webauthnAuthenticate(j.challenge, function(success, info){
		    if (success) {
			$.ajax({url: 'api/u2flogin.php',
				method: 'POST',
				data: {login: info},
				dataType: 'json',
				success: function(j){
				    document.location='myaccount.php';			
				    setTimeout(function(){ $('.cdone').hide(300); }, 2000);
				},
				error: function(xhr, status, error){
				    alert("login failed: "+error+": "+xhr.responseText);
				}
			       });
		    } else {
			$('.cerror').text(info).show();
		    }
		});
	    },
	    error: function(xhr, status, error) {
		alert("login failed: "+error+": "+xhr.resposneText);
	    }
	   });
})

function webauthnAuthenticate(key, cb){
    var pk = JSON.parse(key);
    var originalChallenge = pk.challenge;
    pk.challenge = new Uint8Array(pk.challenge);
    pk.allowCredentials.forEach(function(k, idx){
	pk.allowCredentials[idx].id = new Uint8Array(k.id);
    });
    /* ask the browser to prompt the user */
    navigator.credentials.get({publicKey: pk})
	.then(function(aAssertion) {
	    // console.log("Credentials.Get response: ", aAssertion);
	    var ida = [];
	    (new Uint8Array(aAssertion.rawId)).forEach(function(v){ ida.push(v); });
	    var cd = JSON.parse(String.fromCharCode.apply(null,
							  new Uint8Array(aAssertion.response.clientDataJSON)));
	    var cda = [];
	    (new Uint8Array(aAssertion.response.clientDataJSON)).forEach(function(v){ cda.push(v); });
	    var ad = [];
	    (new Uint8Array(aAssertion.response.authenticatorData)).forEach(function(v){ ad.push(v); });
	    var sig = [];
	    (new Uint8Array(aAssertion.response.signature)).forEach(function(v){ sig.push(v); });
	    var info = {
		type: aAssertion.type,
		originalChallenge: originalChallenge,
		rawId: ida,
		response: {
		    authenticatorData: ad,
		    clientData: cd,
		    clientDataJSONarray: cda,
		    signature: sig
		}
	    };
	    cb(true, JSON.stringify(info));
	})
	.catch(function (aErr) {
	    if (("name" in aErr) && (aErr.name == "AbortError" || aErr.name == "NS_ERROR_ABORT" ||
				     aErr.name == "NotAllowedError")) {
		cb(false, 'abort');
	    } else {
		cb(false, aErr.toString());
	    }
	});
}
