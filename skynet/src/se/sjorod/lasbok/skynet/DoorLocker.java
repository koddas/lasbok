package se.sjorod.lasbok.skynet;

import org.joda.time.DateTime;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import se.sjorod.lasbok.skynet.net.HTTPClient;

/**
 * This class is used for locking and unlocking doors.
 * 
 * @author johan
 *
 */
public class DoorLocker {
	private HTTPClient client;
	private Logger logger;
	
	private DoorLocker() {
		client = new HTTPClient();
		logger = LoggerFactory.getLogger(SkynetStarter.class);
	}
	
	private static class DoorLockerHolder {
		public static final DoorLocker INSTANCE = new DoorLocker();
	}
	
	public static DoorLocker getInstance() {
		return DoorLockerHolder.INSTANCE;
	}

	/**
	 * Unlocks a door.
	 * 
	 * @param door The door that should be locked.
	 * @throws DoorLockException Thrown if the door couldn't be locked.
	 */
	public void lockDoor(Door door) throws DoorLockException {
		logger.info("Locked door " + door.toString() + " at " +
					(new DateTime()).toString());
	}
	
	/**
	 * Locks a door.
	 * 
	 * @param door The door that should be unlocked.
	 * @throws DoorLockException Thrown if the door couldn't be unlocked.
	 */
	public void unlockDoor(Door door) throws DoorLockException {
		logger.info("Locked door " + door.toString() + " at " +
				(new DateTime()).toString());
		
	}
}
