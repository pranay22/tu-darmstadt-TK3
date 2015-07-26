/**
 * based on code from http://yazalimbiraz.blogspot.de/2014/02/snake-game-written-in-java-full-source.html
 */

package snake.core;

import java.util.LinkedList;
import java.util.List;

import snake.network.SnakeProtobuf.Position;

public class Snake {

  LinkedList<Cell> snakePartList = new LinkedList<Cell>();
  Cell head;

  public Snake(Cell initPos) {
    head = initPos;
    head.type = Cell.CELL_TYPE_SNAKE_NODE;
    snakePartList.add(head);
  }

  public Snake(List<Position> positions, Board board) {
    addPositions(positions, board);
  }
  
  private void addPositions(List<Position> positions, Board board) {
    for (Position p : positions) {
      Cell c = board.getCell(p.getRow(), p.getCol());
      c.type = Cell.CELL_TYPE_REMOTE_SNAKE_NODE; //TODO
      snakePartList.add(c);
    }
    head = snakePartList.getFirst();
  }
  
  public void move(List<Position> positions, Board board) {
    for (Cell c : snakePartList) {
      c.type = Cell.CELL_TYPE_EMPTY;
    }
    snakePartList.clear();
    addPositions(positions, board);
  }

  public void grow() {
    snakePartList.addFirst(head);
  }

  public void move(Cell nextCell) {
    Cell tail = snakePartList.removeLast();
    tail.type = Cell.CELL_TYPE_EMPTY;

    head = nextCell;
    head.type = Cell.CELL_TYPE_SNAKE_NODE;
    snakePartList.addFirst(head);
  }

  public boolean checkCrash(Cell nextCell) {
	  //Why so complicated? -checkCrash is called before moving, so:
	  if(nextCell.type > 10){ //Snake and remote Snakes are 20 and 30 respectively
		  return true;
	  }
	  return false;
	  
	  /*
    for (Cell cell : snakePartList) {
      if (cell == nextCell) {
        return true;
      }
    }
    return false;
    */
  }

  public LinkedList<Cell> getSnakeCells() {
    return snakePartList;
  }
}