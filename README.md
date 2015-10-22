# SAMP-Live-map
To be displayed on your website/ucp - Current location of player positions

## Dependencies
* <a href="https://github.com/ikkentim/SanMap">SanMap</a> (Web)
* <a href="http://forum.sa-mp.com/showthread.php?t=48439">DJson</a> (SA:MP plugin)

## Installation
Download the latest version.
After that then:

### SA:MP Server
- Put live.amx and live.pwn in your filterscript directory
- Put "live" to your filterscripts line in your server.cfg
- Edit the PAWN config shown below and, if edited, recompile. (You need the depency shown above)

### Website
- Put everything from the "web" directory on your webserver
- Edit the PHP config shown below

## Config
```PHP
define(PATH_JSON, "/home/samp/lmdmtest/scriptfiles/positions.json"); //full path to the json file
```
```PAWN
#define FILE_JSON	"positions.json"  //the name of the file
#define UPDATE_TIME	60000           //each time it updates the json file (milliseconds)
```

## Preview
There's a "live" version available at <a href="http://lm-dm.net/live_map/">lm-dm.net</a>
Ofcourse i'm not really online.

The json file is:
```JSON
{
  "0":
  {
    "name":"Michael@Belgium",
    "online":1,
    "ping":35,
    "x":2040.979003,
    "y":1351.497680
  },
  "1":
  {
    "name":"bot1",
    "online":1,
    "ping":56,
    "x":0.0,
    "y":0.0
  },
  "2":
  {
    "name":"I_Am_Not_Online",
    "online":0,
    "ping":90,
    "x":2040.979003,
    "y":1351.497680
  }
}
```
