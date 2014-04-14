package se.sjorod.lasbok.skynet;

public class Command {
	public static final int LOCK_ALL = 0;
	public static final int UNLOCK_ALL = 1;
	public static final int LOCK = 2;
	public static final int UNLOCK = 3;
	public static final int UPDATE_SCHEDULE = 4;
	
	private int command;
	private Payload payload;
	
	public Command(int command) {
		this.command = command;
		payload = null;
	}
	
	public Command(int command, Payload payload) {
		this.command = command;
		this.payload = payload;
	}
	
	public int getCommand() {
		return command;
	}
	
	public Payload getPayload() {
		return payload;
	}
	
	public String toString() {
		return payload == null ? "Command: " + command :
				"Command: " + command + ", payload: " + payload.toString();
	}
}