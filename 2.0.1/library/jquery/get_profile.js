$(document).ready(function() {
  $('.about_yourself_save').hide();
  
  $('.about_yourself').click(function() {
    $( this ).replaceWith( "<textarea class='about_yourself_textarea' style='width: 100%; display: inline-block;'>" + $( this ).text() + "</textarea>" );
    $('.about_yourself_save').fadeIn();
  });

  $('.about_yourself_save').click(function() {
    console.log('Save...');
    var text = $('.about_yourself_textarea').val();

    $.ajax({
      type: "GET",
      url: "http://localhost/snelkoppeling/2.0.1/scripts/save_about_me.php",
      data: { about_me: text }
    }).done(function() {
      console.log('SAVED');
    });

    $('.about_yourself_textarea').replaceWith('<dd class="about_yourself" style="padding: 0 10px 0 0;">' + text + '</dd>');
    $('.about_yourself_save').hide();

    event.preventDefault();
  });
});