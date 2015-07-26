#include "ImageServer.h"

#include <iostream>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <pthread.h>

using namespace std;
using namespace cv;

ImageServer::ImageServer() {
	struct sockaddr_in server;

	if ((sock = socket(PF_INET, SOCK_STREAM, IPPROTO_TCP)) < 0) {
		cerr << "could not create socket" << endl;
	}

	memset(&server, 0, sizeof(server));
	server.sin_family = AF_INET;
	server.sin_addr.s_addr = htonl( INADDR_ANY);
	server.sin_port = htons(9090);

	if (bind(sock, (struct sockaddr*) &server, sizeof(server)) < 0) {
		cerr << "could not bind socket" << endl;
		return;
	}
	if (listen(sock, 5) == -1) {
		cerr << "error in listen" << endl;
		return;
	}
}

void ImageServer::start() {
	while (1) {
		struct sockaddr_in client;
		unsigned int len = sizeof(client);
		int clt_sock = accept(sock, (struct sockaddr*) &client, &len);
		if (clt_sock < 0) {
			cerr << "accept error" << endl;
			break;
		} else {
			unsigned char buf[1024];
			int n = read(clt_sock, buf, 1024);
			//cout << "got n:" << n << " bytes" << endl;

			//jpeg encoding
			vector<uchar> buff;  //buffer for coding
			vector<int> param = vector<int>(2);
			param[0] = CV_IMWRITE_JPEG_QUALITY;
			param[1] = 95;  //default(95) 0-100

			imencode(".jpg", frame, buff, param);

			write(clt_sock, "HTTP/1.0 200 OK\n\n", 17);
			//write(clt_sock, "<html><body>hi</body></html>\n",
			//strlen("<html><body>hi</body></html>\n"));
			write(clt_sock, &buff[0], buff.size());
			close(clt_sock);
		}
	}
}

ImageServer::~ImageServer() {
	close(sock);
}

void ImageServer::setFrame(cv::Mat frame) {
	this->frame = frame;
}

void* startImageServerHelper(void* _imageServer) {
	ImageServer* imageServer = (ImageServer*) _imageServer;
	imageServer->start();
	return NULL;
}

ImageServer* ImageServer::startImageServer() {
	ImageServer* imageServer = new ImageServer();

	pthread_t p;
	pthread_create(&p, NULL, startImageServerHelper, imageServer);

	return imageServer;
}
