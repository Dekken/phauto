

#include "phautoop/session.hpp"
#include "phautoop/server.hpp"





int main( int argc, char *argv[] ){
	google::InitGoogleLogging(argv[0]);

	phautoop::Sessions* sessions = phautoop::Sessions::INSTANCE();
	sessions->addSession("KAKOW");

	

	phautoop::Server server(6666);
	server.start();
}