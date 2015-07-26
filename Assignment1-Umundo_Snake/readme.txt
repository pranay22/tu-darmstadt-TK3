This is a multiplayer Snake game using uMundo for communication. It consists of two parts: a Desktop version and an Android App. The classes in the "snake.core" package are based on code from:
http://yazalimbiraz.blogspot.de/2014/02/snake-game-written-in-java-full-source.html 
They are modified a lot and our focus was on the multiplayer features with uMundo.

Desktop Version:
The Desktop version is located in the folder "Snake".
Compiling the Desktop version is similar to the uMundo examples. Just specify the correct paths in the "build.properties" file and run Ant with the "build.xml" file included in the main directory of the Desktop version. The default target also starts the program after compilation.

Android App:
Unfortunately the android version is not completly running.
PROBLEM: java.lang.NoClassDefFoundError: org.umundo.core.discovery at SnakeCommunication.java:56
Using umundo.jar for android. Compile time linking error.
NOTE: The problem is not only with discovery, but the with all umundo core classes (e.g. org.umundo.core.node)


Mentioned in: GameView.java:123



Developpers:
Jan Sturm
Christoph Storm
Pranay Sarkar
Daniel Handau
Carsten Bruns