/*
 * Quadrangle.cpp
 *
 *  Created on: Jun 18, 2015
 *      Author: jan
 */
#include <iostream>
#include "Quadrangle.h"
#include "Point.h"
using namespace std;

#define MOTION_THRESHOLD 500

#define ROW 480
#define COL 640


//checks if a certain point p is in the Triangle formed by p0,p1 and p2
bool  pointInTriangle(Point2 p, Point2 p0, Point2 p1, Point2 p2) {

	int s = p0.y() * p2.x() - p0.x() * p2.y() + (p2.y() - p0.y()) * p.x()
			+ (p0.x() - p2.x()) * p.y();

	int t = p0.x() * p1.y() - p0.y() * p1.x() + (p0.y() - p1.y()) * p.x()
			+ (p1.x() - p0.x()) * p.y();

	if ((s < 0) != (t < 0))
		return false;

	int A = -p1.y() * p2.x() + p0.y() * (p2.x() - p1.x())
			+ p0.x() * (p1.y() - p2.y()) + p1.x() * p2.y();
	if (A < 0.0) {
		s = -s;
		t = -t;
		A = -A;
	}
	return s > 0 && t > 0 && (s + t) < A;

}

//Constructor which generates a Quadrangle from four points
Quadrangle::Quadrangle(Point2 xx, Point2 xy, Point2 yx, Point2 yy)

{
	this->xx = xx;
	this->xy = xy;
	this->yx = yx;
	this->yy = yy;

	int i,a;
	//TODO more sophisticated approach
	for(i=0;i<ROW;i++){
		for(a=0;a<COL;a++){

			Point2 p(a, i);
			if(this->hasPoint(p)) allPoints.push_back(p);
		}
	}
}

//checks if a certain point is in the Quadrangle
bool Quadrangle::hasPoint(Point2 x) {

	//return pointInTriangle(x, xx, xy, yy) || pointInTriangle(x, yy, yx, xx);
	return pointInTriangle(x, xx, xy, yy) || pointInTriangle(x, xy, yx, yy);
}

//checks if there is any motion in this seat
bool Quadrangle::checkMotion(Mat diffFrame) {

	unsigned int i;
	int count=0;
	for(i=0;i<allPoints.size();i++){

		Vec3b intensity = diffFrame.at<Vec3b>(allPoints.at(i).y(), allPoints.at(i).x());
		if(intensity.val[0] !=0 || intensity.val[1] !=0 || intensity.val[2] !=0){
				count++;
		}
	}

	return (count > MOTION_THRESHOLD); //only indicate motion if some threshold is passed to reduce false detection
}



