package se.sjorod.lasbok.skynet.tests;

import static org.junit.Assert.*;

import mockit.*;

import org.junit.Test;

import se.sjorod.lasbok.skynet.Command;
import se.sjorod.lasbok.skynet.Payload;

public class CommandTest {
	@Test
	public void testCommandInt() {
		Command command = null;
		
		try {
			command = new Command(Command.UNLOCK);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
		
		assertEquals(Command.UNLOCK, command.getCommand());
	}

	@Test
	public void testCommandIntNegativeValue() {
		try {
			Command command = new Command(-1);
			fail("This shouldn't happen");
		} catch (IllegalArgumentException e) {}
	}

	@Test
	public void testCommandIntZero() {
		Command command = null;
		
		try {
			command = new Command(0);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
		
		assertEquals(0, command.getCommand());
	}

	@Test
	public void testCommandInHighestValue() {
		Command command = null;
		
		try {
			command = new Command(Command.UPDATE_SCHEDULE);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
		
		assertEquals(Command.UPDATE_SCHEDULE, command.getCommand());
	}

	@Test
	public void testCommandIntValueTooHigh() {
		try {
			Command command = new Command(Command.UPDATE_SCHEDULE + 1);
			fail("This shouldn't happen");
		} catch (IllegalArgumentException e) {}
	}

	@Test
	public void testCommandIntPayload() {
		Payload payload = new MockUp<Payload>() {}.getMockInstance();
		try {
			Command command = new Command(Command.UNLOCK, payload);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}

	@Test
	public void testCommandIntNegativeValuePayload() {
		Payload payload = new MockUp<Payload>() {}.getMockInstance();
		try {
			Command command = new Command(-1, payload);
			fail("This shouldn't happen");
		} catch (IllegalArgumentException e) {}
	}

	@Test
	public void testCommandIntZeroPayload() {
		Payload payload = new MockUp<Payload>() {}.getMockInstance();
		try {
			Command command = new Command(0, payload);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}

	@Test
	public void testCommandInHighestValuePayload() {
		Payload payload = new MockUp<Payload>() {}.getMockInstance();
		try {
			Command command = new Command(Command.UPDATE_SCHEDULE, payload);
		} catch (IllegalArgumentException e) {
			fail("This shouldn't happen");
		}
	}

	@Test
	public void testCommandIntValueTooHighPayload() {
		Payload payload = new MockUp<Payload>() {}.getMockInstance();
		try {
			Command command = new Command(Command.UPDATE_SCHEDULE + 1, payload);
			fail("This shouldn't happen");
		} catch (IllegalArgumentException e) {}
	}

	@Test
	public void testGetCommand() {
		Command command = new Command(Command.UNLOCK);
		
		assertEquals(Command.UNLOCK, command.getCommand());
	}

	@Test
	public void testGetPayload() {
		Payload payload = new MockUp<Payload>() {}.getMockInstance();
		Command command = new Command(Command.UNLOCK, payload);
		
		assertNotNull(command.getPayload());
	}

	@Test
	public void testToString() {
		Command command = new Command(Command.UNLOCK);
		
		assertEquals("Command: 3", command.toString());
	}

//	@Injectable Payload payload;
//	@Test
//	public void testToStringWithPayload() {
//		Command command = new Command(Command.UNLOCK);
//		
//		new Expectations() {{
//			payload.toString();
//			result = "mock";
//		}};
//		
//		assertEquals("Command: 3, payload: mock", command.toString());
//	}

}
