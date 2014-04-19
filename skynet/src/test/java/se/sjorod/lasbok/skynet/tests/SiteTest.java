package se.sjorod.lasbok.skynet.tests;

import static org.junit.Assert.*;

import org.junit.Test;

import se.sjorod.lasbok.skynet.Site;

public class SiteTest {

	@Test
	public void testSite() {
		try {
			Site site = new Site(2);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}

	@Test
	public void testSiteNegativeValue() {
		try {
			Site site = new Site(-1);
			fail("This shouldn't happen");
		} catch (IllegalArgumentException e) {}
	}

	@Test
	public void testSiteZeroValue() {
		try {
			Site site = new Site(0);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}
	
	@Test
	public void testGetId() {
		Site site = new Site(2);
		
		assertEquals(2, site.getId());
	}

	@Test
	public void testToString() {
		Site site = new Site(2);
		
		assertEquals("Site: 2", site.toString());
	}

}
