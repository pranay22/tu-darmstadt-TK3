using System;
using Microsoft.SPOT;

using Gadgeteer.Networking;
using GT = Gadgeteer;
using GTM = Gadgeteer.Modules;
using Gadgeteer.Modules.GHIElectronics;

namespace MasterMind_GroupE
{
    /// <summary>
    /// this class is used to draw a color code on the display 
    /// </summary>
    /// 
    public class ColorCodeView
    {
        private int x;
        private int y;
        private int radius;
        private Gadgeteer.Modules.Module.DisplayModule display;
        private ColorCode code;
        /// <summary>
        /// constructor - set up the view
        /// </summary>
        /// <param name="x"> x coordinate of where to draw the color code</param>
        /// <param name="y"> y coordinate of where to draw the color code</param>
        /// <param name="radius"> how big the code should be</param>
        /// <param name="display"> display module</param>
        /// <param name="code"> color code representation</param>
        public ColorCodeView(int x, int y, int radius, Gadgeteer.Modules.Module.DisplayModule display, ColorCode code)
        {
            this.x = x;
            this.y = y;
            this.radius = radius;
            this.display = display;
            this.code = code;
        }

        /// <summary>
        /// draws the color code at the given positions
        /// </summary>
        public void drawColorCode()
        {
            for (int i = 0; i < 4; i++)
            {
                display.SimpleGraphics.DisplayEllipse(GT.Color.White, 1, code.getColor(i), x + i * (2 * radius + 3), y, radius, radius);
            }
          

        }


    }
}


