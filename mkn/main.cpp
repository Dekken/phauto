

#include "phautop/session.hpp"
#include "phautop/server.hpp"





int main( int argc, char *argv[] ){
	google::InitGoogleLogging(argv[0]);

	phautop::Sessions* sessions = phautop::Sessions::INSTANCE();
	sessions->addSession("KAKOW");

	

	phautop::Server server(6666);
	server.start();
}