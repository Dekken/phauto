

#include "phautoop/server.hpp"

// Inspiration taken from http://www.tutorialspoint.com/unix_sockets/socket_server_example.htm
void phautoop::Server::start(){
	int sockfd, newsockfd, portno;
	socklen_t clilen;
	char buffer[256];
	struct sockaddr_in serv_addr, cli_addr;
	int  n;

	sockfd = socket(AF_INET, SOCK_STREAM, 0);
	if (sockfd < 0){
		perror("ERROR opening socket");
		exit(1);
	}

	bzero((char *) &serv_addr, sizeof(serv_addr));
	portno = this->port;
	serv_addr.sin_family = AF_INET;
	serv_addr.sin_addr.s_addr = INADDR_ANY;
	serv_addr.sin_port = htons(portno); 
 	
	if (bind(sockfd, (struct sockaddr *) &serv_addr, sizeof(serv_addr)) < 0){
		 perror("ERROR on binding");
		 exit(1);
	}
	listen(sockfd,5);
	clilen = sizeof(cli_addr);
	while(1){
		newsockfd = accept(sockfd, (struct sockaddr *) &cli_addr, &clilen);
		if (newsockfd < 0){
			perror("ERROR on accept");
			exit(1);
		}

		bzero(buffer,256);
		n = read(newsockfd,buffer,255);
	 	if (n < 0) perror("ERROR reading from socket");
	 	//LOG(INFO) << "buffer: " << buffer;
	 	std::string b(buffer);
	 	std::string d = kul::String::split(b, kul::OS::newLine())[0];
	 	
	 	d = d.substr(d.find("/?") + 2);
	 	d = d.substr(0, d.rfind(" "));
	 	kul::String::replaceAll(d, "%20", " ");
	 	while(d.find("  ") != std::string::npos)
	 		kul::String::replaceAll(d, "  ", " ");

	 	handle(d);

		close(newsockfd);
	}
}
void phautoop::Server::handle(const std::string& data){
	LOG(INFO) << "data: " << data;
}