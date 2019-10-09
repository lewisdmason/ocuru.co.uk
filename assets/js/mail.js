$( "#consultation" ).submit(function( event ) {
  	event.preventDefault();

  	var data = $('#consultation').serializeArray().reduce(function(obj, item) {
	    obj[item.name] = item.value;
	    return obj;
	}, {});

  	const params = new URLSearchParams();
  	params.append('consultation', true);
	params.append('request_email', data.request_email);
	axios.post('/send.php', params)
	  .then(function (response) {
	    if(response.data.error)
	    {
	    	$('.bd-example-modal-sm').modal('show');
	    }
	  })
	  .catch(function (error) {
	    	$('.bd-example-modal-sm').modal('show');
	  });
});

$( "#contact-form" ).submit(function( event ) {
  	event.preventDefault();

  	var data = $('#contact-form').serializeArray().reduce(function(obj, item) {
	    obj[item.name] = item.value;
	    return obj;
	}, {});

  	const params = new URLSearchParams();
	params.append('request_email', data.request_email);
	params.append('name', data.name);
	params.append('message', data.message);
	axios.post('/send.php', params)
	  .then(function (response) {
	    if(response.data.error)
	    {
	    	$('.bd-example-modal-sm').modal('show');
	    }
	  })
	  .catch(function (error) {
	    	$('.bd-example-modal-sm').modal('show');
	  });
});