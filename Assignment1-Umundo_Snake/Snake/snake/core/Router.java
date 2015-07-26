/**
 * based on code from http://yazalimbiraz.blogspot.de/2014/02/snake-game-written-in-java-full-source.html
 */

package snake.core;

import javax.swing.JOptionPane;

public class Router {

  public static final int DIRECTION_NONE = 0, DIRECTION_RIGHT = 1, DIRECTION_LEFT = -1, DIRECTION_UP = 2, DIRECTION_DOWN = -2;
  private Snake snake;
  private Board board;
  private int direction;
  private boolean gameOver;
  private boolean godMode;
  private int points;

  public Router(Snake snake, Board board) {
    this.snake = snake;
    this.board = board;
    this.points=0;
    godMode = false;
  }

  public void setDirection(int direction) {
	  if(this.direction != -direction){ //Prevent Snakehead to go backwards into the body, tzz -KrrKs
	  	this.direction = direction;
	  }
  }

  public void update() {
    if (!gameOver) {
      if (direction != DIRECTION_NONE) {
        Cell nextCell = getNextCell(snake.head);

        if (snake.checkCrash(nextCell) && !godMode) {
          setDirection(DIRECTION_NONE);
          gameOver = true;
          JOptionPane.showMessageDialog(null, "GAME OVER!\n points: "+ this.points);
        } else {
          if (nextCell.type == Cell.CELL_TYPE_FOOD) {
            nextCell.type = Cell.CELL_TYPE_SNAKE_NODE;
            snake.grow();
            points++;
            board.generateFood();
          }
          snake.move(nextCell);
        }
      }
    }
  }
  
  public void activateGodMode() {
    godMode = true;
  }

  private Cell getNextCell(Cell currentPosition) {
    int row = currentPosition.row;
    int col = currentPosition.col;

    if (direction == DIRECTION_RIGHT) {
      col++;
    } else if (direction == DIRECTION_LEFT) {
      col--;
    } else if (direction == DIRECTION_UP) {
      row--;
    } else if (direction == DIRECTION_DOWN) {
      row++;
    }
    row = (row + board.getRowCount()) % board.getRowCount();
    col = (col + board.getColCount()) % board.getColCount();

    Cell nextCell = board.cells[row][col];

    return nextCell;
  }
}