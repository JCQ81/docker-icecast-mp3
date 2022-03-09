<?php

// http://10.10.9.11:8001/index.php?act=player&val=3

if (isset($_GET['act'])) {
    //echo(var_dump($_GET['act']));
    if ($_GET['act'] == "load") {
        if (isset($_GET['val'])) {
            if ($_GET['val'] == "0") {
                $dirNr = 1;
                shell_exec("");
                foreach (array_filter(explode("\n", shell_exec("find /media -maxdepth 1 ! -path /media -type d | cut -d'/' -f3-"))) as $dirEntry) { 
                    print("<div class=\"dvlink\" onclick=\"httpget('load', $dirNr, 'vwcontent-inner');\">- $dirEntry</div>"); 
                    $dirNr++;
                }
            } else {
                $fileNr = 1;
                shell_exec("find \"$(find /media -maxdepth 1 ! -path /media -type d | sed '".$_GET['val']."!d')\" -maxdepth 1 ! -path /media -type f -name *.mp3 | sort >/tmp/ices/playlist.buf");
                foreach (array_filter(explode("\n", shell_exec("cat /tmp/ices/playlist.buf | cut -d'/' -f4- | sed 's/.mp3$//g'"))) as $fileEntry) {
                    print("<div class=\"dvlink\" onclick=\"\">".$fileNr." - ".$fileEntry."</div>");
                    $fileNr++;
                }
            }
        }
    } 
    if ($_GET['act'] == "info") {
        print(shell_exec("head -n 1 /tmp/ices/ices.cue | cut -d'/' -f3- | sed -e 's/\//:<br>\&nbsp; /g' -e 's/.mp3$//g'"));
    }
    if ($_GET['act'] == "player") {        
        if ($_GET['val'] == "1") {
            
        }
        if ($_GET['val'] == "2") {
            shell_exec("pll=\$(tail -n -2 /tmp/ices/playlist.txt; head -n -2 /tmp/ices/playlist.txt); echo \"\$pll\" >/tmp/ices/playlist.txt; kill -10 \$(cat /tmp/ices/ices.pid);");
        }
        if ($_GET['val'] == "3") {
            shell_exec("kill -9 $(cat /tmp/ices/ices.pid); rm -f /tmp/ices/ices.cue");
        }
        if ($_GET['val'] == "4") {
            shell_exec("cat /tmp/ices/playlist.buf >/tmp/ices/playlist.txt; pgrep ices; if [ \$? -eq 0 ]; then cur=\$(sed '6q;d' /tmp/ices/ices.cue); pll=\$(tail -n -\$cur /tmp/ices/playlist.txt; head -n -\$cur /tmp/ices/playlist.txt); echo \"\$pll\" >/tmp/ices/playlist.txt; kill -10 \$(cat /tmp/ices/ices.pid); else ices -B -n ices -m ices -D /tmp/ices -F /tmp/ices/playlist.txt -h localhost -P icecast; fi");
        }
        if ($_GET['val'] == "5") {
            print(shell_exec("kill -10 $(cat /tmp/ices/ices.pid)"));
        }
    }
    exit();
}?>
<html>
<head>  
  <link rel="stylesheet" href="index.css" type="text/css">  
  <script src="index.js" type="application/javascript"></script>
</head>
<body>
    <div class="mntitle">IceCast MP3 Streaming Server</div>
    <div class="vwmaps">
        <div class="vwtitle">Maps</div>
        <div id="vwmaps-inner" class="vwinner"> 
            <div class="dvcenter"><img src="img/sqbf.gif" width=40></div>
        </div>
    </div>
    <div class="vwplayer">
        <div class="vwtitle">
            Now playing:
            <div style="position:absolute;right:0;padding-right:40px; padding-top: -40px;">
                <div class="btnctrl" onclick="httpget('player', 2);"><img src="img/icpr.png"></div>
                <div class="btnctrl" onclick="httpget('player', 3);"><img src="img/icst.png"></div>
                <div class="btnctrl" onclick="httpget('player', 5);"><img src="img/icnx.png"></div>
            </div>
        </div>
        <div id="vwplayer-inner" class="vwinner"> 
            <div class="dvcenter"><img src="img/sqbf.gif" width=40></div>
        </div>
    </div>
    <div class="vwcontent">
        <div class="vwtitle">Content   <div style="position:absolute;right:0;padding-right:40px; padding-top: -40px;"><div class="btnctrl" onclick="httpget('player', 4);"><img src="img/icpl.png"></div></div>   </div>
        
        <div id="vwcontent-inner" class="vwinner">        
            <div class="dvcenter"><img src="img/sqbf.gif" width=40></div>
        </div>
    </div>
</body>
</html>