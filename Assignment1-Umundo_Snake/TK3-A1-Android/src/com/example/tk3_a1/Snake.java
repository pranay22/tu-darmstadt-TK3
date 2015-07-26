package com.example.tk3_a1;

import java.util.LinkedList;

 public class Snake {

    LinkedList<Cell> snakePartList = new LinkedList<Cell>();
    Cell head;

    public Snake(Cell initPos) {
    	initPos.changeCellType(Cell.CELL_TYPE_SNAKE_NODE);
        head = initPos;
        snakePartList.add(head);
    }

    public void grow() {
//        snakePartList.add(head);
        snakePartList.getLast().changeCellType(Cell.CELL_TYPE_SNAKE_NODE);
    }

    public void move(Cell nextCell) {
        snakePartList.getLast().changeCellType(Cell.CELL_TYPE_EMPTY);
        head = nextCell;
        snakePartList.addFirst(head);
        head.changeCellType(Cell.CELL_TYPE_SNAKE_NODE);
    }

    public boolean checkCrash(Cell nextCell) {
        for (Cell cell : snakePartList) {
            if (cell == nextCell) {
                return true;
            }
        }

        return false;
    }
}