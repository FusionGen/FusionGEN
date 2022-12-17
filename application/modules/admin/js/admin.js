/* -------------
	Updater
------------- */

var AutoUpdater = {
	checkUpdates: function(autoUpdate) {
		$.post(Config.URL + "admin/updater/check_ajax_updates", { csrf_token_name: Config.CSRF, auto_update: autoUpdate }, function(response) {			
			try {
				var data = JSON.parse(response);
				if(typeof data["updateAvailable"] == "boolean") {
					if(data["updateAvailable"]) {
						$(".fusion-update").html('<a href="'+ Config.URL +'admin/updater" class="mb-1 mt-1 me-1 btn btn-sm btn-danger">Update available!</a>');
						
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 10000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})

						Toast.fire({
							title: 'A new Update is available!'
						})
					} else {
						$(".fusion-update").html('<a href="'+ Config.URL +'admin/updater" class="mb-1 mt-1 me-1 btn btn-sm btn-success">Latest version</a>');
					}
				}
			} catch(e) {
				/*if(autoUpdate) {
					Swal.fire(response);
					$(".fusion-update").html('<a href="'+ Config.URL +'admin/updater" class="mb-1 mt-1 me-1 btn btn-sm btn-success">Latest version</a>');
					return;
				} else {*/
					console.log(e);
				//}
			}
		});
	}
}

var checkSoap = {
	check: function() {
		$.get(Config.URL + "admin/checkSoap", function(data) {		
			try {
				if(data.includes("Something")) {
					$(".soapcheck").html('<div class="alert alert-danger alert-dismissible fade show text-center" role="alert"><a href="'+ Config.URL +'admin/checkSoap" class="alert-link"><strong>Oh no!</strong> Looks like a realm has a soap problem!</a></div>');
				}
			} catch(e) {
				console.log(e);
			}
		});
	}
}