package se.sjorod.lasbok.skynet;

import org.joda.time.DateTime;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

// TODO: Test this class

public class SkynetStarter {
	private Logger logger;

	public SkynetStarter() {
		logger = LoggerFactory.getLogger(SkynetStarter.class);
	}

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		Logger logger = LoggerFactory.getLogger(SkynetStarter.class);
		logger.info("Skynet started at "+ (new DateTime()).toString());
		
		// TODO: Start up network part, heartbeat, call dispatcher, door locker and scheduler
	}
}
