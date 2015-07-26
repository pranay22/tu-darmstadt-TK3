/**
 * based on code from http://yazalimbiraz.blogspot.de/2014/02/snake-game-written-in-java-full-source.html
 */

package snake.core;
 public class Cell {

    public final static int CELL_TYPE_EMPTY = 0;
	public static final int CELL_TYPE_FOOD = 10;
	public static final int CELL_TYPE_SNAKE_NODE = 20;
	public static final int CELL_TYPE_REMOTE_SNAKE_NODE = 30; //Please use this to reference non-local snakes
	
    final int row, col;
    public int type;

    public Cell(int row, int col) {
        this.row = row;
        this.col = col;
    }
    
    public int getRow() {
      return row;
    }
    
    public int getCol() {
      return col;
    }
}