/*
 * phautoop.hpp
 *
 *  Created on: 20 Jan 2013
 *      Author: philix
 */

#ifndef _PHAUTOOP_SESSION_HPP_
#define _PHAUTOOP_SESSION_HPP_

#include "phautoop/config.hpp"

#include "kul/threading.hpp"

namespace phautoop{

class Sessions;

class Session{
	private:
		int to;
	public:
		Session() : to(Config::TIMEOUT()){
			LOG(INFO) << "SESSION CREATED"; 
		}
		~Session(){ 
			LOG(INFO) << "SESSION DESTROYED"; 
		}
		void refresh(){ this->to = Config::TIMEOUT(); }
		const bool alive(){ return to > 0; }
		void tick(){
			LOG(INFO) << "TICK"; 
			to--;
		}
};

class SessionsThreadObject{
	private:
		kul::StringToTGMap<std::pair<std::shared_ptr<Session>, unsigned int> >* ss;
		SessionsThreadObject(kul::StringToTGMap<std::pair<std::shared_ptr<Session>, unsigned int> >* ss) : ss(ss){}
	public:
		friend class Sessions;
		void operator()(){
			while(true){
				//scopelock
				std::vector<std::string> erase;
				for(std::pair<std::string, std::pair<std::shared_ptr<Session>, unsigned int> > p : (*ss)){
					p.second.first->tick();
					if(!p.second.first->alive()) erase.push_back(p.first);					
				}
				for(const std::string& e : erase) ss->erase(e);

				kul::threading::ThreaderService::sleep(1000);
			}			
		}
};

class Sessions{
	private:
		static Sessions* instance;
		std::shared_ptr<kul::Thread> thread;
		kul::StringToTGMap<std::pair<std::shared_ptr<Session>, unsigned int> > sessions;
		SessionsThreadObject sto;
		kul::Ref<SessionsThreadObject> ref;

		Sessions() : sto(&sessions), ref(sto){
			sessions.setDeletedKey("SESSIONS");
			thread.reset(new kul::Thread(ref));
			thread->run();
		}
	public:
		static Sessions* INSTANCE(){ if(!instance) instance = new Sessions(); return instance;}
		const void addSession(const std::string& id){
			if(!sessions.count(id))				 
				sessions[id] = std::pair<std::shared_ptr<Session>, unsigned int>(std::shared_ptr<Session>(new Session()), Config::TIMEOUT());
		}

		const void refresh(const std::string& id){
			if(sessions.count(id)){
				//scopelock
				if(sessions.count(id))
					(*sessions.find(id)).second.first->refresh();
			}
		}

};


};
#endif /* _PHAUTOOP_SERVER_HPP_ */
