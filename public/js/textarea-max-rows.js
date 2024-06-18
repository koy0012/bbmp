$(document).ready(function () {
	$('textarea[data-limit-rows=true]').on('keypress', function (event) {
	  var textarea = $(this),
		  numberOfLines = (textarea.val().match(/\n/g) || []).length + 1,
		  maxRows = parseInt(textarea.attr('rows')),
		  maxCols = parseInt(textarea.attr('cols'));
	  
	  if (event.which === 13 && numberOfLines === maxRows ) {
		return false;
	  } 

	  let content = $(this).val(); 
	  let content_arr = content.split('\n'); 
	  for(var i = 0; i< content_arr.length; i++){  
		if(content_arr[i].length > maxCols) { 
			if(content_arr[i].length > maxCols) {
				content_arr[i] = content_arr[i].substring(0,maxCols);  
				continue;
			};
		} 
	  } 

	  $(this).val(content_arr.join('\n'));
	});

	$('textarea[data-limit-rows=true]').on('paste', (e) => {
		
		console.log($(e.target).attr('rows')); 
 
	});

	$('textarea[data-limit-rows=true]').on('keydown', (e) => {
		// let text = e.originalEvent.clipboardData.getData('Text');
		let content = $(e.target).val();
		let ray = content.split('\n');
		ray = ray.splice(0,2);
		let data = ray.join('\n');

		$(e.target).val(data);
	});
  });