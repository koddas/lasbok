package se.sjorod.lasbok.skynet;

import java.net.InetAddress;

// TODO: Test this class

/**
 * This class represents a Denkovi relay card with 16 relays.
 * 
 * @author johan
 */
public class DenkoviCard16 extends DenkoviCard {
	private static final String OID_1_TO_8 = ".1.3.6.1.4.1.19865.1.2.1.33.0";
	private static final String OID_9_TO_16 = ".1.3.6.1.4.1.19865.1.2.2.33.0";
		
	/**
	 * Creates an instance of DenkoviCard16.
	 * 
	 * @param ip This is the IP address at which the Denkovi card that we
	 * 			 wish to control can be reached. 
	 */
	public DenkoviCard16(InetAddress ip) {
		super(ip);
	}
	
	/**
	 * Switches on a device connected to a Denkovi card.
	 * 
	 * @param device A number between 1 and 16, this represents the relay
	 * 				 onto which the device is attached.
	 * @throws InvalidDeviceException 
	 */
	public void switchOn(int device) throws InvalidDeviceException {
		if (device < 1 || device > 16) {
			throw new InvalidDeviceException();
		}
	}
	
	/**
	 * Switches on a number of devices connected to a Denkovi card.
	 * 
	 * @param device An array of integers, the array of size 1 to 16. Each
	 * 				 integer between 1 and 16, this represents the relay onto
	 * 				 which the devices are attached.
	 * @throws InvalidDeviceException 
	 */
	public void switchOn(int[] devices) throws InvalidDeviceException {
		if (devices.length < 1 || devices.length > 16) {
			throw new InvalidDeviceException();
		}
	}
	
	/**
	 * Switches off a device connected to a Denkovi card.
	 * 
	 * @param device A number between 1 and 16, this represents the relay
	 * 				 onto which our device is attached.
	 */
	public void switchOff(int device) throws InvalidDeviceException {
		if (device < 1 || device > 16) {
			throw new InvalidDeviceException();
		}
	}
	
	/**
	 * Switches off a number of devices connected to a Denkovi card.
	 * 
	 * @param device An array of integers, the array of size 1 to 16. Each
	 * 				 integer between 1 and 16, this represents the relay onto
	 * 				 which the devices are attached.
	 * @throws InvalidDeviceException 
	 */
	public void switchOff(int[] devices) throws InvalidDeviceException {
		if (devices.length < 1 || devices.length > 16) {
			throw new InvalidDeviceException();
		}
	}
	
	
	/**
	 * Set the states for all relays on a Denkovi card.
	 * 
	 * @param deviceStates An array of boolean values, the array of size 16.
	 * 					   Boolean value true switches a relay on, and false
	 * 					   switches it off.
	 * @throws InvalidDeviceException 
	 */
	public void setStates(boolean[] deviceStates) throws InvalidDeviceException {
		if (deviceStates.length != 16) {
			throw new InvalidDeviceException();
		}
		
		relayBitmap = 0;
		for (int i = 0; i < 16; i++) {
			if (deviceStates[i]) {
				relayBitmap += 2^i;
			}
		}
	}
	
	/**
	 * Gets the state for a relay on a Denkovi card.
	 * 
	 * @param device A number between 1 and 16, this represents the relay
	 * 				 onto which the device is attached.
	 * @return Returns true if the relay is set to on, otherwise false.
	 */
	public boolean getState(int device) throws InvalidDeviceException {
		if (device < 1 || device > 16) {
			throw new InvalidDeviceException();
		}
		
		// TODO: Naïve implementation. Fix at a later stage.
		boolean result = false;
		
		return result;
	}
	
	/**
	 * Gets the states of all relays on a Denkovi card.
	 * 
	 * @return An array of boolean values, the array of size 16.
	 * 		   An element is set to true if a relay is on, otherwise false.
	 */
	public boolean[] getStates() {
		// TODO: Implement this.
		
		return null;
	}
}
