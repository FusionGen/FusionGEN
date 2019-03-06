/**
 * @package FusionCMS
 * @version 6.X
 * @author Jesper Lindström
 * @author Xavier Geernick
 * @link http://fusion-hub.com
 */

function UI()
{
	/**
	 * Initializing actions
	 */
	this.initialize = function()
	{
		// Is the image slider enabled?
		if($("#slider").length > 0)
		{
			UI.slider();
		}

		// Is the vote reminder enabled?
		if(Config.voteReminder)
		{
			UI.voteReminder();
		}

		// Give older browsers some html5-placeholder love!
		$('input[placeholder], textarea[placeholder]').placeholder();
		
		// Initialize dropdown panels
		UI.dropdown.initialize();

		// Enable tooltip
		Tooltip.initialize();
	}

	/**
	 * Display the vote reminder popup
	 */
	this.voteReminder = function()
	{
		// Show box
		$("#popup_bg").fadeTo(200, 0.5);
		$("#vote_reminder").fadeTo(200, 1);

		// Assign hide-function to background
		$("#popup_bg").bind('click', function()
		{
			UI.hidePopup();
		});
	}

	/**
	 * Initialize the image slider
	 */
	this.slider = function()
	{
		var config = {
			autoplay: true,
			controls: true,
			captions: true,
			delay: Config.Slider.interval
		};

		if(Config.Slider.effect.length > 0)
		{
			config.transitions = new Array(Config.Slider.effect);
		}

		window.myFlux = new flux.slider('#slider', config);
	}

	/**
	 * Shows an alert box
	 * @param String message
	 */
	this.alert = function(question, time)
	{		
		// Put question and button text
		$("#alert_message").html(question);

		// Show box
		$("#popup_bg").fadeTo(200, 0.5);
		$("#alert").fadeTo(200, 1);

		if(typeof time == "undefined")
		{
			$("#alert_message").css({marginBottom:"10px"});
			$(".popup_links").show();

			// Assign click event
			$("#alert_button").bind('click', function()
			{
				UI.hidePopup();	
			});
		}
		else
		{
			$("#alert_message").css({marginBottom:"0px"});
			$(".popup_links").hide();

			setTimeout(function()
			{
				UI.hidePopup();
			}, time);
		}

		// Assign hide-function to background
		$("#popup_bg").bind('click', function()
		{
			UI.hidePopup();
		});

		// Assign key events
		$(document).keypress(function(event)
		{
			// If "enter"
			if(event.which == 13)
			{
				UI.hidePopup();
			}
		});
	}

	/**
	 * Shows a confirm box
	 * @param String question
	 * @param String button
	 * @param Function callback
	 * @param Int width
	 */
	this.confirm = function(question, button, callback, callback_cancel, width)
	{
		var normalWidth = $("#confirm").css("width");
		var normalMargin = $("#confirm").css("margin-left");

		if(width)
		{
			$("#confirm").css({width: width+"px"});
			$("#confirm").css({marginLeft: "-"+(width/2)+"px"});
		}

		$(".popup_links").show();
		
		// Put question and button text
		$("#confirm_question").html(question);
		$("#confirm_button").html(button);

		// Show box
		$("#popup_bg").fadeTo(200, 0.5);
		$("#confirm").fadeTo(200, 1);

		// Assign click event
		$("#confirm_button").bind('click', function()
		{
			$("#confirm").css({width:normalWidth});
			$("#confirm").css({marginLeft:normalMargin});
			callback();
			UI.hidePopup();	
		});

		// Assign hide-function to background
		$("#popup_bg").bind('click', function()
		{
			$("#confirm").css({width:normalWidth});
			$("#confirm").css({marginLeft:normalMargin});
			UI.hidePopup();
		});

		// Assign key events
		$(document).keypress(function(event)
		{
			// If "enter"
			if(event.which == 13)
			{
				$("#confirm").css({width:normalWidth});
				$("#confirm").css({marginLeft:normalMargin});
				callback();
				UI.hidePopup();
			}
		});
	}

	/**
	 * Hides the current popup box
	 */
	this.hidePopup = function()
	{
		// Hide box
		$("#popup_bg").hide();
		$("#confirm").hide();
		$("#alert").hide();
		$("#vote_reminder").hide();

		// Remove events
		$("#confirm_button").unbind('click');
		$("#alert_button").unbind('click');
		$(document).unbind('keypress');
	}

	/**
	 * Display the amount of remaining characters
	 * @param Object field
	 * @param Object indicator
	 */
	this.limitCharacters = function(field, indicator)
	{
		// Get the values
		var max = field.maxLength;
		var length = field.value.length;

		// Change the indicator
		document.getElementById(indicator).innerHTML = length + " / " + max;
	}
	
	/**
	 * Creates a expandable box
	 */
	this.dropdown = {
		initialize: function()
		{
			$(document).ready(function() {
				UI.dropdown.create('.dropdown');
			});
		},
		
		create: function(element)
		{
			$(element)
				.not('[data-dropdown-initialized]')
				.attr('data-dropdown-initialized', 'true')
				.children('h3')
				.bind('click', function() 
				{
					$(this).next('div').slideToggle(200, function() {

						if ($(this).is(':visible'))
							$(this).parent('.dropdown').addClass('active');
						else
							$(this).parent('.dropdown').removeClass('active');
					});
				});
		}
	}
}

