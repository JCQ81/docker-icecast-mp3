document.onload = onload();

function onload() { 
    httpget('load', 0, 'vwmaps-inner');    
    httpget('load', 1, 'vwcontent-inner');
    httpget('info', 0, 'vwplayer-inner');
    setInterval(function() { httpget('info', 0, 'vwplayer-inner'); },1000);
}

function httpget() {    
    if (arguments.length < 2) {
        die();
    }
    var request = new XMLHttpRequest();
    request.open('GET', './index.php?act='+arguments[0]+'&val='+arguments[1], true);
    request.send(null);    
    if (arguments.length > 2) {
        var elementid = arguments[2];        
        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {            
                document.getElementById(elementid).innerHTML = request.responseText;
            }
        }
    }
}