$(document).ready(function(){function add(){if($(this).val()===''){$(this).val($(this).attr('placeholder')).addClass('placeholder');}}
function remove(){if($(this).val()===$(this).attr('placeholder')){$(this).val('').removeClass('placeholder');}}
if(!('placeholder'in $('<input>')[0])){$('input[placeholder], textarea[placeholder]').blur(add).focus(remove).each(add);$('form').submit(function(){$(this).find('input[placeholder], textarea[placeholder]').each(remove);});}});