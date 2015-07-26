using System;
using Microsoft.SPOT;

using Gadgeteer.Networking;
using GT = Gadgeteer;
using GTM = Gadgeteer.Modules;
using Gadgeteer.Modules.GHIElectronics;

namespace MasterMind_GroupE
{
    /// <summary>
    /// this class is used to input a colorCode by the user
    /// </summary>
    public class ColorCodeInput
    {
        private int pos_x;
        private int pos_y;
        private int radius;
        private GTM.Module.DisplayModule display;
        private GTM.GHIElectronics.Joystick joystick;
        private GTM.GHIElectronics.Button button;
        private EventHandler finishedHandler;
        private ColorCode code;
        private ColorCodeView view;
        //private bool finished;
        private Joystick.Position pos_joystick;
        private int pos_code;
        private  GT.Timer joystickTimer = new GT.Timer(150);
      
        enum direction { LEFT,UP, RIGHT, DOWN ,STAY};
        
        /// <summary>
        /// constructor - set up the input
        /// </summary>
        /// <param name="x"> x coordinate where to draw the input mask</param>
        /// <param name="y">y coordinate where to draw the input mask</param>
        /// <param name="radius"> how big the input mask should be</param>
        /// <param name="display"> display module</param>
        /// <param name="joystick"> joystick module</param>
        /// <param name="finishedHandler"> event handler which indicates if an input was finished</param>
        public ColorCodeInput(int x, int y, int radius, Gadgeteer.Modules.Module.DisplayModule display, Gadgeteer.Modules.GHIElectronics.Joystick joystick, EventHandler finishedHandler)
        {
            this.pos_x = x;
            this.pos_y = y;
            this.radius = radius;
            this.display = display;
            this.joystick = joystick;
            this.pos_code = 0;
            this.finishedHandler = finishedHandler;
            this.code = new ColorCode();
            this.view = new ColorCodeView(pos_x,pos_y,radius,display,code);
            this.pos_joystick = new Joystick.Position();
        }

       /// <summary>
       /// starts a joystick timer and the drawing of the input
       /// adds an event handler to indicate if the joystick button was pressed
       /// </summary>
        public void inputCode()
        {
            joystickTimer.Tick += new GT.Timer.TickEventHandler(show_on_display);
            joystickTimer.Start();
            joystick.JoystickPressed += joystick_JoystickPressed;
            view.drawColorCode();
                      
        }
        /// <summary>
        /// stops the joystick timer and removes the event handler of the joystick
        /// </summary>
        public void stop()
        {
            joystickTimer.Stop();
            joystick.JoystickPressed -= joystick_JoystickPressed;
            
        }

        /// <summary>
        /// method is run if the joystick was pressed
        /// checks if the given input is a valid code; if so the finishedHandler will be invoked.
        /// </summary>
        void joystick_JoystickPressed(Joystick sender, Joystick.ButtonState state)
        {
            if (code.isValid())
            {
                stop();
                display.SimpleGraphics.DisplayLine(GT.Color.Black, 2, pos_x - radius,
                                                    pos_y + radius + 4,
                                                    pos_x + 3 * (2 * radius + 3) + radius,
                                                    pos_y + radius + 4);
                finishedHandler.Invoke(this, null);
             
            }
            else Debug.Print("not a valid input");
        }

        /// <summary>
        /// every tick of the timer this method will be executed and prints the actual input of the code and 
        /// an indicator line where the actual position of the joystick is.
        /// </summary>
        /// <param name="timer"></param>
        private void show_on_display(GT.Timer timer)
        {         
            direction direction_v;
             //pos_code indicator
            for (int i = 0; i < 4; i++)
            {
                if (i == pos_code)
                {
                    display.SimpleGraphics.DisplayLine(GT.Color.White, 2, pos_x + i* (2 * radius + 3) - radius,
                                                        pos_y + radius + 4,
                                                        pos_x + i * (2 * radius + 3) + radius,
                                                        pos_y + radius + 4);
                }
                else
                {
                    display.SimpleGraphics.DisplayLine(GT.Color.Black, 2, pos_x + i * (2 * radius + 3) - radius,
                                                       pos_y + radius + 4,
                                                       pos_x + i * (2 * radius + 3) + radius,
                                                       pos_y + radius + 4);
                }
            }
                view.drawColorCode();

                pos_joystick = joystick.GetPosition();
                direction_v = getDirectionJoystick(pos_joystick);
               // Debug.Print("direction_v = " + direction_v);
                if (direction_v == direction.UP || direction_v == direction.DOWN) changeColor(direction_v, code, pos_code);

                if (direction_v == direction.LEFT)
                {
                    if (pos_code > 0) pos_code--;
                }
                if (direction_v == direction.RIGHT)
                {
                    if (pos_code < 3) pos_code++;
                   
                }
                        
        }
        /// <summary>
        /// converts the floatingpoint x and y values of the joystick position in a more convenient
        /// direction 
        /// </summary>
        /// <param name="pos_joystick"> the actual joystick position coordinates (double x, double y)</param>
        /// <returns> UP,DOWN,LEFT or RIGHT</returns>
        private direction getDirectionJoystick(Joystick.Position pos_joystick)
        {
            double threshold = 0.2;
            double x = pos_joystick.X;
            double y = pos_joystick.Y;

            if(x < threshold && y > (1-threshold)) return direction.UP;
            if(x > (1- threshold) && y < threshold) return direction.RIGHT;
            if(x < threshold && y < -(1-threshold)) return direction.DOWN;
            if(x < -(1-threshold) && y < threshold) return direction.LEFT;

            return direction.STAY;
        }

        /// <summary>
        /// changes the color of the given color code at a certain position
        /// </summary>
        /// <param name="d"> the direction (UP or DOWN)</param>
        /// <param name="code"> the color code</param>
        /// <param name="pos"> position of the color to be changed in the code </param>
        private void changeColor(direction d, ColorCode code, int pos){
            if (d == direction.UP)
            {
                code.setColor(pos, ColorCode.getNextColor(code.getColor(pos)));
            }
            else
            {
                code.setColor(pos, ColorCode.getPrevColor(code.getColor(pos)));
            }
        }

        /// <summary>
        /// returns the code which the user has entered
        /// </summary>
        /// <returns> entered color code</returns>
        public ColorCode getCode()
        {
            return code;
        }
    }
}
