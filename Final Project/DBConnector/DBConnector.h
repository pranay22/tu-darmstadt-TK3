#ifndef DBCONNECTOR_DBCONNECTOR_H_
#define DBCONNECTOR_DBCONNECTOR_H_

#include <stdlib.h>
#include <iostream>
#include <string>

#include <mysql_connection.h>

#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/resultset.h>
#include <cppconn/statement.h>

/*
 * This is the class that handles writing into the sql tables.
 * The DB specifier, such as serverIP, DBName and user/password are class variables
 * that come with their own setter.
 * The writeToDB method always tries to first write into a 'history' table
 * and then to update the 'seats'-table of the specified DB.
 */
class DBConnector{

private:
	std::string serverIP;
	std::string serverPort;
	std::string user;
	std::string pass;
	std::string database;
	std::string roomID;


public:
	DBConnector();
	void writeToDB(int seat_id, bool occupied);
	void setServerIP(std::string serverIP);
	std::string getServerIP();
	void setServerPort(std::string serverPort);
	std::string getServerPort();
	void setDBUser(std::string user);
	void setDBPassword(std::string password);
	void setDataBase(std::string dbName);
	void setRoomID(std::string roomID);
	std::string getRoomID();
	int getNumberOfSeats();
	double getCoordinate(std::string pointID, int seatID);

};

#endif
