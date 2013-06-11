var sisyphus_time = 1;
var altKey = false;

function alert_message(text, box, time){
    
    $('#'+box).html('<p style="text-align: center">'+text+'</p>');

    $('#'+box).popup("open", {positionTo: "window", transition: "flip"});
    setTimeout( function(){ $('#'+box).popup("close") }, time*1000);
    
}

function word(number, word_one, word_two, word_three){
    
    number = number % 100;
    if (number > 19) 
    {
	number = number % 10;
    }
    if(number == 1)
    {
        return word_one;
    }
    if(number >= 2 && number <= 4) 
    {
        return word_two;
    }
    
    return word_three;
    
}

function isInteger(s)
{
    var i;
    for (i = 0; i < s.length; i++)
    {

        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }

    return true;
}
function stripCharsInBag(s, bag)
{
    var i;
    var returnString = "";

    for (i = 0; i < s.length; i++)
    {

        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}
function update_navigation(){
    
    if(n == 0)
        next = 'hide';
    else
        next = 'show';
    
    if(max_n <= e+n)
        back = 'hide';
    else
        back = 'show';
        
    if(back == 'hide' && next == 'hide'){
        
        $('#navigation_page').hide();
        
    }
    
    if(back == 'hide' && next == 'show'){
        
        $('#navigation_page').show();
        
        $('#back').addClass("ui-disabled");
        $('#next').removeClass("ui-disabled");
        
    }
    
    if(back == 'show' && next == 'hide'){
        
        $('#navigation_page').show();
        
        $('#next').addClass("ui-disabled");
        $('#back').removeClass("ui-disabled");
        
    }
    
    if(back == 'show' && next == 'show'){
        
        $('#navigation_page').show();
        
        $('#next').removeClass("ui-disabled");
        $('#back').removeClass("ui-disabled");
        
    }
    
}

function is_PC(){
    
    if(navigator.platform.search('Win') >= 0 || navigator.platform.search('Mac') >= 0)
        return true;
    else
        return false;
    
}

$('html').keydown(function (e){
    if (e.keyCode == 18)
        altKey = true;
});
$('html').keyup(function (e){
    if (e.keyCode == 18)
        altKey = false;
});

$('img#user_avatar').live('click', function (){
    
    if($('img#user_avatar').parents('a').length)
        return;
    
    if($('#page_user_information').length)
        return;
    
    $.mobile.changePage("/id"+$(this).attr('data-user')+"/", {
        transition: "flip", 
        reloadPage: true
    });
    
    return false;
    
});