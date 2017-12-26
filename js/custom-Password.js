/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//visible password function
var togglePass = document.querySelectorAll(".togglePass");
for (i = 0; i < togglePass.length; i++) {
    (function (i) {
        togglePass[i].addEventListener('click', function (e) {
            var xx = togglePass[i].previousElementSibling;
            if (xx.type === "password" || e.target.textContent === "visibility_off") {
                e.target.textContent = "visibility";
                xx.type = "text";
            } else {
                e.target.textContent = "visibility_off";
                xx.type = "password";
            }
        });
    })(i);
}

jQuery('.message a').click(function (event) {
    event.preventDefault();
    jQuery('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
jQuery('#headerLoginBtn').click(function (event) {
    var showlogin = jQuery('.login-form');
    var showRegister = jQuery('.register-form');
    event.preventDefault();
   
    if (showlogin) {
        showRegister.css("display", "none");
        showlogin.css("display", "block");
        showlogin.toggleClass("animated fadeIn");
        jQuery(this).toggleClass("animated fadeOut");
        console.log('1');
       
    } else {
        showRegister.css("display", "none");
       }

});



