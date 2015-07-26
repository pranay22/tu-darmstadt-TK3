package com.example.tk3_a1;

 public class Board {

    final int ROW_COUNT, COL_COUNT;
    int x,y;
    Cell[][] cells;
    Cell food;

    public Board(int rowCount, int columnCount, int stepX, int stepY) {
        ROW_COUNT = rowCount;
        COL_COUNT = columnCount;
        
        x = stepX;
        y = stepY;
        
        cells = new Cell[ROW_COUNT][COL_COUNT];
        for (int row = 0; row < ROW_COUNT; row++) {
            for (int column = 0; column < COL_COUNT; column++) {
                cells[row][column] = new Cell(row, column, x, y);
                x += stepX;
            }
            y += stepY;
            x = stepX;
        }
        
        generateFood();
    }

    public void generateFood() {
        int row = (int) (Math.random() * ROW_COUNT);
        int column = (int) (Math.random() * COL_COUNT);
        cells[row][column].changeCellType(Cell.CELL_TYPE_FOOD);
        food = new Cell(row, column);
        food.changeCellType(Cell.CELL_TYPE_FOOD);
//        cells[row][column] = food;
    }
}