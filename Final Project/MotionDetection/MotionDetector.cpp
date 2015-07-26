/*
 * MotionDetector.cpp
 *
 *  Created on: Jun 17, 2015
 *      Author: jan
 */

#include "Quadrangle.h"
#include "Point.h"
#include "MotionDetector.h"
#include "ImageServer.h"
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/imgproc/imgproc.hpp>
#include <iostream>
#include <string.h>
using namespace cv;
using namespace std;

#define DB_WRITE_INTERVAL (60*1)
#define MOTION_THRESHOLD_FRAME_COUNT DB_WRITE_INTERVAL/2

MotionDetector::MotionDetector(int room_id, string ip, string port) {
	this->room_id = room_id;

	dbConnector.setServerIP(ip);
	dbConnector.setServerPort(port);

	dbConnector.setRoomID(room_id);
	dbConnector.registerNode(IMAGE_SERVER_PORT);
	dbConnector.getCoordinates(this);

	counters = new int[allQuadrangles.size()];
	for (unsigned int i = 0; i < allQuadrangles.size(); i++) {
		counters[i] = 0;
	}
}

void MotionDetector::addToList(Quadrangle q, int id) {
	allQuadrangles.push_back(q);
	seatID.push_back(id);
}

void MotionDetector::start() {
  ImageServer* imageServer = ImageServer::startImageServer();

	int counter=0;

	VideoCapture stream1(0); //0 is the id of video device.(0 if there is only one camera)

	if (!stream1.isOpened()) { //check if video device has been initialised
		cout << "cannot open camera";
	}

	Mat previousFrame; //frame to which we compare the next captured frame
	stream1.read(previousFrame);
	cvtColor(previousFrame, previousFrame, CV_RGB2GRAY); //convert frame from RGB to grey

	//unconditional loop
	while (true) {
		Mat nextFrame;

		//for (int i = 0; i < 2; i++)
			stream1.read(nextFrame);
		Mat imServerFrame = nextFrame.clone(); //frame which will be presented in the web interface
		imageServer->setFrame(imServerFrame);
		cvtColor(nextFrame, nextFrame, CV_RGB2GRAY); 

		Mat diffFrame;
		absdiff(nextFrame, previousFrame, diffFrame); //calculates the absolute difference between the two grey frames
		threshold(diffFrame, diffFrame, 80, 255, THRESH_BINARY); //threshold to eliminate noise
		previousFrame = nextFrame.clone();
		imshow("cam", diffFrame); //for debugging only -> shows frame in a seperate window

		checkForMotion(diffFrame, counter == 0);

		if (waitKey(1000) == 27) //wait for 'esc' key press for 1s. If 'esc' key is pressed, break loop
				{
			cout << "esc key is pressed by user" << endl;
			break;
		}
		counter++;
		counter= counter % DB_WRITE_INTERVAL;
	}
}


//iterates over all seats and checks for motion on the seats
void MotionDetector::checkForMotion(Mat diffFrame, bool sendToDB) {
	unsigned int i;
	for (i = 0; i < allQuadrangles.size(); i++) {

		if (allQuadrangles[i].checkMotion(diffFrame)) {
		  if (counters[i] <= MOTION_THRESHOLD_FRAME_COUNT*2) {
			counters[i]++;
		  }
		} else {
		  if (counters[i] > 0) {
		    counters[i]--;
		  }
		}
		if (sendToDB) {
			if (counters[i] > MOTION_THRESHOLD_FRAME_COUNT) {
				cout << "occupied "  << i << endl;
				dbConnector.writeToDB(seatID.at(i), true);
			} else {
				cout << "free "  << i << endl;
			  dbConnector.writeToDB(seatID.at(i), false);
			}
		}
	}
}

