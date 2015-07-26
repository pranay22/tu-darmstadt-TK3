package com.example.tk3_a1;

public class Router {

    public static final int DIRECTION_NONE = 0, DIRECTION_RIGHT = 1, DIRECTION_LEFT = -1, DIRECTION_UP = 2, DIRECTION_DOWN = -2;
    private Snake snake;
    private Board board;
    private int direction;
    private boolean gameOver;

    public Router(Snake snake, Board board) {
        this.snake = snake;
        this.board = board;
    }

    public void setDirection(int direction) {
        this.direction = direction;
    }

    public void update() {
        if (!gameOver) {
            if (direction != DIRECTION_NONE) {
                Cell nextCell = getNextCell(snake.head);

                if (snake.checkCrash(nextCell)) {
                    setDirection(DIRECTION_NONE);
                    gameOver = true;
                } else {
                	
                	
                    snake.move(nextCell);
                    if ((nextCell.row == board.food.row) && (nextCell.col == board.food.col) ) {
                        snake.grow();
                        board.generateFood();
                    }
                }
            }
        }
    }

    private Cell getNextCell(Cell currentPosition) {
        int row = currentPosition.row;
        int col = currentPosition.col;

        if (direction == DIRECTION_RIGHT) {
        	if(col != (board.COL_COUNT-1))
        		col++;
        	else
        		col = 0;
        } else if (direction == DIRECTION_LEFT) {
        	if(col != 0)
        		col--;
        	else
        		col = board.COL_COUNT-1;
        } else if (direction == DIRECTION_UP) {
        	if(row != 0)
        		row--;
        	else
        		row = board.ROW_COUNT-1;
        } else if (direction == DIRECTION_DOWN) {
        	if(row != board.ROW_COUNT-1)
        		row++;
        	else
        		row = 0;
        }

        Cell nextCell = board.cells[row][col];
        return nextCell;
    }
    
    public boolean gameOver(){
    	return gameOver;
    }
    
    public void setGameOver(boolean gameOver){
    	this.gameOver = gameOver;
    }
    
    public int getDirection(){
    	return direction;
    }
}