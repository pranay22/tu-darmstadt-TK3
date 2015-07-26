package snake.gui;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;

import javax.swing.JFrame;
import javax.swing.Timer;

import snake.core.Board;
import snake.core.Router;
import snake.core.Snake;
import snake.network.SnakeCommunication;
import snake.network.SnakeCommunicationCallbacks;

public class SnakeDesktop implements KeyListener, SnakeCommunicationCallbacks {
  private final static int PERIOD = 100;
  private final static float SYNC_FACTOR = 0.1f;

  private final static int BOARD_SIZE_X = 20;
  private final static int BOARD_SIZE_Y = 20;

  private Board snakeBoard;
  private Snake snake;
  private Router router;
  private String input;

  private SnakeCommunication communication;
  private int frameCount;

  private SnakeBoardPanel sbp;

  private Timer gameTimer;

  public SnakeDesktop() {
    snakeBoard = new Board(BOARD_SIZE_X, BOARD_SIZE_Y);
    createGUI();

    communication = new SnakeCommunication(snakeBoard, PERIOD, this);
    frameCount = 0;

    handleTimer(PERIOD);
  }
  
  @Override
  public void allSnakesReceived() {
    sbp.repaint(); //redraw when received all snakes
  }

  public void createGUI() {
    JFrame frame = new JFrame("Snake Desktop");
    frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
    frame.addKeyListener(this);

    sbp = new SnakeBoardPanel(snakeBoard);
    frame.add(sbp);
    frame.setSize(400, 400);

    frame.setVisible(true);

  }

  public static void main(String[] args) {
    new SnakeDesktop();

  }

  @Override
  public void keyPressed(KeyEvent arg0) {
    switch (arg0.getKeyCode()) {
    case (KeyEvent.VK_UP):
    case (KeyEvent.VK_W):
      router.setDirection(Router.DIRECTION_UP);
      break;
    case (KeyEvent.VK_DOWN):
    case (KeyEvent.VK_S):
      router.setDirection(Router.DIRECTION_DOWN);
      break;
    case (KeyEvent.VK_LEFT):
    case (KeyEvent.VK_A):
      router.setDirection(Router.DIRECTION_LEFT);
      break;
    case (KeyEvent.VK_RIGHT):
    case (KeyEvent.VK_D):
      router.setDirection(Router.DIRECTION_RIGHT);
      break;
    }
    input = input + arg0.getKeyChar();
    if (input.contains("god")) {
      input = "";
      router.activateGodMode();
    }
  }

  @Override
  public void keyReleased(KeyEvent arg0) {
  }

  @Override
  public void keyTyped(KeyEvent arg0) {
  }

  private void handleTimer(int period) {

    final ActionListener regularListener = new ActionListener() {

      @Override
      public void actionPerformed(ActionEvent arg0) {
        router.update();

        sbp.repaint(); // repaint immediately for fast user feedback, will be repainted again when all snakes received

        int adaptMS = communication.sendSnake(snake, frameCount++);
        gameTimer.setDelay(PERIOD - (int) (adaptMS * SYNC_FACTOR));
      }
    };

    ActionListener startListener = new ActionListener() {
      // Listener called to set the game up
      @Override
      public void actionPerformed(ActionEvent e) {
        if (frameCount == 0) { // first player
          snakeBoard.generateFood();
        }
        snake = new Snake(snakeBoard.getRandomEmptyCell());
        router = new Router(snake, snakeBoard);
        router.setDirection(Router.DIRECTION_UP);

        /*
         * call the regular Listener -This will screw up the delay computation for the first 2 frames, sorry Carsten Additional delay on my machine is
         * about 30 ms -KrrKs
         */
        regularListener.actionPerformed(e);

        // set up the regular Listener
        gameTimer.addActionListener(regularListener);
        gameTimer.removeActionListener(this);
      }
    };

    gameTimer = new Timer(PERIOD, startListener);
    gameTimer.start();
  }
}
