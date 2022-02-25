import {Modal} from 'bootstrap';

(function () {
    $(document).ready(function () {
        $(".accordion").accordion({ active: 2, event: "mouseover" });
        init();
    });



    let ListenForNavigationLinkClicks= function () {


        $('#linkToFirstSection').on("click", function () {
            scrollAndClickBtn($("#first_section"));
        });
        $('#linkToSecondSection').on("click", function () {
            scrollAndClickBtn($("#second_section"));
        });
        $('#linkToThirdSection').on("click", function () {
            scrollAndClickBtn($("#third_section"));
        });

    }

    let scrollAndClickBtn = function(){

        console.log(arguments[0]);
        let btn = arguments[0];
        if (btn.length) {
            $('html, body').animate({
                scrollTop: btn.offset().top
            }, 500);
        }
        $(".accordion").accordion({ active: 2, event: "mouseover" });

    }


    let init = function () {
        ListenForNavigationLinkClicks();
        scrollAndClickBtn();
    };

})();


