/*
 * server.hpp
 *
 *  Created on: 20 Jan 2013
 *      Author: philix
 */

#ifndef _PHAUTOP_SERVER_HPP_
#define _PHAUTOP_SERVER_HPP_

#include "phautop/config.hpp"

#include <stdio.h>
#include <sys/types.h> 
#include <sys/socket.h>
#include <netinet/in.h>

namespace phautop{


class Server{
	private:
		const int port;
	public:
		Server(const int& port) : port(port){}
		void start();
		void handle(const std::string& data);
};


};
#endif /* _PHAUTOP_SERVER_HPP_ */
