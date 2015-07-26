/*
 * Quadrangle.h
 *
 *  Created on: Jun 17, 2015
 *      Author: jan
 */

#ifndef SRC_QUADRANGLE_H_
#define SRC_QUADRANGLE_H_

#include <iostream>
#include <math.h>
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/imgproc/imgproc.hpp>
#include "Point.h"
#include <vector>

using namespace std;
using namespace cv;

// Class that represents a certain seat.
class Quadrangle {
private:
	Point2 xx, xy, yx, yy;
	vector<Point2> allPoints;  //list that contains all Points that are inside Quadrangle (precomputed in constructor)

public:

	Quadrangle(Point2 xx, Point2 xy, Point2 yx, Point2 yy);

	bool hasPoint(Point2 x);
	bool checkMotion(Mat diffFrame);

};

#endif /* SRC_QUADRANGLE_H_ */
