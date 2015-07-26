using System;
using Microsoft.SPOT;
using GT = Gadgeteer;
using Gadgeteer.Networking;

namespace MasterMind_GroupE
{
    class ModeSelection
    {
        //Constants
        const int CODE_X_POS = 5;
        const int CODE_SIZE = 5;
        const int Y = 10;
        Font font = Resources.GetFont(Resources.FontResources.NinaB);

        Gadgeteer.Modules.Module.DisplayModule display;
        Gadgeteer.Modules.GHIElectronics.Joystick joystick;
        Gadgeteer.Modules.GHIElectronics.Joystick.Position pos_joystick;
        EventHandler inputFinished;
        ColorCodeInput cci;
        ColorCode cc;
        private GT.Timer inputTimer = new GT.Timer(150);
        enum direction { UP, DOWN};
        direction dir = direction.UP;



        /// <summary>
        /// Constructor, initalizes all the needed elements
        /// </summary>
        /// <param name="display"></param>
        /// <param name="button"></param>
        /// <param name="joystick"></param>
        public ModeSelection(Gadgeteer.Modules.Module.DisplayModule display, Gadgeteer.Modules.GHIElectronics.Joystick joystick, EventHandler handler)
        {
            this.display = display;
            this.joystick = joystick;
            this.pos_joystick = new Gadgeteer.Modules.GHIElectronics.Joystick.Position();
            display.SimpleGraphics.Clear();

            inputFinished = handler;
        }


        /// <summary>
        /// Prints two blocks with text. If Joystick is pressed up, the One-Player-Mode is selected, if joystick is pressed down
        /// the Two-Player-Mode is selected
        /// </summary>
        /// <returns> ColorCode random generated or manually</returns>
        public void selectMode()
        {
            display.SimpleGraphics.Clear();
            inputTimer.Tick += new GT.Timer.TickEventHandler(startSelection);
            inputTimer.Start();
            joystick.JoystickPressed += joystick_JoystickPressed;
            cc = new ColorCode();
         

            display.SimpleGraphics.DisplayText("Please pick a mode", font, Gadgeteer.Color.White, 20, 10);
            display.SimpleGraphics.DisplayRectangle(GT.Color.Cyan, 2, GT.Color.DarkGray, 18, 50, 80, 30);
            display.SimpleGraphics.DisplayTextInRectangle("One Player", 20, 50, 100, 50, Gadgeteer.Color.Yellow, font);
            display.SimpleGraphics.DisplayTextInRectangle("Two Player", 20, 80, 100, 50, Gadgeteer.Color.Yellow, font);

        
           
                      
        }

        void joystick_JoystickPressed(GT.Modules.GHIElectronics.Joystick sender, GT.Modules.GHIElectronics.Joystick.ButtonState state)
        {
            if (dir == direction.UP)
            {
                cc.generateRandom();
                inputFinished.Invoke(this, null);
                inputTimer.Stop();

            }
            if (dir == direction.DOWN)
            {
                manuallyGeneratedColor();
                inputTimer.Stop();
            }
            joystick.JoystickPressed -= joystick_JoystickPressed;
        }

        public void startSelection(GT.Timer timer)
        {
             pos_joystick = joystick.GetPosition();
                if (pos_joystick.Y > 0.2)
                {
                    dir = direction.UP;
                    display.SimpleGraphics.Clear();
                    display.SimpleGraphics.DisplayText("Please pick a mode", font, Gadgeteer.Color.White, 20, 10);
                    display.SimpleGraphics.DisplayRectangle(GT.Color.Cyan, 2, GT.Color.DarkGray, 18, 50, 80, 30);
                    display.SimpleGraphics.DisplayTextInRectangle("One Player", 20, 50, 100, 50, Gadgeteer.Color.Yellow, font);
                    display.SimpleGraphics.DisplayTextInRectangle("Two Player", 20, 80, 100, 50, Gadgeteer.Color.Yellow, font);
                   }
                if (pos_joystick.Y < -0.2)
                {
                    dir = direction.DOWN;
                    display.SimpleGraphics.Clear();
                    display.SimpleGraphics.DisplayText("Please pick a mode", font, Gadgeteer.Color.White, 20, 10);
                    display.SimpleGraphics.DisplayRectangle(GT.Color.Cyan, 2, GT.Color.DarkGray, 18, 80, 80, 30);
                    display.SimpleGraphics.DisplayTextInRectangle("One Player", 20, 50, 100, 50, Gadgeteer.Color.Yellow, font);
                    display.SimpleGraphics.DisplayTextInRectangle("Two Player", 20, 80, 100, 50, Gadgeteer.Color.Yellow, font);
 
                }
          
        }
        
        /// <summary>
        /// Fetches the color code
        /// </summary>
        /// <returns>Color code sequence</returns>
        public ColorCode getCode()
        {
            return cc;
        }
        /// <summary>
        /// Generates the Input Color-Code via the class ColorCodeInput and returs the ColorCode
        /// </summary>
        /// <param name="colorCode"></param>
        /// <returns>manually generated ColorCode</returns>
        public void manuallyGeneratedColor()
        {
            display.SimpleGraphics.Clear();
            display.SimpleGraphics.DisplayText("Please enter a code!", font, Gadgeteer.Color.White, 80, 10);
            cci = new ColorCodeInput(10, 50, 8, display, joystick, new EventHandler(unusedMethod));
            cci.inputCode();
        }


        // Dummy-Class for EventHandler, because not needed here
        // TODO: Remove after test
        public void unusedMethod(Object sender, EventArgs e)
        {
            cci.stop();
            cc = cci.getCode();
            inputFinished.Invoke(this,null);

        }
        public void stop()
        {
            if(cci != null)  cci.stop();
            inputTimer.Stop();
        }
    }
}
