package se.sjorod.lasbok.skynet;

/**
 * The Command class represents a command sent to the command dispatcher.
 * 
 * @author johan
 */
public class Command {
	public static final int LOCK_ALL = 0;
	public static final int UNLOCK_ALL = 1;
	public static final int LOCK = 2;
	public static final int UNLOCK = 3;
	public static final int UPDATE_SCHEDULE = 4;
	
	private int command;
	private Payload payload;
	
	/**
	 * Creates an instance of Command.
	 * 
	 * @param command The command to send.
	 * 
	 * @throws IllegalArgumentException if the arguments were illegal.
	 */
	public Command(int command) throws IllegalArgumentException {
		if (command < 0 || command > UPDATE_SCHEDULE) {
			throw new IllegalArgumentException();
		}
		
		this.command = command;
		payload = null;
	}
	
	/**
	 * Creates an instance of Command.
	 * 
	 * @param command The command to send.
	 * @param payload The payload to send with the command.
	 * 
	 * @throws IllegalArgumentException if the arguments were illegal.
	 */
	public Command(int command, Payload payload) throws IllegalArgumentException {
		if (command < 0 || command > UPDATE_SCHEDULE) {
			throw new IllegalArgumentException();
		}
		
		this.command = command;
		this.payload = payload;
	}
	
	/**
	 * Gets the command sent with the object.
	 * 
	 * @return An integer representing the command.
	 */
	public int getCommand() {
		return command;
	}
	
	/**
	 * Gets the payload sent with the command.
	 * 
	 * @return The payload object.
	 */
	public Payload getPayload() {
		return payload;
	}
	
	@Override
	public String toString() {
		return payload == null ? "Command: " + command :
				"Command: " + command + ", payload: " + payload.toString();
	}
}