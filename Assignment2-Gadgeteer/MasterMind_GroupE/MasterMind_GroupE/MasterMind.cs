using System;
using System.Collections;
using Microsoft.SPOT;
using Microsoft.SPOT.Presentation.Shapes;
using GT = Gadgeteer;

namespace MasterMind_GroupE
{
    /// <summary>
    /// Mastermind class handles game logic
    /// </summary>
    public class MasterMind
    {
        Gadgeteer.Modules.Module.DisplayModule display;
        Gadgeteer.Modules.GHIElectronics.Joystick joystick;
        Gadgeteer.Modules.GHIElectronics.MulticolorLED led;
        Gadgeteer.Modules.GHIElectronics.Button button;

        GameView gameview;
        EventHandler inputFinished;
        ColorCode secretColorCode;
        ModeSelection ms;
        const int TOTAL_ROUNDS = 10         ///confugrable number of ctotal rounds.
        int currentRound = 0;

        /// <summary>
        /// Default constructor for MasterMind class. Initializes variables
        /// </summary>
        /// <param name="display">display module</param>
        /// <param name="joystick">joystick module</param>
        /// <param name="button">button module</param>
        /// <param name="led">led module</param>
        public MasterMind(Gadgeteer.Modules.Module.DisplayModule display, Gadgeteer.Modules.GHIElectronics.Joystick joystick,
            Gadgeteer.Modules.GHIElectronics.Button button, Gadgeteer.Modules.GHIElectronics.MulticolorLED led)
        {
            //storing device referenceslocally ingame logic.
            this.display = display;
            this.joystick = joystick;
            this.led = led;
            this.button = button;

            //game restart button
            button.ButtonPressed += button_ButtonPressed;
        }

        /// <summary>
        /// Controller for event after each round. If secret color and guess matched, game finished, show it. 
        /// If not, increase the number of round count (i.e. currentRound) 
        /// If currentRound count reaches max allowed round, display, game lost.
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e">Event which specifies end of round</param>
        public void endOfRound(Object sender, EventArgs e)
        {
            ColorCode compare = secretColorCode.compareCodes(gameview.getLastColorCode());
            if (secretColorCode.isEqual(gameview.getLastColorCode()))
            {
                gameview.gameFinished(secretColorCode,true);
            }
            else
            {
                if (currentRound == TOTAL_ROUNDS)
                {
                    gameview.gameFinished(secretColorCode, false);
                }
                else
                {
                    currentRound++;
                    gameview.nextRound(compare);
                }
            } 
        }

        /// <summary>
        /// Button pressed? stop gameview
        /// </summary>
        /// <param name="sender">holds button variable</param>
        /// <param name="state">event that specifies button is pressed</param>
        void button_ButtonPressed(GT.Modules.GHIElectronics.Button sender, GT.Modules.GHIElectronics.Button.ButtonState state)
        {
            if (gameview != null)  gameview.stop();
            if(ms != null) ms.stop();
            start();
        }
    
        /// <summary>
        /// Starts MasterMind game, and starts mode selection window to chse between Singleplayer and Multiplayer
        /// </summary>
        public void start()
        {
            ColorCode secretCode = new ColorCode();
            ms = new ModeSelection(display, joystick, new EventHandler(modeFinished));
            ms.selectMode();
            
        }

        /// <summary>
        /// Fetches secret code, starts game with that color sequence
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public void modeFinished(Object sender, EventArgs e)
        {
            ColorCode secretCode = ((ModeSelection)sender).getCode();
            startGame(secretCode);
        }
        
        /// <summary>
        /// Initializes/resets the number of current round, clears display, starts the game
        /// </summary>
        /// <param name="secretCode"> Secret color code sequence for that game</param>
        void startGame(ColorCode secretCode)
        {
            display.SimpleGraphics.Clear();
            currentRound = 0;

            secretColorCode = secretCode;
            /*for(int i=0;i<4;i++){
                Debug.Print("color= " + secretColorCode.getColor(i).ToString());
            }*/

            inputFinished = new EventHandler(endOfRound);
            gameview = new GameView(this, display, joystick, led, inputFinished);
        }

        //Get for CurrentRound count.
        /// <summary>
        /// Fetches current round number being played
        /// </summary>
        /// <returns>Current round number (integer)</returns>
        public int getCurrentRound()
        {
            return currentRound;
        }        
    }
}
