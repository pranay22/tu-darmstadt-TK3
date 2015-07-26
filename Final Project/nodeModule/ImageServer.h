/*
 ImageServer.h
 */
#ifndef IMAGESERVER_H_
#define IMAGESERVER_H_

#include <cv.h>
#include <highgui.h>

class ImageServer {
public:
	ImageServer();
	virtual ~ImageServer();
	void start();
	void setFrame(cv::Mat frame);

	static ImageServer* startImageServer();

private:
	int sock;

	cv::Mat frame;
};

#endif /* IMAGESERVER_H_ */
