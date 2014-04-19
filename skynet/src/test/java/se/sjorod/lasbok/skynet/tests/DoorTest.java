package se.sjorod.lasbok.skynet.tests;

import static org.junit.Assert.*;

import java.net.InetAddress;
import java.net.UnknownHostException;

import org.junit.Test;

import se.sjorod.lasbok.skynet.Door;

public class DoorTest {

	@Test
	public void testDoorIntString() {
		try {
			Door door = new Door(1, "127.0.0.1");
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}

	@Test
	public void testDoorIntZeroString() {
		try {
			Door door = new Door(0, "127.0.0.1");
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}

	@Test
	public void testDoorIntNegativeString() {
		try {
			Door door = new Door(-1, "127.0.0.1");
			fail("This shouldn't happen");
		} catch (IllegalArgumentException e) {}
	}

	@Test
	public void testDoorIntStringIllegalAddress() {
		try {
			Door door = new Door(-1, "127.0.0.1-horse");
			fail("This shouldn't happen");
		} catch (IllegalArgumentException e) {}
	}

	@Test
	public void testDoorIntInetAddress() {
		InetAddress address = null;
		
		try {
			address = InetAddress.getByName("127.0.0.1");
		} catch (UnknownHostException e1) {}
		
		try {
			Door door = new Door(1, address);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}

	@Test
	public void testDoorIntZeroInetAddress() {
		InetAddress address = null;
		
		try {
			address = InetAddress.getByName("127.0.0.1");
		} catch (UnknownHostException e1) {}
		
		try {
			Door door = new Door(0, address);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}

	@Test
	public void testDoorIntNegativeInetAddress() {
		InetAddress address = null;
		
		try {
			address = InetAddress.getByName("127.0.0.1");
		} catch (UnknownHostException e1) {}
		
		try {
			Door door = new Door(-1, address);
			fail("This shouldn't happen");
		} catch (IllegalArgumentException e) {}
	}

	@Test
	public void testGetPort() {
		Door door = new Door(1, "127.0.0.1");
		
		assertEquals(1, door.getPort());
	}

	@Test
	public void testGetCard() {
		InetAddress address = null;
		Door door = null;
		
		try {
			address = InetAddress.getByName("127.0.0.1");
		} catch (UnknownHostException e1) {}
		
		door = new Door(1, address);
		
		assertEquals(address, door.getCard());
	}

	@Test
	public void testToString() {
		Door door = new Door(1, "127.0.0.1");
		
		assertEquals("Door at 127.0.0.1, port 1", door.toString());
	}

}
