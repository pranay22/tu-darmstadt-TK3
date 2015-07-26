This is using the (win) MySqlConnector c++ files from "http://dev.mysql.com/downloads/connector/cpp/"
(This is also the reason the boost and mysql header files are in now in the include folder - the connector needs those)

I was (trying) using the dynamic lib func
	The .lib file needs to be added to the compiler// Linker
	The .dll file should be in the same directory as the generated .exe
	
Anyway, for some reason the precompiled libs don't work on my system and
 I can't seem to compile my own, so I have no way to test if this is actually working