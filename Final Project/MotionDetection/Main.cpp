/*
 * Main.cpp
 *
 *  Created on: Jul 7, 2015
 *      Author: jan
 */

#include "MotionDetector.h"
using namespace cv;
using namespace std;

int main(int argc, char* argv[]) {
	if (argc >= 2) {
		if (argc == 2) {
			MotionDetector md(atoi(argv[1]), "127.0.0.1", "3306");
			md.start();
		} else if (argc == 3) {
			MotionDetector md(atoi(argv[1]), argv[2], "3306");
			md.start();
		} else {
			MotionDetector md(atoi(argv[1]), argv[2], argv[3]);
			md.start();
		}
	} else {
		cout << "usage: " << argv[0] << " ROOM_ID [DB_SERVER_IP] [DB_SERVER_PORT]"
				<< endl;
	}
	return 0;
}

