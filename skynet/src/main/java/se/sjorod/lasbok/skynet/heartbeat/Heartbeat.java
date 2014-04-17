package se.sjorod.lasbok.skynet.heartbeat;

import org.joda.time.DateTime;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import se.sjorod.lasbok.skynet.net.HTTPClient;

// TODO: Test and dcoument this class

public class Heartbeat {
	private Logger logger;
	private HTTPClient client;
	
	public Heartbeat() {
		logger = LoggerFactory.getLogger(Heartbeat.class);
		client = new HTTPClient();
		
		logger.info("Heartbeat initialized at " +
					(new DateTime()).toString());
	}
	
	private void sendHeartbeat() {
		logger.info("Heartbeat sent at " + (new DateTime()).toString());
		
		// TODO: Actually send a heartbeat signal. Also, where should we send it?
	}
}
