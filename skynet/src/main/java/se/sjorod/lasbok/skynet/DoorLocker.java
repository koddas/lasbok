package se.sjorod.lasbok.skynet;

import org.joda.time.DateTime;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import se.sjorod.lasbok.skynet.net.HTTPClient;

// TODO: Test this class

/**
 * This class is used for locking and unlocking doors. This class is
 * realised as a singleton.
 * 
 * @author johan
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
	
	/**
	 * Gets a reference to the DoorLocker instance.
	 * 
	 * @return A reference to a DoorLocker object.
	 */
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
		// TODO: Do the lock call
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
		// TODO: Do the unlock call
	}
	
	/**
	 * Locks all doors at a site.
	 * 
	 * @param site The site to lock down.
	 */
	public void lockDoorsAtSite(Site site) {
		logger.info("Locked all doors at " + site.toString() + " at " +
				(new DateTime()).toString());
		// TODO: Do the lock calls
	}
	
	/**
	 * Unlocks all doors at a site.
	 * 
	 * @param site The site to unlock.
	 */
	public void unlockDoorsAtSite(Site site) {
		logger.info("Unlocked all doors at " + site.toString() + " at " +
				(new DateTime()).toString());
		// TODO: Do the unlock calls
	}
}
