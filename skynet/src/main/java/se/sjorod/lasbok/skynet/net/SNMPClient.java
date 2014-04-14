package se.sjorod.lasbok.skynet.net;

import java.net.InetAddress;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import se.sjorod.lasbok.skynet.DenkoviCard;

import com.adventnet.snmp.snmp2.SnmpAPI;
import com.adventnet.snmp.snmp2.SnmpSession;

/**
 * This class is responsible for the communication with the Denkovi relay
 * boards. It uses the API provided by Denkovi, and is more or less a wrapper
 * that is actually usable by human beings.
 * 
 * @author johan
 *
 */
public class SNMPClient {
	private Logger logger;
	private SnmpAPI api;
	private SnmpSession session;

	
	
	/**
	 * Creates an instance of SNMPClient.
	 */
	public SNMPClient() {
		logger = LoggerFactory.getLogger(SNMPClient.class);
		api = new SnmpAPI();
		session = new SnmpSession(api);
	}
	
	public void setStates(DenkoviCard card) {
		
	}
	
	public boolean getStates(DenkoviCard card) {
		return false;
	}
}
