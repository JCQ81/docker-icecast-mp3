IceCast-MP3
===========
[still under development, use at your own risk!!]

---

Docker container running icecast and a simple web interface for streaming .mp3 files.

Written for usage with https://www.instructables.com/Internet-Radio-Using-an-ESP32

Usage (example):
```
docker run -d --name icecast-mp3 -p 8000:8000 -p 8001:80 -v /path/to/local/media:/media icecast-mp3
```

|Interface| URL|
|:-|:-|
|Stream| hostname:8000/ices|
|Web| hostname:8001|

Required map structure in /media:
- Under /media only maps containing .mp3 files
- Sublevels not supported

Known bugs:
- Make sure permissions in /media are right (read for www-data)
- Skipping tracks is not working correctly... (like: still in crappy coding ;) )

