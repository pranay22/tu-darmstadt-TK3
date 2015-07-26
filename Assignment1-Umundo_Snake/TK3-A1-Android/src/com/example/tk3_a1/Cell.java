package com.example.tk3_a1;

import android.graphics.Color;
import android.graphics.Paint;

 public class Cell {

    final static int CELL_TYPE_EMPTY = 0, CELL_TYPE_FOOD = 10, CELL_TYPE_SNAKE_NODE = 20;
    final int row, col;
    final static String COLOR_WHITE = "#FFFFFF", COLOR_BLACK = "#000000", COLOR_GREEN = "#00B200", COLOR_BLUE="#3300FF";
    int type;
    Paint paint;
    int x;
    int y;

    public Cell(int row, int col, int x, int y) {
        this.row = row;
        this.col = col;
        this.x = x;
        this.y = y;
        paint = new Paint();
        paint.setColor(Color.parseColor(COLOR_WHITE));
        
        
    }
    
    
    public Cell(int row, int col){
    	this.row = row;
    	this.col = col;
    	paint = new Paint();
        paint.setColor(Color.parseColor(COLOR_WHITE));
    }
    
    private void changePaint(String type){
    	this.paint.setColor(Color.parseColor(type));
    }    
    
    public void changeCellType(int type){
    	this.type = type;
    	switch(type){
	    	case CELL_TYPE_EMPTY:{
	    		changePaint(COLOR_WHITE);
	    		break;
	    	}
	    	case CELL_TYPE_FOOD:{
	    		changePaint(COLOR_GREEN);
	    		break;
	    	}
	    	case CELL_TYPE_SNAKE_NODE:{
	    		changePaint(COLOR_BLACK);
	    		break;
	    	}
    	}
    }
}