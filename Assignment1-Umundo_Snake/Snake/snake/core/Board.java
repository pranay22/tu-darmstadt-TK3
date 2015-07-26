/**
 * based on code from http://yazalimbiraz.blogspot.de/2014/02/snake-game-written-in-java-full-source.html
 */

package snake.core;

public class Board {

	final int ROW_COUNT, COL_COUNT;
	Cell[][] cells;
	
	private boolean myApple;
	private Cell applePosition;

	public Board(int rowCount, int columnCount) {
		ROW_COUNT = rowCount;
		COL_COUNT = columnCount;

		cells = new Cell[ROW_COUNT][COL_COUNT];
		for (int row = 0; row < ROW_COUNT; row++) {
			for (int column = 0; column < COL_COUNT; column++) {
				cells[row][column] = new Cell(row, column);
			}
		}
		
		myApple = false;
		applePosition = cells[0][0];
	}

	public void generateFood() {
		
		Cell c = getRandomEmptyCell(); //logic relocated there -KrrKs
		c.type = Cell.CELL_TYPE_FOOD;
				
		myApple = true;
		applePosition = c;
	}
	
	public Cell getRandomEmptyCell(){ //previously part of generateFood()
		
		int counter = 0;
		int row = 0, column = 0;

		do {
			row = (int) (Math.random() * ROW_COUNT);
			column = (int) (Math.random() * COL_COUNT);
			counter++;
			if (cells[row][column].type == Cell.CELL_TYPE_EMPTY) {
				return cells[row][column];
			}
		} while (counter < (ROW_COUNT * COL_COUNT));
		
		//If this did not find anything, just use the first available free cell
		for (row = 0; row < ROW_COUNT; row++) {
			for (column = 0; column < COL_COUNT; column++) {
				if (cells[row][column].type == Cell.CELL_TYPE_EMPTY){
					return cells[row][column];
				}
			}
		}
		/*
		*If this is reached, it returns [0,0]. But the entire field is full anyway,
		*resulting in a gameover for everyone in the next turn.
		*
		*Alternatively, the last element of the host snake could be overwritten with a food item.
		*/
		return cells[row][column];
	}
	
	public void clearSnakeCells(Snake snake){
		  for (Cell cell : snake.getSnakeCells()) {
			  
			  cells[cell.getRow()][cell.getCol()].type = Cell.CELL_TYPE_EMPTY;
		  }				  
	}

	public Cell getCell(int row, int col) {

		return cells[row][col];

	}

	public int getCellType(int row, int col) {
		return cells[row][col].type;
	}

	public int getRowCount() {
		return ROW_COUNT;
	}

	public int getColCount() {
		return COL_COUNT;
	}
	
	public boolean isMyApple(){
		//System.out.println("my Apple:" + myApple);
		return myApple;
	}
	
	public Cell getApplePosition(){
		return applePosition;
	}
	
	public void appleReceived(int row, int col){
		if(cells[row][col].type == Cell.CELL_TYPE_EMPTY){
			cells[row][col].type = Cell.CELL_TYPE_FOOD;
			myApple = false;

			if(applePosition.type == Cell.CELL_TYPE_FOOD){ //Yay for invisible players bug!
				applePosition.type = Cell.CELL_TYPE_EMPTY;
			}
			applePosition = cells[row][col];
		}
	}
}