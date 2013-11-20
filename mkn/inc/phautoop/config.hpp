/*
 * server.hpp
 *
 *  Created on: 20 Jan 2013
 *      Author: philix
 */

#ifndef _PHAUTOOP_CONFIG_HPP_
#define _PHAUTOOP_CONFIG_HPP_

#include "glog/logging.h"

#include "kul/os.hpp"
#include "kul/cli.hpp"
#include "kul/scm.hpp"
#include "kul/xml.hpp"
#include "kul/except.hpp"

namespace phautoop{

class Exception : public kul::Exception{
	public:
		Exception(const char*f, const int l, std::string s) : kul::Exception(f, l, s){}
};

class Config{
	public:
		static const int TIMEOUT(){ return 10;}
};


};
#endif /* _PHAUTOOP_CONFIG_HPP_ */
