package se.sjorod.lasbok.skynet.tests;

import static org.junit.Assert.*;

import mockit.Injectable;

import org.junit.Test;

import se.sjorod.lasbok.skynet.CallDispatcher;
import se.sjorod.lasbok.skynet.DoorLocker;

public class CallDispatcherTest {

	@Injectable DoorLocker locker;
	
	@Test
	public void testDispatch() {
		CallDispatcher dispatcher = new CallDispatcher();
	}

}
