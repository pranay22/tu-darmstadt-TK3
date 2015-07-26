/*
 * MotionDetector.h
 *
 *  Created on: Jun 22, 2015
 *      Author: jan
 */

#ifndef SRC_MOTIONDETECTOR_H_
#define SRC_MOTIONDETECTOR_H_

#include <iostream>
#include <math.h>
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/imgproc/imgproc.hpp>
#include "Point.h"
#include "Quadrangle.h"
#include "DBConnector.h"
#include <vector>


class MotionDetector {
private:
	int room_id;

	vector<Quadrangle> allQuadrangles;
	vector<int> seatID;

	DBConnector dbConnector;

	Mat previousFrame;

	int *counters;

public:
	MotionDetector(int room_id, std::string ip, std::string port);
	void addToList(Quadrangle q, int id);
	void start();

	void checkForMotion(Mat diffFrame, bool sendToDB);
};



#endif /* SRC_MOTIONDETECTOR_H_ */
