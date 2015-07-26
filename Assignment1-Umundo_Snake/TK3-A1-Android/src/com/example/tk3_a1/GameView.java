package com.example.tk3_a1;

import java.util.Timer;
import java.util.TimerTask;

import javax.security.auth.callback.Callback;

import android.app.Activity;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Point;
import android.graphics.drawable.BitmapDrawable;
import android.os.Bundle;
import android.os.Handler;
import android.text.format.Time;
import android.view.Display;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.Toast;

public class GameView extends Activity{
	final int ROW_COUNT = 20;
	final int COL_COUNT = 20;
	final static String COLOR_BLACK = "#FFFFFF", COLOR_WHITE = "#000000", COLOR_GREEN = "#00B200", COLOR_BLUE="#3300FF";
	
	int stepRow;
	int stepCol; 
	int doneRow = 0;
    int doneColumn = 0;
    
    Snake snake;
	Board board;
	Canvas canvas;
	Bitmap bg;
	LinearLayout ll;
	
	int delay = 100;
	Router router;
	
	
	Handler handler = new Handler();
	Runnable timerRunnable = new Runnable(){

		@Override
		public void run() {
		    try{
		    	router.update();
		    	int size = snake.snakePartList.size();
		    	for(Cell cell: snake.snakePartList){
		    		board.cells[cell.row][cell.col].changeCellType(cell.type);
		    		if(cell.type == Cell.CELL_TYPE_EMPTY)
		    			snake.snakePartList.remove(cell);
		    	}
		    	for(Cell[] cells: board.cells){
			    	for(Cell cell: cells){
			    		canvas.drawRect(cell.x-stepRow, cell.y-stepCol, cell.x, cell.y, cell.paint);
			    	}
			    }
		    	
		    	int a = board.food.row;
		    	int b = board.food.col;
		    	int c = board.cells[a][b].x;
		    	int d = stepRow;
		    	
		    	canvas.drawRect(board.cells[board.food.row][board.food.col].x-stepRow, board.cells[board.food.row][board.food.col].y-stepCol, board.cells[board.food.row][board.food.col].x, board.cells[board.food.row][board.food.col].y, board.food.paint);
		    						
		    }catch(Exception e){
		    	Toast.makeText(getApplicationContext(), ""+e, Toast.LENGTH_LONG).show();
		    }
		    
			ll.invalidate();
			if(router.gameOver()){
				handler.removeCallbacks(timerRunnable);
				Toast.makeText(getApplicationContext(), "Game Over!", Toast.LENGTH_LONG).show();
			}
			else
				handler.postDelayed(this, delay);
		}
		
	};
	
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
	    super.onCreate(savedInstanceState);
	    try{
	    	setContentView(R.layout.game_view);    
	    	
	    	Display display = getWindowManager().getDefaultDisplay();
	    	int width = display.getWidth()/2;
	    	int height = (display.getHeight()/2);
	    	
		    bg = Bitmap.createBitmap(width, height, Bitmap.Config.ARGB_8888); 
		    canvas = new Canvas(bg);  
		    
		    stepRow = width/ROW_COUNT;
		    stepCol = height/COL_COUNT;
		    board = new Board(ROW_COUNT, COL_COUNT, stepRow, stepCol);
		    
		    
		   	    
		    ll = (LinearLayout) findViewById(R.id.rect); 
		    ll.setBackgroundDrawable(new BitmapDrawable(bg)); 
		    
		    int row = (int) (Math.random() * ROW_COUNT);
		    int column = (int) (Math.random() * COL_COUNT);
		     
		    snake = new Snake(new Cell(row, column));
		    router = new Router(snake, board);
		    router.setDirection(Router.DIRECTION_UP);
		    
		    for(Cell[] cells: board.cells){
		    	for(Cell cell: cells){
		    		canvas.drawRect(cell.x-stepRow, cell.y-stepCol, cell.x, cell.y, cell.paint);
		    	}
		    }
		    handler.postDelayed(timerRunnable, 500);
		    
		    
		    
		    
			
		    
	    }catch(Exception e){
	    	Toast.makeText(getApplicationContext(), "Crashed"+e, Toast.LENGTH_LONG).show();
	    }
	     
	}
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}
	
	public void buttonPressed(View view){
		switch(view.getId()){
		case R.id.button_up:
			if(router.getDirection()!= Router.DIRECTION_DOWN)
				router.setDirection(Router.DIRECTION_UP);
			break;
		case R.id.button_down:
			if(router.getDirection() != Router.DIRECTION_UP)
				router.setDirection(Router.DIRECTION_DOWN);
			break;
		case R.id.button_left:
			if(router.getDirection() != Router.DIRECTION_RIGHT)
				router.setDirection(Router.DIRECTION_LEFT);
			break;
		case R.id.button_right:
			if(router.getDirection() != Router.DIRECTION_LEFT)
				router.setDirection(Router.DIRECTION_RIGHT);
			break;
		}
		handler.removeCallbacks(timerRunnable);
		handler.postDelayed(timerRunnable, 0);
	}

	
	

}
