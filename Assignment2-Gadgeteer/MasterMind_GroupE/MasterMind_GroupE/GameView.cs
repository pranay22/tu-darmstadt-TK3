using System;
using Microsoft.SPOT;

using Gadgeteer.Networking;
using GT = Gadgeteer;
using GTM = Gadgeteer.Modules;
using Gadgeteer.Modules.GHIElectronics;

namespace MasterMind_GroupE
{
    /// <summary>
    ///  This class implements the (graphical) user interface in the main Mastermind game.
    ///  It displays ColorCodeInputs/Views on the screen and controls the MulticolorLED.
    /// </summary>
    public class GameView
    {
        //constants defining the GUI layout
        const int WELCOME_Y_POS = 5;
        const int FINAL_CODE_X_POS = 175;
        const int FINAL_CODE_Y_POS = 50;
        const int CODE_X_POS = 5;
        const int CODE_SIZE = 5;
        const int CODE_SIZE_SPACING = 7;
        const int TEXT_SIZE = 15;
        const int RESULT_X_POS = 120;

        Gadgeteer.Modules.Module.DisplayModule display;
        Gadgeteer.Modules.GHIElectronics.Joystick joystick;
        Gadgeteer.Modules.GHIElectronics.MulticolorLED led;
        EventHandler inputFinished;
        MasterMind masterMind;
        ColorCodeInput input;

        /// <summary>
        /// constructor, gets all peripherals needed for the UI
        /// </summary>
        /// <param name="inputFinished">an EventHandler which will be called when the input in a round is completed successfully</param>
        public GameView(MasterMind masterMind, Gadgeteer.Modules.Module.DisplayModule display, Gadgeteer.Modules.GHIElectronics.Joystick joystick, 
            Gadgeteer.Modules.GHIElectronics.MulticolorLED led, EventHandler inputFinished)
        {
            this.masterMind = masterMind;

            //store Gadgeteer device references for later use
            this.display = display;
            this.joystick = joystick;
            this.led = led;

            //event handler which will be invoked when the user finished his input..we just pass this to the current ColorCodeInput
            this.inputFinished = inputFinished;
            
            //start with the first round!
            display.SimpleGraphics.Clear();
            display.SimpleGraphics.DisplayText("Mastermind - good luck!", Resources.GetFont(Resources.FontResources.NinaB), GT.Color.White, CODE_X_POS, WELCOME_Y_POS);
            createColorCodeInput(0);
        }

        /// <summary>
        /// stops the current game (running timer for screen refresh, EventHandler on peripherals,..)
        /// </summary>
        public void stop()
        {
            input.stop();
            led.TurnOff();
        }

        /// <summary>
        /// creates and initializes a new ColorCodeInput
        /// </summary>
        /// <param name="pos">position (round) of the new input field</param>
        void createColorCodeInput(int pos)
        {
            input = new ColorCodeInput(CODE_X_POS, (pos + 3) * CODE_SIZE_SPACING * 2, CODE_SIZE, display, joystick, inputFinished);
            input.inputCode();
        }

        /// <summary>
        /// initializes and draws everything (new input field, last result code) for a new round
        /// </summary>
        /// <param name="lastResultCode">result code (correct colors, correct positions) of the last round</param>
        public void nextRound(ColorCode lastResultCode)
        {
            int round = masterMind.getCurrentRound();
            ColorCodeView resultView = new ColorCodeView(RESULT_X_POS, (round + 2) * CODE_SIZE_SPACING * 2, CODE_SIZE, display, lastResultCode);
            resultView.drawColorCode();
            createColorCodeInput(round);
        }

        /// <summary>
        /// displays the right code and win/loose message at the end of the game
        /// also controls the LED
        /// </summary>
        /// <param name="rightCode">the right (secret) code</param>
        /// <param name="gameWon">true if the game was won, false if the player lost</param>
        public void gameFinished(ColorCode rightCode, bool gameWon)
        {
            display.SimpleGraphics.DisplayText("The right code was:", Resources.GetFont(Resources.FontResources.NinaB), GT.Color.Blue, FINAL_CODE_X_POS, FINAL_CODE_Y_POS + TEXT_SIZE);
            ColorCodeView rightCodeView = new ColorCodeView(FINAL_CODE_X_POS+10, FINAL_CODE_Y_POS + CODE_SIZE*2 + TEXT_SIZE*2, CODE_SIZE, display, rightCode);
            rightCodeView.drawColorCode();

            if (gameWon)
            {
                display.SimpleGraphics.DisplayText("You won!", Resources.GetFont(Resources.FontResources.NinaB), GT.Color.Green, FINAL_CODE_X_POS, FINAL_CODE_Y_POS);
                led.FadeRepeatedly(GT.Color.Green);
            }
            else
            {
                display.SimpleGraphics.DisplayText("You lost!", Resources.GetFont(Resources.FontResources.NinaB), GT.Color.Red, FINAL_CODE_X_POS, FINAL_CODE_Y_POS);
                led.FadeRepeatedly(GT.Color.Red);
            }
        }

        /// <summary>
        /// getter for the last entered code
        /// </summary>
        /// <returns>the last entered code</returns>
        public ColorCode getLastColorCode()
        {
            return input.getCode();
        }
    }
}
