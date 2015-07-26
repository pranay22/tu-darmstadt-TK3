using System;
using Microsoft.SPOT;

using Gadgeteer.Networking;
using GT = Gadgeteer;
using GTM = Gadgeteer.Modules;
using Gadgeteer.Modules.GHIElectronics;

namespace MasterMind_GroupE
{
    /// <summary>
    /// This class is used to store and compare color codes
    /// </summary>
    public class ColorCode
    {

        //static values
        //TODO standartize colors used with other classes/input...
        public static GT.Color[] allColors = new GT.Color[6]
        {GT.Color.Blue,
         GT.Color.Green,
         GT.Color.Red,
         GT.Color.Yellow,
         GT.Color.Orange,
         GT.Color.Magenta};
        

        public static GT.Color correct = GT.Color.Cyan;
        public static GT.Color semiRight = GT.Color.White;
        public static GT.Color notSet = GT.Color.Gray;

        public GT.Color[] colors = new GT.Color[4] {notSet, notSet, notSet, notSet};

        public ColorCode()
        {

        }

        /// <summary>
        /// returns the next color in allColors (for ColorCodeInput)
        /// </summary>
        /// 
          
        public static GT.Color getNextColor(GT.Color color){
            //not really nice, but it works for testing purposes -JS
            if (color == GT.Color.Gray)
              return GT.Color.Magenta; 
            if(color == GT.Color.Blue)
            return GT.Color.Magenta; 
             else if(color == GT.Color.Green)
            return GT.Color.Blue; 
             else if(color == GT.Color.Red)
            return GT.Color.Green; 
             else if(color == GT.Color.Yellow)
            return GT.Color.Red; 
             else if(color == GT.Color.Orange)
            return GT.Color.Yellow; 
            else  if(color == GT.Color.Magenta)
            return GT.Color.Orange;

            return GT.Color.Gray;

        }
        
        /// <summary>
        /// returns the previous color in allColors (for ColorCodeInput)
        /// </summary>
        /// 
        public static GT.Color getPrevColor(GT.Color color){

             //not really nice, but it works for testing purposes -JS
            if (color == GT.Color.Gray)
              return GT.Color.Blue; 
            if(color == GT.Color.Blue)
            return GT.Color.Green; 
             else if(color == GT.Color.Green)
            return GT.Color.Red; 
             else if(color == GT.Color.Red)
            return GT.Color.Yellow; 
             else if(color == GT.Color.Yellow)
            return GT.Color.Orange; 
             else if(color == GT.Color.Orange)
            return GT.Color.Magenta; 
            else  if(color == GT.Color.Magenta)
            return GT.Color.Blue;

            return GT.Color.Gray;

        }
        

        
         /// <summary>
        /// generates a random color sequence
        /// </summary>
        /// <returns>randomly generated colorcode sequence</returns>

        public GT.Color[] generateRandom()
        {
            Random rng = new Random();
            for (int i = 0; i < 4; i++)
            {
                int c = rng.Next(6);
                colors[i] = allColors[c];
            }
            return colors;
        }

        /// <summary>
        /// Returns the Color at the specified position.
        /// </summary>
        public GT.Color getColor(int position)
        {
            return colors[position];
        }

        /// <summary>
        /// Sets the Color at the specified position to the given input color.
        /// </summary>
        public void setColor(int position, GT.Color color)
        {
            colors[position] = color;
        }

        /// <summary>
        /// Verifies if the code is complete
        /// </summary>
        /// <returns>true if the code input is complete</returns>
        public bool isValid()
        {
            for (int i = 0; i < 4; i++)
            {
                if (colors[i].Equals(notSet))
                {
                    return false;
                }
            }
            return true;
        }

        /// <summary>
        /// checks if ColorCodes match exactly, for game finish checks
        /// </summary>
        /// <param name="other">Colorsequence to check against</param>
        /// <returns>true if identical</returns>
        public bool isEqual(ColorCode other)
        {
            for (int i = 0; i < 4; i++)
            {
                if ( !colors[i].Equals( other.getColor(i) ) )
                {
                    return false;
                }
            }
            return true;
        }

        /// <summary>
        /// Compares the given input code to the colors set in here.
        /// </summary>
        /// <param name="other">ColorCode that is compared</param>
        /// <returns>A color representation of the number of correctly colored and placed inputs.
        /// Cyan means correct input color at the right place, white that there is a correct color.
        /// </returns>
        public ColorCode compareCodes(ColorCode other)
        {
            ColorCode indicator = new ColorCode();

            int index;

            int correctlyPlaced = 0;
            int rightColors = 0;

            GT.Color thisColor;

            GT.Color[] testcase = { colors[0], colors[1], colors[2], colors[3] };

            //First find all correctly placed colors...
            for (index = 0; index < 4; index++)
            {
                thisColor = other.getColor(index);
                if (testcase[index].Equals(thisColor))
                {
                    correctlyPlaced++;
                    //... and remove them, to not test against them again
                    testcase[index] = correct;
                }
            }

            //Now find colors that are present in wrong places...
            for (index = 0; index < 4; index++)
            {
                if (testcase[index] != correct) //already found
                {
                    thisColor = other.getColor(index);
                    for (int i = 0; i < 4; i++)
                    {
                        if ( testcase[i].Equals(thisColor) )
                        {
                            //found an incorrect placed color
                            rightColors++;
                            testcase[i] = semiRight;
                            //remove and don't test for this index further...
                            break;
                        }
                    }
                }
            }

            //fill the to be returned indicator...
            index = 0;
            for (int i = 0; i < correctlyPlaced; i++)
            {
                indicator.setColor(index, correct);
                index++;
            }
            for (int i = 0; i < rightColors; i++)
            {
                indicator.setColor(index, semiRight);
                index++;
            }

            return indicator;
        }

    }
}
