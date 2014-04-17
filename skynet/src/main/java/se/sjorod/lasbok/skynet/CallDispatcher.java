package se.sjorod.lasbok.skynet;

import org.joda.time.DateTime;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

// TODO: Test and document this class

public class CallDispatcher {
	private DoorLocker locker;
	private Logger logger;
	
	public CallDispatcher() {
		locker = DoorLocker.getInstance();
		logger = LoggerFactory.getLogger(CallDispatcher.class);
	}
	
	public void dispatch(Command command) {
		switch (command.getCommand()) {
		case Command.LOCK_ALL:
			break;
		case Command.UNLOCK_ALL:
			break;
		case Command.LOCK:
			try {
				locker.lockDoor((Door) command.getPayload());
			} catch (DoorLockException e) {
				logger.error("Unable to lock " +
							command.getPayload().toString() + " at " +
							(new DateTime()).toString());
				logger.error("Error message: " + e.getMessage());
			}
			break;
		case Command.UNLOCK:
			try {
				locker.unlockDoor((Door) command.getPayload());
			} catch (DoorLockException e) {
				logger.error("Unable to unlock " +
							command.getPayload().toString() + " at " +
							(new DateTime()).toString());
				logger.error("Error message: " + e.getMessage());
			}
			break;
		case Command.UPDATE_SCHEDULE:
			break;
		default:
			logger.error("Unknown command " + command.toString() + " at " +
						(new DateTime()).toString());
		}
	}
}
