/*
 * server.hpp
 *
 *  Created on: 20 Jan 2013
 *      Author: philix
 */

#ifndef _PHAUTOP_CONFIG_HPP_
#define _PHAUTOP_CONFIG_HPP_

#include "kul/os.hpp"
#include "kul/cli.hpp"
#include "kul/scm.hpp"
#include "kul/xml.hpp"
#include "kul/except.hpp"

namespace phautop{

class Exception : public kul::Exception{
	public:
		Exception(const char*f, const int l, std::string s) : kul::Exception(f, l, s){}
};

class Config{
	public:
		static const int TIMEOUT(){ return 10;}
};


};
#endif /* _PHAUTOP_CONFIG_HPP_ */
