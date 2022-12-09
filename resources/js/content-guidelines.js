require("jquery-ui-dist/jquery-ui.js");

(function () {
	$(document).ready(function () {
		init();
	});


	let ListenForPageExpansion = function () {
		$(document).on("scroll", function () {
			let content_height = $(document).height();
			let content_scroll_pos = $(window).scrollTop();
			let percentage_value = content_scroll_pos * 100 / content_height;
			console.log(percentage_value);
			if(percentage_value >= 50) {
				let scrollTopBtn = document.getElementById("btn-back-to-top");
				scrollTopBtn.style.display = "block";
			} else {
				let scrollTopBtn = document.getElementById("btn-back-to-top");
				scrollTopBtn.style.display = "none";
			}

		});

	};



	let ListenForNavigationLinkClicks= function () {

		$("#linkToFirstSection").on("click", function () {
			let $section = $("#section_one");
			$section.click();
			scrollToArgument( $section);
		});
		$("#linkToSecondSection").on("click", function () {
			let $section = $("#section_two");
			$section.click();
			scrollToArgument($section);

		});
		$("#linkToThirdSection").on("click", function () {
			let $section = $("#section_three");
			$section.click();
			scrollToArgument($section);
		});

	};


	let ListenForBackToTop = function () {
		$("#btn-back-to-top").on("click", function () {
			scrollToArgument($("#intro"));
		});
	};

	let scrollToArgument= function(){
		if(arguments.length){
			let arg = arguments[0];
			if (arg.length) {
				$("html, body").animate({
					scrollTop: arg.offset().top
				}, 500);
			}
		}


	};


	let init = function () {
		ListenForNavigationLinkClicks();
		scrollToArgument();
		ListenForPageExpansion();
		ListenForBackToTop();
	};

})();


