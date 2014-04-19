package se.sjorod.lasbok.skynet;

import org.joda.time.DateTime;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Represents a site.
 * 
 * @author johan
 */
public class Site implements Payload {
	private int id;
	private Logger logger;
	
	/**
	 * Creates a Site object.
	 * 
	 * @param id The id number.
	 */
	public Site(int id) {
		logger = LoggerFactory.getLogger(Site.class);
		
		if (id < 0) {
			logger.error("Error at " + (new DateTime()).toString());
			logger.error("Bad site number: " + id);
			throw new IllegalArgumentException();
		}
		
		this.id = id;
	}
	
	/**
	 * Returns the id number of the site.
	 * 
	 * @return The id number.
	 */
	public int getId() {
		return id;
	}
	
	@Override
	public String toString() {
		return "Site: " + id;
	}
}
