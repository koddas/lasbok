package se.sjorod.lasbok.skynet;

import java.net.InetAddress;
import java.net.UnknownHostException;

import org.joda.time.DateTime;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

// TODO: Test this class

/**
 * Represents a door with corresponding lock.
 * 
 * @author johan
 */
public class Door implements Payload {
	private int port;
	private InetAddress card;
	private Logger logger;

	/**
	 * Creates a Door object.
	 * 
	 * @param port
	 * @param card
	 */
	public Door(int port, String card) {
		logger = LoggerFactory.getLogger(Door.class);
		
		this.port = port;
		try {
			this.card = InetAddress.getByName(card);
		} catch (UnknownHostException e) {
			logger.error("Error at " + (new DateTime()).toString());
			logger.error("Couldn't convert string to IP-address: " + card);
			logger.error("Error message: " + e.getMessage());
		}
	}
	
	public Door(int port, InetAddress card) {
		this.port = port;
		this.card = card;
	}
	
	public int getPort() {
		return port;
	}
	
	public InetAddress getCard() {
		return card;
	}
	
	public String toString() {
		return "Door at " + card.getHostAddress() + ", port " + port;
	}
}
