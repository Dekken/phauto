/*
 * phautoop.hpp
 *
 *  Created on: 20 Jan 2013
 *      Author: philix
 */

#ifndef _PHAUTOOP_SERVER_HPP_
#define _PHAUTOOP_SERVER_HPP_

#include "phautoop/config.hpp"

#include <stdio.h>
#include <sys/types.h> 
#include <sys/socket.h>
#include <netinet/in.h>

namespace phautoop{


class Server{
	private:
		const int port;
	public:
		Server(const int& port) : port(port){}
		void start();
		void handle(const std::string& data);
};


};
#endif /* _PHAUTOOP_SERVER_HPP_ */
