$(document).ready(function(){
    // show popup when you click on the link
    $('.show-popup-email').click(function(event){
        event.preventDefault(); // disable normal link function so that it doesn't refresh the page
        $('.changeemail').show(); //display your popup
    });

    // hide popup when user clicks on close button
    $('.close-btn-email').click(function(){
      $('.changeemail').hide(); // hide the overlay
    });
});

$(document).ready(function(){
    // show popup when you click on the link
    $('.show-popup-pass').click(function(event){
        event.preventDefault(); // disable normal link function so that it doesn't refresh the page
        $('.changepass').show(); //display your popup
    });

    // hide popup when user clicks on close button
    $('.close-btn-pass').click(function(){
      $('.changepass').hide(); // hide the overlay
    });
});