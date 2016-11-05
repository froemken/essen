/**
 * Module: TYPO3/CMS/Essen/EssenModule
 */
define("TYPO3/CMS/Essen/EssenModule", ["jquery"], function($) {
	$("div#startAjax").on("click", function() {
		$.ajax({
			type: "GET",
			url: TYPO3.settings.ajaxUrls['essen'],
			data: {
				tx_essen_food: {
					objectName: "FindFood",
					arguments: {
						uid: 2
					}
				}
			}
		}).done(function(title) {
			alert(title);
		}).fail(function() {
			alert("Shit");
		});
	});
});
