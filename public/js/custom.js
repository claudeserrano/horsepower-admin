$(document).ready(function(){
  
	$(".ssn").mask("000-00-0000");
	$(".date").mask("00/00/0000");
	$(".phone").mask("(000) 000-0000");
	$('.sex').mask('Z', {
    translation: {
      'Z': {
        pattern: /[MF]/
      }
    }
  });

	$('.sex').attr('placeholder', 'M/F');
	$('.date').attr('placeholder', 'mm/dd/yyyy');
	$('.ssn').attr('placeholder', 'xxx-xx-xxxx');
	$('.phone').attr('placeholder', '(xxx) xxx-xxxx');
	$('.email').attr('placeholder', 'yourmail@example.com');

  window.onresize = function(){
  }
    
})