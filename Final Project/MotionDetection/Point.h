/*
 * Point.h
 *
 *  Created on: Jun 17, 2015
 *      Author: jan
 */

#ifndef SRC_POINT_H_
#define SRC_POINT_H_

/*
 * Point.cpp
 *
 *  Created on: Jun 17, 2015
 *      Author: jan
 */


#include <iostream>
#include <math.h>

using namespace std;
// Class to represent points.
class Point2 {
private:
        double xval, yval;
public:
        // Constructor uses default arguments to allow calling with zero, one,
        // or two values.
        Point2();
        Point2(double x, double y);

        // Extractors.
        double x() { return xval; }
        double y() { return yval; }

        // Distance to another point.  Pythagorean thm.
        double dist(Point2 other);

        // Add or subtract two points.
        Point2 add(Point2 b);
        Point2 sub(Point2 b);

        // Move the existing point.
        void move(double a, double b);

        // Print the point on the stream.  The class ostream is a base class
        // for output streams of various types.
        void print(ostream &strm);
};






#endif /* SRC_POINT_H_ */