/**
 * Tooltip related functions
 */
function Tooltip()
{
	/**
	 * Add event-listeners
	 */
	this.initialize = function()
	{
		// Add the tooltip element
		$("body").prepend('<div id="tooltip"></div>');

		// Add mouse-over event listeners
		this.addEvents();
	}

	/**
	 * Used to support Ajax content
	 * Reloads the tooltip elements
	 */
	this.refresh = function()
	{
		// Remove all
		$("[data-tip]").unbind('hover');

		// Re-add
		this.addEvents();
	}
	
	/**
	 * Adds mouseover events to all elements
	 * that should show a tooltip.
	 */
	this.addEvents = function()
	{
		Tooltip.addEvents.handleMouseMove = function(e)
		{
			Tooltip.move(e.pageX, e.pageY);
		}
		
		// Add mouse-over event listeners
		$("[data-tip]").hover(
			function()
			{
				$(document).bind('mousemove', Tooltip.addEvents.handleMouseMove);
				Tooltip.show($(this).attr("data-tip"));
			},
			function()
			{
				$("#tooltip").hide();
				$(document).unbind('mousemove', Tooltip.addEvents.handleMouseMove);
			}
		);

		if(Config.UseFusionTooltip)
		{
			$("[rel]").hover(
				function()
				{
					$(document).bind('mousemove', Tooltip.addEvents.handleMouseMove);
					if(/^item=[0-9]*$/.test($(this).attr("rel")))
					{
						Tooltip.Item.get(this, function(data)
						{
							Tooltip.show(data);
						});
					}
				},
				function()
				{
					$(document).unbind('mousemove', Tooltip.addEvents.handleMouseMove);
					$("#tooltip").hide();
				}
			);
		}
	}

	/**
	 * Moves tooltip
	 * @param Int x
	 * @param Int y
	 */
	this.move = function(x, y)
	{
		// Get half of the width
		var width = ($("#tooltip").css("width").replace("px", "") / 2);

		// Position it at the mouse, and center
		$("#tooltip").css("left", x - width).css("top", y + 25);
	}

	/**
	 * Displays the tooltip
	 * @param Object element
	 */
	this.show = function(data)
	{
		$("#tooltip").html(data).show();
	}

	/**
	 * Item tooltip object
	 */
	 this.Item = new function()
	 {
	 	/**
	 	 * Loading HTML
	 	 */
	 	this.loading = "Loading...";

	 	/**
	 	 * Runtime cache
	 	 */
	 	this.cache = new Array();

	 	/**
	 	 * The currently displayed item ID
	 	 */
	 	this.currentId = false;

	 	/**
	 	 * Load an item and display it in the tooltip
	 	 * @param Object element
	 	 * @param Function callback
	 	 */
	 	this.get = function(element, callback)
	 	{
	 		var obj = $(element);
	 		var realm = obj.attr("data-realm");
	 		var id = obj.attr("rel").replace("item=", "");
	 		Tooltip.Item.currentId = id;

	 		if(id in this.cache)
	 		{
	 			callback(this.cache[id])
	 		}
	 		else
	 		{
	 			var cache = Tooltip.Item.CacheObj.get("item_" + realm + "_" + id + "_" + Config.language);

		 		if(cache !== false)
		 		{
		 			callback(cache);
		 		}
		 		else
		 		{
		 			callback(this.loading);

			 		$.get(Config.URL + "tooltip/" + realm + "/" + id, function(data)
			 		{
			 			// Cache it this visit
			 			Tooltip.Item.cache[id] = data;
			 			Tooltip.Item.CacheObj.save("item_" + realm + "_" + id  + "_" + Config.language, data);

			 			// Make sure it's still visible
			 			if($("#tooltip").is(":visible") && Tooltip.Item.currentId == id)
			 			{
			 				callback(data);
			 			}
			 		});
			 	}
		 	}
	 	}

	 	this.CacheObj = new function()
	 	{
	 		/**
	 		 * Get cache from localStorage
	 		 * @param String name
	 		 * @return Mixed
	 		 */
	 		this.get = function(name)
	 		{
	 			if(typeof localStorage != "undefined")
	 			{
	 				var cache = localStorage.getItem(name);
	 				
		 			if(cache)
		 			{
		 				cache = JSON.parse(cache);

		 				// If it hasn't expired
		 				if(cache.expiration > Math.round((new Date()).getTime() / 1000))
		 				{
		 					return cache.data;
		 				}
		 				else
		 				{
		 					return false;
		 				}
		 			}
		 			else
		 			{
		 				return false;
		 			}
		 		}
		 		else
		 		{
		 			return false;
		 		}
	 		}

	 		/**
	 		 * Save data to localStorage
	 		 * @param String name
	 		 * @param String data
	 		 * @param Int expiration
	 		 */
	 		this.save = function(name, data)
	 		{
	 			if(typeof localStorage != "undefined")
	 			{
	 				var time = Math.round((new Date()).getTime() / 1000);
	 				var expiration = time + 60*60*24;

		 			localStorage.setItem(name, JSON.stringify({"data": data, "expiration": expiration}));
	 			}
	 		}
	 	}
	 }
}

var UI = new UI();
var Tooltip = new Tooltip();