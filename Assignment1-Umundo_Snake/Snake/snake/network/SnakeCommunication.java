package snake.network;

import java.util.HashMap;
import java.util.Map;

import org.umundo.core.Discovery;
import org.umundo.core.Discovery.DiscoveryType;
import org.umundo.core.Message;
import org.umundo.core.Node;
import org.umundo.core.SubscriberStub;
import org.umundo.s11n.ITypedGreeter;
import org.umundo.s11n.ITypedReceiver;
import org.umundo.s11n.TypedPublisher;
import org.umundo.s11n.TypedSubscriber;

import snake.core.Board;
import snake.core.Cell;
import snake.core.Snake;
import snake.network.SnakeProtobuf.Position;
import snake.network.SnakeProtobuf.SnakeMsg;

public class SnakeCommunication {
	private final static float SYNC_SEND_THRESHOLD = 0.1f;

	private Discovery disc;
	private Node snakeNode;
	public SnakeReceiver snakeRcv;
	private TypedSubscriber snakeSub;
	private TypedPublisher snakePub;

	private int delaySum;
	private int delayCount;
	private int othersDelayAvgSum;

	private long timeRef;

	private int period;

	private Board board;
	private SnakeCommunicationCallbacks callbacks;

	public SnakeCommunication(Board board, int period,
	    SnakeCommunicationCallbacks callbacks) {
		delaySum = 0;
		delayCount = 0;
		othersDelayAvgSum = 0;
		this.period = period;
		this.board = board;
		this.callbacks = callbacks;

		disc = new Discovery(DiscoveryType.MDNS);

		snakeNode = new Node();
		disc.add(snakeNode);

		snakeRcv = new SnakeReceiver(board, this);
		snakeSub = new TypedSubscriber("snake");
		snakeSub.setReceiver(snakeRcv);
		snakePub = new TypedPublisher("snake");
		snakeSub.registerType(SnakeMsg.class);

		SnakeGreeter greeter = new SnakeGreeter(board, this);
		snakePub.setGreeter(greeter);

		snakeNode.addPublisher(snakePub);
		snakeNode.addSubscriber(snakeSub);
	}

	public int sendSnake(Snake snake, int frameCount) {
		SnakeMsg.Builder snakeMsgBuilder = SnakeMsg.newBuilder()
				.setFrameCount(frameCount).setUUID(snakeSub.getUUID());
		//had to change it to snakeSub.getUUID() for Greeter...dont know if this is good :D
		for (Cell c : snake.getSnakeCells()) {
			Position cellPosition = Position.newBuilder().setRow(c.getRow())
					.setCol(c.getCol()).build();
			snakeMsgBuilder.addSnakePartList(cellPosition);
		}

		if (board.isMyApple()) {
			Cell c = board.getApplePosition();
			Position applePosition = Position.newBuilder().setRow(c.getRow())
					.setCol(c.getCol()).build();
			snakeMsgBuilder.setApplePosition(applePosition);
		}

		int adaptMS = 0;
		if (delayCount != 0) {
			int avgDelay = delaySum / delayCount;
			int othersDelayAvg = othersDelayAvgSum / delayCount;
			adaptMS = (othersDelayAvg - avgDelay) / 1000;
			if (Math.abs(adaptMS) > period) {
				adaptMS = 0;
			}
			// System.out.println("avgDelay: " + avgDelay / 1000);
			// System.out.println("othersDelayAvg: " + othersDelayAvg / 1000);
			// System.out.println("need to adapt: " + adaptMS);

			if (Math.abs(avgDelay) < SYNC_SEND_THRESHOLD * period * 1000) {
				snakeMsgBuilder.setAvgDelay(avgDelay);
			} else {
				snakeMsgBuilder.setAvgDelay(0);
			}
		} else {
			snakeMsgBuilder.setAvgDelay(0);
		}

		snakePub.sendObject("SnakeMsg", snakeMsgBuilder.build());

		timeRef = System.nanoTime();

		delaySum = 0;
		delayCount = 0;
		othersDelayAvgSum = 0;
		return adaptMS;
	}

	public void snakeReceived(int avgDelay, int knownSnakes) {
		int delay = (int) ((System.nanoTime() - timeRef) / 1000);
		if (delay > period / 2 * 1000) { // when delay is greater than half the
											// period assume an offset of one
											// frame!
			delay -= period * 1000;
		}

		delaySum += delay;
		othersDelayAvgSum += avgDelay;
		delayCount++;

		if (delayCount >= knownSnakes) {
			callbacks.allSnakesReceived();
		}
	}
}

class SnakeReceiver implements ITypedReceiver {
	private Board board;
	private Map<String, Snake> otherSnakes;
	private SnakeCommunication snakeCommunication;

	public SnakeReceiver(Board board, SnakeCommunication snakeCommunication) {
		this.board = board;
		this.snakeCommunication = snakeCommunication;
		otherSnakes = new HashMap<String, Snake>();
	}

	@Override
	public void receiveObject(Object object, Message msg) {
		if (object != null) {
			SnakeMsg snakeMsg = (SnakeMsg) object;

			if (otherSnakes.containsKey(snakeMsg.getUUID())) {
				otherSnakes.get(snakeMsg.getUUID()).move(
						snakeMsg.getSnakePartListList(), board);
			} else {
				otherSnakes.put(snakeMsg.getUUID(),
						new Snake(snakeMsg.getSnakePartListList(), board));
			}
			snakeCommunication.snakeReceived(snakeMsg.getAvgDelay(),
					otherSnakes.size());

			if (snakeMsg.hasApplePosition()) {
				board.appleReceived(snakeMsg.getApplePosition().getRow(),
						snakeMsg.getApplePosition().getCol() //, snakeMsg.getFrameCount()
						);
			}
		}
	}

	public Snake deleteSnake(String id) {

		Snake toBeRemoved = otherSnakes.get(id);
		otherSnakes.remove(id);
		
	//	board.getCell(0, 0).type = Cell.CELL_TYPE_FOOD; // TEST
		return toBeRemoved;
	}
}

class SnakeGreeter implements ITypedGreeter {
	private Board board;
	private SnakeCommunication snakeCommunication;

	public SnakeGreeter(Board board, SnakeCommunication snakeCommunication) {

		this.snakeCommunication = snakeCommunication;
		this.board = board;

	}

	@Override
	public void welcome(TypedPublisher atPub, SubscriberStub subStub) {
		// TEST
		System.out.println("hello new player " + subStub.getUUID() + "\n");
	}

	@Override
	public void farewell(TypedPublisher fromPub, SubscriberStub subStub) {
		// TEST
		System.out.println("goodbye player " + subStub.getUUID() + "\n");

		board.clearSnakeCells(snakeCommunication.snakeRcv.deleteSnake(subStub.getUUID()));
	
	}

}
