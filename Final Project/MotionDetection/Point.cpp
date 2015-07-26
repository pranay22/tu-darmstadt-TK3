/*
 * Point.cpp
 *
 *  Created on: Jun 18, 2015
 *      Author: jan
 */

#include <iostream>
#include <math.h>
#include "Point.h"

using namespace std;
 // Constructor uses default arguments to allow calling with zero, one,
        // or two values.
        Point2::Point2(double x, double y) {
                xval = x;
                yval = y;
        }
        Point2::Point2() {
                       xval = 0;
                       yval = 0;
               }



        // Distance to another point.  Pythagorean thm.
        double Point2::dist(Point2 other) {
                double xd = xval - other.xval;
                double yd = yval - other.yval;
                return sqrt(xd*xd + yd*yd);
        }

        // Add or subtract two points.
        Point2 Point2::add(Point2 b)
        {
                return Point2(xval + b.xval, yval + b.yval);
        }
        Point2 Point2::sub(Point2 b)
        {
                return Point2(xval - b.xval, yval - b.yval);
        }

        // Move the existing point.
        void Point2::move(double a, double b)
        {
                xval += a;
                yval += b;
        }

        // Print the point on the stream.  The class ostream is a base class
        // for output streams of various types.
        void Point2::print(ostream &strm)
        {
                strm << "(" << xval << "," << yval << ")";
        }

