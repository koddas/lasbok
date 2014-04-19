package se.sjorod.lasbok.skynet.tests;

import static org.junit.Assert.*;

import mockit.Expectations;
import mockit.Injectable;

import org.junit.Test;

import se.sjorod.lasbok.skynet.Door;
import se.sjorod.lasbok.skynet.DoorLocker;
import se.sjorod.lasbok.skynet.net.HTTPClient;

public class DoorLockerTest {

	@Test
	public void testGetInstance() {
		DoorLocker locker = DoorLocker.getInstance();
		
		assertNotNull(locker);
	}

	@Test
	public void testGetInstanceVerifySingletonness() {
		DoorLocker locker = DoorLocker.getInstance();
		DoorLocker locker2 = DoorLocker.getInstance();
		
		assertSame(locker, locker2);
	}

	@Injectable HTTPClient client;
	@Test
	public void testLockDoor() {
		DoorLocker locker = DoorLocker.getInstance();
		Door door = new Door(1, "127.0.0.1");
		
		new Expectations() {{
			client.hashCode();
			result = 1;
		}};
	}

	@Test
	public void testLockDoorNonExistingDoor() {
		DoorLocker locker = DoorLocker.getInstance();
		Door door = new Door(1, "127.0.0.1");
	}

	@Test
	public void testUnlockDoor() {
		DoorLocker locker = DoorLocker.getInstance();
		Door door = new Door(1, "127.0.0.1");
	}

	@Test
	public void testUnlockDoorNonExistingDoor() {
		DoorLocker locker = DoorLocker.getInstance();
		Door door = new Door(1, "127.0.0.1");
	}

	@Test
	public void testLockDoorsAtSite() {
		DoorLocker locker = DoorLocker.getInstance();
	}

	@Test
	public void testLockDoorsAtSiteNonExistingSite() {
		DoorLocker locker = DoorLocker.getInstance();
	}

	@Test
	public void testUnlockDoorsAtSite() {
		DoorLocker locker = DoorLocker.getInstance();
	}

	@Test
	public void testUnlockDoorsAtSiteNonExistingSite() {
		DoorLocker locker = DoorLocker.getInstance();
	}

}
