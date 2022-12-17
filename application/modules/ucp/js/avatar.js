function ui_add_log(message, color)
{
  var d = new Date();

  var dateString = (('0' + d.getHours())).slice(-2) + ':' +
    (('0' + d.getMinutes())).slice(-2) + ':' +
    (('0' + d.getSeconds())).slice(-2);

  color = (typeof color === 'undefined' ? 'muted' : color);

  var template = $('#debug-template').text();
  template = template.replace('%%date%%', dateString);
  template = template.replace('%%message%%', message);
  template = template.replace('%%color%%', color);
  
  $('#debug').find('li.empty').fadeOut(); // remove the 'no messages yet'
  $('#debug').prepend(template);
}

function ui_single_update_active(element, active)
{
  element.find('div.progress').toggleClass('d-none', !active);
  element.find('input[type="text"]').toggleClass('d-none', active);

  element.find('input[type="file"]').prop('disabled', active);
  element.find('.btn').toggleClass('disabled', active);

  element.find('.btn i').toggleClass('fa-circle-o-notch fa-spin', active);
  element.find('.btn i').toggleClass('fa-folder-o', !active);
}

function ui_single_update_progress(element, percent, active)
{
  active = (typeof active === 'undefined' ? true : active);

  var bar = element.find('div.progress-bar');

  bar.width(percent + '%').attr('aria-valuenow', percent);
  bar.toggleClass('progress-bar-striped progress-bar-animated', active);

  if (percent === 0){
    bar.html('');
  } else {
    bar.html(percent + '%');
  }
}

function ui_single_update_status(element, message, color)
{
  color = (typeof color === 'undefined' ? 'muted' : color);

  element.find('small.status').prop('class','status text-' + color).html(message);
}

var Avatar = {
remove: function()
	{
		Swal.fire({
			title: "Are you sure you want to delete your avatar?",
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post(Config.URL + 'ucp/avatar/remove', {csrf_token_name: Config.CSRF}, function(data)
				{
					if(data == '1')
					{
						Swal.fire('Saved!', '', 'success')
						window.location.reload(true);
					}
					else
					{
						Swal.fire('Something went wrong!')
					}
				});
			}
		});
	}
}