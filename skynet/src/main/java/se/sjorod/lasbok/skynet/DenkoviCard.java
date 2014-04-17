package se.sjorod.lasbok.skynet;

import java.net.InetAddress;

/**
 * This class represents a Denkovi relay card. As the actual Denkovi card
 * incarnations come with different numbers of relays, this class is
 * abstract, and in order to use it, the programmer will have to use one of
 * its subclasses.
 * 
 * @author johan
 */
public abstract class DenkoviCard {
	private InetAddress ipaddress;
	private int port;
	private String community;
	
	protected int relayBitmap;
	
	/**
	 * Creates an instance of DenkoviCard.
	 * 
	 * @param ip This is the IP address at which the Denkovi card that we
	 * 			 wish to control can be reached. 
	 */
	public DenkoviCard(InetAddress ip) {
		ipaddress = ip;
		port = 161;
		community = "private";
		
		relayBitmap = 0;
	}
	
	/**
	 * Returns the IP address needed at which this card can be reached.
	 * 
	 * @return The IP address needed at which this card can be reached
	 */
	public InetAddress getIPAddress() {
		return ipaddress;
	}
	
	/**
	 * Returns the port number to which this card listens.
	 * 
	 * @return The port number to which this card listens.
	 */
	public int getPort() {
		return port;
	}
	
	/**
	 * Returns the community string used by this card.
	 * 
	 * @return The community string used by this card.
	 */
	public String getCommunity() {
		return community;
	}
	
	/**
	 * Switches on a device connected to a Denkovi card.
	 * 
	 * @param device Represents the relay onto which the device is attached.
	 * @throws InvalidDeviceException 
	 */
	public void switchOn(int device) throws InvalidDeviceException {}
	
	/**
	 * Switches on a number of devices connected to a Denkovi card.
	 * 
	 * @param device An array of integers, represents the relay onto
	 * 				 which the devices are attached.
	 * @throws InvalidDeviceException 
	 */
	public void switchOn(int[] devices) throws InvalidDeviceException {}
	
	/**
	 * Switches off a device connected to a Denkovi card.
	 * 
	 * @param device Represents the relay onto which our device is attached.
	 */
	public void switchOff(int device) throws InvalidDeviceException {}
	
	/**
	 * Switches off a number of devices connected to a Denkovi card.
	 * 
	 * @param device An array of integers, this represents the relay onto
	 * 				 which the devices are attached.
	 * @throws InvalidDeviceException 
	 */
	public void switchOff(int[] devices) throws InvalidDeviceException {}
	
	/**
	 * Set the states for all relays on a Denkovi card.
	 * 
	 * @param deviceStates An array of boolean values.
	 * 					   Boolean value true switches a relay on, and false
	 * 					   switches it off.
	 * @throws InvalidDeviceException 
	 */
	public void setStates(boolean[] deviceStates) throws InvalidDeviceException {}
	
	/**
	 * Gets the state for a relay on a Denkovi card.
	 * 
	 * @param device This represents the relay onto which the device is
	 * 				 attached.
	 * @return Returns true if the relay is set to on, otherwise false.
	 */
	public boolean getState(int device) throws InvalidDeviceException {
		return false;
	}
	
	/**
	 * Gets the states of all relays on a Denkovi card.
	 * 
	 * @return An array of boolean values. An element is set to true if a
	 * 		   relay is on, otherwise false.
	 */
	public boolean[] getStates() {
		return null;
	}
	
	/**
	 * Overrides the toString method of {@link java.lang.Object}.
	 * 
	 * @return A string representing this object instance.
	 */
	public String toString() {
		return "DenkoviCard:\n" +
				"IP address: " + ipaddress.getHostAddress() + "\n" +
				"Port: " + port + "\n" +
				"Community: " + community + "\n" +
				"Relay map: " + relayBitmap;
	}
}
